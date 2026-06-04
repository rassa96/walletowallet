<!DOCTYPE html>
<html>
<head>
    <title>Admin - Verify User</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background: #f0f2f5; }
        .container { max-width: 800px; margin: 0 auto; }
        .card { background: white; padding: 30px; border-radius: 10px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1, h2 { color: #333; }
        .user-info { margin-bottom: 20px; }
        .user-info p { margin: 5px 0; }
        .passport-view { text-align: center; margin: 20px 0; }
        .passport-view img { max-width: 100%; max-height: 400px; border: 1px solid #ddd; border-radius: 5px; }
        .btn { padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; margin-right: 10px; }
        .btn-approve { background: #28a745; color: white; }
        .btn-reject { background: #dc3545; color: white; }
        .btn-back { background: #6c757d; color: white; text-decoration: none; display: inline-block; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; min-height: 100px; }
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 5px; }
        .alert-info { background: #d1ecf1; color: #0c5460; }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('admin.verifications') }}" class="btn btn-back">← Back to Verifications</a>
        
        <div class="card">
            <h1>Review Verification Request</h1>
            
            <div class="user-info">
                <h2>User Information</h2>
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Registered:</strong> {{ $user->created_at->format('F j, Y') }}</p>
                <p><strong>Submitted:</strong> {{ $verificationRequest->created_at->format('F j, Y, g:i a') }}</p>
            </div>
            
            <div class="passport-view">
                <h2>Passport Document</h2>
                @php
                    $extension = pathinfo($user->passport_path, PATHINFO_EXTENSION);
                @endphp
                
                @if(in_array($extension, ['jpg', 'jpeg', 'png']))
                    <img src="{{ asset('storage/' . $user->passport_path) }}" alt="Passport">
                @elseif($extension == 'pdf')
                    <iframe src="{{ asset('storage/' . $user->passport_path) }}" width="100%" height="500px"></iframe>
                @endif
                
                <p><a href="{{ route('admin.verifications.passport', $user) }}" target="_blank" style="color: #007bff;">Open in new tab</a></p>
            </div>
        </div>
        
        <div class="card">
            <h2>Decision</h2>
            
            <form action="{{ route('admin.verifications.approve', $user) }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-approve" onclick="return confirm('Approve this user?')">✅ Approve User</button>
            </form>
            
            <form action="{{ route('admin.verifications.reject', $user) }}" method="POST" style="display: inline;">
                @csrf
                <div class="form-group" style="margin-top: 20px;">
                    <label for="reason">Rejection Reason (required)</label>
                    <textarea name="reason" id="reason" placeholder="Explain why this verification is being rejected..."></textarea>
                </div>
                <button type="submit" class="btn btn-reject" onclick="return confirm('Reject this verification?')">❌ Reject User</button>
            </form>
        </div>
        
        <div class="alert alert-info">
            <strong>Note:</strong> Approved users will be able to send money. Rejected users will need to resubmit their passport.
        </div>
    </div>
</body>
</html>