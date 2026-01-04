<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gatepass Approved</title>
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
            background: linear-gradient(135deg, #10b981, #059669);
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
        .success-box {
            background: #d1fae5;
            border-left: 4px solid #10b981;
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
            color: #10b981;
        }
        .details p {
            margin: 5px 0;
        }
        .action-button {
            display: inline-block;
            background: #10b981;
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
        .pdf-notice {
            background: #fef3c7;
            border: 1px solid #f59e0b;
            border-radius: 5px;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✅ Gatepass Approved</h1>
            <p>Digital Gatepass Management System</p>
        </div>

        <p>Dear {{ $student->user->name }},</p>

        <div class="success-box">
            <strong>Great news! Your gatepass request has been approved.</strong>
        </div>

        @if($isFinalApproved)
            <div class="pdf-notice">
                <strong>📄 Your approved gatepass PDF is attached to this email!</strong><br>
                Please save it for your records and show it when required.
            </div>
        @endif

        <div class="details">
            <h3>Approval Details</h3>
            <p><strong>Gatepass ID:</strong> #{{ str_pad($gatepass->id, 6, '0', STR_PAD_LEFT) }}</p>
            <p><strong>Approved By:</strong> {{ $approvedBy->name }} ({{ ucfirst($approvalType) }})</p>
            <p><strong>Date:</strong> {{ $gatepass->gatepass_date->format('M d, Y') }}</p>
            <p><strong>Out Time:</strong> {{ $gatepass->out_time->format('h:i A') }}</p>
            <p><strong>In Time:</strong> {{ $gatepass->in_time->format('h:i A') }}</p>
            <p><strong>Duration:</strong> {{ $gatepass->out_time->diffInHours($gatepass->in_time) }} hours</p>
            <p><strong>Reason:</strong> {{ $gatepass->reason }}</p>
        </div>

        @if($isFinalApproved)
            <p><strong>Your gatepass is now final approved and ready to use!</strong></p>
            <p>Please carry this gatepass (either printed or on your mobile device) when leaving the campus.</p>
        @else
            <p>Your gatepass has been approved by the {{ ucfirst($approvalType) }} and is now pending further approval.</p>
        @endif

        <div style="text-align: center;">
            <a href="{{ url('/student/gatepasses') }}" class="action-button">View All Gatepasses</a>
        </div>

        <div class="footer">
            <p>This is an automated message from the Digital Gatepass Management System.</p>
            <p>If you have any questions, please contact the system administrator.</p>
        </div>
    </div>
</body>
</html>
