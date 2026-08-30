@extends('adminlte::page')

@section('title', 'Edit Jadwal Klarifikasi & Mediasi')

@section('content_header')
    <h1>Edit Jadwal Klarifikasi & Mediasi</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">

        <form action="{{ route('jadwal.update', $jadwal->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @if ($errors->any())
    <div class="alert alert-danger mb-3">
        <ul class="mb-0 ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

            <div class="row">

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Kegiatan</label>
                        <input type="text" name="nama_kegiatan"
                               class="form-control"
                               value="{{ old('nama_kegiatan', $jadwal->nama_kegiatan) }}" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jenis Kegiatan</label>
                        <select name="jenis_kegiatan" class="form-control" required>
                            @foreach (['klarifikasi 1','klarifikasi 2','klarifikasi 3','mediasi 1','mediasi 2','mediasi 3'] as $jenis)
                                <option value="{{ $jenis }}"
                                    {{ $jadwal->jenis_kegiatan == $jenis ? 'selected' : '' }}>
                                    {{ ucfirst($jenis) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai"
                               class="form-control"
                               value="{{ $jadwal->tanggal_mulai }}" required>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Waktu Mulai</label>
                        <input type="time" name="waktu_mulai"
                               class="form-control"
                               value="{{ $jadwal->waktu_mulai }}" required>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai"
                               class="form-control"
                               value="{{ $jadwal->tanggal_selesai }}" required>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Waktu Selesai</label>
                        <input type="time" name="waktu_selesai"
                               class="form-control"
                               value="{{ $jadwal->waktu_selesai }}" required>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Pengingat (menit)</label>
                        <input type="number" name="pengingat"
                               class="form-control"
                               value="{{ $jadwal->pengingat }}" required>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Tempat</label>
                        <select name="tempat" id="tempat" class="form-control" required>
                            <option value="Ruang Klarifikasi Dan Mediasi"
                                {{ $jadwal->tempat == 'Ruang Klarifikasi Dan Mediasi' ? 'selected' : '' }}>
                                Ruang Klarifikasi Dan Mediasi
                            </option>
                            <option value="Zoom"
                                {{ $jadwal->tempat == 'Zoom' ? 'selected' : '' }}>
                                Zoom
                            </option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6" id="linkZoomWrapper">
                    <div class="form-group">
                        <label>Link Zoom (jika Zoom)</label>
                        <input type="text" name="link_zoom"
                               class="form-control"
                               value="{{ $jadwal->link_zoom }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>WhatsApp P3MI</label>
                        <input type="number" name="whatsapp_p3mi"
                               class="form-control"
                               value="{{ $jadwal->whatsapp_p3mi }}" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email P3MI</label>
                        <input type="email" name="email_p3mi"
                               class="form-control"
                               value="{{ $jadwal->email_p3mi }}" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nomor Pengaduan</label>
                        <input type="text" name="nomor_pengaduan"
                               class="form-control"
                               value="{{ $jadwal->nomor_pengaduan }}" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama PMI</label>
                        <input type="text" name="nama_pmi"
                               class="form-control"
                               value="{{ $jadwal->nama_pmi }}" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Pengadu</label>
                        <input type="text" name="nama_pengadu"
                               class="form-control"
                               value="{{ $jadwal->nama_pengadu }}" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>P3MI</label>
                        <input type="text" name="p3mi"
                               class="form-control"
                               value="{{ $jadwal->p3mi }}" required>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Deskripsi Kasus</label>
                        <textarea name="deskripsi_kasus"
                                  class="form-control"
                                  rows="3" required>{{ $jadwal->deskripsi_kasus }}</textarea>
                    </div>
                </div>

                {{-- <div class="col-md-12">
                    <div class="form-group">
                        <label>Foto</label>
                        <input type="file" name="foto" class="form-control">
                        @if ($jadwal->foto)
                            <small class="text-muted">Foto lama: {{ $jadwal->foto }}</small>
                        @endif
                    </div>
                </div> --}}

            </div>

            <button type="submit" class="btn btn-warning">
                <i class="fas fa-save"></i> Update
            </button>
            <a href="{{ route('jadwal.index') }}" class="btn btn-secondary">
                Batal
            </a>

        </form>
    </div>
</div>
@stop

@section('js')
<script>
    const tempatSelect = document.getElementById('tempat');
    const linkZoomWrapper = document.getElementById('linkZoomWrapper');

    function toggleLinkZoom() {
        if (tempatSelect.value === 'Zoom') {
            linkZoomWrapper.style.display = 'block';
        } else {
            linkZoomWrapper.style.display = 'none';
        }
    }

    toggleLinkZoom();
    tempatSelect.addEventListener('change', toggleLinkZoom);
</script>
@stop
