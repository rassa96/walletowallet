<!DOCTYPE html>
<html>
<head>
    <title>Admin - Verifications</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background: #f0f2f5; }
        .container { max-width: 1200px; margin: 0 auto; }
        h1, h2 { color: #333; }
        .card { background: white; padding: 20px; border-radius: 8px; margin-bottom: 30px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #007bff; color: white; }
        .btn { display: inline-block; padding: 5px 10px; background: #007bff; color: white; text-decoration: none; border-radius: 3px; font-size: 12px; }
        .btn-review { background: #28a745; }
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 5px; }
        .alert-success { background: #d4edda; color: #155724; }
        .alert-warning { background: #fff3cd; color: #856404; }
        .back-btn { display: inline-block; margin-bottom: 20px; padding: 10px 15px; background: #6c757d; color: white; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <a href="/admin/dashboard" class="back-btn">← Back to Dashboard</a>
        <h1>Verification Management</h1>
        
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        @if(session('warning'))
            <div class="alert alert-warning">{{ session('warning') }}</div>
        @endif
        
        <!-- Pending Passports -->
        <div class="card">
            <h2>📄 Pending Passport Verifications ({{ $pendingPassports->count() }})</h2>
            @if($pendingPassports->count() > 0)
                <table>
                    <thead>
                        <tr><th>User</th><th>Email</th><th>Submitted</th><th>Action</th></tr>
                    </thead>
                    <tbody>
                        @foreach($pendingPassports as $request)
                        <tr>
                            <td>{{ $request->user->name }}</td>
                            <td>{{ $request->user->email }}</td>
                            <td>{{ $request->created_at->diffForHumans() }}</td>
                            <td><a href="{{ route('admin.verifications.passport.show', $request->user->id) }}" class="btn btn-review">Review Passport</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>✅ No pending passport verifications.</p>
            @endif
        </div>
        
        <!-- Pending ID Cards -->
        <div class="card">
            <h2>🪪 Pending ID Card Verifications ({{ $pendingIdCards->count() }})</h2>
            @if($pendingIdCards->count() > 0)
                <table>
                    <thead>
                        <tr><th>User</th><th>Email</th><th>ID Type</th><th>Submitted</th><th>Action</th></tr>
                    </thead>
                    <tbody>
                        @foreach($pendingIdCards as $request)
                        <tr>
                            <td>{{ $request->user->name }}</td>
                            <td>{{ $request->user->email }}</td>
                            <td>{{ ucfirst(str_replace('_', ' ', $request->id_card_type)) }}</td>
                            <td>{{ $request->created_at->diffForHumans() }}</td>
                            <td><a href="{{ route('admin.verifications.idcard.show', $request->user->id) }}" class="btn btn-review">Review ID Card</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>✅ No pending ID card verifications.</p>
            @endif
        </div>
        
        <!-- Recent Verifications -->
        <div class="card">
            <h2>Recent Verifications</h2>
            @if($recentVerifications->count() > 0)
                <table>
                    <thead>
                        <tr><th>User</th><th>Type</th><th>Status</th><th>Reviewed By</th><th>Date</th></tr>
                    </thead>
                    <tbody>
                        @foreach($recentVerifications as $request)
                        <tr>
                            <td>{{ $request->user->name }}</td>
                            <td>{{ ucfirst($request->verification_type) }}</td>
                            <td><span style="color: {{ $request->status == 'approved' ? 'green' : 'red' }}">{{ ucfirst($request->status) }}</span></td>
                            <td>{{ $request->reviewer->name ?? 'N/A' }}</td>
                            <td>{{ $request->reviewed_at ? $request->reviewed_at->format('Y-m-d H:i') : 'N/A' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No recent verifications.</p>
            @endif
        </div>
    </div>
</body>
</html>