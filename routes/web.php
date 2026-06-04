<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Transaction;
use App\Models\VerificationRequest;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Http\Controllers\WalletController;
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

    if (Schema::hasTable('wallets') && Schema::hasColumn('wallets', 'user_id')) {
        $wallet = Wallet::where('user_id', $user->id)->first();
    }

    if (Schema::hasTable('transactions')) {
        $transactions = Transaction::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
    }

    return view('home', ['wallet' => $wallet, 'transactions' => $transactions]);
});

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
    Route::get('/transfer', [WalletController::class, 'showTransferForm'])->name('wallet.transfer.form');
    Route::post('/transfer', [WalletController::class, 'transfer'])->name('wallet.transfer');
    Route::get('/balance', [WalletController::class, 'getBalance'])->name('wallet.balance');
    
    // User Verification Routes (Passport & ID Card)
    Route::get('/verification', [UserVerificationController::class, 'showForm'])->name('user.verification');
    Route::post('/upload-passport', [UserVerificationController::class, 'uploadPassport'])->name('user.upload-passport');
    Route::post('/upload-idcard', [UserVerificationController::class, 'uploadIdCard'])->name('user.upload-idcard');
    
    // Profile Avatar Upload
    Route::post('/profile/avatar', function (Request $request) {
        $request->validate([
            'avatar' => ['required', 'image', 'max:2048'],
        ]);

        $user = Auth::user();
        $avatar = $request->file('avatar');
        $destination = public_path('uploads/profile_images');

        if (!Schema::hasColumn('users', 'profile_image')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('profile_image')->nullable()->after('password');
            });
            $user = $user->fresh();
        }

        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }

        if ($user->profile_image && file_exists(public_path($user->profile_image))) {
            @unlink(public_path($user->profile_image));
        }

        $filename = Str::slug($user->name ?: 'user') . '-' . $user->id . '-' . time() . '.' . $avatar->extension();
        $avatar->move($destination, $filename);

        $user->profile_image = 'uploads/profile_images/' . $filename;
        $user->save();

        return back()->with('status', 'Profile image updated successfully.');
    })->name('profile.avatar.update');
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
        
        return view('admin.dashboard', compact(
            'totalUsers',
            'verifiedUsers',
            'unverifiedUsers',
            'totalTransactions',
            'pendingPassports',
            'pendingIdCards',
            'totalPending',
            'recentUsers',
            'recentVerifications'
        ));
    })->name('dashboard');
    
    // User Management
    Route::get('/users', function () {
        if (auth()->user()->is_admin != 1) abort(403);
        $users = User::with('wallet')->latest()->paginate(20);
        return view('admin.users', compact('users'));
    })->name('users');
    
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