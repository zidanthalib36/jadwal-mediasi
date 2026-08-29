<p>Yth. Bapak/Ibu,</p>

<p>
Pengingat jadwal <strong>{{ $jadwal->nama_kegiatan }}</strong><br>
Jenis: {{ strtoupper($jadwal->jenis_kegiatan) }}<br>
Tanggal: {{ $jadwal->tanggal_mulai }}<br>
Waktu: {{ $jadwal->waktu_mulai }}
</p>

@if ($jadwal->tempat === 'Zoom')
    <p><strong>Zoom Meeting</strong></p>
    <p>Link Zoom:<br>
    <a href="{{ $jadwal->link_zoom }}">{{ $jadwal->link_zoom }}</a></p>
@else
    <p><strong>Lokasi:</strong></p>
    <p>Mohon hadir langsung ke <strong>Ruang Mediasi dan Klarifikasi</strong>.</p>
@endif

<p>
Pengingat ini dikirim {{ $tipe }} sebelum kegiatan.
</p>

<p>Terima kasih.</p>
