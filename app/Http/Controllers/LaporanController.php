<?php

namespace App\Http\Controllers;

use App\Models\Konsultasi;
use App\Models\Penyuluh;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{

    public function laporanPetani($idKecamatan, $tahun)
    {
        if ((int) $idKecamatan === 0) {
            // Semua kecamatan tapi filter berdasarkan tahun created_at
            $users = User::with(['desa', 'desa.kecamatan'])
                ->whereYear('created_at', $tahun)
                ->get();
        } else {
            // Hanya kecamatan tertentu dan filter tahun
            $users = User::with(['desa', 'desa.kecamatan'])
                ->whereHas('desa.kecamatan', function ($q) use ($idKecamatan) {
                    $q->where('id_kecamatan', $idKecamatan);
                })
                ->whereYear('created_at', $tahun)
                ->get();
        }

        $pdf = Pdf::loadView('invoices.laporan-users', [
            'users' => $users,
            'label' => 'Petani',
            'tahun' => $tahun, // kirim tahun ke view juga kalau mau ditampilkan
        ]);

        return $pdf->download('laporan_data_petani_' . $tahun . '_' . date('d_m_Y') . '.pdf');
    }

    public function laporanAhliPertanian($idTanaman, $tahun)
    {
        if ((int) $idTanaman === 0) {
            // Semua tanaman, tapi filter berdasarkan tahun created_at
            $users = Penyuluh::with(['desa', 'desa.kecamatan', 'tanaman'])
                ->whereYear('created_at', $tahun)
                ->get();
        } else {
            // Filter berdasarkan tanaman dan tahun
            $users = Penyuluh::with(['desa', 'desa.kecamatan', 'tanaman'])
                ->whereHas('tanaman', function ($q) use ($idTanaman) {
                    $q->where('id_tanaman', $idTanaman);
                })
                ->whereYear('created_at', $tahun)
                ->get();
        }

        $pdf = Pdf::loadView('invoices.laporan-users', [
            'users' => $users,
            'label' => 'Penyuluh Pertanian',
            'tahun' => $tahun, // dikirim ke view agar bisa ditampilkan di laporan
        ]);

        return $pdf->download('laporan_data_penyuluh_pertanian_' . $tahun . '_' . date('d_m_Y') . '.pdf');
    }

    public function laporanKonsultasi(Request $request)
    {

        $request->validate([
            'id' => 'required|exists:konsultasi,id',
        ]);

        $konsultasi = Konsultasi::with('hasil')->find($request->id);

        $pdf = Pdf::loadView('invoices.konsultasi', ['konsultasi' => $konsultasi]);

        return $pdf->download('laporan_konsultasi_'.date('d_m_Y').'.pdf');

        // return view('invoices.konsultasi', [
        //     'konsultasi' => $konsultasi,
        // ]);

    }

    public function laporanKonsultasiKecamatan(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:kecamatan,id_kecamatan',
        ]);

        $konsultasi = Konsultasi::with(['user', 'user.desa'])
            ->whereHas('user.desa', function ($query) use ($request) {
                $query->where('id_kecamatan', $request->id);
            })->get();

        $pdf = Pdf::loadView('invoices.konsultasi-kecamatan', ['konsultasi' => $konsultasi]);

        return $pdf->download('laporan_konsultasi_kecamatan'.date('d_m_Y').'.pdf');

        // return view('invoices.konsultasi-kecamatan', [
        //     'konsultasi' => $konsultasi,
        // ]);
    }
}
