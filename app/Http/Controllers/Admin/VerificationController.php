<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;

class VerificationController extends Controller
{
    public function index()
    {
        if (auth()->user()->is_admin != 1) {
            abort(403, 'Admin access only');
        }
        
        // Pending passports (exclude already verified users)
        $pendingPassports = VerificationRequest::where('status', 'pending')
            ->whereNotNull('passport_path')
            ->where('passport_path', '!=', '')
            ->whereHas('user', function ($query) {
                $query->where('is_verified', false);
            })
            ->with('user')
            ->latest()
            ->get();
            
        // Pending ID cards (exclude already ID-card-verified users)
        $pendingIdCards = VerificationRequest::where('status', 'pending')
            ->whereNotNull('id_card_path')
            ->whereHas('user', function ($query) {
                $query->where(function ($q) {
                    $q->where('id_card_verified', false)
                      ->orWhereNull('id_card_verified');
                });
            })
            ->with('user')
            ->latest()
            ->get();
        
        // Approved/Verified passports
        $approvedPassports = VerificationRequest::where('status', 'approved')
            ->whereNotNull('passport_path')
            ->where('passport_path', '!=', '')
            ->with('user', 'reviewer')
            ->latest()
            ->get();
        
        // Approved/Verified ID cards
        $approvedIdCards = VerificationRequest::where('status', 'approved')
            ->whereNotNull('id_card_path')
            ->with('user', 'reviewer')
            ->latest()
            ->get();
            
        // Rejected verifications
        $rejectedVerifications = VerificationRequest::where('status', 'rejected')
            ->with('user', 'reviewer')
            ->latest()
            ->limit(20)
            ->get();
            
        return view('admin.verifications', compact(
            'pendingPassports', 
            'pendingIdCards', 
            'approvedPassports',
            'approvedIdCards',
            'rejectedVerifications'
        ));
    }
    
    public function showPassport($userId)
    {
        if (auth()->user()->is_admin != 1) {
            abort(403);
        }
        
        $user = User::findOrFail($userId);
        
        // Get verification request
        $verificationRequest = VerificationRequest::where('user_id', $userId)
            ->whereNotNull('passport_path')
            ->where('passport_path', '!=', '')
            ->first();
        
        // If no verification request found, create one from user data
        if (!$verificationRequest && $user->passport_path) {
            $verificationRequest = VerificationRequest::create([
                'user_id' => $user->id,
                'passport_path' => $user->passport_path,
                'status' => 'pending',
            ]);
        }
        
        // Get the passport path from verification request or user
        $passportPath = $verificationRequest->passport_path ?? $user->passport_path ?? null;
        
        // Check if file exists at any expected location
        $fileExists = false;
        if ($passportPath) {
            $possiblePaths = [
                storage_path('app/public/' . $passportPath),
                storage_path('app/public/verifications/passports/' . basename($passportPath)),
                storage_path('app/public/passports/' . basename($passportPath)),
                storage_path('app/public/passports/user' . $userId . '_passport.jpg'),
            ];
            foreach ($possiblePaths as $p) {
                if (file_exists($p)) {
                    $fileExists = true;
                    break;
                }
            }
        }
        
        return view('admin.verify-passport', compact('user', 'verificationRequest', 'fileExists', 'passportPath'));
    }
    
    public function showIdCard($userId)
    {
        if (auth()->user()->is_admin != 1) {
            abort(403);
        }
        
        $user = User::findOrFail($userId);
        $verificationRequest = VerificationRequest::where('user_id', $userId)
            ->whereNotNull('id_card_path')
            ->first();
        
        // Get id card path from verification request or user
        $idCardPath = $verificationRequest->id_card_path ?? $user->id_card_path ?? null;
            
        return view('admin.verify-idcard', compact('user', 'verificationRequest', 'idCardPath'));
    }
    
    public function approvePassport($userId)
    {
        if (auth()->user()->is_admin != 1) {
            abort(403);
        }
        
        $user = User::findOrFail($userId);
        
        $user->update([
            'is_verified' => true,
            'verified_at' => now(),
            'rejection_reason' => null,
        ]);
        
        if ($verificationRequest = VerificationRequest::where('user_id', $userId)->whereNotNull('passport_path')->first()) {
            $verificationRequest->update([
                'status' => 'approved',
                'reviewed_by' => auth()->id(),
                'reviewed_at' => now(),
            ]);
        }
        
        return redirect()->route('admin.verifications')
            ->with('success', $user->name . "'s passport has been verified!");
    }
    
    public function approveIdCard($userId)
    {
        if (auth()->user()->is_admin != 1) {
            abort(403);
        }
        
        $user = User::findOrFail($userId);
        
        $user->update([
            'id_card_verified' => true,
            'is_verified' => true,
            'verified_at' => now(),
        ]);
        
        if ($verificationRequest = VerificationRequest::where('user_id', $userId)->whereNotNull('id_card_path')->first()) {
            $verificationRequest->update([
                'status' => 'approved',
                'reviewed_by' => auth()->id(),
                'reviewed_at' => now(),
            ]);
        }
        
        return redirect()->route('admin.verifications')
            ->with('success', $user->name . "'s ID Card has been verified!");
    }
    
    public function rejectPassport(Request $request, $userId)
    {
        if (auth()->user()->is_admin != 1) {
            abort(403);
        }
        
        $request->validate([
            'reason' => 'required|string|min:5'
        ]);
        
        $user = User::findOrFail($userId);
        
        $user->update([
            'is_verified' => false,
            'rejection_reason' => $request->reason,
        ]);
        
        if ($verificationRequest = VerificationRequest::where('user_id', $userId)->whereNotNull('passport_path')->first()) {
            $verificationRequest->update([
                'status' => 'rejected',
                'admin_notes' => $request->reason,
                'reviewed_by' => auth()->id(),
                'reviewed_at' => now(),
            ]);
        }
        
        return redirect()->route('admin.verifications')
            ->with('warning', $user->name . "'s passport verification rejected.");
    }
    
    public function rejectIdCard(Request $request, $userId)
    {
        if (auth()->user()->is_admin != 1) {
            abort(403);
        }
        
        $request->validate([
            'reason' => 'required|string|min:5'
        ]);
        
        $user = User::findOrFail($userId);
        
        $user->update([
            'id_card_verified' => false,
            'id_card_rejection_reason' => $request->reason,
        ]);
        
        if ($verificationRequest = VerificationRequest::where('user_id', $userId)->whereNotNull('id_card_path')->first()) {
            $verificationRequest->update([
                'status' => 'rejected',
                'admin_notes' => $request->reason,
                'reviewed_by' => auth()->id(),
                'reviewed_at' => now(),
            ]);
        }
        
        return redirect()->route('admin.verifications')
            ->with('warning', $user->name . "'s ID Card verification rejected.");
    }
    
    public function viewPassport($userId)
    {
        if (auth()->user()->is_admin != 1) {
            abort(403);
        }
        
        $user = User::findOrFail($userId);
        
        // Get passport path from user or verification request
        $passportPath = $user->passport_path;
        
        if (!$passportPath) {
            $verificationRequest = VerificationRequest::where('user_id', $userId)
                ->whereNotNull('passport_path')
                ->where('passport_path', '!=', '')
                ->first();
            $passportPath = $verificationRequest->passport_path ?? null;
        }
        
        if (!$passportPath) {
            abort(404, 'No passport path in database');
        }
        
        // Try multiple paths
        $paths = [
            storage_path('app/public/' . $passportPath),
            storage_path('app/public/verifications/passports/' . basename($passportPath)),
            storage_path('app/public/passports/' . basename($passportPath)),
            storage_path('app/public/passports/user' . $userId . '_passport.jpg'),
            public_path('storage/' . $passportPath),
            storage_path('app/' . $passportPath),
        ];
        
        $filePath = null;
        foreach ($paths as $path) {
            if (file_exists($path)) {
                $filePath = $path;
                break;
            }
        }
        
        // Last resort: search for any passport file for this user
        if (!$filePath) {
            $searchDirs = [
                storage_path('app/public/passports'),
                storage_path('app/public/verifications/passports'),
            ];
            foreach ($searchDirs as $dir) {
                if (is_dir($dir)) {
                    $files = glob($dir . '/*');
                    foreach ($files as $file) {
                        if (str_contains(basename($file), 'user' . $userId) || str_contains(basename($file), basename($passportPath))) {
                            $filePath = $file;
                            break 2;
                        }
                    }
                }
            }
        }
        
        if (!$filePath) {
            abort(404, 'File not found. DB path: ' . $passportPath);
        }
        
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        $mimeTypes = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'pdf' => 'application/pdf',
        ];
        
        $mime = $mimeTypes[$extension] ?? 'application/octet-stream';
        
        return response()->file($filePath, ['Content-Type' => $mime]);
    }
    
    public function viewIdCard($userId)
    {
        if (auth()->user()->is_admin != 1) {
            abort(403);
        }
        
        $user = User::findOrFail($userId);
        
        // Get id card path from user or verification request
        $idCardPath = $user->id_card_path;
        
        if (!$idCardPath) {
            $verificationRequest = VerificationRequest::where('user_id', $userId)
                ->whereNotNull('id_card_path')
                ->first();
            $idCardPath = $verificationRequest->id_card_path ?? null;
        }
        
        if (!$idCardPath) {
            abort(404, 'No ID card path in database');
        }
        
        // Try multiple paths
        $paths = [
            storage_path('app/public/' . $idCardPath),
            storage_path('app/public/verifications/id_cards/' . basename($idCardPath)),
            storage_path('app/public/id_cards/' . basename($idCardPath)),
            public_path('storage/' . $idCardPath),
            storage_path('app/' . $idCardPath),
        ];
        
        $filePath = null;
        foreach ($paths as $path) {
            if (file_exists($path)) {
                $filePath = $path;
                break;
            }
        }
        
        if (!$filePath) {
            abort(404, 'File not found. DB path: ' . $idCardPath);
        }
        
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        $mimeTypes = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'pdf' => 'application/pdf',
        ];
        
        $mime = $mimeTypes[$extension] ?? 'application/octet-stream';
        
        return response()->file($filePath, ['Content-Type' => $mime]);
    }

}
