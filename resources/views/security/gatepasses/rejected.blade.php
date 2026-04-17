@extends('layouts.app')

@section('title', 'Rejected Gatepasses')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Rejected Gatepasses</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('security.dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="row mb-4">
        <div class="col-12">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('security.gatepasses.pending') }}">
                        <i class="fas fa-clock"></i> Pending
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('security.gatepasses.approved') }}">
                        <i class="fas fa-check-circle"></i> Approved
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('security.gatepasses.rejected') }}">
                        <i class="fas fa-times-circle"></i> Rejected
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('security.gatepasses') }}">
                        <i class="fas fa-list"></i> All Gatepasses
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Rejected Gatepasses Table -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-danger">Rejected Gatepasses</h6>
                    <span class="badge bg-danger">{{ $gatepasses->total() }} Rejected</span>
                </div>
                <div class="card-body">
                    @if($gatepasses->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Student Name</th>
                                        <th>Register No.</th>
                                        <th>Date</th>
                                        <th>Out Time</th>
                                        <th>In Time</th>
                                        <th>Reason</th>
                                        <th>Rejected By</th>
                                        <th>Remarks</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($gatepasses as $gatepass)
                                    <tr>
                                        <td>{{ $gatepass->id }}</td>
                                        <td>{{ $gatepass->student->name ?? 'N/A' }}</td>
                                        <td>{{ $gatepass->student->register_number ?? 'N/A' }}</td>
                                        <td>{{ $gatepass->gatepass_date }}</td>
                                        <td>{{ $gatepass->out_time }}</td>
                                        <td>{{ $gatepass->in_time }}</td>
                                        <td>{{ Str::limit($gatepass->reason, 30) }}</td>
                                        <td>
                                            @if($gatepass->staff_rejected_by)
                                                Staff: {{ $gatepass->staffRejecter->name ?? 'N/A' }}
                                            @elseif($gatepass->hod_rejected_by)
                                                HOD: {{ $gatepass->hodRejecter->name ?? 'N/A' }}
                                            @elseif($gatepass->warden_rejected_by)
                                                Warden: {{ $gatepass->wardenRejecter->name ?? 'N/A' }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            @if($gatepass->staff_remarks)
                                                <small class="text-muted">{{ Str::limit($gatepass->staff_remarks, 50) }}</small>
                                            @elseif($gatepass->hod_remarks)
                                                <small class="text-muted">{{ Str::limit($gatepass->hod_remarks, 50) }}</small>
                                            @elseif($gatepass->warden_remarks)
                                                <small class="text-muted">{{ Str::limit($gatepass->warden_remarks, 50) }}</small>
                                            @else
                                                <span class="text-muted">No remarks</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-primary" onclick="viewDetails({{ $gatepass->id }})">
                                                    <i class="fas fa-eye"></i> View
                                                </button>
                                                <button class="btn btn-sm btn-info" onclick="verifyGatepass({{ $gatepass->id }})">
                                                    <i class="fas fa-qrcode"></i> Verify
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted">
                                Showing {{ $gatepasses->firstItem() }} to {{ $gatepasses->lastItem() }} of {{ $gatepasses->total() }} entries
                            </div>
                            {{ $gatepasses->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-times-circle fa-3x text-gray-300 mb-3"></i>
                            <h5 class="text-gray-500">No rejected gatepasses</h5>
                            <p class="text-gray-400">No gatepasses have been rejected.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function viewDetails(gatepassId) {
    window.open(`/security/gatepasses/${gatepassId}`, '_blank');
}

function verifyGatepass(gatepassId) {
    fetch('{{ route("security.verify") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ gatepass_id: gatepassId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(`Gatepass Verified!\n\nStudent: ${data.student?.name || 'N/A'}\nStatus: ${data.status_text}\nDate: ${data.gatepass?.gatepass_date || 'N/A'}\nReason: ${data.gatepass?.reason || 'N/A'}`);
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        alert('Error verifying gatepass. Please try again.');
    });
}
</script>
@endpush
