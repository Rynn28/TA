<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JTI Monitoring - Politeknik Negeri Jember</title>
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

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

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
            position: sticky;
            top: 18px;
            z-index: 20;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 14px;
            text-decoration: none;
            color: inherit;
        }

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

        .brand-text h1 {
            font-size: 1.05rem;
            line-height: 1.1;
            color: var(--text);
        }

        .brand-text p {
            margin-top: 2px;
            color: var(--muted);
            font-size: 0.9rem;
        }

        .role-switch {
            display: inline-flex;
            gap: 8px;
            padding: 6px;
            border-radius: 999px;
            background: rgba(226, 232, 240, 0.8);
            border: 1px solid rgba(148, 163, 184, 0.25);
        }

        .role-switch button {
            border: 0;
            border-radius: 999px;
            padding: 11px 18px;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.2s ease, background 0.2s ease, color 0.2s ease, box-shadow 0.2s ease;
            color: #475569;
            background: transparent;
        }

        .role-switch button:hover {
            transform: translateY(-1px);
        }

        .role-switch button.active {
            color: #fff;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-2) 100%);
            box-shadow: 0 10px 20px rgba(79, 70, 229, 0.22);
        }

        .hero {
            margin-top: 18px;
            border-radius: 28px;
            overflow: hidden;
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.96) 0%, rgba(124, 58, 237, 0.9) 100%);
            color: white;
            box-shadow: var(--shadow);
            position: relative;
            isolation: isolate;
        }

        .hero::before,
        .hero::after {
            content: '';
            position: absolute;
            inset: auto;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.14);
            filter: blur(2px);
        }

        .hero::before {
            width: 240px;
            height: 240px;
            top: -110px;
            right: -70px;
        }

        .hero::after {
            width: 180px;
            height: 180px;
            bottom: -80px;
            left: -40px;
        }

        .hero-inner {
            position: relative;
            z-index: 1;
            padding: 42px 32px 38px;
            text-align: center;
        }

        .hero-kicker {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 14px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.15);
            font-size: 0.9rem;
            letter-spacing: 0.02em;
        }

        .hero h2 {
            margin-top: 18px;
            font-size: clamp(2rem, 4vw, 3.5rem);
            line-height: 1.05;
        }

        .hero p {
            margin-top: 12px;
            font-size: 1.05rem;
            opacity: 0.95;
        }

        .content {
            margin-top: 18px;
            border-radius: 28px;
            background: var(--panel);
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

        .section-head h3 {
            font-size: 1.45rem;
            color: var(--text);
        }

        .section-head span {
            color: var(--muted);
            font-size: 0.95rem;
        }

        .role-pane {
            display: none;
            padding: 26px;
            animation: fadeIn 0.35s ease;
        }

        .role-pane.active {
            display: block;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
        }

        .prodi-groups {
            display: grid;
            gap: 22px;
        }

        .prodi-group {
            border-radius: 20px;
            border: 1px solid rgba(148, 163, 184, 0.2);
            background: rgba(255, 255, 255, 0.7);
            padding: 18px;
        }

        .prodi-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 14px;
            padding-bottom: 10px;
            border-bottom: 1px dashed rgba(148, 163, 184, 0.35);
        }

        .prodi-title {
            font-size: 1.05rem;
            font-weight: 800;
            color: #1e293b;
        }

        .prodi-count {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            padding: 6px 10px;
            font-size: 0.78rem;
            font-weight: 800;
            color: #fff;
            background: linear-gradient(135deg, var(--primary), var(--primary-2));
        }

        .bagian-groups {
            display: grid;
            gap: 22px;
        }

        .bagian-group {
            border-radius: 20px;
            border: 1px solid rgba(148, 163, 184, 0.2);
            background: rgba(255, 255, 255, 0.7);
            padding: 18px;
        }

        .bagian-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 14px;
            padding-bottom: 10px;
            border-bottom: 1px dashed rgba(148, 163, 184, 0.35);
        }

        .bagian-title {
            font-size: 1.05rem;
            font-weight: 800;
            color: #1e293b;
        }

        .bagian-count {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            padding: 6px 10px;
            font-size: 0.78rem;
            font-weight: 800;
            color: #fff;
            background: linear-gradient(135deg, var(--green), #14b8a6);
        }

        .card {
            position: relative;
            overflow: hidden;
            border-radius: 24px;
            padding: 22px;
            background: var(--panel-strong);
            border: 1px solid rgba(148, 163, 184, 0.16);
            box-shadow: 0 14px 34px rgba(15, 23, 42, 0.08);
            display: flex;
            gap: 18px;
            align-items: flex-start;
        }

        .card::before {
            content: '';
            position: absolute;
            inset: 0 auto auto 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--primary-2));
        }

        .avatar {
            width: 84px;
            height: 84px;
            border-radius: 50%;
            flex: 0 0 auto;
            display: grid;
            place-items: center;
            color: #fff;
            font-size: 1.5rem;
            font-weight: 800;
            background-image: linear-gradient(135deg, var(--primary) 0%, var(--primary-2) 100%);
            box-shadow: 0 12px 26px rgba(79, 70, 229, 0.28);
            background-size: cover;
            background-position: center;
            overflow: hidden;
        }

        .avatar.teknisi {
            background-image: linear-gradient(135deg, #059669 0%, #10b981 100%);
            box-shadow: 0 12px 26px rgba(5, 150, 105, 0.25);
        }

        .avatar-placeholder {
            display: grid;
            place-items: center;
            width: 100%;
            height: 100%;
            background-image: linear-gradient(135deg, var(--primary) 0%, var(--primary-2) 100%);
            color: #fff;
            font-size: 1.5rem;
            font-weight: 800;
        }

        .avatar.teknisi .avatar-placeholder {
            background-image: linear-gradient(135deg, #059669 0%, #10b981 100%);
        }

        .card-body {
            flex: 1;
            min-width: 0;
        }

        .card-title {
            font-size: 1.15rem;
            font-weight: 800;
            line-height: 1.35;
            color: var(--text);
        }

        .card-meta {
            margin-top: 8px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 999px;
            font-size: 0.88rem;
            font-weight: 700;
            color: #fff;
        }

        .card-meta.dosen {
            background: linear-gradient(135deg, var(--primary), var(--primary-2));
        }

        .card-meta.teknisi {
            background: linear-gradient(135deg, var(--green), #14b8a6);
        }

        .detail-list {
            margin-top: 16px;
            display: grid;
            gap: 10px;
        }

        .detail {
            display: grid;
            grid-template-columns: 84px 1fr;
            gap: 12px;
            align-items: start;
            padding: 11px 14px;
            border-radius: 14px;
            background: #f8fafc;
            border: 1px solid rgba(148, 163, 184, 0.18);
        }

        .detail-label {
            color: #64748b;
            font-weight: 700;
            font-size: 0.92rem;
        }

        .detail-value {
            color: var(--text);
            font-weight: 600;
            word-break: break-word;
        }

        .empty-state {
            margin-top: 18px;
            padding: 24px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.7);
            border: 1px dashed rgba(100, 116, 139, 0.3);
            color: var(--muted);
        }

        .footer-note {
            padding: 0 26px 26px;
            color: var(--muted);
            font-size: 0.92rem;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 900px) {
            .topbar {
                flex-direction: column;
                align-items: stretch;
            }

            .role-switch {
                width: 100%;
                justify-content: center;
            }

            .cards {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            .page-shell {
                padding: 12px;
            }

            .hero-inner,
            .role-pane,
            .section-head,
            .footer-note {
                padding-left: 16px;
                padding-right: 16px;
            }

            .card {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .detail {
                grid-template-columns: 1fr;
                text-align: left;
            }

            .detail-label {
                font-size: 0.84rem;
                text-transform: uppercase;
                letter-spacing: 0.03em;
            }
        }
    </style>
</head>
<body>
    <div class="page-shell">
        <header class="topbar">
            <a class="brand" href="/">
                <div class="brand-mark">JTI</div>
                <div class="brand-text">
                    <h1>Politeknik Negeri Jember</h1>
                    <p>Dashboard data dosen dan teknisi</p>
                </div>
            </a>

            <div class="role-switch" aria-label="Pilih role tampilan">
                <button id="btnDosen" class="active" type="button" onclick="showRole('dosen')">Dosen</button>
                <button id="btnTeknisi" type="button" onclick="showRole('teknisi')">Teknisi</button>
            </div>
        </header>

        <section class="hero">
            <div class="hero-inner">
                <div class="hero-kicker">Jurusan Teknologi Informasi</div>
                <h2 id="heroTitle">Dosen JTI</h2>
            </div>
        </section>

        <main class="content">
            <div class="section-head">
                <div>
                    <h3 id="sectionTitle">Program Studi Dosen</h3>
                    <span id="sectionDesc">Daftar dosen aktif berdasarkan program studi.</span>
                </div>
            </div>

            <?php
                $makeInitial = static function (string $nama): string {
                    $parts = preg_split('/\s+/', trim($nama)) ?: [];
                    $initials = '';

                    foreach ($parts as $part) {
                        if ($part === '') {
                            continue;
                        }

                        $initials .= strtoupper(substr($part, 0, 1));

                        if (strlen($initials) >= 2) {
                            break;
                        }
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

            <section id="dosenPane" class="role-pane active">
                <?php
                    $dosenByProdi = $dosen
                        ->sortBy([['prodi', 'asc'], ['nama', 'asc']])
                        ->groupBy(function ($item) {
                            $prodi = trim((string) ($item->prodi ?? ''));
                            return $prodi !== '' ? $prodi : 'Prodi Belum Ditentukan';
                        });
                ?>

                <?php if($dosenByProdi->isEmpty()): ?>
                    <div class="empty-state">Belum ada data dosen di database.</div>
                <?php else: ?>
                    <div class="prodi-groups">
                        <?php $__currentLoopData = $dosenByProdi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prodiName => $prodiItems): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <section class="prodi-group">
                                <header class="prodi-head">
                                    <h4 class="prodi-title"><?php echo e($prodiName); ?></h4>
                                    <span class="prodi-count"><?php echo e($prodiItems->count()); ?> Dosen</span>
                                </header>

                                <div class="cards">
                                    <?php $__currentLoopData = $prodiItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <article class="card">
                                            <?php
                                                $fotoUrl = $resolveFoto($item->foto);
                                            ?>
                                            <div class="avatar" <?php if($fotoUrl): ?> style="background-image: url('<?php echo e($fotoUrl); ?>')" <?php endif; ?>>
                                                <?php if(!$fotoUrl): ?>
                                                    <div class="avatar-placeholder"><?php echo e($makeInitial($item->nama)); ?></div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="card-body">
                                                <div class="card-title"><?php echo e($item->nama); ?></div>
                                                <div class="card-meta dosen">Dosen</div>
                                                <div class="detail-list">
                                                    <div class="detail"><div class="detail-label">NIP</div><div class="detail-value"><?php echo e($item->nip ?? '-'); ?></div></div>
                                                    <div class="detail"><div class="detail-label">NIDN</div><div class="detail-value"><?php echo e($item->nidn ?? '-'); ?></div></div>
                                                    <div class="detail"><div class="detail-label">Lokasi</div><div class="detail-value">Gedung JTI Lt. 1</div></div>
                                                </div>
                                            </div>
                                        </article>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </section>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </section>

            <section id="teknisiPane" class="role-pane">
                <?php
                    $teknisiByBagian = $teknisi
                        ->sortBy([['bagian', 'asc'], ['nama', 'asc']])
                        ->groupBy(function ($item) {
                            $bagian = trim((string) ($item->bagian ?? ''));
                            return $bagian !== '' ? $bagian : 'Bagian Belum Ditentukan';
                        });
                ?>

                <?php if($teknisiByBagian->isEmpty()): ?>
                    <div class="empty-state">Belum ada data teknisi/staff di database.</div>
                <?php else: ?>
                    <div class="bagian-groups">
                        <?php $__currentLoopData = $teknisiByBagian; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bagianName => $bagianItems): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <section class="bagian-group">
                                <header class="bagian-head">
                                    <h4 class="bagian-title"><?php echo e($bagianName); ?></h4>
                                    <span class="bagian-count"><?php echo e($bagianItems->count()); ?> Orang</span>
                                </header>

                                <div class="cards">
                                    <?php $__currentLoopData = $bagianItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <article class="card">
                                            <?php
                                                $fotoUrl = $resolveFoto($item->foto);
                                            ?>
                                            <div class="avatar teknisi" <?php if($fotoUrl): ?> style="background-image: url('<?php echo e($fotoUrl); ?>')" <?php endif; ?>>
                                                <?php if(!$fotoUrl): ?>
                                                    <div class="avatar-placeholder"><?php echo e($makeInitial($item->nama)); ?></div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="card-body">
                                                <div class="card-title"><?php echo e($item->nama); ?></div>
                                                <div class="card-meta teknisi"><?php echo e(ucfirst($item->role ?? 'staff')); ?></div>
                                                <div class="detail-list">
                                                    <div class="detail"><div class="detail-label">NIP</div><div class="detail-value"><?php echo e($item->nip ?? '-'); ?></div></div>
                                                    <div class="detail"><div class="detail-label">NIDN</div><div class="detail-value"><?php echo e($item->nidn ?? '-'); ?></div></div>
                                                    <div class="detail"><div class="detail-label">Lokasi</div><div class="detail-value">Gedung JTI Lt. 1</div></div>
                                                </div>
                                            </div>
                                        </article>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </section>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </section>

            <div class="footer-note">
            </div>
        </main>
    </div>

    <script>
        function showRole(role) {
            const dosenPane = document.getElementById('dosenPane');
            const teknisiPane = document.getElementById('teknisiPane');
            const btnDosen = document.getElementById('btnDosen');
            const btnTeknisi = document.getElementById('btnTeknisi');
            const heroTitle = document.getElementById('heroTitle');
            const sectionTitle = document.getElementById('sectionTitle');
            const sectionDesc = document.getElementById('sectionDesc');

            const isDosen = role === 'dosen';

            dosenPane.classList.toggle('active', isDosen);
            teknisiPane.classList.toggle('active', !isDosen);
            btnDosen.classList.toggle('active', isDosen);
            btnTeknisi.classList.toggle('active', !isDosen);

            heroTitle.textContent = isDosen ? 'Dosen JTI' : 'Teknisi JTI';
            sectionTitle.textContent = isDosen ? 'Program Studi Dosen' : 'Teknisi dan Staff';
            sectionDesc.textContent = isDosen
                ? 'Daftar dosen aktif berdasarkan program studi.'
                : 'Daftar teknisi dan staff aktif berdasarkan bagian.';
        }
    </script>
</body>
</html>

<?php /**PATH F:\Sempro TA\project\Laravel\TA\resources\views/dashboard.blade.php ENDPATH**/ ?>