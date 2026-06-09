<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Transaction;
use App\Models\NotificationLog;
use App\Models\VerificationRequest;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\WalletFundingController;
use App\Http\Controllers\UserVerificationController;
use App\Http\Controllers\Admin\VerificationController;

// ============ PUBLIC ROUTES ============
Route::get('/', function () {
    if (!Auth::check()) {
        return view('index');
    }

    $user = Auth::user();
    $wallet = null;
    $transactions = [];
    $notifications = collect();
    $popupNotification = null;
    $weeklyBalanceChange = 0;
    $weeklyBalanceChangePercent = 0;

    if (Schema::hasTable('wallets') && Schema::hasColumn('wallets', 'user_id')) {
        $wallet = Wallet::where('user_id', $user->id)->first();
    }

    if (Schema::hasTable('transactions')) {
        $transactions = Transaction::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $weeklyIncoming = Transaction::where('user_id', $user->id)
            ->where('status', 'completed')
            ->where('created_at', '>=', now()->subWeek())
            ->whereIn('type', ['deposit'])
            ->sum('amount');

        $weeklyOutgoing = Transaction::where('user_id', $user->id)
            ->where('status', 'completed')
            ->where('created_at', '>=', now()->subWeek())
            ->whereIn('type', ['transfer', 'withdrawal'])
            ->sum('amount');

        $weeklyBalanceChange = (float) $weeklyIncoming - (float) $weeklyOutgoing;
        $currentBalance = $wallet ? (float) $wallet->balance : 0;
        $previousBalance = $currentBalance - $weeklyBalanceChange;
        $weeklyBalanceChangePercent = $previousBalance > 0
            ? ($weeklyBalanceChange / $previousBalance) * 100
            : ($weeklyBalanceChange > 0 ? 100 : 0);
    }

    if (Schema::hasTable('notification_logs')) {
        $popupNotification = NotificationLog::where('user_id', $user->id)
            ->where('is_read', false)
            ->latest()
            ->first();

        $notifications = NotificationLog::where('user_id', $user->id)
            ->latest()
            ->limit(10)
            ->get();

        if ($popupNotification) {
            $popupNotification->update(['is_read' => true]);
        }
    }

    return view('home', [
        'wallet' => $wallet,
        'transactions' => $transactions,
        'notifications' => $notifications,
        'popupNotification' => $popupNotification,
        'weeklyBalanceChange' => $weeklyBalanceChange,
        'weeklyBalanceChangePercent' => $weeklyBalanceChangePercent,
    ]);
})->name('home');

// ============ AUTHENTICATION ROUTES ============
Route::view('/register', 'auth.register')->name('register');

Route::post('/register', function (Request $request) {
    $data = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255', 'unique:users,email'],
        'password' => ['required', 'string', 'min:6'],
    ]);

    $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => bcrypt($data['password']),
    ]);

    // Create wallet for new user
    try {
        Wallet::create([
            'user_id' => $user->id,
            'balance' => 0,
            'wallet_address' => 'WLT_' . strtoupper(Str::random(12)),
        ]);
    } catch (\Throwable $e) {
        \Log::error('Wallet creation failed: ' . $e->getMessage());
    }

    Auth::login($user);
    return redirect('/');
})->name('register.submit');

Route::view('/login', 'auth.login')->name('login');

Route::post('/login', function (Request $request) {
    $data = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required', 'string'],
    ]);

    if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
        $request->session()->regenerate();
        return redirect()->intended('/dashboard');
    }

    return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
})->name('login.submit');

// Logout - Accept both GET and POST
Route::match(['get', 'post'], '/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// ============ AUTHENTICATED USER ROUTES ============
Route::middleware(['auth'])->group(function () {
    
    // Dashboard & Wallet Routes
    Route::get('/dashboard', [WalletController::class, 'dashboard'])->name('wallet.dashboard');
    Route::get('/personal-details', function () {
        $user = Auth::user();
        $wallet = $user->wallet;

        return view('personal-details', compact('user', 'wallet'));
    })->name('profile.details');
    Route::get('/transfer', [WalletController::class, 'showTransferForm'])->name('wallet.transfer.form');
    Route::post('/transfer', [WalletController::class, 'transfer'])->name('wallet.transfer');
    Route::get('/balance', [WalletController::class, 'getBalance'])->name('wallet.balance');
    
    // Top Up Routes
    Route::get('/topup', [WalletFundingController::class, 'showTopUp'])->name('wallet.topup');
    Route::post('/topup', [WalletFundingController::class, 'processTopUp'])->name('wallet.topup.process');
    
    // User Verification Routes (Passport & ID Card)
    Route::get('/verification', [UserVerificationController::class, 'showForm'])->name('user.verification');
    Route::post('/upload-passport', [UserVerificationController::class, 'uploadPassport'])->name('user.upload-passport');
    Route::post('/upload-idcard', [UserVerificationController::class, 'uploadIdCard'])->name('user.upload-idcard');
    
    // Profile Avatar Upload
    Route::post('/profile/avatar', function (Request $request) {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ]);

        $user = Auth::user();
        $user->name = $request->name;

        if (!Schema::hasColumn('users', 'profile_image')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('profile_image')->nullable()->after('password');
            });
            $user = $user->fresh();
            $user->name = $request->name;
        }

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $destination = public_path('uploads/profile_images');

            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            if ($user->profile_image && file_exists(public_path($user->profile_image))) {
                @unlink(public_path($user->profile_image));
            }

            $filename = Str::slug($user->name ?: 'user') . '-' . $user->id . '-' . time() . '.' . $avatar->extension();
            $avatar->move($destination, $filename);

            $user->profile_image = 'uploads/profile_images/' . $filename;
        }

        $user->save();

        return back()->with('status', 'Profile updated successfully.');
    })->name('profile.avatar.update');
    
    // Password change route
    Route::post('/profile/password', function (Request $request) {
        $request->validate([
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'new_password.confirmed' => 'The new password and re-typed password do not match.',
        ]);
        
        $user = Auth::user();
        $user->password = bcrypt($request->new_password);
        $user->save();
        
        return back()->with('status', 'Password changed successfully.');
    })->name('profile.password.update');
    
    // Chat routes (user side)
    Route::get('/chat', [\App\Http\Controllers\ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat/send', [\App\Http\Controllers\ChatController::class, 'send'])->name('chat.send');
    Route::get('/chat/fetch', [\App\Http\Controllers\ChatController::class, 'fetch'])->name('chat.fetch');
});

// ============ ADMIN ROUTES ============
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    // Admin Dashboard - FIXED VERSION
    Route::get('/dashboard', function () {
        if (auth()->user()->is_admin != 1) {
            abort(403, 'Access denied. Admin only.');
        }
        
        // Get counts from USERS table (not verification_requests)
        $totalUsers = User::count();
        $verifiedUsers = User::where('is_verified', 1)->count();
        $unverifiedUsers = User::where('is_verified', 0)->count();
        $totalTransactions = Transaction::count();
        
        // Pending verifications from VERIFICATION_REQUESTS table
        $pendingPassports = VerificationRequest::where('status', 'pending')
            ->whereNotNull('passport_path')
            ->count();
            
        $pendingIdCards = VerificationRequest::where('status', 'pending')
            ->whereNotNull('id_card_path')
            ->count();
        
        $totalPending = $pendingPassports + $pendingIdCards;
        
        // Recent users
        $recentUsers = User::latest()->take(5)->get();
        
        // Recent verification requests
        $recentVerifications = VerificationRequest::with('user')
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();
        
        // Verified users list
        $verifiedUsersList = User::where('is_verified', 1)
            ->with('wallet')
            ->latest()
            ->get();
        
        return view('admin.dashboard', compact(
            'totalUsers',
            'verifiedUsers',
            'unverifiedUsers',
            'totalTransactions',
            'pendingPassports',
            'pendingIdCards',
            'totalPending',
            'recentUsers',
            'recentVerifications',
            'verifiedUsersList'
        ));
    })->name('dashboard');
    
    // User Management
    Route::get('/users', function () {
        if (auth()->user()->is_admin != 1) abort(403);
        $users = User::with('wallet')->latest()->paginate(20);
        return view('admin.users', compact('users'));
    })->name('users');
    
    // Delete user
    Route::post('/users/{userId}/delete', function ($userId) {
        if (auth()->user()->is_admin != 1) abort(403);
        
        // Prevent admin from deleting themselves
        if ($userId == auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }
        
        $user = User::findOrFail($userId);
        
        // Prevent deleting other admins
        if ($user->is_admin == 1) {
            return back()->with('error', 'You cannot delete another admin account.');
        }
        
        $userName = $user->name;
        
        // Delete related records
        if (Schema::hasTable('chat_messages')) {
            \App\Models\ChatMessage::where('user_id', $user->id)->delete();
        }
        if (Schema::hasTable('notification_logs')) {
            \App\Models\NotificationLog::where('user_id', $user->id)->delete();
        }
        Transaction::where('user_id', $user->id)->delete();
        VerificationRequest::where('user_id', $user->id)->delete();
        if ($user->wallet) {
            $user->wallet->delete();
        }
        
        $user->delete();
        
        return redirect()->route('admin.users')->with('success', "User '{$userName}' has been deleted successfully.");
    })->name('users.delete');
    
    // Transaction Management
    Route::get('/transactions', function () {
        if (auth()->user()->is_admin != 1) abort(403);
        $transactions = Transaction::latest()->paginate(20);
        return view('admin.transactions', compact('transactions'));
    })->name('transactions');
    
    // ============ VERIFICATION MANAGEMENT ============
    Route::get('/verifications', [VerificationController::class, 'index'])->name('verifications');
    
    // Passport verification routes
    Route::get('/verifications/passport/{userId}', [VerificationController::class, 'showPassport'])->name('verifications.passport.show');
    Route::post('/verifications/passport/{userId}/approve', [VerificationController::class, 'approvePassport'])->name('verifications.passport.approve');
    Route::post('/verifications/passport/{userId}/reject', [VerificationController::class, 'rejectPassport'])->name('verifications.passport.reject');
    Route::get('/verifications/passport/{userId}/view', [VerificationController::class, 'viewPassport'])->name('verifications.passport.view');
    
    // ID Card verification routes
    Route::get('/verifications/idcard/{userId}', [VerificationController::class, 'showIdCard'])->name('verifications.idcard.show');
    Route::post('/verifications/idcard/{userId}/approve', [VerificationController::class, 'approveIdCard'])->name('verifications.idcard.approve');
    Route::post('/verifications/idcard/{userId}/reject', [VerificationController::class, 'rejectIdCard'])->name('verifications.idcard.reject');
    Route::get('/verifications/idcard/{userId}/view', [VerificationController::class, 'viewIdCard'])->name('verifications.idcard.view');
    
    // Admin Chat Routes
    Route::get('/chat', [\App\Http\Controllers\Admin\ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{userId}', [\App\Http\Controllers\Admin\ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{userId}/send', [\App\Http\Controllers\Admin\ChatController::class, 'send'])->name('chat.send');
});

// ============ TEMPORARY FIX ROUTE (Remove after running) ============
Route::get('/_fix/create-chat-table', function () {
    if (Schema::hasTable('chat_messages')) {
        return 'Table chat_messages already exists.';
    }
    
    Schema::create('chat_messages', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('sender_id');
        $table->text('message');
        $table->boolean('is_from_admin')->default(false);
        $table->boolean('is_read')->default(false);
        $table->timestamps();
        
        $table->index(['user_id', 'created_at']);
        $table->index(['user_id', 'is_read']);
    });
    
    return 'SUCCESS: chat_messages table created. Chat system is ready.';
});

Route::get('/_fix/create-wallets', function () {
    $users = User::doesntHave('wallet')->get();
    $count = 0;
    
    foreach ($users as $user) {
        Wallet::create([
            'user_id' => $user->id,
            'wallet_address' => 'WLT_' . strtoupper(Str::random(12)),
            'currency' => 'USD',
            'balance' => 0,
            'is_active' => true,
        ]);
        $count++;
    }
    
    return "SUCCESS: Created wallets for $count users. All registered users now have a wallet address.";
});

Route::get('/_fix/passport-nullable', function () {
    try {
        DB::statement('ALTER TABLE verification_requests MODIFY passport_path VARCHAR(255) NULL');
        return 'SUCCESS: passport_path column is now nullable. ID card upload should work now.';
    } catch (\Throwable $e) {
        return 'Error: ' . $e->getMessage();
    }
});

Route::get('/_fix/storage-link', function () {
    $target = storage_path('app/public');
    $link = public_path('storage');
    
    if (file_exists($link)) {
        return 'Storage link already exists.';
    }
    
    try {
        if (PHP_OS_FAMILY === 'Windows') {
            exec("mklink /D \"$link\" \"$target\"", $output, $code);
            if ($code !== 0) {
                // Fallback: copy files instead of symlink
                $link = public_path('storage');
                if (!is_dir($link)) {
                    mkdir($link, 0755, true);
                }
                // Create a junction instead
                exec("cmd /c mklink /J \"$link\" \"$target\"", $output, $code);
                if ($code !== 0) {
                    return 'Could not create symlink. Run "php artisan storage:link" manually in your terminal as administrator.';
                }
            }
        } else {
            symlink($target, $link);
        }
        return 'SUCCESS: Storage link created. Images should now be accessible.';
    } catch (\Throwable $e) {
        return 'Error: ' . $e->getMessage() . '. Try running "php artisan storage:link" in your terminal.';
    }
});

// ============ TEMPORARY SEED ROUTE (Remove in production) ============
Route::get('/_seed/transactions', function () {
    if (!Auth::check()) return redirect('/login');
    $user = Auth::user();
    
    if (Schema::hasTable('transactions')) {
        Transaction::where('user_id', $user->id)->delete();
        Transaction::create([
            'user_id' => $user->id,
            'type' => 'deposit',
            'amount' => 500.00,
            'description' => 'Initial deposit',
            'status' => 'completed',
        ]);
        Transaction::create([
            'user_id' => $user->id,
            'type' => 'transfer',
            'amount' => 50.00,
            'description' => 'Transfer to John',
            'status' => 'completed',
        ]);
        Transaction::create([
            'user_id' => $user->id,
            'type' => 'withdrawal',
            'amount' => 100.00,
            'description' => 'Withdrawal request',
            'status' => 'completed',
        ]);
    }
    
    return redirect('/');
});
