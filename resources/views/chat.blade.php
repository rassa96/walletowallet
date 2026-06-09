<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, viewport-fit=cover">

    <link rel="stylesheet" href="{{ asset('fonts/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('icons/icomoon/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/styles.css') }}" />

    <link rel="shortcut icon" href="{{ asset('images/logo/40.png') }}" />
    <title>Chat with Support - EasyPay</title>
    
    <style>
        body { background:#f0f2f5; }
        .chat-container {
            max-width: 720px;
            margin: 0 auto;
            background: #fff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .chat-header {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        .chat-header .back-btn {
            color: white;
            font-size: 22px;
            background: rgba(255,255,255,0.15);
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }
        .chat-header .info h5 { margin:0; font-size:16px; font-weight:600; }
        .chat-header .info p { margin:0; font-size:12px; opacity:0.85; }
        .messages-area {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            background: #f7f8fa;
            min-height: 400px;
        }
        .message {
            margin-bottom: 14px;
            display: flex;
        }
        .message.from-user { justify-content: flex-end; }
        .message.from-admin { justify-content: flex-start; }
        .message-bubble {
            max-width: 75%;
            padding: 10px 14px;
            border-radius: 16px;
            font-size: 14px;
            line-height: 1.45;
            word-wrap: break-word;
        }
        .message.from-user .message-bubble {
            background: #007bff;
            color: white;
            border-bottom-right-radius: 4px;
        }
        .message.from-admin .message-bubble {
            background: white;
            color: #333;
            border: 1px solid #e0e0e0;
            border-bottom-left-radius: 4px;
        }
        .message-time {
            font-size: 11px;
            margin-top: 4px;
            opacity: 0.7;
        }
        .input-area {
            background: white;
            padding: 12px 16px;
            border-top: 1px solid #e0e0e0;
            position: sticky;
            bottom: 0;
        }
        .input-form { display: flex; gap: 8px; }
        .input-form input[type="text"] {
            flex: 1;
            padding: 12px 16px;
            border: 1px solid #ddd;
            border-radius: 24px;
            font-size: 14px;
            outline: none;
        }
        .input-form input[type="text"]:focus { border-color: #007bff; }
        .input-form button {
            background: #007bff;
            color: white;
            border: none;
            border-radius: 50%;
            width: 44px;
            height: 44px;
            cursor: pointer;
            font-size: 18px;
        }
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }
        .empty-state i { font-size: 48px; margin-bottom: 12px; }
    </style>
</head>

<body>
    <div class="chat-container">
        <!-- Header -->
        <div class="chat-header">
            <a href="{{ url('/') }}" class="back-btn"><i class="icon-icon-arrow-narrow-left-2"></i></a>
            <div class="info">
                <h5>Customer Support</h5>
                <p>We typically reply within a few minutes</p>
            </div>
        </div>
        
        <!-- Messages -->
        <div class="messages-area" id="messages-area">
            @forelse($messages as $msg)
                <div class="message {{ $msg->is_from_admin ? 'from-admin' : 'from-user' }}">
                    <div>
                        <div class="message-bubble">{{ $msg->message }}</div>
                        <div class="message-time {{ $msg->is_from_admin ? 'text-start' : 'text-end' }}" style="text-align:{{ $msg->is_from_admin ? 'left' : 'right' }};">
                            {{ $msg->created_at->format('M d, h:i A') }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="icon-message"></i>
                    <p style="font-size:16px; font-weight:600; margin-top:8px;">Start a conversation</p>
                    <p style="font-size:13px;">Send a message to our support team and they'll respond as soon as possible.</p>
                </div>
            @endforelse
        </div>
        
        <!-- Input -->
        <div class="input-area">
            <form action="{{ route('chat.send') }}" method="POST" class="input-form">
                @csrf
                <input type="text" name="message" placeholder="Type your message..." maxlength="2000" required autofocus>
                <button type="submit" title="Send"><i class="icon-icon-send"></i></button>
            </form>
        </div>
    </div>
    
    <script>
        // Auto-scroll to bottom on load
        var area = document.getElementById('messages-area');
        if (area) area.scrollTop = area.scrollHeight;
    </script>
</body>
</html>
