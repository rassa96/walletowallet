<!DOCTYPE html>
<html>
<head>
    <title>Admin - Verify ID Card</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f0f2f5;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        .card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1, h2 {
            color: #333;
        }
        .user-info {
            margin-bottom: 20px;
        }
        .user-info p {
            margin: 5px 0;
        }
        .document-view {
            text-align: center;
            margin: 20px 0;
        }
        .document-view img, .document-view iframe {
            max-width: 100%;
            max-height: 500px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-right: 10px;
        }
        .btn-approve {
            background: #28a745;
            color: white;
        }
        .btn-reject {
            background: #dc3545;
            color: white;
        }
        .btn-back {
            background: #6c757d;
            color: white;
            text-decoration: none;
            display: inline-block;
            padding: 10px 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            min-height: 100px;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('admin.verifications') }}" class="btn-back">← Back to Verifications</a>
        
        <div class="card">
            <h1>Review ID Card Verification</h1>
            
            <div class="user-info">
                <h2>User Information</h2>
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>ID Type:</strong> {{ ucfirst(str_replace('_', ' ', $verificationRequest->id_card_type ?? 'N/A')) }}</p>
                <p><strong>Submitted:</strong> {{ $verificationRequest->created_at->format('F j, Y, g:i a') }}</p>
            </div>
            
            <div class="document-view">
                <h2>ID Card Document</h2>
                @if($user->id_card_path)
                    @php
                        $extension = pathinfo($user->id_card_path, PATHINFO_EXTENSION);
                    @endphp
                    
                    @if(in_array($extension, ['jpg', 'jpeg', 'png']))
                        <img src="{{ asset('storage/' . $user->id_card_path) }}" alt="ID Card">
                    @elseif($extension == 'pdf')
                        <iframe src="{{ asset('storage/' . $user->id_card_path) }}" width="100%" height="500px"></iframe>
                    @else
                        <p>File type not previewable. <a href="{{ asset('storage/' . $user->id_card_path) }}" target="_blank">Click here to view</a></p>
                    @endif
                    
                    <p><a href="{{ route('admin.verifications.idcard.view', $user->id) }}" target="_blank" style="color: #007bff;">Open in new tab</a></p>
                @else
                    <p class="alert alert-danger">No ID card file found for this user.</p>
                @endif
            </div>
        </div>
        
        <div class="card">
            <h2>Make Decision</h2>
            
            <form action="{{ route('admin.verifications.idcard.approve', $user->id) }}" method="POST" style="display: inline-block; margin-right: 10px;">
                @csrf
                <button type="submit" class="btn btn-approve" onclick="return confirm('Approve this ID card?')">
                    ✅ Approve ID Card
                </button>
            </form>
            
            <form action="{{ route('admin.verifications.idcard.reject', $user->id) }}" method="POST" style="display: inline-block;">
                @csrf
                <div class="form-group" style="margin-top: 20px;">
                    <label for="reason">Rejection Reason (required for rejection)</label>
                    <textarea name="reason" id="reason" placeholder="Explain why this ID card is being rejected..."></textarea>
                </div>
                <button type="submit" class="btn btn-reject" onclick="return confirm('Reject this ID card?')">
                    ❌ Reject ID Card
                </button>
            </form>
        </div>
        
        <div class="alert alert-info">
            <strong>Note:</strong> After approving the ID card, the user will be fully verified.
        </div>
    </div>
</body>
</html>