@extends('adminlte::page')

@section('title', 'Jadwal Klarifikasi & Mediasi')

@section('css')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">

@stop


@section('js')

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready(function() {

    var table = $('#jadwalTable').DataTable({
        "pageLength": 10,
        "lengthMenu": [10, 25, 50, 100],

        ordering: false,

        "language": {
            "lengthMenu": "Show _MENU_ entries",
            "search": "Search:",
            "info": "Showing _START_ to _END_ of _TOTAL_ entries",
            "paginate": {
                "previous": "Previous",
                "next": "Next"
            }
        },

        columnDefs: [{
            targets: 0,
            orderable: false,
            searchable: false
        }]
    });

});
</script>

@stop

@section('content_header')
    <h1>Jadwal Klarifikasi & Mediasi</h1>
@stop

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">

    {{-- Tombol Tambah Jadwal --}}
    <div>
        <a href="{{ route('jadwal.create') }}" class="btn btn-primary">
            + Tambah Jadwal
        </a>
    </div>

    {{-- Filter Status --}}
    <div style="width:250px;">
        <form method="GET" action="{{ route('jadwal.index') }}">
            <label class="mr-2">Filter Status</label>
            <select name="status" class="form-control" onchange="this.form.submit()">

                <option value="">-- Semua Status --</option>

                <option value="Menunggu Jadwal"
                    {{ request('status') == 'Menunggu Jadwal' ? 'selected' : '' }}>
                    Menunggu Jadwal
                </option>

                <option value="Berlangsung"
                    {{ request('status') == 'Berlangsung' ? 'selected' : '' }}>
                    Berlangsung
                </option>

                <option value="Menunggu Hasil"
                    {{ request('status') == 'Menunggu Hasil' ? 'selected' : '' }}>
                    Menunggu Hasil
                </option>

                <option value="Hadir"
                    {{ request('status') == 'Hadir' ? 'selected' : '' }}>
                    Hadir
                </option>

                <option value="Tidak Hadir"
                    {{ request('status') == 'Tidak Hadir' ? 'selected' : '' }}>
                    Tidak Hadir
                </option>

                <option value="Bersurat"
                    {{ request('status') == 'Bersurat' ? 'selected' : '' }}>
                    Bersurat
                </option>

            </select>
        </form>
    </div>

</div>
@if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
            {{ session('error') }}
        </div>
    @endif
<div class="card">
    <div class="card-body table-responsive">

        <table id="jadwalTable" class="table table-bordered table-striped table-hover">
            <thead class="bg-warning text-center">
                <tr>
                    <th>No</th>
                    <th>Nama Kegiatan</th>
                    <th>Jenis</th>
                    <th>Tanggal Mulai</th>
                    <th>Waktu Mulai</th>
                    <th>Tempat</th>
                    <th>No WhatsApp P3MI</th>
                    <th>No Aduan</th>
                    <th>Nama PMI</th>
                    <th>P3MI</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    <th>Hasil</th>
                    <th>PIC</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($jadwal as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama_kegiatan }}</td>
                    <td>{{ $item->jenis_kegiatan }}</td>
                    <td>
    {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d-m-Y') }}
</td>
                    <td>{{ $item->waktu_mulai }}</td>
                    <td>{{ $item->tempat }}</td>
                    <td>{{ $item->whatsapp_p3mi }}</td>
                    <td>{{ $item->nomor_pengaduan }}</td>
                    <td>{{ $item->nama_pmi }}</td>
                    <td>{{ $item->p3mi }}</td>
                    <td>{{ Str::limit($item->deskripsi_kasus, 30) }}</td>
                    <td class="text-center">

@php
    $status = $item->computed_status ?? $item->status;
@endphp

@if($status == 'Menunggu Jadwal')
    <span class="badge badge-secondary">Menunggu Jadwal</span>

@elseif($status == 'Berlangsung')
    <span class="badge badge-primary">Berlangsung</span>

@elseif($status == 'Menunggu Hasil')
    <span class="badge badge-warning">Menunggu Hasil</span>

@elseif($status == 'Hadir')
    <span class="badge badge-success">Hadir</span>

@elseif($status == 'Tidak Hadir')
    <span class="badge badge-danger">Tidak Hadir</span>

@elseif($status == 'Bersurat')
    <span class="badge badge-info">Bersurat</span>

@else
    <span class="badge badge-dark">{{ $status }}</span>
@endif

</td>
                    <td>{{ Str::limit($item->hasil_kegiatan, 30) }}</td>
                    <td>{{ $item->pic }}</td>

                    <td class="text-center">

    {{-- DETAIL --}}
    <button class="btn btn-info btn-sm mb-1"
            data-toggle="modal"
            data-target="#detailModal{{ $item->id }}">
        Detail
    </button>

    @if ($item->pic === Auth::user()->name)

        {{-- NAMA KEGIATAN JADI TOMBOL INPUT HASIL --}}
        <button class="btn btn-primary btn-sm mb-1"
                data-toggle="modal"
                data-target="#hasilModal{{ $item->id }}">
            Isi Hasil
        </button>

        <a href="{{ route('jadwal.edit', $item->id) }}"
           class="btn btn-warning btn-sm">
            Edit
        </a>

        <form action="{{ route('jadwal.destroy', $item->id) }}"
              method="POST"
              style="display:inline"
              onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="btn btn-danger btn-sm">
                Hapus
            </button>
        </form>

    @endif

</td>
                </tr>


                {{-- ================= MODAL DETAIL ================= --}}
                <div class="modal fade"
                     id="detailModal{{ $item->id }}"
                     tabindex="-1">

                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                            <div class="modal-header bg-info">
                                <h5 class="modal-title text-white">
                                    Detail Jadwal Klarifikasi & Mediasi
                                </h5>
                                <button type="button"
                                        class="close"
                                        data-dismiss="modal">
                                    &times;
                                </button>
                            </div>

                            <div class="modal-body">

                                <div class="row">

                                    <div class="col-md-6">
                                        <strong>Nama Kegiatan:</strong><br>
                                        {{ $item->nama_kegiatan }}
                                    </div>

                                    <div class="col-md-6">
                                        <strong>Jenis Kegiatan:</strong><br>
                                        {{ $item->jenis_kegiatan }}
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <strong>Tanggal Mulai:</strong><br>
                                        {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d-m-Y') }}
                                    </div>
<div class="col-md-6 mt-3">
                                        <strong>Tanggal Selesai:</strong><br>
                                        {{ \Carbon\Carbon::parse($item->selesai)->format('d-m-Y') }}
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <strong>Waktu Mulai:</strong><br>
                                        {{ $item->waktu_mulai }}
                                    </div>



                                    <div class="col-md-6 mt-3">
                                        <strong>Waktu Selesai:</strong><br>
                                        {{ $item->waktu_selesai }}
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <strong>Pengingat:</strong><br>
                                        {{ $item->pengingat ?? '-' }} menit
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <strong>Tempat:</strong><br>
                                        {{ $item->tempat }}
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <strong>No WhatsApp P3MI:</strong><br>
                                        {{ $item->whatsapp_p3mi }}
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <strong>Email P3MI:</strong><br>
                                        {{ $item->email_p3mi }}
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <strong>No Aduan:</strong><br>
                                        {{ $item->nomor_pengaduan }}
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <strong>Nama PMI:</strong><br>
                                        {{ $item->nama_pmi }}
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <strong>Nama Pengadu:</strong><br>
                                        {{ $item->nama_pengadu }}
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <strong>P3MI:</strong><br>
                                        {{ $item->p3mi }}
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <strong>Deskripsi Kasus:</strong><br>
                                        {{ $item->deskripsi_kasus }}
                                    </div>





                                    <div class="col-md-12 mt-4 text-center">
                                        <strong>Foto:</strong><br><br>

                                        @if ($item->foto)
                                            <img src="{{ asset('storage/' . $item->foto) }}"
                                                 class="img-fluid img-thumbnail"
                                                 style="max-height:300px;">
                                        @else
                                            Tidak ada foto
                                        @endif
                                    </div>
                                    <div class="col-md-6 mt-3">

</div>
<div class="col-md-12 mt-3">
                                        <strong>Hasil Kegiatan:</strong><br>
                                        {{ $item->hasil_kegiatan }}
                                    </div>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="button"
                                        class="btn btn-secondary"
                                        data-dismiss="modal">
                                    Tutup
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
                {{-- ================================================== --}}


                {{-- ================= MODAL HASIL ================= --}}
<div class="modal fade"
     id="hasilModal{{ $item->id }}"
     tabindex="-1">

    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{ route('jadwal.updateHasil', $item->id) }}"
      method="POST"
      enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white">
                        Input Hasil Kegiatan
                    </h5>
                    <button type="button"
                            class="close"
                            data-dismiss="modal">
                        &times;
                    </button>
                </div>

                <div class="modal-body">

                    {{-- STATUS (Hadir / Tidak Hadir / Bersurat) --}}
                    <div class="form-group">
                        <label>Status Kehadiran</label>
                        <select name="status" class="form-control" required oninvalid="this.setCustomValidity('Silakan pilih status kehadiran terlebih dahulu')"
        oninput="this.setCustomValidity('')">
    <option value="">-- Pilih Status --</option>

    <option value="Hadir"
        {{ $item->status == 'Hadir' ? 'selected' : '' }}>
        Hadir
    </option>

    <option value="Tidak Hadir"
        {{ $item->status == 'Tidak Hadir' ? 'selected' : '' }}>
        Tidak Hadir
    </option>

    <option value="Bersurat"
        {{ $item->status == 'Bersurat' ? 'selected' : '' }}>
        Bersurat
    </option>
</select>
                    </div>

                    {{-- DESKRIPSI HASIL --}}
                    <div class="form-group">
                        <label>Hasil Kegiatan</label>
<textarea name="hasil_kegiatan"
          class="form-control"
          required oninvalid="this.setCustomValidity('Silakan isi hasil kegiatan')"
        oninput="this.setCustomValidity('')">{{ $item->hasil_kegiatan }}</textarea>
                    </div>
                    {{-- Upload Hasil Foto --}}
 <div>

    <label>Upload Foto Hasil Kegiatan</label>
    <input type="file"
       name="foto"
       class="form-control-file"
       accept=".jpg,.jpeg,.png">
    @if ($item->foto)
        <p class="mt-2">Foto saat ini:</p>
        <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto Hasil" class="img-fluid img-thumbnail" style="max-height: 200px;">
    @endif
 </div>
                </div>

                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">
                        Batal
                    </button>

                    <button type="submit"
                            class="btn btn-success">
                        Simpan Hasil
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
@endforeach
{{-- ================================================= --}}
            </tbody>
        </table>

    </div>
</div>

@stop
