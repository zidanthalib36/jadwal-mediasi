<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\JadwalKlarifikasi;
use App\Models\ActivityLog;
use App\Jobs\KirimPengingatJadwal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JadwalKlarifikasiController extends Controller
{
    public function index(Request $request)
{
    $jadwal = JadwalKlarifikasi::with('user');

    // Filter berdasarkan status
    if ($request->filled('status')) {
        $jadwal->where('status', $request->status);
    }

    $jadwal = $jadwal->get();

    return view('jadwal.index', compact('jadwal'));
}


    public function create()
    {
        return view('jadwal.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'nama_kegiatan'   => 'required|string|max:255',
        'jenis_kegiatan'  => 'required|in:klarifikasi 1,klarifikasi 2,klarifikasi 3,mediasi 1,mediasi 2,mediasi 3',
        'tanggal_mulai'   => 'required|date',
        'waktu_mulai'     => 'required',
        'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        'waktu_selesai'   => 'required',
        'pengingat'       => 'nullable|integer|min:1|max:60',
        'tempat'          => 'required|in:Ruang Klarifikasi Dan Mediasi,Zoom',
        'link_zoom'       => 'nullable|string',
        'whatsapp_p3mi'   => 'required|string', // ✅ ganti
        'email_p3mi'      => 'required|email',
        'nomor_pengaduan' => 'required|string',
        'nama_pmi'        => 'required|string',
        'nama_pengadu'    => 'required|string',
        'p3mi'            => 'required|string',
        'deskripsi_kasus' => 'required|string',
        'hasil_kegiatan'  => 'nullable|string',
        'foto'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $data = $request->except('pic');
    $data['pic'] = Auth::user()->name;
    $data['user_id'] = Auth::id(); // ✅ penting

    if ($request->hasFile('foto')) {
        $data['foto'] = $request->file('foto')->store('jadwal_foto', 'public');
    }

    $jadwal = JadwalKlarifikasi::create($data);

    ActivityLog::create([
    'user_id' => Auth::id(),
    'action' => 'create',
    'module' => 'Jadwal',
    'subject_id' => $jadwal->id,
    'description' => 'Membuat jadwal "' . $jadwal->nama_kegiatan . '"',
]);

    $waktuMulai = Carbon::parse(
        $jadwal->tanggal_mulai . ' ' . $jadwal->waktu_mulai
    );

    KirimPengingatJadwal::dispatch(
        $jadwal,
        '1 hari sebelum'
    )->delay(
        $waktuMulai->copy()->subDay()
    );

    if ($jadwal->pengingat) {
        KirimPengingatJadwal::dispatch(
            $jadwal,
            $jadwal->pengingat . ' menit sebelum'
        )->delay(
            $waktuMulai->copy()->subMinutes($jadwal->pengingat)
        );
    }

    return redirect()->route('jadwal.index')
        ->with('success', 'Jadwal berhasil disimpan');
}



    public function edit($id)
{
    $jadwal = JadwalKlarifikasi::findOrFail($id);

    // Hak akses berdasarkan PIC / nama user
    if ($jadwal->pic !== Auth::user()->name) {
        abort(403, 'Anda tidak berhak mengedit data ini.');
    }

    return view('jadwal.edit', compact('jadwal'));
}


    public function update(Request $request, $id)
{
    $jadwal = JadwalKlarifikasi::findOrFail($id);

    if ($jadwal->pic !== Auth::user()->name) {
    abort(403, 'Anda tidak berhak mengubah data ini.');
}

    $data = $request->except([
        'pic',
        '_token',
        '_method'
    ]);

    $data['pic'] = Auth::user()->name;

    if ($request->hasFile('foto')) {

        if (
            $jadwal->foto &&
            Storage::disk('public')->exists($jadwal->foto)
        ) {
            Storage::disk('public')->delete($jadwal->foto);
        }

        $data['foto'] = $request
            ->file('foto')
            ->store('jadwal_foto', 'public');
    }

    /*
    |--------------------------------------------------------------------------
    | Simpan data yang berubah
    |--------------------------------------------------------------------------
    */

    $jadwal->fill($data);

    $changes = [];

    foreach ($jadwal->getDirty() as $field => $newValue) {

        // Jangan catat updated_at
        if ($field === 'updated_at') {
            continue;
        }

        $oldValue = $jadwal->getOriginal($field);

        $changes[$field] = [
            'old' => $oldValue,
            'new' => $newValue,
        ];
    }

    $jadwal->save();

    /*
    |--------------------------------------------------------------------------
    | Simpan activity log
    |--------------------------------------------------------------------------
    */

    if (!empty($changes)) {

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'update',
            'module' => 'Jadwal',
            'subject_id' => $jadwal->id,

            'description' =>
                'Mengubah jadwal "' .
                $jadwal->nama_kegiatan .
                '"',

            'changes' => $changes,
        ]);
    }

    return redirect()
        ->route('jadwal.index')
        ->with('success', 'Jadwal berhasil diupdate');
}

public function updateHasil(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:Hadir,Tidak Hadir,Bersurat',
        'hasil_kegiatan' => 'required|string',
        'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $jadwal = JadwalKlarifikasi::findOrFail($id);

    // Hanya pemilik jadwal yang dapat mengisi hasil
    if ($jadwal->pic !== Auth::user()->name) {
    abort(403, 'Anda tidak berhak mengubah hasil kegiatan ini.');
}

    /*
    |--------------------------------------------------------------------------
    | SIMPAN DATA LAMA
    |--------------------------------------------------------------------------
    */

    $statusLama = $jadwal->status;
    $hasilLama = $jadwal->hasil_kegiatan;
    $fotoLama = $jadwal->foto;


    /*
    |--------------------------------------------------------------------------
    | DATA BARU
    |--------------------------------------------------------------------------
    */

    $statusBaru = $request->status;
    $hasilBaru = $request->hasil_kegiatan;


    /*
    |--------------------------------------------------------------------------
    | SIAPKAN DATA UPDATE
    |--------------------------------------------------------------------------
    */

    $data = [
        'status' => $statusBaru,
        'hasil_kegiatan' => $hasilBaru,
    ];


    /*
    |--------------------------------------------------------------------------
    | UPLOAD FOTO BARU
    |--------------------------------------------------------------------------
    */

    $fotoBaru = null;

    if ($request->hasFile('foto')) {

        // Hapus foto lama
        if (
            $jadwal->foto &&
            Storage::disk('public')->exists($jadwal->foto)
        ) {
            Storage::disk('public')->delete($jadwal->foto);
        }

        // Simpan foto baru
        $fotoBaru = $request->file('foto')
            ->store('jadwal_foto', 'public');

        $data['foto'] = $fotoBaru;
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE JADWAL
    |--------------------------------------------------------------------------
    */

    $jadwal->update($data);


    /*
    |--------------------------------------------------------------------------
    | ACTIVITY LOG
    |--------------------------------------------------------------------------
    */

    $changes = [];

    // STATUS
    if ($statusLama !== $statusBaru) {

        $changes['status'] = [
            'old' => $statusLama,
            'new' => $statusBaru,
        ];
    }

    // HASIL KEGIATAN
    if ($hasilLama !== $hasilBaru) {

        $changes['hasil_kegiatan'] = [
            'old' => $hasilLama,
            'new' => $hasilBaru,
        ];
    }

    // FOTO
    if ($fotoBaru !== null) {

        $changes['foto'] = [
            'old' => $fotoLama,
            'new' => $fotoBaru,
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | SIMPAN ACTIVITY LOG
    |--------------------------------------------------------------------------
    */

    ActivityLog::create([
        'user_id' => Auth::id(),
        'action' => 'update',
        'module' => 'Hasil Kegiatan',
        'subject_id' => $jadwal->id,

        'description' =>
            'Mengisi hasil kegiatan "' .
            $jadwal->nama_kegiatan .
            '" dengan status "' .
            $statusBaru .
            '"',

        'changes' => $changes,
    ]);


    /*
    |--------------------------------------------------------------------------
    | REDIRECT
    |--------------------------------------------------------------------------
    */

    return redirect()
        ->route('jadwal.index')
        ->with('success', 'Hasil kegiatan berhasil disimpan.');
}
    public function destroy($id)
{
    $jadwal = JadwalKlarifikasi::findOrFail($id);

    // Hanya pemilik jadwal yang dapat menghapus
    if ($jadwal->pic !== Auth::user()->name) {
    abort(403, 'Anda tidak berhak menghapus jadwal ini.');
}

    /*
    |--------------------------------------------------------------------------
    | SIMPAN DATA UNTUK ACTIVITY LOG
    |--------------------------------------------------------------------------
    */

    $namaKegiatan = $jadwal->nama_kegiatan;
    $jadwalId = $jadwal->id;


    /*
    |--------------------------------------------------------------------------
    | HAPUS FOTO
    |--------------------------------------------------------------------------
    */

    if (
        $jadwal->foto &&
        Storage::disk('public')->exists($jadwal->foto)
    ) {
        Storage::disk('public')->delete($jadwal->foto);
    }


    /*
    |--------------------------------------------------------------------------
    | ACTIVITY LOG
    |--------------------------------------------------------------------------
    */

    ActivityLog::create([
        'user_id' => Auth::id(),
        'action' => 'delete',
        'module' => 'Jadwal',
        'subject_id' => $jadwalId,
        'description' => 'Menghapus jadwal "' . $namaKegiatan . '"',
        'changes' => null,
    ]);


    /*
    |--------------------------------------------------------------------------
    | HAPUS DATA
    |--------------------------------------------------------------------------
    */

    $jadwal->delete();


    return redirect()
        ->route('jadwal.index')
        ->with('success', 'Jadwal berhasil dihapus.');
}
}
