<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gatepass Notification</title>
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
        .status-pending {
            background-color: #ffc107;
            color: #856404;
        }
        .status-staff_approved {
            background-color: #17a2b8;
            color: #fff;
        }
        .status-hod_approved {
            background-color: #6f42c1;
            color: #fff;
        }
        .action-buttons {
            text-align: center;
            margin: 30px 0;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            margin: 0 10px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        .btn-approve {
            background-color: #28a745;
            color: #ffffff;
        }
        .btn-approve:hover {
            background-color: #218838;
            transform: translateY(-2px);
        }
        .btn-reject {
            background-color: #dc3545;
            color: #ffffff;
        }
        .btn-reject:hover {
            background-color: #c82333;
            transform: translateY(-2px);
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
            color: #6c757d;
            font-size: 12px;
        }
        .warning-text {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            color: #856404;
        }
        @media only screen and (max-width: 480px) {
            .container {
                padding: 20px;
            }
            .btn {
                display: block;
                width: 100%;
                margin: 10px 0;
            }
            .info-row {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Gatepass Notification</h1>
            <p>{{ config('app.name') }} - Digital Gate Pass System</p>
        </div>

        <p>Dear <strong>{{ $recipient->name }}</strong>,</p>

        @switch($approvalType)
            @case('staff')
                <p>A new gatepass request has been submitted by a student and requires your review and approval.</p>
                @break
            @case('hod')
                <p>A gatepass request has been approved by the class teacher and now requires your approval.</p>
                @break
            @case('warden')
                <p>A gatepass request has been approved by the HOD and requires your final approval.</p>
                @break
            @case('security')
                <p>A gatepass request has been fully approved and is now active. This is for your information.</p>
                @break
            @default
                <p>You have a gatepass notification that requires your attention.</p>
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

        @if($approvalType !== 'security')
            <div class="warning-text">
                <strong>Please review this request carefully.</strong> Your approval or rejection will be recorded and the student will be notified accordingly.
            </div>

            <div class="action-buttons">
                <a href="{{ route('gatepass.approve.email', [$gatepass->id, $recipient->id, $approveToken]) }}" class="btn btn-approve">
                    <i class="fas fa-check"></i> Approve
                </a>
                <a href="{{ route('gatepass.reject.email', [$gatepass->id, $recipient->id, $rejectToken]) }}" class="btn btn-reject">
                    <i class="fas fa-times"></i> Reject
                </a>
            </div>
        @else
            <div class="gatepass-info">
                <h3>Final Approval Status</h3>
                <p>This gatepass has been fully approved and is now active. The student can use this gatepass on the specified date and time.</p>
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
