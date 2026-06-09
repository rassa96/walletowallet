<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
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
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            text-align: center;
        }
        .stat-card h3 {
            margin: 0 0 10px 0;
            color: #666;
            font-size: 14px;
        }
        .stat-card .number {
            font-size: 32px;
            font-weight: bold;
            margin: 0;
            color: #007bff;
        }
        .stat-card.success .number {
            color: #28a745;
        }
        .stat-card.warning .number {
            color: #ffc107;
        }
        .nav-links {
            display: flex;
            gap: 15px;
            margin: 30px 0;
            flex-wrap: wrap;
        }
        .nav-links a {
            display: inline-block;
            padding: 12px 24px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .nav-links a:hover {
            background: #0056b3;
        }
        table {
            width: 100%;
            background: white;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
            margin-top: 20px;
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
        .logout-btn {
            padding: 10px 20px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Dashboard</h1>
        <p>Welcome, <strong>{{ auth()->user()->name }}</strong>!</p>
        
        <div class="stats">
            <div class="stat-card">
                <h3>Total Users</h3>
                <p class="number">{{ $totalUsers }}</p>
            </div>
            <div class="stat-card success">
                <h3>Verified Users</h3>
                <p class="number">{{ $verifiedUsers }}</p>
            </div>
            <div class="stat-card warning">
                <h3>Unverified Users</h3>
                <p class="number">{{ $unverifiedUsers }}</p>
            </div>
            <div class="stat-card">
                <h3>Total Transactions</h3>
                <p class="number">{{ $totalTransactions }}</p>
            </div>
        </div>
        
        <div class="stats">
            <div class="stat-card">
                <h3>📄 Pending Passports</h3>
                <p class="number">{{ $pendingPassports }}</p>
            </div>
            <div class="stat-card">
                <h3>🪪 Pending ID Cards</h3>
                <p class="number">{{ $pendingIdCards }}</p>
            </div>
        </div>
        
        <div class="nav-links">
            <a href="{{ route('admin.users') }}">👥 Manage Users</a>
            <a href="{{ route('admin.transactions') }}">📊 View Transactions</a>
            <a href="{{ route('admin.verifications') }}">📄 Verify Documents ({{ $totalPending }})</a>
            <a href="{{ route('admin.chat.index') }}">💬 Customer Support Chats</a>
        </div>
        
        <div style="margin-top: 30px;">
            <h2>Verified Users</h2>
            @if($verifiedUsersList->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Wallet Balance</th>
                        <th>Verified Since</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($verifiedUsersList as $index => $vUser)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $vUser->name }}</td>
                        <td>{{ $vUser->email }}</td>
                        <td>{{ $vUser->wallet ? number_format($vUser->wallet->balance, 2) : 'N/A' }}</td>
                        <td>{{ $vUser->updated_at->format('Y-m-d') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p style="color: #666; padding: 20px; background: white; border-radius: 8px;">No verified users yet.</p>
            @endif
        </div>

        <div style="margin-top: 30px;">
            <h2>Recent Users</h2>
            <table>
                <thead>
                    <tr><th>Name</th><th>Email</th><th>Verified</th><th>Registered</th></tr>
                </thead>
                <tbody>
                    @foreach($recentUsers as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->is_verified ? '✅ Yes' : '❌ No' }}</td>
                        <td>{{ $user->created_at->format('Y-m-d') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>
</body>
</html>
