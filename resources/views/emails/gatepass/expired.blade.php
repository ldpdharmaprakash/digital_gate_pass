<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gatepass Expired</title>
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
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 2px solid #e74c3c;
        }
        .header h1 {
            color: #e74c3c;
            margin: 0;
            font-size: 28px;
        }
        .content {
            padding: 20px 0;
        }
        .gatepass-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #e74c3c;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 5px 0;
        }
        .info-label {
            font-weight: bold;
            color: #555;
        }
        .info-value {
            color: #333;
        }
        .status-badge {
            background-color: #e74c3c;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #777;
            font-size: 12px;
        }
        .warning-text {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 5px;
            padding: 15px;
            margin: 20px 0;
            color: #856404;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Gatepass Expired</h1>
        </div>

        <div class="content">
            <p>Dear {{ $gatepass->student->user->name }},</p>
            
            <p>Your gatepass has expired automatically because the entry time has passed.</p>

            <div class="gatepass-info">
                <h3>Gatepass Details</h3>
                <div class="info-row">
                    <span class="info-label">Gatepass ID:</span>
                    <span class="info-value">#{{ str_pad($gatepass->id, 6, '0', STR_PAD_LEFT) }}</span>
                </div>
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
                        <span class="status-badge">Expired</span>
                    </span>
                </div>
            </div>

            <div class="warning-text">
                <strong>Important:</strong> This gatepass is no longer valid. If you still need to go out, please submit a new gatepass request.
            </div>

            <p>If you believe this is an error or have any questions, please contact the administration.</p>
        </div>

        <div class="footer">
            <p>This is an automated message from {{ config('app.name') }} Digital Gate Pass System.</p>
            <p>If you did not expect this email, please contact the system administrator.</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
