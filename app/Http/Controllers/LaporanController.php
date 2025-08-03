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

        $users = User::where('role', Role::PETANI->value)->get();

        return view('invoices.laporan-users', [
            'users' => $users,
        ]);

    }

    public function laporanAhliPertanian()
    {

        $users = User::where('role', Role::AHLIPERTANIAN->value)->get();

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
}
