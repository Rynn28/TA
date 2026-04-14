<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management Portal - Dosen & Staff/Teknisi</title>
    <style>
        :root {
            --bg: #f5f7f4;
            --panel: #ffffff;
            --ink: #17211f;
            --muted: #5f6d69;
            --line: #d8dfdc;
            --brand: #0f766e;
            --brand-soft: #e7f3f1;
            --accent: #f97316;
            --ok: #16a34a;
            --warn: #c2410c;
            --shadow: 0 18px 42px rgba(23, 33, 31, 0.08);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            font-family: "Trebuchet MS", "Segoe UI", sans-serif;
            color: var(--ink);
            background:
                radial-gradient(65rem 45rem at 120% -10%, #d7f0ec 0%, transparent 45%),
                radial-gradient(55rem 40rem at -20% 120%, #ffe8d4 0%, transparent 38%),
                var(--bg);
        }

        .layout {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 270px 1fr;
            gap: 18px;
            padding: 18px;
        }

        .sidebar {
            background: linear-gradient(180deg, #0f172a, #111827);
            color: #e5e7eb;
            border-radius: 20px;
            padding: 20px;
            box-shadow: var(--shadow);
            display: flex;
            flex-direction: column;
        }

        .brand {
            margin-bottom: 24px;
            padding-bottom: 18px;
            border-bottom: 1px solid rgba(229, 231, 235, 0.2);
        }

        .brand h1 {
            font-size: 1.1rem;
            letter-spacing: 0.04em;
        }

        .brand p {
            margin-top: 4px;
            color: #9ca3af;
            font-size: 0.9rem;
        }

        .menu {
            display: grid;
            gap: 10px;
        }

        .menu a {
            text-decoration: none;
            color: #d1d5db;
            border: 1px solid rgba(209, 213, 219, 0.15);
            border-radius: 12px;
            padding: 12px 14px;
            font-weight: 700;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .menu a:hover,
        .menu a.active {
            color: #ffffff;
            background: rgba(15, 118, 110, 0.35);
            border-color: rgba(94, 234, 212, 0.45);
            transform: translateX(2px);
        }

        .sidebar-note {
            margin-top: auto;
            border-top: 1px solid rgba(229, 231, 235, 0.18);
            padding-top: 14px;
            font-size: 0.84rem;
            color: #9ca3af;
        }

        .content {
            display: grid;
            grid-template-rows: auto 1fr;
            gap: 16px;
        }

        .topbar {
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 18px;
            box-shadow: var(--shadow);
            padding: 16px 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 14px;
        }

        .welcome h2 {
            font-size: clamp(1.15rem, 2.5vw, 1.8rem);
        }

        .welcome p {
            margin-top: 4px;
            color: var(--muted);
            font-size: 0.95rem;
        }

        .status-wrap {
            position: relative;
            min-width: 240px;
        }

        .status-trigger {
            width: 100%;
            border: 1px solid var(--line);
            background: #ffffff;
            border-radius: 12px;
            padding: 10px 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            cursor: pointer;
            font-weight: 700;
            color: var(--ink);
        }

        .status-current {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .status-dot {
            width: 10px;
            height: 10px;
            border-radius: 999px;
            background: var(--ok);
            box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.18);
        }

        .status-minus {
            display: inline-flex;
            width: 14px;
            height: 14px;
            border-radius: 999px;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 900;
            color: #fff;
            background: var(--warn);
            line-height: 1;
        }

        .status-menu {
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            right: 0;
            border: 1px solid var(--line);
            background: #fff;
            border-radius: 12px;
            box-shadow: var(--shadow);
            display: none;
            overflow: hidden;
            z-index: 10;
        }

        .status-menu.open {
            display: block;
        }

        .status-option {
            width: 100%;
            text-align: left;
            background: #fff;
            border: 0;
            border-bottom: 1px solid #edf0ef;
            padding: 10px 12px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .status-option:last-child {
            border-bottom: 0;
        }

        .status-option:hover {
            background: #f8faf9;
        }

        .main-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 16px;
        }

        .card {
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 18px;
            box-shadow: var(--shadow);
            padding: 18px;
        }

        .card h3 {
            font-size: 1.05rem;
            margin-bottom: 6px;
        }

        .card p {
            color: var(--muted);
            font-size: 0.92rem;
        }

        .chart-wrap {
            margin-top: 14px;
        }

        .chart-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            flex-wrap: wrap;
            gap: 8px;
        }

        .chip {
            background: var(--brand-soft);
            color: var(--brand);
            border: 1px solid #b5ddd8;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 700;
        }

        .chart {
            display: grid;
            gap: 9px;
        }

        .row {
            display: grid;
            grid-template-columns: 70px 1fr 55px;
            align-items: center;
            gap: 10px;
        }

        .day {
            font-weight: 700;
            color: #33413e;
            font-size: 0.9rem;
        }

        .bar-bg {
            height: 12px;
            background: #e9efed;
            border-radius: 999px;
            overflow: hidden;
        }

        .bar {
            height: 100%;
            border-radius: 999px;
            background: linear-gradient(90deg, var(--brand), #14b8a6);
            transition: width 0.3s ease;
        }

        .hours {
            text-align: right;
            font-weight: 700;
            color: #33413e;
            font-size: 0.86rem;
        }

        .settings-list {
            margin-top: 14px;
            display: grid;
            gap: 10px;
        }

        .setting-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #e7ecea;
            border-radius: 12px;
            padding: 10px 12px;
            font-size: 0.92rem;
        }

        .setting-item span {
            color: var(--muted);
        }

        .btn {
            border: 1px solid #d2dad7;
            border-radius: 9px;
            background: #fff;
            padding: 6px 9px;
            cursor: pointer;
            font-weight: 700;
            color: #33413e;
            font-size: 0.82rem;
        }

        .btn:hover {
            border-color: #a9bbb6;
            background: #f6faf9;
        }

        @media (max-width: 980px) {
            .layout {
                grid-template-columns: 1fr;
            }

            .sidebar {
                padding: 14px;
            }

            .menu {
                grid-template-columns: 1fr 1fr;
            }

            .main-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 620px) {
            .topbar {
                flex-direction: column;
                align-items: stretch;
            }

            .status-wrap {
                min-width: 0;
            }

            .row {
                grid-template-columns: 56px 1fr 45px;
            }
        }
    </style>
</head>
<body>
    <?php
        $namaString = $nama ?? 'Dosen/Staff';
        $durasiMingguan = $durasiMingguan ?? [
            'Senin' => 7.5,
            'Selasa' => 6.8,
            'Rabu' => 8.2,
            'Kamis' => 7.1,
            'Jumat' => 5.4,
        ];
        $maksJam = max($durasiMingguan);
    ?>

    <div class="layout">
        <aside class="sidebar">
            <div class="brand">
                <h1>JTI MANAGEMENT</h1>
                <p>Portal Dosen & Staff/Teknisi</p>
            </div>

            <nav class="menu" aria-label="Menu utama">
                <a href="#" class="active">
                    <span>Home</span>
                    <span>01</span>
                </a>
                <a href="#">
                    <span>Setting</span>
                    <span>02</span>
                </a>
            </nav>

            <div class="sidebar-note">
                Monitoring kehadiran kampus aktif Senin - Jumat dan reset otomatis tiap minggu.
            </div>
        </aside>

        <section class="content">
            <header class="topbar">
                <div class="welcome">
                    <h2>Selamat datang, <?php echo e($namaString); ?></h2>
                    <p>Semoga aktivitas akademik dan operasional hari ini berjalan lancar.</p>
                </div>

                <div class="status-wrap">
                    <button id="statusTrigger" class="status-trigger" type="button" aria-expanded="false" aria-controls="statusMenu">
                        <span id="statusCurrent" class="status-current">
                            <span class="status-dot" aria-hidden="true"></span>
                            Online
                        </span>
                        <span aria-hidden="true">v</span>
                    </button>

                    <div id="statusMenu" class="status-menu" role="listbox" aria-label="Pilih status">
                        <button type="button" class="status-option" data-type="online" role="option">
                            <span class="status-dot" aria-hidden="true"></span>
                            Online
                        </button>
                        <button type="button" class="status-option" data-type="dnd" role="option">
                            <span class="status-minus" aria-hidden="true">-</span>
                            Tidak Bisa Diganggu
                        </button>
                    </div>
                </div>
            </header>

            <div class="main-grid">
                <article class="card">
                    <h3>Grafik Durasi Kehadiran Dosen di Kampus</h3>
                    <p>Rekap otomatis dari Senin sampai Jumat, reset pada awal minggu berikutnya.</p>

                    <div class="chart-wrap">
                        <div class="chart-head">
                            <strong>Durasi mingguan (jam)</strong>
                            <span class="chip">Reset Mingguan Otomatis</span>
                        </div>

                        <div class="chart">
                            <?php $__currentLoopData = $durasiMingguan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hari => $jam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $persen = $maksJam > 0 ? ($jam / $maksJam) * 100 : 0;
                                ?>
                                <div class="row">
                                    <div class="day"><?php echo e($hari); ?></div>
                                    <div class="bar-bg" aria-hidden="true">
                                        <div class="bar" style="width: <?php echo e(number_format($persen, 2, '.', '')); ?>%"></div>
                                    </div>
                                    <div class="hours"><?php echo e(rtrim(rtrim(number_format($jam, 1, '.', ''), '0'), '.')); ?>j</div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </article>

                <aside class="card">
                    <h3>Setting</h3>
                    <p>Pengaturan singkat untuk akun dosen dan staff/teknisi.</p>

                    <div class="settings-list">
                        <div class="setting-item">
                            <span>Nama Tampilan</span>
                            <button class="btn" type="button">Ubah</button>
                        </div>
                        <div class="setting-item">
                            <span>Notifikasi Kehadiran</span>
                            <button class="btn" type="button">Aktif</button>
                        </div>
                        <div class="setting-item">
                            <span>Sinkron Mingguan</span>
                            <button class="btn" type="button">Jadwalkan</button>
                        </div>
                    </div>
                </aside>
            </div>
        </section>
    </div>

    <script>
        (function () {
            const trigger = document.getElementById('statusTrigger');
            const menu = document.getElementById('statusMenu');
            const current = document.getElementById('statusCurrent');

            if (!trigger || !menu || !current) return;

            const closeMenu = function () {
                menu.classList.remove('open');
                trigger.setAttribute('aria-expanded', 'false');
            };

            trigger.addEventListener('click', function () {
                const isOpen = menu.classList.contains('open');
                menu.classList.toggle('open', !isOpen);
                trigger.setAttribute('aria-expanded', String(!isOpen));
            });

            menu.querySelectorAll('.status-option').forEach(function (option) {
                option.addEventListener('click', function () {
                    const type = option.getAttribute('data-type');

                    if (type === 'online') {
                        current.innerHTML = '<span class="status-dot" aria-hidden="true"></span>Online';
                    } else {
                        current.innerHTML = '<span class="status-minus" aria-hidden="true">-</span>Tidak Bisa Diganggu';
                    }

                    closeMenu();
                });
            });

            document.addEventListener('click', function (event) {
                if (!menu.contains(event.target) && !trigger.contains(event.target)) {
                    closeMenu();
                }
            });
        })();
    </script>
</body>
</html>
<?php /**PATH F:\Sempro TA\project\Laravel\TA\resources\views\welcome.blade.php ENDPATH**/ ?>