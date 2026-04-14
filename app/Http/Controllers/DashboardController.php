<?php

namespace App\Http\Controllers;

use App\Models\UserDosen;
use App\Models\UserStaff;

class DashboardController extends Controller
{
	public function index()
	{
		try {
			$dosen = UserDosen::query()
				->where('role', 'dosen')
				->orderBy('nama')
				->get();

			$teknisi = UserStaff::query()
				->whereIn('role', ['teknisi', 'staff'])
				->orderBy('nama')
				->get();
		} catch (\Exception $e) {
			// Fallback ke data kosong jika database gagal
			$dosen = collect();
			$teknisi = collect();
		}

		return view('dashboard', [
			'dosen' => $dosen,
			'teknisi' => $teknisi,
		]);
	}
}
