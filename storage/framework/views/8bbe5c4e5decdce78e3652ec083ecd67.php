<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Kelola Users - Dashboard JTI</title>
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

		.sidebar-header {
			padding: 16px 18px;
			background: linear-gradient(135deg, rgba(79, 70, 229, 0.1), rgba(124, 58, 237, 0.08));
			border-bottom: 1px solid rgba(148, 163, 184, 0.2);
			font-weight: 800;
			color: var(--text);
			font-size: 0.95rem;
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
			padding: 16px 18px;
			font-size: 0.85rem;
			font-weight: 900;
			color: #475569;
			background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
			border-bottom: 2px solid rgba(148, 163, 184, 0.2);
			letter-spacing: 0.5px;
			text-transform: uppercase;
		}

		tbody tr {
			transition: all 0.3s ease;
			border-bottom: 1px solid rgba(148, 163, 184, 0.1);
		}

		tbody tr:hover {
			background: rgba(79, 70, 229, 0.04);
			box-shadow: inset 0 0 12px rgba(79, 70, 229, 0.08);
		}

		tbody tr:nth-child(even) {
			background: rgba(248, 250, 252, 0.5);
		}

		tbody tr:nth-child(even):hover {
			background: rgba(79, 70, 229, 0.06);
		}

		tbody td {
			padding: 14px 18px;
			border-bottom: 1px solid rgba(148, 163, 184, 0.1);
			vertical-align: middle;
			font-weight: 600;
			color: var(--text);
		}

		tbody tr:last-child td { border-bottom: 0; }

		.avatar {
			width: 64px;
			height: 64px;
			border-radius: 14px;
			background-size: cover;
			background-position: center;
			overflow: hidden;
			display: grid;
			place-items: center;
			color: #fff;
			font-weight: 900;
			background: linear-gradient(135deg, var(--primary) 0%, var(--primary-2) 100%);
			box-shadow: 0 10px 24px rgba(79, 70, 229, 0.28);
			border: 2.5px solid rgba(255, 255, 255, 0.35);
			transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
			font-size: 1.25rem;
			flex-shrink: 0;
		}

		tbody tr:hover .avatar {
			transform: scale(1.1);
			box-shadow: 0 14px 32px rgba(79, 70, 229, 0.35);
		}

		.avatar-placeholder {
			display: grid;
			place-items: center;
			width: 100%;
			height: 100%;
			background: linear-gradient(135deg, var(--primary) 0%, var(--primary-2) 100%);
			color: #fff;
			font-weight: 900;
			font-size: 1.1rem;
		}

		.meta { color: var(--muted); font-weight: 700; font-size: 0.85rem; margin-top: 6px; letter-spacing: 0.3px; }
		
		.pill {
			display: inline-flex;
			padding: 8px 14px;
			border-radius: 999px;
			font-size: 0.8rem;
			font-weight: 900;
			color: #fff;
			background: linear-gradient(135deg, var(--primary) 0%, var(--primary-2) 100%);
			box-shadow: 0 4px 12px rgba(79, 70, 229, 0.22);
			text-transform: uppercase;
			letter-spacing: 0.5px;
			transition: all 0.3s ease;
		}

		.pill:hover {
			transform: translateY(-2px);
			box-shadow: 0 6px 16px rgba(79, 70, 229, 0.28);
		}

		.pill.dosen { 
			background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
			box-shadow: 0 4px 12px rgba(99, 102, 241, 0.22);
		}

		.pill.dosen:hover {
			box-shadow: 0 6px 16px rgba(99, 102, 241, 0.28);
		}

		.pill.teknisi { 
			background: linear-gradient(135deg, #10b981 0%, #14b8a6 100%);
			box-shadow: 0 4px 12px rgba(16, 185, 129, 0.22);
		}

		.pill.teknisi:hover {
			box-shadow: 0 6px 16px rgba(16, 185, 129, 0.28);
		}

		.pill.staff { 
			background: linear-gradient(135deg, #f59e0b 0%, #f97316 100%);
			box-shadow: 0 4px 12px rgba(245, 158, 11, 0.22);
		}

		.pill.staff:hover {
			box-shadow: 0 6px 16px rgba(245, 158, 11, 0.28);
		}

		.row-actions { display: flex; gap: 8px; flex-wrap: wrap; align-items: center; }

		.btn-sm {
			border: 0;
			border-radius: 10px;
			padding: 10px 14px;
			font-weight: 900;
			cursor: pointer;
			text-decoration: none;
			display: inline-flex;
			align-items: center;
			justify-content: center;
			transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
			font-size: 0.85rem;
			letter-spacing: 0.3px;
			text-transform: uppercase;
		}

		.btn-sm:hover { 
			transform: translateY(-3px);
			box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
		}

		.btn-sm:active {
			transform: translateY(-1px);
		}

		.btn-sm.ghost {
			color: #475569;
			background: rgba(226, 232, 240, 0.8);
			border: 1.5px solid rgba(148, 163, 184, 0.3);
			transition: all 0.25s ease;
		}

		.btn-sm.ghost:hover {
			background: rgba(226, 232, 240, 1);
			border-color: rgba(99, 102, 241, 0.5);
			color: var(--primary);
		}

		.btn-sm.success {
			color: #fff;
			background: linear-gradient(135deg, #10b981 0%, #059669 100%);
			box-shadow: 0 6px 16px rgba(16, 185, 129, 0.2);
		}

		.btn-sm.success:hover {
			box-shadow: 0 8px 24px rgba(16, 185, 129, 0.28);
		}

		.btn-sm.warning {
			color: #fff;
			background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
			box-shadow: 0 6px 16px rgba(245, 158, 11, 0.2);
		}

		.btn-sm.warning:hover {
			box-shadow: 0 8px 24px rgba(245, 158, 11, 0.28);
		}

		.btn-sm.primary {
			color: #fff;
			background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
			box-shadow: 0 6px 16px rgba(59, 130, 246, 0.2);
		}

		.btn-sm.primary:hover {
			box-shadow: 0 8px 24px rgba(59, 130, 246, 0.28);
		}

		.btn-sm.danger {
			color: #fff;
			background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
			box-shadow: 0 6px 16px rgba(239, 68, 68, 0.2);
		}

		.btn-sm.danger:hover {
			box-shadow: 0 8px 24px rgba(239, 68, 68, 0.28);
		}

		.pagination {
			margin-top: 20px;
			display: flex;
			align-items: center;
			justify-content: space-between;
			gap: 16px;
			flex-wrap: wrap;
			color: var(--muted);
			font-weight: 700;
			padding-top: 12px;
			border-top: 1px solid rgba(148, 163, 184, 0.12);
		}

		.pager { 
			display: inline-flex; 
			gap: 10px;
			align-items: center;
		}

		@media (max-width: 1000px) {
			.page-shell { grid-template-columns: 1fr; }
			.sidebar { position: static; }
			.filters-row { grid-template-columns: 1fr; }
			.actions { justify-content: stretch; }
			.btn { width: 100%; }
		}

		.welcome-section {
			padding: 32px 26px;
			background: linear-gradient(135deg, rgba(79, 70, 229, 0.08) 0%, rgba(124, 58, 237, 0.06) 100%);
			border-bottom: 1px solid rgba(148, 163, 184, 0.15);
		}

		.welcome-content {
			display: grid;
			grid-template-columns: 1fr auto;
			gap: 24px;
			align-items: center;
		}

		.welcome-text h3 {
			font-size: 1.5rem;
			font-weight: 900;
			color: var(--text);
			margin-bottom: 8px;
			letter-spacing: -0.5px;
		}

		.welcome-text p {
			color: var(--muted);
			font-weight: 700;
			line-height: 1.6;
			margin-bottom: 14px;
			font-size: 1rem;
		}

		.welcome-stats {
			display: flex;
			gap: 20px;
			flex-wrap: wrap;
		}

		.stat-item {
			display: flex;
			align-items: center;
			gap: 12px;
			padding: 12px 16px;
			border-radius: 12px;
			background: rgba(255, 255, 255, 0.7);
			border: 1px solid rgba(148, 163, 184, 0.12);
		}

		.stat-icon {
			width: 48px;
			height: 48px;
			border-radius: 12px;
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 1.5rem;
			background: linear-gradient(135deg, rgba(79, 70, 229, 0.15), rgba(124, 58, 237, 0.1));
		}

		.stat-value {
			display: flex;
			flex-direction: column;
		}

		.stat-number {
			font-size: 1.3rem;
			font-weight: 900;
			color: var(--primary);
		}

		.stat-label {
			font-size: 0.75rem;
			color: var(--muted);
			font-weight: 800;
			text-transform: uppercase;
			letter-spacing: 0.5px;
		}

		.welcome-icon {
			font-size: 5rem;
			opacity: 0.15;
		}
	</style>
</head>
<body>
	<?php
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
	?>

	<div class="page-shell sidebar-hidden">
		<!-- Sidebar Navigation -->
		<aside class="sidebar hidden">
			<div class="sidebar-card">
				<div class="sidebar-top">
					<button class="sidebar-toggle" id="sidebarToggle" title="Toggle Sidebar">✕</button>
				</div>
				<ul class="sidebar-menu">
					<li><a href="<?php echo e(route('users.index')); ?>" class="active"><span class="sidebar-icon">🏠</span> Home</a></li>
					<li><a href="<?php echo e(route('users.dosen')); ?>"><span class="sidebar-icon">👨‍🏫</span> CRUD Dosen</a></li>
					<li><a href="<?php echo e(route('users.staff')); ?>"><span class="sidebar-icon">🔧</span> CRUD Staff/Teknisi</a></li>
				</ul>
			</div>
		</aside>

		<!-- Main Content -->
		<div class="main-content">
			<header class="topbar">
				<button class="sidebar-toggle sidebar-open" id="sidebarOpen" title="Buka Sidebar">☰</button>
				<a class="brand" href="<?php echo e(url('/dashboard')); ?>">
					<div class="brand-mark">JTI</div>
					<div class="brand-text">
						<h1>Kelola Users</h1>
						<p>Lihat semua data dosen, staff dan teknisi</p>
					</div>
				</a>

				<div class="actions"></div>
			</header>

		<main class="content">
			<div class="section-head">
				<div>
					<h2>Daftar Users</h2>
					<p>Gunakan filter untuk mencari dan batasi jumlah data.</p>
				</div>
				<div class="meta">Total: <?php echo e($totalCount ?? 0); ?></div>
			</div>

			<div class="welcome-section">
				<div class="welcome-content">
					<div class="welcome-text">
						<h3>🎉 Selamat Datang di Admin Panel</h3>
						<p>Kelola semua data dosen, staff, dan teknisi dengan mudah. Cari, filter, dan kelola informasi pengguna dalam satu tempat yang terintegrasi.</p>
					</div>
					<div class="welcome-icon">👥</div>
				</div>
				<div class="welcome-stats">
					<div class="stat-item">
						<div class="stat-icon">👨‍🏫</div>
						<div class="stat-value">
							<span class="stat-number"><?php echo e($totalCount); ?></span>
							<span class="stat-label">Total Users</span>
						</div>
					</div>
					<div class="stat-item">
						<div class="stat-icon">📊</div>
						<div class="stat-value">
							<span class="stat-number">3</span>
							<span class="stat-label">Kategori</span>
						</div>
					</div>
					<div class="stat-item">
						<div class="stat-icon">⚙️</div>
						<div class="stat-value">
							<span class="stat-number">∞</span>
							<span class="stat-label">Fitur</span>
						</div>
					</div>
				</div>
			</div>

			<form class="filters" method="GET" action="<?php echo e(route('users.index')); ?>">
				<div class="filters-row">
					<div class="field">
						<label for=" q">Cari</label>
						<input id="q" class="input" type="text" name="q" value="<?php echo e($q); ?>" placeholder="Nama / NIP / NIDN">
					</div>

					<div class="field">
						<label for="role">Role</label>
						<select id="role" class="select" name="role">
							<option value="">Semua</option>
							<?php $__currentLoopData = $roleOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($opt); ?>" <?php if($role === $opt): echo 'selected'; endif; ?>><?php echo e(ucfirst($opt)); ?></option>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</select>
					</div>

					<div class="field">
						<label for="per_page">Per Halaman</label>
						<select id="per_page" class="select" name="per_page">
							<?php $__currentLoopData = ['10','25','50','100','all']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($size); ?>" <?php if($perPage === $size): echo 'selected'; endif; ?>>
									<?php echo e($size === 'all' ? 'Semua' : $size); ?>

								</option>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</select>
					</div>

					<div class="field">
						<button class="btn primary" type="submit">Terapkan</button>
					</div>
				</div>

				<div class="actions">
					<a class="btn ghost" href="<?php echo e(route('users.index')); ?>">Reset</a>
				</div>
			</form>

			<?php if(session('success')): ?>
				<div class="notice"><?php echo e(session('success')); ?></div>
			<?php endif; ?>

			<div class="table-wrap">
				<table>
					<thead>
						<tr>
							<th style="width: 80px;">Foto</th>
							<th style="flex: 1; min-width: 280px;">Nama</th>
							<th style="width: 160px;">NIP</th>
							<th style="width: 140px;">NIDN</th>
							<th style="width: 110px;">Role</th>
							<th style="width: 160px;">Waktu Input</th>
						</tr>
					</thead>
					<tbody>
						<?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
							<tr>
								<td>
									<?php ($fotoUrl = $resolveFoto($item->foto)); ?>
									<div class="avatar" <?php if($fotoUrl): ?> style="background-image: url('<?php echo e($fotoUrl); ?>')" <?php endif; ?>>
										<?php if(!$fotoUrl): ?>
											<div class="avatar-placeholder"><?php echo e($makeInitial($item->nama)); ?></div>
										<?php endif; ?>
									</div>
								</td>
								<td>
									<div style="font-weight: 900; font-size: 1.05rem; color: #1f2937; line-height: 1.4;"><?php echo e($item->nama); ?></div>
									<div class="meta" style="font-size: 0.8rem;">ID: <?php echo e($item->id); ?></div>
								</td>
								<td style="font-family: 'Monaco', 'Courier New', monospace; color: #475569;"><?php echo e($item->nip ?? '-'); ?></td>
								<td style="font-family: 'Monaco', 'Courier New', monospace; color: #475569;"><?php echo e($item->nidn ?? '-'); ?></td>
								<td>
									<?php ($r = (string) ($item->role ?? 'staff')); ?>
									<?php ($r = in_array($r, ['dosen', 'teknisi', 'staff'], true) ? $r : 'staff'); ?>
									<span class="pill <?php echo e($r); ?>"><?php echo e(ucfirst($r)); ?></span>
								</td>
								<td style="font-family: 'Monaco', 'Courier New', monospace; color: #6b7280; font-size: 0.95rem;">
									<?php echo e($item->created_at ? $item->created_at->format('d M Y H:i') : '-'); ?>

									<div class="meta" style="font-size: 0.75rem; margin-top: 4px;"><?php echo e($item->created_at ? $item->created_at->diffForHumans() : '-'); ?></div>
								</td>
							</tr>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
							<tr>
								<td colspan="6" style="text-align: center; padding: 48px 18px;">
									<div style="color: var(--muted); font-size: 1.1rem; font-weight: 700;">📭 Belum ada data</div>
									<div style="color: #9ca3af; font-size: 0.9rem; margin-top: 8px;">Coba ubah filter atau tambahkan data baru untuk memulai</div>
								</td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>

				<div class="pagination">
					<div>
						Menampilkan <?php echo e($users->firstItem() ?? 0); ?>–<?php echo e($users->lastItem() ?? 0); ?> dari <?php echo e($totalCount ?? 0); ?>

					</div>
					<div class="pager">
						<?php if($users->currentPage() == 1): ?>
							<span class="btn-sm ghost" style="opacity:0.6; cursor:not-allowed;">Sebelumnya</span>
						<?php else: ?>
							<a class="btn-sm ghost" href="<?php echo e($users->previousPageUrl()); ?>">Sebelumnya</a>
						<?php endif; ?>

						<?php if($users->lastPage() > $users->currentPage()): ?>
							<a class="btn-sm ghost" href="<?php echo e($users->nextPageUrl()); ?>">Berikutnya</a>
						<?php else: ?>
							<span class="btn-sm ghost" style="opacity:0.6; cursor:not-allowed;">Berikutnya</span>
						<?php endif; ?>
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
<?php /**PATH F:\Sempro TA\project\Laravel\TA\resources\views/user/index.blade.php ENDPATH**/ ?>