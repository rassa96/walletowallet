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
        .btn-delete {
            background: #dc3545;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
        }
        .btn-delete:hover { background: #c82333; }
        .btn-delete:disabled { background: #ccc; cursor: not-allowed; }
        .alert {
            padding: 12px 16px;
            border-radius: 5px;
            margin-bottom: 16px;
        }
        .alert-success { background: #d4edda; color: #155724; }
        .alert-danger { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <div class="container">
        <a href="/admin/dashboard" class="back-btn">← Back to Dashboard</a>
        <h1>User Management</h1>
        
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        
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
                    <th>Action</th>
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
                    <td>
                        @if($user->id == auth()->id())
                            <button class="btn-delete" disabled title="You cannot delete yourself">You</button>
                        @elseif($user->is_admin == 1)
                            <button class="btn-delete" disabled title="Cannot delete admin">Admin</button>
                        @else
                            <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete user \'{{ $user->name }}\'? This will permanently delete their wallet, transactions, verifications, and chat messages.');">
                                @csrf
                                <button type="submit" class="btn-delete">Delete</button>
                            </form>
                        @endif
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
