<!DOCTYPE html>
<html>
<head>
    <title>Admin - All Transactions</title>
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
        .completed {
            color: green;
            font-weight: bold;
        }
        .pending {
            color: orange;
            font-weight: bold;
        }
        .failed {
            color: red;
            font-weight: bold;
        }
        .pagination {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="/admin/dashboard" class="back-btn">← Back to Dashboard</a>
        <h1>All Transactions</h1>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Description</th>
                    <th>Reference</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->id }}</td>
                    <td>{{ $transaction->user->name ?? 'N/A' }}</td>
                    <td>{{ ucfirst($transaction->type ?? 'transfer') }}</td>
                    <td>${{ number_format($transaction->amount, 2) }}</td>
                    <td>{{ $transaction->description ?? 'N/A' }}</td>
                    <td>{{ $transaction->reference ?? 'N/A' }}</td>
                    <td class="{{ $transaction->status }}">
                        {{ ucfirst($transaction->status) }}
                    </td>
                    <td>{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="pagination">
            {{ $transactions->links() }}
        </div>
    </div>
</body>
</html>