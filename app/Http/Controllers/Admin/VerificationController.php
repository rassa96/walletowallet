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
        
        // Simple queries without verification_type
        $pendingPassports = VerificationRequest::where('status', 'pending')
            ->whereNotNull('passport_path')
            ->with('user')
            ->latest()
            ->get();
            
        $pendingIdCards = VerificationRequest::where('status', 'pending')
            ->whereNotNull('id_card_path')
            ->with('user')
            ->latest()
            ->get();
            
        $recentVerifications = VerificationRequest::where('status', '!=', 'pending')
            ->with('user', 'reviewer')
            ->latest()
            ->limit(20)
            ->get();
            
        return view('admin.verifications', compact('pendingPassports', 'pendingIdCards', 'recentVerifications'));
    }
    
    public function showPassport($userId)
{
    if (auth()->user()->is_admin != 1) {
        abort(403);
    }
    
    $user = User::findOrFail($userId);
    
    // Get verification request - try both ways
    $verificationRequest = VerificationRequest::where('user_id', $userId)
        ->whereNotNull('passport_path')
        ->first();
    
    // If no verification request found, create one from user data
    if (!$verificationRequest && $user->passport_path) {
        $verificationRequest = VerificationRequest::create([
            'user_id' => $user->id,
            'passport_path' => $user->passport_path,
            'status' => 'pending',
        ]);
    }
    
    // Debug - check if file exists
    $fileExists = false;
    if ($user->passport_path) {
        $fullPath = storage_path('app/public/' . $user->passport_path);
        $fileExists = file_exists($fullPath);
    }
    
    return view('admin.verify-passport', compact('user', 'verificationRequest', 'fileExists'));
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
            
        return view('admin.verify-idcard', compact('user', 'verificationRequest'));
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
    
    if (!$user->passport_path) {
        abort(404, 'No passport found');
    }
    
    // Try multiple paths
    $paths = [
        storage_path('app/public/' . $user->passport_path),
        base_path('public/storage/' . $user->passport_path),
        storage_path('app/' . $user->passport_path),
    ];
    
    $filePath = null;
    foreach ($paths as $path) {
        if (file_exists($path)) {
            $filePath = $path;
            break;
        }
    }
    
    if (!$filePath) {
        abort(404, 'File not found. Tried: ' . implode(', ', $paths));
    }
    
    $extension = pathinfo($filePath, PATHINFO_EXTENSION);
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
        $path = storage_path('app/public/' . $user->id_card_path);
        
        if (!file_exists($path)) {
            abort(404, 'ID Card file not found');
        }
        
        return response()->file($path);
    }

}