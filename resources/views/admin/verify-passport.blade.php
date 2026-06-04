<!DOCTYPE html>
<html>
<head>
    <title>Admin - Verify Passport</title>
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
        .alert-success {
            background: #d4edda;
            color: #155724;
        }
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('admin.verifications') }}" class="btn-back">← Back to Verifications</a>
        
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        
        <div class="card">
            <h1>Review Passport Verification</h1>
            
            <div class="user-info">
                <h2>User Information</h2>
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Registered:</strong> {{ $user->created_at->format('F j, Y') }}</p>
                <p><strong>Submitted:</strong> {{ $verificationRequest->created_at->format('F j, Y, g:i a') }}</p>
            </div>
            
            <div class="document-view">
                <h2>Passport Document</h2>
                @if($user->passport_path)
                    @php
                        $extension = pathinfo($user->passport_path, PATHINFO_EXTENSION);
                    @endphp
                    
                    @if(in_array($extension, ['jpg', 'jpeg', 'png']))
                        <img src="{{ asset('storage/' . $user->passport_path) }}" alt="Passport">
                    @elseif($extension == 'pdf')
                        <iframe src="{{ asset('storage/' . $user->passport_path) }}" width="100%" height="500px"></iframe>
                    @else
                        <p>File type not previewable. <a href="{{ asset('storage/' . $user->passport_path) }}" target="_blank">Click here to view</a></p>
                    @endif
                    
                    <p><a href="{{ route('admin.verifications.passport.view', $user->id) }}" target="_blank" style="color: #007bff;">Open in new tab</a></p>
                @else
                    <p class="alert alert-danger">No passport file found for this user.</p>
                @endif
            </div>
        </div>

        <div class="document-view">
    <h2>Passport Document</h2>
    
    <!-- Debug info - Remove after fixing -->
    @if(isset($fileExists))
        <div class="alert alert-info">
            <strong>Debug Info:</strong><br>
            File path in database: {{ $user->passport_path ?? 'NULL' }}<br>
            File exists on server: {{ $fileExists ? 'Yes' : 'No' }}<br>
            User ID: {{ $user->id }}
        </div>
    @endif
    
    @if($user->passport_path)
        @php
            $extension = pathinfo($user->passport_path, PATHINFO_EXTENSION);
            $fullUrl = asset('storage/' . $user->passport_path);
        @endphp
        
        <p><strong>File:</strong> {{ $user->passport_path }}</p>
        <p><strong>Full URL:</strong> <a href="{{ $fullUrl }}" target="_blank">{{ $fullUrl }}</a></p>
        
        @if(in_array($extension, ['jpg', 'jpeg', 'png']))
            <img src="{{ $fullUrl }}" alt="Passport" style="max-width: 100%; max-height: 500px; border: 1px solid #ddd; border-radius: 5px;">
        @elseif($extension == 'pdf')
            <iframe src="{{ $fullUrl }}" width="100%" height="500px"></iframe>
        @else
            <p>File type: {{ $extension }}. <a href="{{ $fullUrl }}" target="_blank">Click here to view/download</a></p>
        @endif
        
        <p><a href="{{ route('admin.verifications.passport.view', $user->id) }}" target="_blank" style="color: #007bff;">Open in new tab</a></p>
    @else
        <div class="alert alert-danger">
            <strong>No passport file found for this user.</strong><br>
            The user may not have uploaded a passport yet.
        </div>
        
        @if($user->id_card_path)
            <div class="alert alert-info">
                This user has uploaded an ID card instead. <a href="{{ route('admin.verifications.idcard.show', $user->id) }}">Click here to review ID card</a>
            </div>
        @endif
    @endif
</div>
        
        <div class="card">
            <h2>Make Decision</h2>
            
            <form action="{{ route('admin.verifications.passport.approve', $user->id) }}" method="POST" style="display: inline-block; margin-right: 10px;">
                @csrf
                <button type="submit" class="btn btn-approve" onclick="return confirm('Approve this passport?')">
                    ✅ Approve Passport
                </button>
            </form>
            
            <form action="{{ route('admin.verifications.passport.reject', $user->id) }}" method="POST" style="display: inline-block;">
                @csrf
                <div class="form-group" style="margin-top: 20px;">
                    <label for="reason">Rejection Reason (required for rejection)</label>
                    <textarea name="reason" id="reason" placeholder="Explain why this passport is being rejected..."></textarea>
                </div>
                <button type="submit" class="btn btn-reject" onclick="return confirm('Reject this passport?')">
                    ❌ Reject Passport
                </button>
            </form>
        </div>
    
        
        <div class="alert alert-info">
            <strong>Note:</strong> After approving the passport, the user will be verified and can send/receive money.
        </div>
    </div>
</body>
</html>