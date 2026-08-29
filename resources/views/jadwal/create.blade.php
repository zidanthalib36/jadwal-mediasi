@extends('adminlte::page')

@section('title', 'Tambah Jadwal Klarifikasi & Mediasi')

@section('content_header')
    <h1>Tambah Jadwal Klarifikasi & Mediasi</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">

        <form action="{{ route('jadwal.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">

                {{-- Nama Kegiatan --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Kegiatan</label>
                        <input type="text" name="nama_kegiatan"
                               class="form-control"
                               value="{{ old('nama_kegiatan') }}" required>
                    </div>
                </div>

                {{-- Jenis Kegiatan --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jenis Kegiatan</label>
                        <select name="jenis_kegiatan" class="form-control" required>
                            <option value="">-- Pilih Jenis --</option>
                            @foreach (['klarifikasi 1','klarifikasi 2','klarifikasi 3','mediasi 1','mediasi 2','mediasi 3'] as $jenis)
                                <option value="{{ $jenis }}" {{ old('jenis_kegiatan') == $jenis ? 'selected' : '' }}>
                                    {{ ucfirst($jenis) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Tanggal & Waktu --}}
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai"
                               class="form-control"
                               value="{{ old('tanggal_mulai') }}" required>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Waktu Mulai</label>
                        <input type="time" name="waktu_mulai"
                               class="form-control"
                               value="{{ old('waktu_mulai') }}" required>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai"
                               class="form-control"
                               value="{{ old('tanggal_selesai') }}" required>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Waktu Selesai</label>
                        <input type="time" name="waktu_selesai"
                               class="form-control"
                               value="{{ old('waktu_selesai') }}" required>
                    </div>
                </div>

                {{-- Pengingat --}}
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Pengingat (menit sebelum mulai)</label>
                        <input type="number" name="pengingat"
                               class="form-control"
                               min="1"
                               placeholder="Contoh: 60 = 1 jam"
                               value="{{ old('pengingat') }}">
                    </div>
                </div>

                {{-- Tempat --}}
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Tempat</label>
                        <select name="tempat" id="tempat" class="form-control" required>
                            <option value="">-- Pilih Tempat --</option>
                            <option value="Ruang Klarifikasi Dan Mediasi"
                                {{ old('tempat') == 'Ruang Klarifikasi Dan Mediasi' ? 'selected' : '' }}>
                                Ruang Klarifikasi Dan Mediasi
                            </option>
                            <option value="Zoom"
                                {{ old('tempat') == 'Zoom' ? 'selected' : '' }}>
                                Zoom
                            </option>
                        </select>
                    </div>
                </div>

                {{-- Link Zoom --}}
                <div class="col-md-6" id="zoom_link_wrapper">
                    <div class="form-group">
                        <label>Link Zoom (jika Zoom)</label>
                        <input type="text" name="link_zoom"
                               class="form-control"
                               placeholder="https://zoom.us/..."
                               value="{{ old('link_zoom') }}">
                    </div>
                </div>

                {{-- Kontak --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>WhatsApp P3MI</label>
                        <input type="number" name="whatsapp_p3mi"
                               class="form-control"
                               placeholder="6289xxxxxx"
                               value="{{ old('whatsapp_p3mi') }}" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email P3MI</label>
                        <input type="email" name="email_p3mi"
                               class="form-control"
                               value="{{ old('email_p3mi') }}" required>
                    </div>
                </div>

                {{-- Data Kasus --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nomor Pengaduan</label>
                        <input type="text" name="nomor_pengaduan"
                               class="form-control"
                               value="{{ old('nomor_pengaduan') }}" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama PMI</label>
                        <input type="text" name="nama_pmi"
                               class="form-control"
                               value="{{ old('nama_pmi') }}" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Pengadu</label>
                        <input type="text" name="nama_pengadu"
                               class="form-control"
                               value="{{ old('nama_pengadu') }}" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>P3MI</label>
                        <input type="text" name="p3mi"
                               class="form-control"
                               value="{{ old('p3mi') }}" required>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Deskripsi Kasus</label>
                        <textarea name="deskripsi_kasus"
                                  class="form-control"
                                  rows="3" required>{{ old('deskripsi_kasus') }}</textarea>
                    </div>
                </div>

                {{-- Foto
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Foto</label>
                        <input type="file" name="foto"
                               class="form-control"
                               accept="image/*">
                    </div>
                </div> --}}

            </div>

            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Simpan
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
    const zoomWrapper = document.getElementById('zoom_link_wrapper');

    function toggleZoom() {
        if (tempatSelect.value === 'Zoom') {
            zoomWrapper.style.display = 'block';
        } else {
            zoomWrapper.style.display = 'none';
        }
    }

    toggleZoom();
    tempatSelect.addEventListener('change', toggleZoom);
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const forms = document.querySelectorAll('form');

    forms.forEach(function(form) {

        form.addEventListener('invalid', function(e) {

            if (e.target.validity.valueMissing) {
                e.target.setCustomValidity('wajib diisi.');
            }

            if (e.target.validity.typeMismatch) {
                e.target.setCustomValidity('Format tidak sesuai.');
            }

            if (e.target.validity.patternMismatch) {
                e.target.setCustomValidity('Format input tidak valid.');
            }

        }, true);

        form.addEventListener('input', function(e) {
            e.target.setCustomValidity('');
        }, true);

    });

});
</script>
@stop
