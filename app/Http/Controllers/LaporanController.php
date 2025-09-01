<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Models\Konsultasi;
use App\Models\User;
use App\Models\Penyuluh;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function laporanPetani()
    {

        $users = User::with(['desa', 'desa.kecamatan'])->get();
        $pdf = Pdf::loadView('invoices.laporan-users', ['users' => $users, 'label' => 'Petani']);

        return $pdf->download('laporan_data_petani_'.date('d_m_Y').'.pdf');

        // return view('invoices.laporan-users', [
        //     'users' => $users,
        //     'label' => 'Petani'
        // ]);

    }

    public function laporanAhliPertanian()
    {

        $users = Penyuluh::with(['desa', 'desa.kecamatan'])->get();

        $pdf = Pdf::loadView('invoices.laporan-users', ['users' => $users, 'label' => 'Penyuluh Pertanian']);

        return $pdf->download('laporan_data_ahli_pertanian_'.date('d_m_Y').'.pdf');

        // return view('invoices.laporan-users', [
        //     'users' => $users,
        //     'label' => 'Penyuluh Pertanian'
        // ]);

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

        $konsultasi = Konsultasi::with(['user', 'user.desa', 'hasil'])
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
