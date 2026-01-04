<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Department Gatepass Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            font-size: 24px;
            margin: 0;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        .status-approved {
            background-color: #d4edda;
            color: #155724;
        }
        .status-rejected {
            background-color: #f8d7da;
            color: #721c24;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #666;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Department Gatepass Report</h1>
        <p>Generated on: {{ now()->format('M d, Y h:i A') }}</p>
        <p>Department: {{ Auth::user()->hod->department->name }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Gatepass #</th>
                <th>Student Name</th>
                <th>Register No.</th>
                <th>Date</th>
                <th>Out Time</th>
                <th>In Time</th>
                <th>Reason</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($gatepasses as $gatepass)
                <tr>
                    <td>{{ str_pad($gatepass->id, 6, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $gatepass->student->user->name }}</td>
                    <td>{{ $gatepass->student->register_number }}</td>
                    <td>{{ $gatepass->gatepass_date->format('M d, Y') }}</td>
                    <td>{{ $gatepass->out_time->format('h:i A') }}</td>
                    <td>{{ $gatepass->in_time->format('h:i A') }}</td>
                    <td>{{ Str::limit($gatepass->reason, 50) }}</td>
                    <td class="status-{{ $gatepass->status }}">{{ ucfirst(str_replace('_', ' ', $gatepass->status)) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Total Gatepasses: {{ $gatepasses->count() }}</p>
        <p>This is a computer-generated report. No signature required.</p>
    </div>
</body>
</html>
