<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Gatepass #{{ str_pad($gatepass->id, 6, '0', STR_PAD_LEFT) }}</title>

<style>
@page { size:A4; margin:12mm; }

body{
    font-family: Arial;
    font-size:12px;
    color:#222;
}

/* WATERMARK */
.watermark{
    position:fixed;
    top:35%;
    left:20%;
    width:350px;
    opacity:0.06;
    z-index:-1;
}

/* HEADER */
.header{
    border-bottom:3px solid {{ $primaryColor }};
    padding-bottom:8px;
}

.logo{ width:60px; }

.header-title{text-align:center;}
.header-title h1{ margin:0; color:{{ $primaryColor }}; font-size:20px; }
.header-title p{ margin:0; font-size:12px; }

/* ID BAR */
.gatepass-id{
    background:{{ $primaryColor }};
    color:#fff;
    text-align:center;
    padding:6px;
    margin:10px 0;
    font-weight:bold;
}

/* SECTION */
.section-title{
    background:#f1f5f9;
    border-left:4px solid {{ $primaryColor }};
    padding:5px;
    font-weight:bold;
    margin-top:8px;
}

/* TABLE */
table{ width:100%; border-collapse:collapse; }
td{ padding:5px; }
.label{ font-weight:bold; width:30%; }

/* PHOTO */
.photo{
    width:120px;
    height:150px;
    border:2px solid {{ $primaryColor }};
}

/* STATUS BADGE */
.badge{
    padding:6px;
    text-align:center;
    font-weight:bold;
    color:#fff;
}

.approved{ background:#16a34a; }
.pending{ background:#dc2626; }

/* QR */
.qr{ border:1px solid #ddd; padding:6px; text-align:center; }

/* REASON */
.reason{ border:1px solid #ddd; padding:6px; min-height:50px; }

/* SIGN */
.signatures td{ text-align:center; padding-top:30px; }
.line{ border-top:1px solid #000; margin-top:20px; }

/* TEAR OFF */
.tear{
    margin-top:15px;
    border-top:2px dashed #000;
    padding-top:6px;
    font-size:11px;
}

/* FOOTER */
.footer{ font-size:10px; margin-top:6px; }

</style>
</head>

<body>

@if($watermarkBase64)
<img class="watermark" src="{{ $watermarkBase64 }}">
@endif

<!-- HEADER -->
<table class="header">
<tr>
<td width="15%">
@if($logoBase64)<img src="{{ $logoBase64 }}" class="logo">@endif
</td>
<td class="header-title">
<h1>DIGITAL GATEPASS SYSTEM</h1>
<!-- <p>{{ config('app.name') }}</p> -->
</td>
<td width="15%"></td>
</tr>
</table>

<div class="gatepass-id">
Gatepass #{{ str_pad($gatepass->id, 6, '0', STR_PAD_LEFT) }}
</div>

<table>
<tr>

<!-- LEFT -->
<td width="68%">

<div class="section-title">STUDENT INFORMATION</div>
<table>
<tr><td class="label">Name</td><td>{{ $gatepass->student->user->name }}</td></tr>
<tr><td class="label">Register No</td><td>{{ $gatepass->student->register_number }}</td></tr>
<tr><td class="label">Department</td><td>{{ $gatepass->student->department->name }}</td></tr>
<tr><td class="label">Semester</td><td>{{ $gatepass->student->semester }}</td></tr>
</table>

<div class="section-title">OUTPASS DETAILS</div>
<table>
<tr><td class="label">Date</td><td>{{ $gatepass->gatepass_date->format('d M Y') }}</td></tr>
<tr><td class="label">Out</td><td>{{ $gatepass->out_time->format('h:i A') }}</td></tr>
<tr><td class="label">In</td><td>{{ $gatepass->in_time->format('h:i A') }}</td></tr>
</table>

<div class="section-title">REASON</div>
<div class="reason">{{ $gatepass->reason }}</div>

</td>

<!-- RIGHT -->
<td width="32%">

<div class="section-title center">PHOTO</div>
<img src="{{ $studentPhotoBase64 }}" class="photo center">

<div class="section-title center">STATUS</div>
<div class="badge {{ $gatepass->isFinalApproved() ? 'approved' : 'pending' }}">
{{ $gatepass->isFinalApproved() ? 'APPROVED' : 'PENDING' }}
</div>

@if($gatepass->isFinalApproved() && $qrCode)
<div class="section-title">QR</div>
<div class="qr">
    @if(str_contains($qrCode, 'data:image'))
        <img src="{{ $qrCode }}" style="width:100px;height:100px;" alt="QR Code" />
    @else
        {!! $qrCode !!}
    @endif
</div>
@endif

</td>

</tr>
</table>

<!-- SIGN -->
<!-- <div class="section-title">APPROVALS</div>
<table class="signatures">
<tr>
<td><div class="line"></div>Staff</td>
<td><div class="line"></div>HOD</td>
@if($gatepass->student->hosteller==='yes')
<td><div class="line"></div>Warden</td>
@endif
</tr>
</table> -->

<!-- TEAR OFF -->
<!-- <div class="tear">
<b>SECURITY COPY</b><br>
Gatepass ID: {{ $gatepass->id }} |
Reg No: {{ $gatepass->student->register_number }} |
Out: {{ $gatepass->out_time->format('h:i A') }} |
Sign: __________
</div> -->

<div class="footer">
Generated: {{ now()->format('d M Y h:i A') }}
</div>

</body>
</html>