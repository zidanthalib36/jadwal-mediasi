@extends('adminlte::page')

@section('title', 'Monitoring Notifikasi')

@section('content_header')
<h1>Monitoring Notifikasi</h1>
@endsection

@section('content')

<div class="row">

    <!-- Job Pending -->
    <div class="col-md-3">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $pendingJobs }}</h3>
                <p>Job Pending</p>
            </div>
            <div class="icon">
                <i class="fas fa-clock"></i>
            </div>
        </div>
    </div>

    <!-- Job Gagal -->
    <div class="col-md-3">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $failedJobs }}</h3>
                <p>Job Gagal</p>
            </div>
            <div class="icon">
                <i class="fas fa-times-circle"></i>
            </div>
        </div>
    </div>

    <!-- Notifikasi Berhasil -->
    <div class="col-md-3">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $successNotif }}</h3>
                <p>Notifikasi Berhasil</p>
            </div>
            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
    </div>

    <!-- Notifikasi Gagal -->
    <div class="col-md-3">
        <div class="small-box bg-secondary">
            <div class="inner">
                <h3>{{ $failedNotif }}</h3>
                <p>Notifikasi Gagal</p>
            </div>
            <div class="icon">
                <i class="fas fa-exclamation-circle"></i>
            </div>
        </div>
    </div>

</div>


<div class="card">

<div class="card-header bg-warning">
<h3 class="card-title">Log Notifikasi</h3>
</div>

<div class="card-body">

<table class="table table-bordered table-striped">
    {{ $logs->links() }}

<thead>
<tr>
<th>No</th>
<th>Jadwal</th>
<th>Channel</th>
<th>Tipe Notifikasi</th>
<th>Tujuan</th>
<th>Kontak</th>
<th>Status</th>
<th>Waktu</th>
</tr>
</thead>

<tbody>

@foreach($logs as $index => $log)

<tr>

<td>{{ $index + 1 }}</td>

<td>{{ $log->jadwal->nama_kegiatan ?? '-' }}</td>

<td>
@if($log->channel == 'whatsapp')
<span class="badge bg-success">WhatsApp</span>
@else
<span class="badge bg-primary">Email</span>
@endif
</td>

<td>{{ $log->tipe_notifikasi }}</td>

<td>{{ $log->tujuan }}</td>

<td>{{ $log->kontak }}</td>

<td>
@if($log->status == 'berhasil')
<span class="badge bg-success">Berhasil</span>
@else
<span class="badge bg-danger">Gagal</span>
@endif
</td>

<td>{{ $log->created_at }}</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</div>

@endsection
