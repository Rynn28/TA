<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Tambah Dosen Baru - Dashboard JTI</title>
	<style>
		:root {
			--bg: #eef2ff;
			--text: #1f2937;
			--muted: #6b7280;
			--primary: #4f46e5;
			--primary-2: #7c3aed;
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
			grid-template-columns: 1fr;
			gap: 18px;
			max-width: 1000px;
			margin: 0 auto;
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

		.brand-text h1 { font-size: 1rem; line-height: 1.1; color: var(--text); font-weight: 900; }
		.brand-text p { margin-top: 2px; color: var(--muted); font-size: 0.85rem; }

		.actions {
			display: flex;
			gap: 10px;
			align-items: center;
		}

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
			transition: all 0.25s ease;
			font-size: 0.9rem;
			text-transform: uppercase;
			letter-spacing: 0.3px;
		}

		.btn:hover {
			transform: translateY(-2px);
		}

		.btn.primary {
			color: #fff;
			background: linear-gradient(135deg, var(--primary) 0%, var(--primary-2) 100%);
			box-shadow: 0 12px 24px rgba(79, 70, 229, 0.22);
		}

		.btn.primary:hover {
			box-shadow: 0 16px 32px rgba(79, 70, 229, 0.28);
		}

		.btn.ghost {
			color: #475569;
			background: rgba(226, 232, 240, 0.8);
			border: 1px solid rgba(148, 163, 184, 0.25);
		}

		.btn.ghost:hover {
			background: rgba(226, 232, 240, 1);
			color: var(--primary);
		}

		.content {
			border-radius: 28px;
			background: rgba(255, 255, 255, 0.82);
			backdrop-filter: blur(16px);
			box-shadow: var(--shadow);
			overflow: hidden;
		}

		.section-head {
			padding: 28px 32px;
			background: linear-gradient(135deg, rgba(79, 70, 229, 0.1), rgba(124, 58, 237, 0.08));
			border-bottom: 1px solid rgba(148, 163, 184, 0.2);
		}

		.section-head h2 {
			font-size: 1.8rem;
			color: var(--text);
			margin-bottom: 8px;
			font-weight: 900;
		}

		.section-head p {
			color: var(--muted);
			font-weight: 700;
			font-size: 0.95rem;
		}

		.form-wrapper {
			padding: 36px 32px;
			display: grid;
			grid-template-columns: 280px 1fr;
			gap: 40px;
			align-items: start;
		}

		.photo-section {
			display: flex;
			flex-direction: column;
			gap: 16px;
		}

		.photo-preview {
			width: 100%;
			aspect-ratio: 3/4;
			border-radius: 20px;
			background: linear-gradient(135deg, var(--primary) 0%, var(--primary-2) 100%);
			display: grid;
			place-items: center;
			color: #fff;
			font-size: 3.5rem;
			font-weight: 900;
			overflow: hidden;
			position: relative;
			cursor: pointer;
			transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
			box-shadow: 0 16px 40px rgba(79, 70, 229, 0.25);
			border: 3px solid rgba(255, 255, 255, 0.15);
		}

		.photo-preview:hover {
			transform: scale(1.03);
			box-shadow: 0 20px 50px rgba(79, 70, 229, 0.32);
		}

		.photo-preview img {
			width: 100%;
			height: 100%;
			object-fit: cover;
		}

		.photo-initial {
			display: grid;
			place-items: center;
			width: 100%;
			height: 100%;
		}

		.photo-label {
			border: 2px dashed rgba(79, 70, 229, 0.3);
			border-radius: 16px;
			padding: 16px;
			text-align: center;
			cursor: pointer;
			transition: all 0.3s ease;
			background: rgba(79, 70, 229, 0.02);
		}

		.photo-label:hover {
			border-color: var(--primary);
			background: rgba(79, 70, 229, 0.1);
		}

		.photo-label-text {
			font-size: 0.9rem;
			font-weight: 800;
			color: var(--primary);
			margin-bottom: 4px;
		}

		.photo-label-hint {
			font-size: 0.8rem;
			color: var(--muted);
			font-weight: 600;
		}

		.photo-input {
			display: none;
		}

		.form-fields {
			display: flex;
			flex-direction: column;
			gap: 24px;
		}

		.field-row {
			display: grid;
			grid-template-columns: 1fr 1fr;
			gap: 20px;
		}

		.field-row.full {
			grid-column: 1 / -1;
		}

		.field {
			display: flex;
			flex-direction: column;
			gap: 10px;
		}

		.field label {
			font-weight: 800;
			color: #475569;
			font-size: 0.9rem;
			letter-spacing: 0.3px;
		}

		.required {
			color: var(--orange);
		}

		.input, .select {
			width: 100%;
			padding: 13px 14px;
			border-radius: 14px;
			background: #fff;
			border: 1.5px solid rgba(148, 163, 184, 0.25);
			outline: none;
			font-weight: 600;
			color: var(--text);
			transition: all 0.3s ease;
			font-size: 0.95rem;
		}

		.input:focus, .select:focus {
			border-color: var(--primary);
			background: rgba(79, 70, 229, 0.02);
			box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
		}

		.input.error, .select.error {
			border-color: #ef4444;
			background: rgba(239, 68, 68, 0.02);
		}

		.hint {
			font-size: 0.8rem;
			color: var(--muted);
			font-weight: 600;
			margin-top: 4px;
		}

		.field-error {
			font-size: 0.8rem;
			color: #dc2626;
			font-weight: 700;
		}

		.error-box {
			padding: 16px 20px;
			border-radius: 16px;
			background: rgba(239, 68, 68, 0.08);
			border: 1px solid rgba(239, 68, 68, 0.2);
			color: #7f1d1d;
			margin-bottom: 20px;
		}

		.error-box strong {
			display: block;
			font-weight: 800;
			margin-bottom: 10px;
		}

		.error-box ul {
			list-style: none;
			padding-left: 20px;
		}

		.error-box li {
			font-weight: 700;
			margin-bottom: 6px;
			position: relative;
		}

		.error-box li:before {
			content: "•";
			position: absolute;
			left: -15px;
		}

		.form-actions {
			display: flex;
			gap: 12px;
			padding-top: 20px;
			border-top: 1px solid rgba(148, 163, 184, 0.12);
			grid-column: 1 / -1;
		}

		.btn.success {
			color: #fff;
			background: linear-gradient(135deg, #10b981 0%, #059669 100%);
			box-shadow: 0 12px 24px rgba(16, 185, 129, 0.22);
			flex: 1;
		}

		.btn.success:hover {
			box-shadow: 0 16px 32px rgba(16, 185, 129, 0.28);
		}

		.btn.ghost {
			flex: 1;
		}

		@media (max-width: 900px) {
			.form-wrapper {
				grid-template-columns: 1fr;
			}

			.field-row {
				grid-template-columns: 1fr;
			}

			.section-head h2 {
				font-size: 1.4rem;
			}

			.photo-preview {
				aspect-ratio: 1/1;
			}
		}
	</style>
</head>
<body>
	<div class="page-shell">
		<header class="topbar">
			<a class="brand" href="<?php echo e(route('users.index')); ?>">
				<div class="brand-mark">JTI</div>
				<div class="brand-text">
					<h1>Tambah Dosen</h1>
					<p>Data dosen baru</p>
				</div>
			</a>
			<div class="actions">
				<a class="btn ghost" href="<?php echo e(route('users.dosen')); ?>">Kembali</a>
			</div>
		</header>

		<main class="content">
			<div class="section-head">
				<h2>👨‍🏫 Form Tambah Dosen Baru</h2>
				<p>Lengkapi informasi dosen dengan data yang akurat dan benar.</p>
			</div>

			<?php if($errors->any()): ?>
				<div style="padding: 0 32px; padding-top: 20px;">
					<div class="error-box">
						<strong>❌ Validasi gagal, periksa kembali data Anda:</strong>
						<ul>
							<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<li><?php echo e($error); ?></li>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</ul>
					</div>
				</div>
			<?php endif; ?>

			<form method="POST" action="<?php echo e(route('dosen.store')); ?>" class="form-wrapper" id="dosenForm">
				<?php echo csrf_field(); ?>

				<!-- Photo Section -->
				<div class="photo-section">
					<div class="photo-preview" id="photoPreview">
						<div class="photo-initial" id="photoInitial">👨‍🏫</div>
						<img id="photoImg" style="display: none;" alt="Preview" />
					</div>
					<label class="photo-label" for="photoInput">
						<div class="photo-label-text">📤 Upload Foto</div>
						<div class="photo-label-hint">Klik untuk pilih gambar</div>
					</label>
					<input id="photoInput" class="photo-input" type="file" accept="image/*">
					<input 
						id="fotoUrl" 
						class="input" 
						type="text" 
						name="foto" 
						value="<?php echo e(old('foto')); ?>"
						placeholder="atau URL gambar"
					>
					<div class="hint">📝 Gunakan file atau URL gambar untuk foto profil</div>
				</div>

				<!-- Form Fields -->
				<div class="form-fields">
					<!-- Nama -->
					<div class="field-row full">
						<div class="field">
							<label for="nama">Nama Lengkap <span class="required">*</span></label>
							<input
								id="nama"
								class="input <?php $__errorArgs = ['nama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
								type="text"
								name="nama"
								value="<?php echo e(old('nama')); ?>"
								required
							>
							<?php $__errorArgs = ['nama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
								<div class="field-error"><?php echo e($message); ?></div>
							<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
							<div class="hint">Masukkan nama lengkap dosen</div>
						</div>
					</div>

					<!-- NIP & NIDN -->
					<div class="field-row">
						<div class="field">
							<label for="nip">NIP</label>
							<input
								id="nip"
								class="input <?php $__errorArgs = ['nip'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
								type="text"
								name="nip"
								value="<?php echo e(old('nip')); ?>"
								placeholder="Contoh: 19850315 200901 1 001"
							>
							<?php $__errorArgs = ['nip'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
								<div class="field-error"><?php echo e($message); ?></div>
							<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
							<div class="hint">Nomor Induk Pegawai (opsional)</div>
						</div>

						<div class="field">
							<label for="nidn">NIDN</label>
							<input
								id="nidn"
								class="input <?php $__errorArgs = ['nidn'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
								type="text"
								name="nidn"
								value="<?php echo e(old('nidn')); ?>"
								placeholder="Contoh: 0017058003"
							>
							<?php $__errorArgs = ['nidn'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
								<div class="field-error"><?php echo e($message); ?></div>
							<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
							<div class="hint">Nomor Induk Dosen Nasional (opsional)</div>
						</div>
					</div>

					<!-- Prodi -->
					<div class="field-row full">
						<div class="field">
							<label for="prodi">Program Studi <span class="required">*</span></label>
							<select
								id="prodi"
								class="select <?php $__errorArgs = ['prodi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
								name="prodi"
								required
							>
								<option value="">-- Pilih Program Studi --</option>
								<option value="Manajemen Informatika" <?php if(old('prodi') === 'Manajemen Informatika'): echo 'selected'; endif; ?>>Manajemen Informatika</option>
								<option value="Teknik Informatika" <?php if(old('prodi') === 'Teknik Informatika'): echo 'selected'; endif; ?>>Teknik Informatika</option>
								<option value="Teknik Komputer" <?php if(old('prodi') === 'Teknik Komputer'): echo 'selected'; endif; ?>>Teknik Komputer</option>
								<option value="Teknologi Rekayasa Komputer" <?php if(old('prodi') === 'Teknologi Rekayasa Komputer'): echo 'selected'; endif; ?>>Teknologi Rekayasa Komputer</option>
							</select>
							<?php $__errorArgs = ['prodi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
								<div class="field-error"><?php echo e($message); ?></div>
							<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
							<div class="hint">Pilih program studi untuk dosen</div>
						</div>
					</div>

					<!-- Role (Hidden for Dosen) -->
					<input type="hidden" name="role" value="dosen">

					<!-- Form Actions -->
					<div class="form-actions">
						<button class="btn success" type="submit">✅ Simpan Dosen</button>
						<a class="btn ghost" href="<?php echo e(route('users.dosen')); ?>">❌ Batal</a>
					</div>
				</div>
			</form>
		</main>
	</div>

	<script>
		const photoInput = document.getElementById('photoInput');
		const fotoUrl = document.getElementById('fotoUrl');
		const photoPreview = document.getElementById('photoPreview');
		const photoImg = document.getElementById('photoImg');
		const photoInitial = document.getElementById('photoInitial');
		const namaInput = document.getElementById('nama');
		const dosenForm = document.getElementById('dosenForm');
		let isSubmitting = false;

		// Prevent double submit
		dosenForm.addEventListener('submit', function(e) {
			if (isSubmitting) {
				e.preventDefault();
				return false;
			}
			isSubmitting = true;
			
			// Disable submit button
			const submitBtn = dosenForm.querySelector('button[type="submit"]');
			if (submitBtn) {
				submitBtn.disabled = true;
				submitBtn.style.opacity = '0.6';
				submitBtn.style.cursor = 'not-allowed';
				submitBtn.textContent = '⏳ Sedang menyimpan...';
			}
		});

		// Handle file input
		photoInput.addEventListener('change', (e) => {
			const file = e.target.files[0];
			if (file) {
				const reader = new FileReader();
				reader.onload = (event) => {
					photoImg.src = event.target.result;
					photoImg.style.display = 'block';
					photoInitial.style.display = 'none';
					fotoUrl.value = event.target.result;
				};
				reader.readAsDataURL(file);
			}
		});

		// Handle URL input
		fotoUrl.addEventListener('change', (e) => {
			const url = e.target.value.trim();
			if (url && (url.startsWith('http') || url.startsWith('data:'))) {
				photoImg.src = url;
				photoImg.style.display = 'block';
				photoInitial.style.display = 'none';
			} else {
				photoImg.style.display = 'none';
				photoInitial.style.display = 'block';
			}
		});

		// Update initial dari nama
		namaInput.addEventListener('input', () => {
			const nama = namaInput.value.trim();
			if (nama && !photoImg.src) {
				const words = nama.split(/\s+/);
				const initials = words.slice(0, 2).map(w => w.charAt(0).toUpperCase()).join('');
				photoInitial.textContent = initials || '👨‍🏫';
			}
		});

		// Restore state saat halaman load
		window.addEventListener('load', () => {
			// Reset form state jika ada error
			isSubmitting = false;
			const submitBtn = dosenForm.querySelector('button[type="submit"]');
			if (submitBtn) {
				submitBtn.disabled = false;
				submitBtn.style.opacity = '1';
				submitBtn.style.cursor = 'pointer';
				submitBtn.textContent = '✅ Simpan Dosen';
			}
			
			if (fotoUrl.value.trim()) {
				fotoUrl.dispatchEvent(new Event('change'));
			}
			if (namaInput.value.trim()) {
				namaInput.dispatchEvent(new Event('input'));
			}
		});
	</script>
</body>
</html>

<?php /**PATH F:\Sempro TA\project\Laravel\TA\resources\views/Dosen/create.blade.php ENDPATH**/ ?>