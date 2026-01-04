<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gatepass Rejected</title>
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
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 10px 10px 0 0;
            margin: -30px -30px 20px -30px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .error-box {
            background: #fee2e2;
            border-left: 4px solid #ef4444;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .details {
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 5px;
            padding: 20px;
            margin: 20px 0;
        }
        .details h3 {
            margin-top: 0;
            color: #ef4444;
        }
        .details p {
            margin: 5px 0;
        }
        .remarks-box {
            background: #fef3c7;
            border: 1px solid #f59e0b;
            border-radius: 5px;
            padding: 15px;
            margin: 20px 0;
        }
        .action-button {
            display: inline-block;
            background: #ef4444;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
            color: #666;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>❌ Gatepass Rejected</h1>
            <p>Digital Gatepass Management System</p>
        </div>

        <p>Dear {{ $student->user->name }},</p>

        <div class="error-box">
            <strong>Your gatepass request has been rejected.</strong>
        </div>

        <div class="details">
            <h3>Rejection Details</h3>
            <p><strong>Gatepass ID:</strong> #{{ str_pad($gatepass->id, 6, '0', STR_PAD_LEFT) }}</p>
            <p><strong>Rejected By:</strong> {{ $rejectedBy->name }} ({{ ucfirst($rejectionType) }})</p>
            <p><strong>Date:</strong> {{ $gatepass->gatepass_date->format('M d, Y') }}</p>
            <p><strong>Out Time:</strong> {{ $gatepass->out_time->format('h:i A') }}</p>
            <p><strong>In Time:</strong> {{ $gatepass->in_time->format('h:i A') }}</p>
            <p><strong>Reason:</strong> {{ $gatepass->reason }}</p>
        </div>

        @if($remarks)
            <div class="remarks-box">
                <h4>Remarks:</h4>
                <p>{{ $remarks }}</p>
            </div>
        @endif

        <p>If you believe this rejection was made in error or if you need clarification, please contact the {{ ucfirst($rejectionType) }} office.</p>

        <p>You can submit a new gatepass request with updated information if needed.</p>

        <div style="text-align: center;">
            <a href="{{ url('/student/gatepasses/create') }}" class="action-button">Create New Request</a>
        </div>

        <div class="footer">
            <p>This is an automated message from the Digital Gatepass Management System.</p>
            <p>If you have any questions, please contact the system administrator.</p>
        </div>
    </div>
</body>
</html>
