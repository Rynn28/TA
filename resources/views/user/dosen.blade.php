<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>CRUD Dosen - Dashboard JTI</title>
	<style>
		:root {
			--bg: #eef2ff;
			--panel: rgba(255, 255, 255, 0.9);
			--panel-strong: #ffffff;
			--text: #1f2937;
			--muted: #6b7280;
			--primary: #4f46e5;
			--primary-2: #7c3aed;
			--green: #059669;
			--orange: #d97706;
			--shadow: 0 24px 70px rgba(31, 41, 55, 0.18);
		}

		* { box-sizing: border-box; margin: 0; padding: 0; }

		body {
			min-height: 100vh;
			font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
			background:
				radial-gradient(circle at top left, rgba(99, 102, 241, 0.25), transparent 35%),
				radial-gradient(circle at top right, rgba(168, 85, 247, 0.18), transparent 32%),
				linear-gradient(135deg, #e0e7ff 0%, #eef2ff 45%, #f8fafc 100%);
			color: var(--text);
		}

		.page-shell {
			min-height: 100vh;
			padding: 18px;
			display: grid;
			grid-template-columns: 260px 1fr;
			gap: 18px;
		}

		.sidebar {
			display: flex;
			flex-direction: column;
			gap: 12px;
			height: fit-content;
			position: sticky;
			top: 18px;
			transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
			opacity: 1;
			transform: translateX(0);
		}

		.sidebar.hidden {
			opacity: 0;
			transform: translateX(-100%);
			pointer-events: none;
			visibility: hidden;
		}

		.page-shell.sidebar-hidden {
			grid-template-columns: 1fr;
		}

		.sidebar-top {
			display: flex;
			align-items: center;
			justify-content: flex-end;
			padding: 12px 14px;
			border-bottom: 1px solid rgba(148, 163, 184, 0.2);
		}

		.sidebar-card {
			border-radius: 20px;
			background: rgba(255, 255, 255, 0.82);
			backdrop-filter: blur(16px);
			box-shadow: var(--shadow);
			overflow: hidden;
		}

		.sidebar-menu {
			list-style: none;
			padding: 8px;
			display: flex;
			flex-direction: column;
			gap: 6px;
		}

		.sidebar-menu li {
			margin: 0;
			padding: 0;
		}

		.sidebar-menu a {
			display: flex;
			align-items: center;
			gap: 12px;
			padding: 12px 14px;
			border-radius: 14px;
			color: var(--text);
			text-decoration: none;
			font-weight: 700;
			transition: all 0.2s ease;
			position: relative;
		}

		.sidebar-menu a:hover {
			background: rgba(79, 70, 229, 0.08);
			color: var(--primary);
		}

		.sidebar-menu a.active {
			background: linear-gradient(135deg, var(--primary) 0%, var(--primary-2) 100%);
			color: #fff;
			box-shadow: 0 8px 16px rgba(79, 70, 229, 0.18);
		}

		.sidebar-toggle {
			border: 0;
			background: none;
			cursor: pointer;
			font-size: 1.5rem;
			padding: 8px;
			display: flex;
			align-items: center;
			justify-content: center;
			color: var(--text);
			transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1), color 0.3s ease;
			width: 40px;
			height: 40px;
		}

		.sidebar-toggle:hover {
			color: var(--primary);
			transform: scale(1.15) rotate(90deg);
		}

		.sidebar-toggle.active {
			color: var(--primary);
		}

		.sidebar-icon {
			width: 20px;
			height: 20px;
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 1rem;
		}

		.main-content {
			display: flex;
			flex-direction: column;
			gap: 0;
		}

		.main-content > header {
			margin-bottom: 18px;
		}

		.topbar {
			display: flex;
			align-items: center;
			justify-content: space-between;
			gap: 16px;
			padding: 14px 18px;
			border-radius: 20px;
			background: rgba(255, 255, 255, 0.72);
			backdrop-filter: blur(14px);
			box-shadow: 0 10px 35px rgba(79, 70, 229, 0.08);
			position: relative;
			z-index: 20;
		}

		.sidebar-open {
			display: none;
		}

		.page-shell.sidebar-hidden .sidebar-open {
			display: flex;
		}

		.brand { display: flex; align-items: center; gap: 14px; text-decoration: none; color: inherit; }

		.brand-mark {
			width: 44px;
			height: 44px;
			border-radius: 14px;
			display: grid;
			place-items: center;
			color: #fff;
			font-weight: 800;
			background: linear-gradient(135deg, var(--primary) 0%, var(--primary-2) 100%);
			box-shadow: 0 12px 24px rgba(79, 70, 229, 0.28);
		}

		.brand-text h1 { font-size: 1.05rem; line-height: 1.1; color: var(--text); }
		.brand-text p { margin-top: 2px; color: var(--muted); font-size: 0.9rem; }

		.actions { display: flex; gap: 10px; flex-wrap: wrap; justify-content: flex-end; align-items: center; }

		.btn {
			border: 0;
			border-radius: 999px;
			padding: 11px 16px;
			font-weight: 800;
			cursor: pointer;
			text-decoration: none;
			display: inline-flex;
			align-items: center;
			justify-content: center;
			transition: transform 0.15s ease, box-shadow 0.15s ease;
		}

		.btn:hover { transform: translateY(-1px); }

		.btn.primary {
			color: #fff;
			background: linear-gradient(135deg, var(--primary) 0%, var(--primary-2) 100%);
			box-shadow: 0 12px 22px rgba(79, 70, 229, 0.18);
		}

		.btn.ghost {
			color: #475569;
			background: rgba(226, 232, 240, 0.8);
			border: 1px solid rgba(148, 163, 184, 0.25);
		}

		.btn.danger {
			color: #fff;
			background: linear-gradient(135deg, var(--orange) 0%, var(--primary-2) 100%);
			box-shadow: 0 12px 22px rgba(217, 119, 6, 0.18);
		}

		.content {
			border-radius: 28px;
			background: rgba(255, 255, 255, 0.82);
			backdrop-filter: blur(16px);
			box-shadow: var(--shadow);
			overflow: hidden;
		}

		.section-head {
			display: flex;
			align-items: center;
			justify-content: space-between;
			gap: 16px;
			padding: 22px 26px;
			background: linear-gradient(135deg, rgba(79, 70, 229, 0.1), rgba(124, 58, 237, 0.08));
			border-bottom: 1px solid rgba(148, 163, 184, 0.2);
		}

		.section-head h2 { font-size: 1.35rem; color: var(--text); }
		.section-head p { margin-top: 4px; color: var(--muted); font-size: 0.95rem; }

		.filters {
			padding: 18px 26px;
			display: grid;
			gap: 12px;
			border-bottom: 1px solid rgba(148, 163, 184, 0.16);
		}

		.filters-row {
			display: grid;
			grid-template-columns: 1.4fr 220px 180px auto;
			gap: 12px;
			align-items: end;
		}

		.field label { display: block; font-size: 0.9rem; font-weight: 800; color: #475569; margin-bottom: 6px; }
		.input, .select {
			width: 100%;
			padding: 11px 12px;
			border-radius: 14px;
			background: #fff;
			border: 1px solid rgba(148, 163, 184, 0.22);
			outline: none;
			font-weight: 600;
			color: var(--text);
		}

		.notice {
			margin: 18px 26px 0;
			padding: 14px 16px;
			border-radius: 18px;
			background: rgba(5, 150, 105, 0.08);
			border: 1px solid rgba(5, 150, 105, 0.18);
			color: #065f46;
			font-weight: 700;
		}

		.table-wrap { padding: 18px 26px 26px; }

		table {
			width: 100%;
			border-collapse: separate;
			border-spacing: 0;
			overflow: hidden;
			border-radius: 18px;
			border: 1px solid rgba(148, 163, 184, 0.18);
			background: #fff;
		}

		thead th {
			text-align: left;
			padding: 12px 14px;
			font-size: 0.9rem;
			color: #475569;
			background: #f8fafc;
			border-bottom: 1px solid rgba(148, 163, 184, 0.18);
		}

		tbody td {
			padding: 12px 14px;
			border-bottom: 1px solid rgba(148, 163, 184, 0.12);
			vertical-align: middle;
			font-weight: 600;
			color: var(--text);
		}

		tbody tr:last-child td { border-bottom: 0; }

		.avatar {
			width: 46px;
			height: 46px;
			border-radius: 50%;
			background-size: cover;
			background-position: center;
			overflow: hidden;
			display: grid;
			place-items: center;
			color: #fff;
			font-weight: 900;
			background: linear-gradient(135deg, var(--primary) 0%, var(--primary-2) 100%);
			box-shadow: 0 10px 18px rgba(79, 70, 229, 0.18);
		}

		.avatar-placeholder {
			display: grid;
			place-items: center;
			width: 100%;
			height: 100%;
			background: linear-gradient(135deg, var(--primary) 0%, var(--primary-2) 100%);
			color: #fff;
			font-weight: 900;
		}

		.meta { color: var(--muted); font-weight: 700; font-size: 0.92rem; }
		.pill {
			display: inline-flex;
			padding: 7px 10px;
			border-radius: 999px;
			font-size: 0.85rem;
			font-weight: 800;
			color: #fff;
			background: linear-gradient(135deg, var(--primary) 0%, var(--primary-2) 100%);
		}

		.pill.dosen { background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%); }
		.pill.teknisi { background: linear-gradient(135deg, var(--green), #14b8a6); }
		.pill.staff { background: linear-gradient(135deg, var(--orange), var(--orange)); }

		.row-actions { display: inline-flex; gap: 8px; flex-wrap: wrap; }

		.btn-sm {
			border: 0;
			border-radius: 999px;
			padding: 9px 12px;
			font-weight: 800;
			cursor: pointer;
			text-decoration: none;
			display: inline-flex;
			align-items: center;
			justify-content: center;
			transition: transform 0.15s ease, box-shadow 0.15s ease;
		}

		.btn-sm:hover { transform: translateY(-2px); }

		.btn-sm.ghost {
			color: #475569;
			background: rgba(226, 232, 240, 0.8);
			border: 1px solid rgba(148, 163, 184, 0.25);
		}

		.btn-sm.success {
			color: #fff;
			background: linear-gradient(135deg, #10b981 0%, #059669 100%);
			box-shadow: 0 8px 16px rgba(16, 185, 129, 0.18);
		}

		.btn-sm.primary {
			color: #fff;
			background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
			box-shadow: 0 8px 16px rgba(59, 130, 246, 0.18);
		}

		.btn-sm.danger {
			color: #fff;
			background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
			box-shadow: 0 8px 16px rgba(239, 68, 68, 0.18);
		}

		.pagination {
			margin-top: 16px;
			display: flex;
			align-items: center;
			justify-content: space-between;
			gap: 12px;
			flex-wrap: wrap;
			color: var(--muted);
			font-weight: 700;
		}

		.pager { display: inline-flex; gap: 8px; }

		@media (max-width: 1000px) {
			.page-shell { grid-template-columns: 1fr; }
			.sidebar { position: static; }
			.filters-row { grid-template-columns: 1fr; }
			.actions { justify-content: stretch; }
			.btn { width: 100%; }
		}
	</style>
</head>
<body>
	@php
		$makeInitial = static function (?string $nama): string {
			$nama = trim((string) $nama);
			if ($nama === '') return 'NA';
			$parts = preg_split('/\s+/', $nama) ?: [];
			$initials = '';
			foreach ($parts as $part) {
				if ($part === '') continue;
				$initials .= strtoupper(substr($part, 0, 1));
				if (strlen($initials) >= 2) break;
			}
			return $initials !== '' ? $initials : 'NA';
		};

		$resolveFoto = static function (?string $foto): ?string {
			$foto = trim((string) $foto);
			if ($foto === '') return null;
			if (preg_match('~^(https?://|data:|//)~i', $foto)) return $foto;
			if (str_starts_with($foto, '/')) return $foto;
			return asset($foto);
		};
	@endphp

	<div class="page-shell sidebar-hidden">
		<!-- Sidebar Navigation -->
		<aside class="sidebar hidden">
			<div class="sidebar-card">
				<div class="sidebar-top">
					<button class="sidebar-toggle" id="sidebarToggle" title="Toggle Sidebar">✕</button>
				</div>
				<ul class="sidebar-menu">
					<li><a href="{{ route('users.index') }}"><span class="sidebar-icon">🏠</span> Home</a></li>
					<li><a href="{{ route('users.dosen') }}" class="active"><span class="sidebar-icon">👨‍🏫</span> CRUD Dosen</a></li>
					<li><a href="{{ route('users.staff') }}"><span class="sidebar-icon">🔧</span> CRUD Staff/Teknisi</a></li>
				</ul>
			</div>
		</aside>

		<!-- Main Content -->
		<div class="main-content">
			<header class="topbar">
				<button class="sidebar-toggle sidebar-open" id="sidebarOpen" title="Buka Sidebar">☰</button>
				<a class="brand" href="{{ url('/dashboard') }}">
					<div class="brand-mark">JTI</div>
					<div class="brand-text">
						<h1>CRUD Dosen</h1>
						<p>Kelola data dosen JTI</p>
					</div>
				</a>

				<div class="actions">
					<a class="btn-sm success" href="{{ route('users.create') }}">Tambah Dosen</a>
				</div>
			</header>

		<main class="content">
			<div class="section-head">
				<div>
					<h2>Daftar Dosen</h2>
					<p>Kelola data dosen dengan fitur pencarian dan filter.</p>
				</div>
				<div class="meta">Total: {{ $dosenCount }}</div>
			</div>

			<form class="filters" method="GET" action="{{ route('users.dosen') }}">
				<div class="filters-row">
					<div class="field">
						<label for="q">Cari</label>
						<input id="q" class="input" type="text" name="q" value="{{ $q }}" placeholder="Nama / NIP / NIDN">
					</div>

					<div class="field">
						<label for="per_page">Per Halaman</label>
						<select id="per_page" class="select" name="per_page">
							@foreach (['10','25','50','100','all'] as $size)
								<option value="{{ $size }}" @selected($perPage === $size)>
									{{ $size === 'all' ? 'Semua' : $size }}
								</option>
							@endforeach
						</select>
					</div>

					<div class="field">
						<button class="btn primary" type="submit">Terapkan</button>
					</div>
				</div>

				<div class="actions">
					<a class="btn ghost" href="{{ route('users.dosen') }}">Reset</a>
				</div>
			</form>

			@if (session('success'))
				<div class="notice">{{ session('success') }}</div>
			@endif

			<div class="table-wrap">
				<table>
					<thead>
						<tr>
							<th style="width: 70px;">Foto</th>
							<th>Nama</th>
							<th style="width: 180px;">NIP</th>
							<th style="width: 140px;">NIDN</th>
							<th style="width: 190px;">Aksi</th>
						</tr>
					</thead>
					<tbody>
						@forelse ($dosen as $item)
							<tr>
								<td>
									@php($fotoUrl = $resolveFoto($item->foto))
									<div class="avatar" @if($fotoUrl) style="background-image: url('{{ $fotoUrl }}')" @endif>
										@if(!$fotoUrl)
											<div class="avatar-placeholder">{{ $makeInitial($item->nama) }}</div>
										@endif
									</div>
								</td>
								<td>
									<div style="font-weight: 900;">{{ $item->nama }}</div>
									<div class="meta">ID: {{ $item->id }}</div>
								</td>
								<td>{{ $item->nip ?? '-' }}</td>
								<td>{{ $item->nidn ?? '-' }}</td>
								<td>
									<div class="row-actions">
										<a class="btn-sm primary" href="{{ route('users.edit', $item) }}">Edit</a>

										<form method="POST" action="{{ route('users.destroy', $item) }}" onsubmit="return confirm('Hapus dosen ini?')" style="display:inline;">
											@csrf
											@method('DELETE')
											<button class="btn-sm danger" type="submit">Hapus</button>
										</form>
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="5" class="meta">Belum ada data dosen.</td>
							</tr>
						@endforelse
					</tbody>
				</table>

				<div class="pagination">
					<div>
						Menampilkan {{ $dosen->firstItem() ?? 0 }}–{{ $dosen->lastItem() ?? 0 }} dari {{ $dosenCount }}
					</div>
					<div class="pager">
						@if ($dosen->onFirstPage())
							<span class="btn-sm ghost" style="opacity:0.6; cursor:not-allowed;">Sebelumnya</span>
						@else
							<a class="btn-sm ghost" href="{{ $dosen->previousPageUrl() }}">Sebelumnya</a>
						@endif

						@if ($dosen->hasMorePages())
							<a class="btn-sm ghost" href="{{ $dosen->nextPageUrl() }}">Berikutnya</a>
						@else
							<span class="btn-sm ghost" style="opacity:0.6; cursor:not-allowed;">Berikutnya</span>
						@endif
					</div>
				</div>
			</div>
		</main>
		</div>
	</div>

	<script>
		const sidebarToggle = document.getElementById('sidebarToggle');
		const sidebarOpen = document.getElementById('sidebarOpen');
		const sidebar = document.querySelector('.sidebar');
		const pageShell = document.querySelector('.page-shell');

		function toggleSidebar() {
			sidebar.classList.toggle('hidden');
			pageShell.classList.toggle('sidebar-hidden');
			sidebarToggle.classList.toggle('active');
			sidebarOpen.classList.toggle('active');
		}

		if (sidebarToggle) sidebarToggle.addEventListener('click', toggleSidebar);
		if (sidebarOpen) sidebarOpen.addEventListener('click', toggleSidebar);

		// Close sidebar when clicking on a menu link
		const menuLinks = document.querySelectorAll('.sidebar-menu a');
		menuLinks.forEach(link => {
			link.addEventListener('click', () => {
				if (!sidebar.classList.contains('hidden')) {
					toggleSidebar();
				}
			});
		});
	</script>
</body>
</html>
