<?php

namespace App\Http\Controllers;

use App\Models\User;

class DashboardController extends Controller
{
	public function index()
	{
		try {
			$dosen = User::query()
				->where('role', 'dosen')
				->orderBy('nama')
				->get();

			$teknisi = User::query()
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
