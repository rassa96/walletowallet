<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\VerificationRequest;
use Illuminate\Support\Facades\Storage;

class UserVerificationController extends Controller
{
    public function showForm()
    {
        $user = auth()->user();
        $verificationRequest = $user->latestVerificationRequest;
        
        return view('user.verification', compact('user', 'verificationRequest'));
    }
    
    public function uploadPassport(Request $request)
    {
        $request->validate([
            'passport' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);
        
        $user = auth()->user();
        
        // Check if already verified
        if ($user->is_verified) {
            return back()->with('error', 'You are already verified!');
        }
        
        // Store passport
        $path = $request->file('passport')->store('verifications/passports', 'public');
        
        // Update user
        $user->update([
            'passport_path' => $path,
            'is_verified' => false,
            'rejection_reason' => null,
        ]);
        
        // Create or update verification request
        VerificationRequest::updateOrCreate(
            ['user_id' => $user->id, 'verification_type' => 'passport'],
            [
                'passport_path' => $path,
                'status' => 'pending',
            ]
        );
        
        return redirect()->route('user.verification')
            ->with('success', 'Passport uploaded successfully! Admin will review it shortly.');
    }
    
    // NEW: Upload ID Card
    public function uploadIdCard(Request $request)
    {
        $request->validate([
            'id_card' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'id_card_type' => 'required|in:passport,driving_license,national_id,other',
        ]);
        
        $user = auth()->user();
        
        // Store ID card
        $path = $request->file('id_card')->store('verifications/id_cards', 'public');
        
        // Update user
        $user->update([
            'id_card_path' => $path,
            'id_card_type' => $request->id_card_type,
            'id_card_verified' => false,
            'id_card_rejection_reason' => null,
        ]);
        
        // Create or update verification request
        $verificationRequest = VerificationRequest::updateOrCreate(
            ['user_id' => $user->id, 'verification_type' => 'id_card'],
            [
                'id_card_path' => $path,
                'id_card_type' => $request->id_card_type,
                'passport_path' => $user->passport_path ?? '',
                'status' => 'pending',
            ]
        );
        
        return redirect()->route('user.verification')
            ->with('success', 'ID Card uploaded successfully! Admin will review it shortly.');
    }

    
}
