<?php

namespace App\Http\Controllers;

use App\Models\UserDosen;
use App\Models\UserStaff;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));
        $role = trim((string) $request->query('role', ''));
        $perPageInput = (string) $request->query('per_page', '10');

        $allowedPerPage = ['10', '25', '50', '100', 'all'];
        if (!in_array($perPageInput, $allowedPerPage, true)) {
            $perPageInput = '10';
        }

        $perPage = $perPageInput === 'all' ? 100000 : (int) $perPageInput;

        // Query dari users_dosen (Dosen)
        $dosenQuery = UserDosen::query();
        
        // Query dari users_staff (Staff & Teknisi)
        $staffQuery = UserStaff::query();

        // Apply search filter
        if ($q !== '') {
            $dosenQuery->where(function ($sub) use ($q) {
                $sub->where('nama', 'ilike', "%{$q}%")
                    ->orWhere('nip', 'ilike', "%{$q}%")
                    ->orWhere('nidn', 'ilike', "%{$q}%");
            });

            $staffQuery->where(function ($sub) use ($q) {
                $sub->where('nama', 'ilike', "%{$q}%")
                    ->orWhere('nip', 'ilike', "%{$q}%")
                    ->orWhere('nidn', 'ilike', "%{$q}%");
            });
        }

        // Apply role filter
        if ($role !== '') {
            if ($role === 'dosen') {
                $staffQuery = null; // Only show dosen
            } else {
                $dosenQuery = null; // Only show staff/teknisi
                if (in_array($role, ['staff', 'teknisi'])) {
                    $staffQuery->where('role', $role);
                }
            }
        }

        // Merge results
        $dosen = $dosenQuery ? $dosenQuery->get() : collect();
        $staff = $staffQuery ? $staffQuery->get() : collect();
        
        $allUsers = $dosen->merge($staff)->sortBy('nama');
        $totalCount = $allUsers->count();

        // Manual pagination
        $page = (int) $request->query('page', 1);
        $offset = ($page - 1) * $perPage;
        $items = $allUsers->slice($offset, $perPage)->values();

        // Create a Length Aware paginator instance
        $users = new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $totalCount,
            $perPage,
            $page,
            [
                'path' => route('users.index'),
                'query' => $request->query(),
            ]
        );

        return view('user.index', [
            'users' => $users,
            'q' => $q,
            'role' => $role,
            'perPage' => $perPageInput,
            'roleOptions' => ['dosen', 'teknisi', 'staff'],
            'totalCount' => $totalCount,
        ]);
    }

    public function dosen(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));
        $perPageInput = (string) $request->query('per_page', '10');

        $allowedPerPage = ['10', '25', '50', '100', 'all'];
        if (!in_array($perPageInput, $allowedPerPage, true)) {
            $perPageInput = '10';
        }

        $perPage = $perPageInput === 'all' ? 100000 : (int) $perPageInput;

        $query = UserDosen::query()->where('role', 'dosen')->orderBy('nama');

        if ($q !== '') {
            $query->where(function ($sub) use ($q) {
                $sub->where('nama', 'ilike', "%{$q}%")
                    ->orWhere('nip', 'ilike', "%{$q}%")
                    ->orWhere('nidn', 'ilike', "%{$q}%");
            });
        }

        $dosen = $query->paginate($perPage)->withQueryString();
        $dosenCount = UserDosen::where('role', 'dosen')->count();

        return view('Dosen.dosen', [
            'dosen' => $dosen,
            'dosenCount' => $dosenCount,
            'q' => $q,
            'perPage' => $perPageInput,
        ]);
    }

    public function staff(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));
        $role = trim((string) $request->query('role', ''));
        $perPageInput = (string) $request->query('per_page', '10');

        $allowedPerPage = ['10', '25', '50', '100', 'all'];
        if (!in_array($perPageInput, $allowedPerPage, true)) {
            $perPageInput = '10';
        }

        $perPage = $perPageInput === 'all' ? 100000 : (int) $perPageInput;

        $query = UserStaff::query()->orderBy('nama');

        if ($q !== '') {
            $query->where(function ($sub) use ($q) {
                $sub->where('nama', 'ilike', "%{$q}%")
                    ->orWhere('nip', 'ilike', "%{$q}%")
                    ->orWhere('nidn', 'ilike', "%{$q}%");
            });
        }

        if ($role !== '') {
            $query->where('role', $role);
        }

        $staff = $query->paginate($perPage)->withQueryString();
        $staffCount = UserStaff::count();

        return view('staff.staff', [
            'staff' => $staff,
            'staffCount' => $staffCount,
            'q' => $q,
            'role' => $role,
            'perPage' => $perPageInput,
        ]);
    }

    public function create(): View
    {
        $roleOptions = ['dosen', 'teknisi', 'staff'];
        
        // Determine which view to show based on the URL path
        if (request()->path() === 'dosen/create') {
            return view('Dosen.create', [
                'roleOptions' => $roleOptions,
            ]);
        }

        // Default to staff create view
        return view('staff.create', [
            'roleOptions' => $roleOptions,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        // Clean up input - trim whitespace and convert empty strings to null
        $request->merge([
            'nama' => trim((string) $request->input('nama')),
            'nip' => ($nip = trim((string) $request->input('nip'))) === '' ? null : $nip,
            'nidn' => ($nidn = trim((string) $request->input('nidn'))) === '' ? null : $nidn,
            'bagian' => trim((string) $request->input('bagian')),
            'foto' => trim((string) $request->input('foto')),
        ]);

        $role = $request->input('role');

        if ($role === 'dosen') {
            // Validate for Dosen
            $validated = $request->validate([
                'nama' => ['required', 'string', 'max:255'],
                'nip' => ['nullable', 'string', 'max:255', 'unique:users_dosen,nip'],
                'nidn' => ['nullable', 'string', 'max:255', 'unique:users_dosen,nidn'],
                'prodi' => ['nullable', 'string', 'max:255'],
                'foto' => ['nullable', 'string', 'max:2048'],
                'role' => ['required', 'in:dosen'],
            ]);

            UserDosen::create($validated);

            return redirect()->route('users.dosen')->with('success', 'Data dosen berhasil ditambahkan.');
        } else {
            // Validate for Staff/Teknisi
            $validated = $request->validate([
                'nama' => ['required', 'string', 'max:255'],
                'nip' => ['nullable', 'string', 'max:255', 'unique:users_staff,nip'],
                'nidn' => ['nullable', 'string', 'max:255', 'unique:users_staff,nidn'],
                'bagian' => ['nullable', 'string', 'max:255'],
                'foto' => ['nullable', 'string', 'max:2048'],
                'role' => ['required', 'in:staff,teknisi'],
            ]);

            UserStaff::create($validated);

            return redirect()->route('users.staff')->with('success', 'Data staff/teknisi berhasil ditambahkan.');
        }
    }

    public function edit(UserDosen | UserStaff $user): View
    {
        $roleOptions = ['dosen', 'teknisi', 'staff'];
        
        // Determine which view to show based on the URL path or user type
        if (request()->path() === "dosen/{$user->getKey()}/edit" || $user instanceof UserDosen) {
            return view('Dosen.edit', [
                'user' => $user,
                'roleOptions' => $roleOptions,
            ]);
        }

        return view('staff.edit', [
            'user' => $user,
            'roleOptions' => $roleOptions,
        ]);
    }

    public function update(Request $request, UserDosen | UserStaff $user): RedirectResponse
    {
        // Clean up input - trim whitespace and convert empty strings to null
        $request->merge([
            'nama' => trim((string) $request->input('nama')),
            'nip' => ($nip = trim((string) $request->input('nip'))) === '' ? null : $nip,
            'nidn' => ($nidn = trim((string) $request->input('nidn'))) === '' ? null : $nidn,
            'bagian' => trim((string) $request->input('bagian')),
            'foto' => trim((string) $request->input('foto')),
        ]);

        if ($user instanceof UserDosen) {
            // Update Dosen
            $validated = $request->validate([
                'nama' => ['required', 'string', 'max:255'],
                'nip' => ['nullable', 'string', 'max:255', 'unique:users_dosen,nip,' . $user->getKey() . ',id'],
                'nidn' => ['nullable', 'string', 'max:255', 'unique:users_dosen,nidn,' . $user->getKey() . ',id'],
                'prodi' => ['nullable', 'string', 'max:255'],
                'foto' => ['nullable', 'string', 'max:2048'],
                'role' => ['required', 'in:dosen'],
            ]);

            $user->update($validated);

            return redirect()->route('users.dosen')->with('success', 'Data dosen berhasil diperbarui.');
        } else {
            // Update Staff/Teknisi
            $validated = $request->validate([
                'nama' => ['required', 'string', 'max:255'],
                'nip' => ['nullable', 'string', 'max:255', 'unique:users_staff,nip,' . $user->getKey() . ',id'],
                'nidn' => ['nullable', 'string', 'max:255', 'unique:users_staff,nidn,' . $user->getKey() . ',id'],
                'bagian' => ['nullable', 'string', 'max:255'],
                'foto' => ['nullable', 'string', 'max:2048'],
                'role' => ['required', 'in:staff,teknisi'],
            ]);

            $user->update($validated);

            return redirect()->route('users.staff')->with('success', 'Data staff/teknisi berhasil diperbarui.');
        }
    }

    public function destroy(Request $request, string $id): RedirectResponse
    {
        // Try to find in UserDosen first, then UserStaff
        $userDosen = UserDosen::find($id);
        $userStaff = UserStaff::find($id);
        
        if ($userDosen) {
            $userDosen->delete();
            return redirect()->route('users.dosen')->with('success', 'Data dosen berhasil dihapus.');
        } elseif ($userStaff) {
            $userStaff->delete();
            return redirect()->route('users.staff')->with('success', 'Data staff/teknisi berhasil dihapus.');
        }
        
        return redirect()->back()->with('error', 'Data user tidak ditemukan.');
    }
}
