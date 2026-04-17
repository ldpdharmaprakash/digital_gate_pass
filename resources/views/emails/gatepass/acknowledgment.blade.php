<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gatepass Acknowledgment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 2px solid #e9ecef;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #2c3e50;
            margin: 0;
            font-size: 24px;
        }
        .gatepass-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #007bff;
        }
        .gatepass-info h3 {
            margin-top: 0;
            color: #495057;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
            padding: 5px 0;
        }
        .info-label {
            font-weight: bold;
            color: #6c757d;
        }
        .info-value {
            color: #495057;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-pending { background-color: #ffc107; color: #856404; }
        .status-staff_approved { background-color: #17a2b8; color: #fff; }
        .status-hod_approved { background-color: #6f42c1; color: #fff; }
        .status-final_approved { background-color: #28a745; color: #fff; }
        .status-rejected { background-color: #dc3545; color: #fff; }
        
        .action-info {
            background-color: #e9ecef;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #6c757d;
        }
        .action-info.approved {
            border-left-color: #28a745;
            background-color: #d4edda;
        }
        .action-info.rejected {
            border-left-color: #dc3545;
            background-color: #f8d7da;
        }
        .action-info.submitted {
            border-left-color: #17a2b8;
            background-color: #d1ecf1;
        }
        
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
            color: #6c757d;
            font-size: 12px;
        }
        .portal-link {
            text-align: center;
            margin: 20px 0;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            background-color: #007bff;
            color: #ffffff;
            transition: all 0.3s ease;
        }
        .btn:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }
        @media only screen and (max-width: 480px) {
            .container { padding: 20px; }
            .info-row { flex-direction: column; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Gatepass Acknowledgment</h1>
            <p>{{ config('app.name') }} - Digital Gate Pass System</p>
        </div>

        <p>Dear <strong>{{ $recipient ? $recipient->name : 'User' }}</strong>,</p>

        @switch($action)
            @case('submitted')
                <div class="action-info submitted">
                    <h3>Gatepass Request Submitted</h3>
                    <p>A new gatepass request has been submitted by <strong>{{ $gatepass->student->user->name }}</strong> and is now awaiting approval.</p>
                </div>
                @break
                
            @case('approved')
                <div class="action-info approved">
                    <h3>Gatepass Approved</h3>
                    <p>The gatepass request has been <strong>approved</strong> by <strong>{{ $actor->name }}</strong> ({{ ucfirst($actor->role) }}).</p>
                </div>
                @break
                
            @case('rejected')
                <div class="action-info rejected">
                    <h3>Gatepass Rejected</h3>
                    <p>The gatepass request has been <strong>rejected</strong> by <strong>{{ $actor->name }}</strong> ({{ ucfirst($actor->role) }}).</p>
                </div>
                @break
                
            @case('final_approved')
                <div class="action-info approved">
                    <h3>Gatepass Fully Approved</h3>
                    <p>The gatepass request has been <strong>fully approved</strong> and is now active. The student can use this gatepass on the specified date and time.</p>
                </div>
                @break
        @endswitch

        <div class="gatepass-info">
            <h3>Gatepass Details</h3>
            <div class="info-row">
                <span class="info-label">Student Name:</span>
                <span class="info-value">{{ $gatepass->student->user->name }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Register Number:</span>
                <span class="info-value">{{ $gatepass->student->register_number }}</span>
            </div>
            @if($gatepass->student->department)
                <div class="info-row">
                    <span class="info-label">Department:</span>
                    <span class="info-value">{{ $gatepass->student->department->name }}</span>
                </div>
            @endif
            <div class="info-row">
                <span class="info-label">Gatepass Date:</span>
                <span class="info-value">{{ $gatepass->gatepass_date->format('d M Y') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Out Time:</span>
                <span class="info-value">{{ $gatepass->out_time->format('h:i A') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">In Time:</span>
                <span class="info-value">{{ $gatepass->in_time->format('h:i A') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Reason:</span>
                <span class="info-value">{{ $gatepass->reason }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Current Status:</span>
                <span class="info-value">
                    <span class="status-badge status-{{ $gatepass->status }}">
                        {{ str_replace('_', ' ', ucfirst($gatepass->status)) }}
                    </span>
                </span>
            </div>
        </div>

        @if($action === 'approved' && $gatepass->status !== 'final_approved')
            <div class="portal-link">
                <p>This gatepass is now pending approval from the next authority. You can review and approve it through the portal:</p>
                <a href="{{ url('/login') }}" class="btn">Open Portal</a>
            </div>
        @elseif($action === 'rejected')
            <div class="portal-link">
                <p>The gatepass request has been rejected. You can view the details in the portal:</p>
                <a href="{{ url('/login') }}" class="btn">Open Portal</a>
            </div>
        @elseif($action === 'final_approved')
            <div class="portal-link">
                <p>The gatepass is now fully approved and active. You can view the details in the portal:</p>
                <a href="{{ url('/login') }}" class="btn">Open Portal</a>
            </div>
        @endif

        <div class="footer">
            <p>This is an automated message from {{ config('app.name') }} Digital Gate Pass System.</p>
            <p>If you did not expect this email, please contact the system administrator.</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
