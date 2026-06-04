<!DOCTYPE html>
<html>
<head>
    <title>Admin - Users Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f0f2f5;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        h1 {
            color: #333;
        }
        .back-btn {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 15px;
            background: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        table {
            width: 100%;
            background: white;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #007bff;
            color: white;
        }
        .verified {
            color: green;
            font-weight: bold;
        }
        .unverified {
            color: red;
        }
        .pagination {
            margin-top: 20px;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 12px;
        }
        .badge-success {
            background: #28a745;
            color: white;
        }
        .badge-danger {
            background: #dc3545;
            color: white;
        }
        .badge-warning {
            background: #ffc107;
            color: #000;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="/admin/dashboard" class="back-btn">← Back to Dashboard</a>
        <h1>User Management</h1>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Wallet Address</th>
                    <th>Balance</th>
                    <th>Passport</th>
                    <th>ID Card</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->wallet->wallet_address ?? 'No wallet' }}</td>
                    <td>${{ number_format($user->wallet->balance ?? 0, 2) }}</td>
                    <td class="{{ $user->is_verified == 1 ? 'verified' : 'unverified' }}">
    @if($user->is_verified == 1)
        ✅ Yes
    @else
        ❌ No
    @endif
</td>
                    <td>
                        @if($user->id_card_verified)
                            <span class="badge badge-success">Verified</span>
                        @elseif($user->id_card_path)
                            <span class="badge badge-warning">Pending</span>
                        @else
                            <span class="badge badge-danger">Not Uploaded</span>
                        @endif
                    </td>
                    <td class="{{ $user->is_verified && $user->id_card_verified ? 'verified' : 'unverified' }}">
                        {{ $user->is_verified && $user->id_card_verified ? 'Fully Verified' : 'Not Verified' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="pagination">
            {{ $users->links() }}
        </div>
    </div>
</body>
</html>