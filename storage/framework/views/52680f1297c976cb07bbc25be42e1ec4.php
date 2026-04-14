<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Tambah Staff/Teknisi - Dashboard JTI</title>
	<style>
		:root {
			--bg: #e0fdf4;
			--panel: rgba(255, 255, 255, 0.9);
			--panel-strong: #ffffff;
			--text: #1f2937;
			--muted: #6b7280;
			--primary: #059669;
			--primary-2: #14b8a6;
			--purple: #4f46e5;
			--orange: #d97706;
			--shadow: 0 24px 70px rgba(31, 41, 55, 0.18);
		}

		* { box-sizing: border-box; margin: 0; padding: 0; }

		body {
			min-height: 100vh;
			font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
			background:
				radial-gradient(circle at top left, rgba(5, 150, 105, 0.25), transparent 35%),
				radial-gradient(circle at top right, rgba(20, 184, 166, 0.18), transparent 32%),
				linear-gradient(135deg, #d1fae5 0%, #e0fdf4 45%, #f0fdfa 100%);
			color: var(--text);
		}

		.page-shell { 
			min-height: 100vh; 
			padding: 18px;
			max-width: 900px;
			margin: 0 auto;
		}

		.header {
			margin-bottom: 28px;
		}

		.header-title {
			font-size: 2rem;
			font-weight: 900;
			color: var(--text);
			margin-bottom: 8px;
		}

		.header-desc {
			color: var(--muted);
			font-weight: 700;
			font-size: 0.95rem;
		}

		.content {
			border-radius: 28px;
			background: rgba(255, 255, 255, 0.82);
			backdrop-filter: blur(16px);
			box-shadow: var(--shadow);
			overflow: hidden;
		}

		.form-container {
			padding: 36px;
			display: grid;
			grid-template-columns: 280px 1fr;
			gap: 36px;
			align-items: start;
		}

		.photo-section {
			display: flex;
			flex-direction: column;
			gap: 16px;
		}

		.photo-frame {
			width: 100%;
			aspect-ratio: 3/4;
			border-radius: 20px;
			background: linear-gradient(135deg, var(--primary) 0%, var(--primary-2) 100%);
			display: grid;
			place-items: center;
			color: #fff;
			font-size: 4rem;
			font-weight: 900;
			overflow: hidden;
			position: relative;
			cursor: pointer;
			transition: transform 0.3s ease, box-shadow 0.3s ease;
			box-shadow: 0 16px 36px rgba(5, 150, 105, 0.22);
		}

		.photo-frame:hover {
			transform: scale(1.02);
			box-shadow: 0 20px 48px rgba(5, 150, 105, 0.28);
		}

		.photo-frame img {
			width: 100%;
			height: 100%;
			object-fit: cover;
		}

		.photo-input {
			display: none;
		}

		.photo-label {
			border: 2px dashed rgba(5, 150, 105, 0.3);
			border-radius: 14px;
			padding: 14px;
			text-align: center;
			cursor: pointer;
			transition: all 0.3s ease;
			background: rgba(5, 150, 105, 0.02);
		}

		.photo-label:hover {
			border-color: var(--primary);
			background: rgba(5, 150, 105, 0.08);
		}

		.photo-label-text {
			font-size: 0.85rem;
			font-weight: 700;
			color: var(--primary);
			margin-bottom: 4px;
		}

		.photo-label-hint {
			font-size: 0.8rem;
			color: var(--muted);
			font-weight: 600;
		}

		.form-fields {
			display: flex;
			flex-direction: column;
			gap: 20px;
		}

		.field-section {
			display: grid;
			grid-template-columns: 1fr 1fr;
			gap: 20px;
		}

		.field-section.full {
			grid-column: 1 / -1;
		}

		.field {
			display: flex;
			flex-direction: column;
			gap: 8px;
		}

		.field label {
			font-weight: 800;
			color: #475569;
			font-size: 0.92rem;
		}

		.field label .required {
			color: var(--orange);
		}

		.input, .select {
			padding: 13px 14px;
			border-radius: 12px;
			background: #fff;
			border: 1.5px solid rgba(148, 163, 184, 0.25);
			outline: none;
			font-weight: 600;
			color: var(--text);
			transition: all 0.2s ease;
			font-size: 0.95rem;
		}

		.input:focus, .select:focus {
			border-color: var(--primary);
			background: rgba(5, 150, 105, 0.02);
			box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
		}

		.input::placeholder {
			color: var(--muted);
		}

		.hint {
			font-size: 0.85rem;
			color: var(--muted);
			margin-top: -2px;
		}

		.error-message {
			margin: 18px 0;
			padding: 14px 16px;
			border-radius: 16px;
			background: rgba(217, 119, 6, 0.08);
			border: 1px solid rgba(217, 119, 6, 0.18);
			color: #7c2d12;
			font-weight: 700;
		}

		.error-message ul {
			margin-top: 8px;
			padding-left: 20px;
		}

		.field-error {
			padding: 8px 10px;
			border-radius: 8px;
			background: rgba(239, 68, 68, 0.08);
			color: #991b1b;
			font-weight: 700;
			font-size: 0.85rem;
		}

		.input.error, .select.error {
			border-color: #ef4444;
			background: rgba(239, 68, 68, 0.02);
		}

		.role-selector {
			display: grid;
			grid-template-columns: 1fr 1fr;
			gap: 14px;
			padding: 16px;
			background: rgba(5, 150, 105, 0.05);
			border-radius: 14px;
			border: 1.5px solid rgba(5, 150, 105, 0.2);
		}

		.role-option {
			display: flex;
			align-items: center;
			gap: 10px;
			padding: 12px 14px;
			border-radius: 10px;
			cursor: pointer;
			transition: all 0.2s ease;
			background: #fff;
			border: 1.5px solid rgba(148, 163, 184, 0.2);
		}

		.role-option input[type="radio"] {
			cursor: pointer;
			accent-color: var(--primary);
		}

		.role-option:hover {
			border-color: var(--primary);
			background: rgba(5, 150, 105, 0.04);
		}

		.role-option input[type="radio"]:checked ~ label {
			color: var(--primary);
		}

		.role-option label {
			cursor: pointer;
			font-weight: 800;
			color: var(--text);
			flex: 1;
		}

		.form-actions {
			display: grid;
			grid-template-columns: 1fr 1fr;
			gap: 12px;
			grid-column: 1 / -1;
		}

		.btn {
			border: 0;
			border-radius: 12px;
			padding: 14px 18px;
			font-weight: 800;
			cursor: pointer;
			text-decoration: none;
			display: inline-flex;
			align-items: center;
			justify-content: center;
			transition: all 0.2s ease;
			gap: 8px;
			font-size: 0.95rem;
		}

		.btn:hover {
			transform: translateY(-2px);
		}

		.btn.primary {
			color: #fff;
			background: linear-gradient(135deg, var(--primary) 0%, var(--primary-2) 100%);
			box-shadow: 0 12px 24px rgba(5, 150, 105, 0.22);
		}

		.btn.primary:hover {
			box-shadow: 0 16px 32px rgba(5, 150, 105, 0.28);
		}

		.btn.ghost {
			color: #475569;
			background: rgba(226, 232, 240, 0.8);
			border: 1px solid rgba(148, 163, 184, 0.25);
		}

		.btn.ghost:hover {
			background: rgba(226, 232, 240, 1);
		}

		@media (max-width: 900px) {
			.form-container {
				grid-template-columns: 1fr;
			}

			.field-section {
				grid-template-columns: 1fr;
			}

			.role-selector {
				grid-template-columns: 1fr;
			}

			.form-actions {
				grid-template-columns: 1fr;
			}

			.header-title {
				font-size: 1.5rem;
			}
		}
	</style>
</head>
<body>
	<div class="page-shell">
		<header class="header">
			<h1 class="header-title">🔧 Tambah Staff/Teknisi</h1>
			<p class="header-desc">Lengkapi data staff atau teknisi dengan informasi yang akurat.</p>
		</header>

		<div class="content">
			<?php if($errors->any()): ?>
				<div class="error-message">
					<strong>❌ Terjadi kesalahan validasi:</strong>
					<ul>
						<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<li><?php echo e($error); ?></li>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</ul>
				</div>
			<?php endif; ?>

			<form method="POST" action="<?php echo e(route('staff.store')); ?>" class="form-container">
				<?php echo csrf_field(); ?>

				<!-- Foto Section -->
				<div class="photo-section">
					<div class="photo-frame" id="photoPreview">
						<span id="photoInitial">🔧</span>
						<img id="photoImg" style="display:none;" />
					</div>
					<label class="photo-label" for="fotoInput">
						<div class="photo-label-text">📤 Upload Foto</div>
						<div class="photo-label-hint">Klik untuk memilih gambar</div>
					</label>
					<input 
						id="fotoInput" 
						class="input" 
						type="text" 
						name="foto" 
						value="<?php echo e(old('foto')); ?>"
						placeholder="atau masukkan URL foto"
					>
					<div class="hint">Format: URL gambar (https://...)</div>
				</div>

				<!-- Form Fields -->
				<div class="form-fields">
					<!-- Row 1: Nama -->
					<div class="field-section full">
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
								placeholder="Masukkan nama lengkap"
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
						</div>
					</div>

					<!-- Row 2: NIP dan NIDN -->
					<div class="field-section">
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
								placeholder="Contoh: 12345678 900000 1 001"
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
							<label for="nidn">Identitas Lain / BioID</label>
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
								placeholder="Contoh: BiometricID atau nomor lain"
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
							<div class="hint">Identitas tambahan (opsional)</div>
						</div>
					</div>

					<!-- Row 3: Bagian -->
					<div class="field-section full">
						<div class="field">
							<label for="bagian">Bagian <span class="required">*</span></label>
							<select 
								id="bagian" 
								class="select <?php $__errorArgs = ['bagian'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
								name="bagian"
								required
							>
								<option value="">-- Pilih Bagian --</option>
								<option value="Staff Administrasi" <?php if(old('bagian') === 'Staff Administrasi'): echo 'selected'; endif; ?>>Staff Administrasi</option>
								<option value="Arsitektur dan Jaringan Komputer" <?php if(old('bagian') === 'Arsitektur dan Jaringan Komputer'): echo 'selected'; endif; ?>>Arsitektur dan Jaringan Komputer</option>
								<option value="Komputasi dan Sistem Informasi" <?php if(old('bagian') === 'Komputasi dan Sistem Informasi'): echo 'selected'; endif; ?>>Komputasi dan Sistem Informasi</option>
								<option value="Rekayasa Sistem Informasi" <?php if(old('bagian') === 'Rekayasa Sistem Informasi'): echo 'selected'; endif; ?>>Rekayasa Sistem Informasi</option>
								<option value="Sistem Komputer dan Kontrol" <?php if(old('bagian') === 'Sistem Komputer dan Kontrol'): echo 'selected'; endif; ?>>Sistem Komputer dan Kontrol</option>
								<option value="Rekayasa Perangkat Lunak" <?php if(old('bagian') === 'Rekayasa Perangkat Lunak'): echo 'selected'; endif; ?>>Rekayasa Perangkat Lunak</option>
								<option value="Multimedia Cerdas" <?php if(old('bagian') === 'Multimedia Cerdas'): echo 'selected'; endif; ?>>Multimedia Cerdas</option>
								<option value="Staff Lainnya" <?php if(old('bagian') === 'Staff Lainnya'): echo 'selected'; endif; ?>>Staff Lainnya</option>
							</select>
							<?php $__errorArgs = ['bagian'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
								<div class="field-error"><?php echo e($message); ?></div>
							<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
							<div class="hint">Pilih bagian/divisi staff</div>
						</div>
					</div>

					<!-- Role Selection -->
					<div class="field-section full">
						<label style="font-weight: 800; color: #475569; font-size: 0.92rem; margin-bottom: 8px;">Pilih Role <span class="required">*</span></label>
						<div class="role-selector">
							<div class="role-option">
								<input type="radio" id="roleStaff" name="role" value="staff" <?php if(old('role') === 'staff' || !old('role')): echo 'checked'; endif; ?> required>
								<label for="roleStaff">👤 Staff</label>
							</div>
							<div class="role-option">
								<input type="radio" id="roleTeknik" name="role" value="teknisi" <?php if(old('role') === 'teknisi'): echo 'checked'; endif; ?> required>
								<label for="roleTeknik">🔧 Teknisi</label>
							</div>
						</div>
					</div>
				</div>

				<!-- Form Actions -->
				<div class="form-actions">
					<button class="btn primary" type="submit">✅ Simpan Staff/Teknisi</button>
					<a class="btn ghost" href="<?php echo e(route('users.staff')); ?>">❌ Batal</a>
				</div>
			</form>
		</div>
	</div>

	<script>
		// Photo preview dari URL
		const fotoInput = document.getElementById('fotoInput');
		const photoPreview = document.getElementById('photoPreview');
		const photoImg = document.getElementById('photoImg');
		const photoInitial = document.getElementById('photoInitial');
		const namaInput = document.getElementById('nama');
		const roleStaffInput = document.getElementById('roleStaff');
		const roleTeknikInput = document.getElementById('roleTeknik');
		const submitBtn = document.querySelector('button[type="submit"]');
		const form = document.querySelector('form');
		let isSubmitting = false;

		function updatePhotoIcon() {
			if (roleTeknikInput.checked) {
				return '🔧';
			}
			return '👤';
		}

		// Prevent double submission
		form.addEventListener('submit', (e) => {
			if (isSubmitting) {
				e.preventDefault();
				return false;
			}
			isSubmitting = true;
			submitBtn.disabled = true;
			submitBtn.textContent = '⏳ Menyimpan...';
		});

		fotoInput.addEventListener('change', (e) => {
			const url = e.target.value.trim();
			if (url && (url.startsWith('http') || url.startsWith('data:'))) {
				photoImg.src = url;
				photoImg.style.display = 'block';
				photoInitial.style.display = 'none';
			} else {
				photoImg.style.display = 'none';
				photoInitial.style.display = 'block';
				updateInitials();
			}
		});

		function updateInitials() {
			const nama = namaInput.value.trim();
			if (nama) {
				const initials = nama.split(/\s+/)
					.slice(0, 2)
					.map(w => w.charAt(0).toUpperCase())
					.join('');
				photoInitial.textContent = initials || updatePhotoIcon();
			} else {
				photoInitial.textContent = updatePhotoIcon();
			}
		}

		// Trigger dari input nama
		namaInput.addEventListener('input', updateInitials);

		// Trigger dari role selection
		roleStaffInput.addEventListener('change', updateInitials);
		roleTeknikInput.addEventListener('change', updateInitials);

		// Inisialisasi saat halaman load
		window.addEventListener('load', () => {
			isSubmitting = false;
			submitBtn.disabled = false;
			submitBtn.textContent = '✅ Simpan Staff/Teknisi';
			if (fotoInput.value.trim()) {
				fotoInput.dispatchEvent(new Event('change'));
			}
			if (namaInput.value.trim()) {
				namaInput.dispatchEvent(new Event('input'));
			}
		});
	</script>
</body>
</html>
<?php /**PATH F:\Sempro TA\project\Laravel\TA\resources\views\staff\create.blade.php ENDPATH**/ ?>