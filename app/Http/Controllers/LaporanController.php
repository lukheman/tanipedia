<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Models\Konsultasi;
use App\Models\User;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function laporanPetani()
    {

        $users = User::where('role', Role::PETANI->value)->with(['desa', 'desa.kecamatan'])->get();

        return view('invoices.laporan-users', [
            'users' => $users,
        ]);

    }

    public function laporanAhliPertanian()
    {

        $users = User::where('role', Role::AHLIPERTANIAN->value)->with(['desa', 'desa.kecamatan'])->get();

        return view('invoices.laporan-users', [
            'users' => $users,
        ]);

    }

    public function laporanKonsultasi(Request $request)
    {

        $request->validate([
            'id' => 'required|exists:konsultasi,id',
        ]);

        $konsultasi = Konsultasi::with('hasil')->find($request->id);

        return view('invoices.konsultasi', [
            'konsultasi' => $konsultasi,
        ]);

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

        return view('invoices.konsultasi-kecamatan', [
            'konsultasi' => $konsultasi,
        ]);
    }
}
