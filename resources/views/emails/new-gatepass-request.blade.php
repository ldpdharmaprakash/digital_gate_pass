<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Gatepass Request</title>
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
            background: linear-gradient(135deg, #1e40af, #3b82f6);
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
        .info-box {
            background: #f8f9fa;
            border-left: 4px solid #1e40af;
            padding: 15px;
            margin: 20px 0;
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
            color: #1e40af;
        }
        .details p {
            margin: 5px 0;
        }
        .action-button {
            display: inline-block;
            background: #1e40af;
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
            <h1>🎓 New Gatepass Request</h1>
            <p>Digital Gatepass Management System</p>
        </div>

        <p>Dear {{ $recipient->name }},</p>

        <div class="info-box">
            <strong>A new gatepass request has been submitted by a student in your department and requires your attention.</strong>
        </div>

        <div class="details">
            <h3>Student Information</h3>
            <p><strong>Name:</strong> {{ $student->user->name }}</p>
            <p><strong>Register Number:</strong> {{ $student->register_number }}</p>
            <p><strong>Department:</strong> {{ $department->name }}</p>
            <p><strong>Semester:</strong> {{ $student->semester }}</p>
            <p><strong>Hosteller:</strong> {{ ucfirst($student->hosteller) }}</p>
        </div>

        <div class="details">
            <h3>Gatepass Details</h3>
            <p><strong>Gatepass ID:</strong> #{{ str_pad($gatepass->id, 6, '0', STR_PAD_LEFT) }}</p>
            <p><strong>Date:</strong> {{ $gatepass->gatepass_date->format('M d, Y') }}</p>
            <p><strong>Out Time:</strong> {{ $gatepass->out_time->format('h:i A') }}</p>
            <p><strong>In Time:</strong> {{ $gatepass->in_time->format('h:i A') }}</p>
            <p><strong>Duration:</strong> {{ $gatepass->out_time->diffInHours($gatepass->in_time) }} hours</p>
            <p><strong>Reason:</strong> {{ $gatepass->reason }}</p>
        </div>

        @if($recipient->isStaff())
            <p>Please log in to the system to review and approve or reject this request.</p>
        @endif

        @if($recipient->isHod())
            <p>This request has been reviewed by staff and is now pending your approval.</p>
        @endif

        <div style="text-align: center;">
            <a href="{{ url('/login') }}" class="action-button">Review Request</a>
        </div>

        <div class="footer">
            <p>This is an automated message from the Digital Gatepass Management System.</p>
            <p>If you have any questions, please contact the system administrator.</p>
        </div>
    </div>
</body>
</html>
