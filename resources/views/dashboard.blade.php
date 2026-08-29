@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Dashboard Monitoring Jadwal</h1>
@stop

@section('content')

{{-- ================= SUMMARY ================= --}}
<div class="row">

<div class="col-md-2">
<div class="small-box bg-dark">
<div class="inner">
<h3>{{ $totalJadwal }}</h3>
<p>Total Jadwal</p>
</div>
</div>
</div>

<div class="col-md-2">
<div class="small-box bg-secondary">
<div class="inner">
<h3>{{ $menungguJadwal }}</h3>
<p>Menunggu Jadwal</p>
</div>
</div>
</div>

<div class="col-md-2">
<div class="small-box bg-primary">
<div class="inner">
<h3>{{ $berlangsung }}</h3>
<p>Berlangsung</p>
</div>
</div>
</div>

<div class="col-md-2">
<div class="small-box bg-warning">
<div class="inner">
<h3>{{ $menungguHasil }}</h3>
<p>Menunggu Hasil</p>
</div>
</div>
</div>

<div class="col-md-2">
<div class="small-box bg-success">
<div class="inner">
<h3>{{ $hadir }}</h3>
<p>Hadir</p>
</div>
</div>
</div>

<div class="col-md-2">
<div class="small-box bg-danger">
<div class="inner">
<h3>{{ $tidakHadir }}</h3>
<p>Tidak Hadir</p>
</div>
</div>
</div>

<div class="col-md-2">
<div class="small-box bg-info">
<div class="inner">
<h3>{{ $bersurat }}</h3>
<p>Bersurat</p>
</div>
</div>
</div>

</div>

{{-- ================= ROW 2 ================= --}}
<div class="row">

<div class="col-md-3">

<div class="card">
<div class="card-header">
<h3 class="card-title">Jadwal Hari Ini</h3>
</div>

<div class="card-body text-center">
<div class="card-body">

<table class="table table-bordered table-sm">

<thead>
<tr>
<th>Nama Kegiatan</th>
<th>Pukul</th>
<th>PIC</th>
</tr>
</thead>

<tbody>

@forelse($jadwalHariIni as $item)

<tr>
<td>{{ $item->nama_kegiatan }}</td>
<td>{{ $item->waktu_mulai }}</td>
<td>{{ $item->pic }}</td>
</tr>

@empty

<tr>
<td colspan="3" class="text-center">Tidak ada kegiatan hari ini</td>
</tr>

@endforelse

</tbody>

</table>

</div>
</div>

</div>

</div>


<div class="col-md-9">

<div class="card">

<div class="card-header">
<h3 class="card-title">Grafik Kegiatan per Bulan</h3>
</div>

<div class="card-body">
<canvas id="grafikJadwal"></canvas>
</div>

</div>

</div>

</div>


{{-- ================= ROW 3 ================= --}}
<div class="row">

<div class="col-md-6">

<div class="card">

<div class="card-header">
<h4>Kegiatan Menunggu Hasil</h4>

<table class="table table-bordered">

<thead>
<tr>
<th>Nama Kegiatan</th>
<th>PIC</th>
<th>Tanggal</th>
</tr>
</thead>

<tbody>

@foreach($kegiatanMenungguHasil as $item)

<tr>
<td>{{ $item->nama_kegiatan }}</td>
<td>{{ $item->pic }}</td>
<td>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d-m-Y') }}</td>
</tr>

@endforeach

</tbody>

</table>

</div>

</div>

</div>



<div class="col-md-6">

<div class="card">

<div class="card-header">
<h3 class="card-title">Reminder Kegiatan 5 Hari Mendatang</h3>
</div>

<div class="card-body">

<table class="table table-bordered">

<thead>
<tr>
<th>Nama Kegiatan</th>
<th>Tanggal</th>
<th>Pukul</th>
<th>PIC</th>
</tr>
</thead>

<tbody>

@foreach($reminder as $item)

<tr>
<td>{{ $item->nama_kegiatan }}</td>
<td>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d-m-Y') }}</td>
<td>{{ $item->waktu_mulai }}</td>
<td>{{ $item->pic }}</td>
</tr>

@endforeach

</tbody>

</table>

</div>

</div>

</div>

</div>

@stop


@section('js')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctx = document.getElementById('grafikJadwal');

const data = {
labels: [
@foreach($grafik as $item)
"{{ \Carbon\Carbon::create()->month($item->bulan)->translatedFormat('F') }}",
@endforeach
],
datasets: [{
label: 'Jumlah Kegiatan',
data: [
@foreach($grafik as $item)
{{ $item->total }},
@endforeach
]
}]
};

new Chart(ctx, {
type: 'bar',
data: data
});

</script>

@stop
