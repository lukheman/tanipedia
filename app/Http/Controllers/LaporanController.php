<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Models\Konsultasi;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function laporanPetani()
    {

        $users = User::where('role', Role::PETANI->value)->with(['desa', 'desa.kecamatan'])->get();
        $pdf = Pdf::loadView('invoices.laporan-users', ['users' => $users, 'label' => 'Petani']);

        return $pdf->download('laporan_data_petani_' . date('d_m_Y') . '.pdf');

        // return view('invoices.laporan-users', [
        //     'users' => $users,
        //     'label' => 'Petani'
        // ]);

    }

    public function laporanAhliPertanian()
    {

        $users = User::where('role', Role::AHLIPERTANIAN->value)->with(['desa', 'desa.kecamatan'])->get();

        $pdf = Pdf::loadView('invoices.laporan-users', ['users' => $users, 'label' => 'Ahli Pertanian']);

        return $pdf->download('laporan_data_ahli_pertanian_' . date('d_m_Y') . '.pdf');

        // return view('invoices.laporan-users', [
        //     'users' => $users,
        //     'label' => 'Ahli Pertanian'
        // ]);

    }

    public function laporanKonsultasi(Request $request)
    {

        $request->validate([
            'id' => 'required|exists:konsultasi,id',
        ]);

        $konsultasi = Konsultasi::with('hasil')->find($request->id);

        $pdf = Pdf::loadView('invoices.konsultasi', ['konsultasi' => $konsultasi]);

        return $pdf->download('laporan_konsultasi_' . date('d_m_Y') . '.pdf');

        // return view('invoices.konsultasi', [
        //     'konsultasi' => $konsultasi,
        // ]);

    }

    public function laporanKonsultasiKecamatan(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:kecamatan,id',
        ]);

        $konsultasi = Konsultasi::with(['user', 'user.desa', 'hasil'])
            ->whereHas('user.desa', function ($query) use ($request) {
                $query->where('id_kecamatan', $request->id);
            })->get();

        $pdf = Pdf::loadView('invoices.konsultasi-kecamatan', ['konsultasi' => $konsultasi]);

        return $pdf->download('laporan_konsultasi_kecamatan' . date('d_m_Y') . '.pdf');

        // return view('invoices.konsultasi-kecamatan', [
        //     'konsultasi' => $konsultasi,
        // ]);
    }
}
