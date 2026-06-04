<!DOCTYPE html>
<html>
<head>
    <title>Account Verification</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background: #f0f2f5; }
        .container { max-width: 800px; margin: 0 auto; }
        .card { background: white; padding: 30px; border-radius: 10px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1, h2 { color: #333; }
        .alert { padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .alert-warning { background: #fff3cd; color: #856404; border: 1px solid #ffeeba; }
        .alert-info { background: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="file"], select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
        button { background: #007bff; color: white; padding: 12px 30px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; }
        button:hover { background: #0056b3; }
        .status-badge { display: inline-block; padding: 5px 10px; border-radius: 5px; font-size: 12px; }
        .status-pending { background: #ffc107; color: #000; }
        .status-approved { background: #28a745; color: white; }
        .status-rejected { background: #dc3545; color: white; }
        hr { margin: 30px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>Account Verification</h1>
            
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            
            @if($user->is_verified && $user->id_card_verified)
                <div class="alert alert-success">
                    ✅ <strong>Fully Verified Account!</strong> You are fully verified and can send/receive money.
                </div>
                <a href="/dashboard" class="back-link">← Go to Dashboard</a>
            @else
                
                <!-- Passport Upload Section -->
                <div style="margin-bottom: 30px;">
                    <h2>📄 Passport Verification</h2>
                    
                    @if($user->is_verified)
                        <div class="alert alert-success">✅ Passport Verified!</div>
                    @elseif($user->rejection_reason && $user->passport_path)
                        <div class="alert alert-danger">
                            <strong>❌ Passport Rejected!</strong>
                            <p>Reason: {{ $user->rejection_reason }}</p>
                        </div>
                        <form action="{{ route('user.upload-passport') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Upload Passport (JPG, PNG, PDF - Max 5MB)</label>
                                <input type="file" name="passport" required accept=".jpg,.jpeg,.png,.pdf">
                            </div>
                            <button type="submit">Submit Passport</button>
                        </form>
                    @elseif($user->passport_path && !$user->is_verified)
                        <div class="alert alert-warning">⏳ Passport pending admin review.</div>
                    @else
                        <form action="{{ route('user.upload-passport') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Upload Passport (JPG, PNG, PDF - Max 5MB)</label>
                                <input type="file" name="passport" required accept=".jpg,.jpeg,.png,.pdf">
                            </div>
                            <button type="submit">Submit Passport</button>
                        </form>
                    @endif
                </div>
                
                <hr>
                
                <!-- ID Card Upload Section -->
                <div>
                    <h2>🪪 ID Card Verification</h2>
                    
                    @if($user->id_card_verified)
                        <div class="alert alert-success">✅ ID Card Verified!</div>
                    @elseif($user->id_card_rejection_reason && $user->id_card_path)
                        <div class="alert alert-danger">
                            <strong>❌ ID Card Rejected!</strong>
                            <p>Reason: {{ $user->id_card_rejection_reason }}</p>
                        </div>
                        <form action="{{ route('user.upload-idcard') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>ID Card Type</label>
                                <select name="id_card_type" required>
                                    <option value="">Select ID Type</option>
                                    <option value="passport">Passport</option>
                                    <option value="driving_license">Driving License</option>
                                    <option value="national_id">National ID Card</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Upload ID Card (JPG, PNG, PDF - Max 5MB)</label>
                                <input type="file" name="id_card" required accept=".jpg,.jpeg,.png,.pdf">
                            </div>
                            <button type="submit">Submit ID Card</button>
                        </form>
                    @elseif($user->id_card_path && !$user->id_card_verified)
                        <div class="alert alert-warning">⏳ ID Card pending admin review.</div>
                    @else
                        <form action="{{ route('user.upload-idcard') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>ID Card Type</label>
                                <select name="id_card_type" required>
                                    <option value="">Select ID Type</option>
                                    <option value="passport">Passport</option>
                                    <option value="driving_license">Driving License</option>
                                    <option value="national_id">National ID Card</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Upload ID Card (JPG, PNG, PDF - Max 5MB)</label>
                                <input type="file" name="id_card" required accept=".jpg,.jpeg,.png,.pdf">
                            </div>
                            <button type="submit">Submit ID Card</button>
                        </form>
                    @endif
                </div>
                
            @endif
        </div>
        
        <a href="/dashboard" style="display: inline-block; margin-top: 20px; color: #007bff;">← Back to Dashboard</a>
    </div>
</body>
</html>