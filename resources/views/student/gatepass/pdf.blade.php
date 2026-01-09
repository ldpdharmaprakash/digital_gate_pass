<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Gatepass #{{ str_pad($gatepass->id, 6, '0', STR_PAD_LEFT) }}</title>
    <style>
        @page {
            size: A4;
            margin: 20mm;
            header: html_pageHeader;
            footer: html_pageFooter;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: #333;
            position: relative;
        }
        
        @if($watermarkBase64)
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.1;
            z-index: -1;
            pointer-events: none;
            width: 250px;
            height: auto;
        }
        @endif
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #1e40af;
            padding-bottom: 20px;
        }
        
        .header h1 {
            font-size: 28px;
            margin: 0;
            color: #1e40af;
            font-weight: bold;
        }
        
        .header h2 {
            font-size: 18px;
            margin: 5px 0;
            color: #666;
        }
        
        .gatepass-id {
            background: #1e40af;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
        }
        
        .section {
            margin-bottom: 25px;
        }
        
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 10px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 5px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .info-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #f3f4f6;
        }
        
        .info-label {
            font-weight: 600;
            color: #4b5563;
        }
        
        .info-value {
            font-weight: 500;
            color: #1f2937;
        }
        
        .reason-box {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 5px;
            padding: 15px;
            min-height: 80px;
        }
        
        .qr-section {
            text-align: center;
            margin: 30px 0;
        }
        
        .qr-code {
            display: inline-block;
            padding: 20px;
            background: white;
            border: 2px solid #1e40af;
            border-radius: 10px;
        }
        
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 12px;
        }
        
        .status-approved {
            background: #10b981;
            color: white;
        }
        
        .signatures {
            margin-top: 50px;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 30px;
        }
        
        .signature-box {
            text-align: center;
            padding: 20px;
            border: 1px solid #e5e7eb;
            border-radius: 5px;
            min-height: 120px;
        }
        
        .signature-line {
            border-bottom: 1px solid #9ca3af;
            margin: 20px 0 10px;
            height: 40px;
        }
        
        .signature-label {
            font-size: 12px;
            color: #6b7280;
        }
        
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            font-size: 12px;
            color: #6b7280;
        }
        
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 100px;
            color: rgba(59, 130, 246, 0.1);
            font-weight: bold;
            z-index: -1;
        }
    </style>
</head>
<body>
    <!-- Watermark for approved gatepasses -->
    @if($watermarkBase64)
        <div class="watermark">
            <img src="{{ $watermarkBase64 }}" alt="Watermark" style="width: 100%; height: auto;">
        </div>
    @endif

    <!-- Header -->
    <div class="header">
        <h1>DIGITAL GATEPASS SYSTEM</h1>
        <h2>{{ config('app.name', 'College Management System') }}</h2>
        <p>{{ now()->format('M d, Y') }}</p>
    </div>

    <!-- Gatepass ID -->
    <div class="gatepass-id">
        Gatepass #{{ str_pad($gatepass->id, 6, '0', STR_PAD_LEFT) }}
    </div>

    <!-- Status Badge -->
    <div style="text-align: center; margin-bottom: 30px;">
        @if($gatepass->isFinalApproved())
            <span class="status-badge status-approved">✓ FINAL APPROVED</span>
        @else
            <span class="status-badge" style="background: #f59e0b; color: white;">PENDING</span>
        @endif
    </div>

    <!-- Student Information -->
    <div class="section">
        <div class="section-title">STUDENT INFORMATION</div>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Name:</span>
                <span class="info-value">{{ $gatepass->student->user->name }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Register Number:</span>
                <span class="info-value">{{ $gatepass->student->register_number }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Department:</span>
                <span class="info-value">{{ $gatepass->student->department->name }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Semester:</span>
                <span class="info-value">{{ $gatepass->student->semester }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Hosteller:</span>
                <span class="info-value">{{ ucfirst($gatepass->student->hosteller) }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Phone:</span>
                <span class="info-value">{{ $gatepass->student->user->phone ?? 'N/A' }}</span>
            </div>
        </div>
    </div>

    <!-- Gatepass Details -->
    <div class="section">
        <div class="section-title">GATEPASS DETAILS</div>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Date:</span>
                <span class="info-value">{{ $gatepass->gatepass_date->format('M d, Y') }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Out Time:</span>
                <span class="info-value">{{ $gatepass->out_time->format('h:i A') }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">In Time:</span>
                <span class="info-value">{{ $gatepass->in_time->format('h:i A') }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Duration:</span>
                <span class="info-value">{{ $gatepass->out_time->diffInHours($gatepass->in_time) }} hours</span>
            </div>
        </div>
    </div>

    <!-- Reason -->
    <div class="section">
        <div class="section-title">REASON FOR GATEPASS</div>
        <div class="reason-box">
            {{ $gatepass->reason }}
        </div>
    </div>

    <!-- QR Code -->
    @if($gatepass->isFinalApproved() && $gatepass->qr_code)
        <div class="qr-section">
            <div class="section-title">VERIFICATION QR CODE</div>
            <div class="qr-code">
                {!! QrCode::size(150)->generate($gatepass->qr_code) !!}
                <p style="margin-top: 10px; font-size: 12px; color: #666;">Scan to verify</p>
            </div>
        </div>
    @endif

    <!-- Approval Signatures -->
    <div class="section">
        <div class="section-title">APPROVAL SIGNATURES</div>
        <div class="signatures">
            <!-- Staff Signature -->
            <div class="signature-box">
                @if($gatepass->staff_approved_at)
                    <div class="signature-line">
                        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg==" alt="Signature" style="height: 40px;" />
                    </div>
                    <div class="signature-label">{{ $gatepass->staffApprovedBy->name }}</div>
                    <div class="signature-label">Staff</div>
                    <div class="signature-label">{{ $gatepass->staff_approved_at->format('M d, Y') }}</div>
                @else
                    <div class="signature-line"></div>
                    <div class="signature-label">Staff Signature</div>
                    <div class="signature-label">Pending</div>
                @endif
            </div>

            <!-- HOD Signature -->
            <div class="signature-box">
                @if($gatepass->hod_approved_at)
                    <div class="signature-line">
                        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg==" alt="Signature" style="height: 40px;" />
                    </div>
                    <div class="signature-label">{{ $gatepass->hodApprovedBy->name }}</div>
                    <div class="signature-label">Head of Department</div>
                    <div class="signature-label">{{ $gatepass->hod_approved_at->format('M d, Y') }}</div>
                @else
                    <div class="signature-line"></div>
                    <div class="signature-label">HOD Signature</div>
                    <div class="signature-label">Pending</div>
                @endif
            </div>

            <!-- Warden Signature (for hostellers) -->
            @if($gatepass->student->hosteller === 'yes')
                <div class="signature-box">
                    @if($gatepass->warden_approved_at)
                        <div class="signature-line">
                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg==" alt="Signature" style="height: 40px;" />
                        </div>
                        <div class="signature-label">{{ $gatepass->wardenApprovedBy->name }}</div>
                        <div class="signature-label">Warden</div>
                        <div class="signature-label">{{ $gatepass->warden_approved_at->format('M d, Y') }}</div>
                    @else
                        <div class="signature-line"></div>
                        <div class="signature-label">Warden Signature</div>
                        <div class="signature-label">Pending</div>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p><strong>Important Instructions:</strong></p>
        <ul style="text-align: left; max-width: 600px; margin: 10px auto;">
            <li>This gatepass is valid only on the date mentioned above</li>
            <li>Student must carry this gatepass and college ID card</li>
            <li>Security personnel may verify this gatepass using the QR code</li>
            <li>This is a computer-generated document, no manual signature required</li>
        </ul>
        <p style="margin-top: 20px;">Generated on: {{ now()->format('M d, Y h:i A') }} | Gatepass ID: {{ $gatepass->qr_code ?? 'N/A' }}</p>
    </div>
</body>
</html>
