<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Edit Dosen - JTI</title>
	<style>
		:root { --primary: #4f46e5; --success: #10b981; --orange: #d97706; --text: #1f2937; --muted: #6b7280; }
		* { margin: 0; padding: 0; box-sizing: border-box; }
		body { font-family: 'Segoe UI', sans-serif; background: linear-gradient(135deg, #e0e7ff 0%, #eef2ff 100%); min-height: 100vh; color: var(--text); }
		.container { max-width: 900px; margin: 20px auto; padding: 0 16px; }
		.header { display: flex; justify-content: space-between; align-items: center; padding: 16px; background: white; border-radius: 16px; margin-bottom: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
		.header h1 { font-size: 20px; font-weight: 900; }
		.btn { padding: 10px 16px; border-radius: 8px; border: none; cursor: pointer; font-weight: 700; text-decoration: none; display: inline-block; transition: all 0.2s; }
		.btn:hover { transform: translateY(-2px); }
		.btn-ghost { background: #e2e8f0; color: #334155; }
		.btn-success { background: var(--success); color: white; }
		.card { background: white; border-radius: 16px; padding: 32px; box-shadow: 0 4px 16px rgba(0,0,0,0.08); }
		.form-layout { display: grid; grid-template-columns: 280px 1fr; gap: 40px; }
		.photo-box { text-align: center; }
		.photo-preview { width: 100%; aspect-ratio: 3/4; background: linear-gradient(135deg, var(--primary), #7c3aed); border-radius: 16px; display: flex; align-items: center; justify-content: center; color: white; font-size: 48px; font-weight: 900; margin-bottom: 16px; overflow: hidden; position: relative; }
		.photo-preview img { width: 100%; height: 100%; object-fit: cover; position: absolute; }
		.photo-initial { position: relative; z-index: 1; }
		.file-input { display: none; }
		.file-label { display: block; padding: 12px; border: 2px dashed var(--primary); border-radius: 12px; cursor: pointer; color: var(--primary); font-weight: 700; margin-bottom: 12px; transition: all 0.2s; }
		.file-label:hover { background: rgba(79, 70, 229, 0.05); border-color: #7c3aed; }
		.form-group { margin-bottom: 24px; }
		.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
		.form-row.full { grid-column: 1 / -1; }
		label { display: block; margin-bottom: 8px; font-weight: 700; color: #475569; font-size: 14px; }
		.required { color: var(--orange); }
		input, select { width: 100%; padding: 12px; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 14px; font-family: inherit; }
		input:focus, select:focus { outline: none; border-color: var(--primary); background: rgba(79, 70, 229, 0.02); box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1); }
		input.error, select.error { border-color: #ef4444; background: rgba(239, 68, 68, 0.02); }
		.error-text { color: #dc2626; font-size: 12px; margin-top: 4px; }
		.hint-text { color: #6b7280; font-size: 12px; margin-top: 4px; }
		.error-alert { background: #fee2e2; border: 1px solid #fecaca; border-radius: 12px; padding: 16px; margin-bottom: 20px; }
		.error-alert strong { color: #7f1d1d; display: block; margin-bottom: 8px; font-weight: 800; }
		.error-alert ul { list-style: none; padding-left: 20px; color: #b91c1c; }
		.error-alert li { margin-bottom: 4px; }
		.form-actions { display: flex; gap: 12px; margin-top: 40px; border-top: 1px solid #e2e8f0; padding-top: 24px; }
		.form-actions button, .form-actions a { flex: 1; padding: 12px; border-radius: 8px; border: none; font-weight: 700; cursor: pointer; text-align: center; transition: all 0.2s; }
		.form-actions button:disabled { opacity: 0.6; cursor: not-allowed; }
		@media (max-width: 800px) {
			.form-layout { grid-template-columns: 1fr; }
			.form-row { grid-template-columns: 1fr; }
			.header { flex-direction: column; gap: 12px; align-items: flex-start; }
		}
	</style>
</head>
<body>
	@php
		$makeInitial = static function (?string $nama): string {
			$nama = trim((string) $nama);
			if ($nama === '') return '👨‍🏫';
			$parts = preg_split('/\s+/', $nama) ?: [];
			$initials = '';
			foreach ($parts as $part) {
				if ($part === '') continue;
				$initials .= strtoupper(substr($part, 0, 1));
				if (strlen($initials) >= 2) break;
			}
			return $initials !== '' ? $initials : '👨‍🏫';
		};
	@endphp
	<div class="container">
		<div class="header">
			<h1>✏️ Edit Dosen</h1>
			<a href="{{ route('users.dosen') }}" class="btn btn-ghost">Kembali</a>
		</div>
		<div class="card">
			@if ($errors->any())
			<div class="error-alert">
				<strong>❌ Validasi gagal:</strong>
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
			@endif
			<form method="POST" action="{{ route('dosen.update', $user) }}" id="editForm" class="form-layout">
				@csrf
				@method('PUT')
				<div class="photo-box">
					<div class="photo-preview" id="photoPreview">
						<span id="photoInitial">{{ $makeInitial($user->nama) }}</span>
						<img id="photoImg" style="display: none;" alt="Foto Dosen" />
					</div>
					<label for="photoFile" class="file-label">📤 Ubah Foto</label>
					<input id="photoFile" type="file" accept="image/*" class="file-input">
					<input id="fotoUrl" type="text" name="foto" value="{{ old('foto', $user->foto) }}" placeholder="atau URL foto">
					<div class="hint-text">URL gambar untuk profil</div>
				</div>
				<div>
					<div class="form-row full">
						<div class="form-group">
							<label for="nama">Nama Lengkap <span class="required">*</span></label>
							<input id="nama" type="text" name="nama" value="{{ old('nama', $user->nama) }}" required class="@error('nama') error @enderror">
							@error('nama')<div class="error-text">{{ $message }}</div>@enderror
							<div class="hint-text">Nama lengkap dosen</div>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group">
							<label for="nip">NIP</label>
							<input id="nip" type="text" name="nip" value="{{ old('nip', $user->nip) }}" placeholder="19850315 200901 1 001" class="@error('nip') error @enderror">
							@error('nip')<div class="error-text">{{ $message }}</div>@enderror
							<div class="hint-text">Nomor Induk Pegawai</div>
						</div>
						<div class="form-group">
							<label for="nidn">NIDN</label>
							<input id="nidn" type="text" name="nidn" value="{{ old('nidn', $user->nidn) }}" placeholder="0017058003" class="@error('nidn') error @enderror">
							@error('nidn')<div class="error-text">{{ $message }}</div>@enderror
							<div class="hint-text">Nomor Induk Dosen Nasional</div>
						</div>
					</div>
					<div class="form-row full">
						<div class="form-group">
							<label for="prodi">Program Studi <span class="required">*</span></label>
							<select id="prodi" name="prodi" required class="@error('prodi') error @enderror">
								<option value="">-- Pilih Program Studi --</option>
								<option value="Manajemen Informatika" @selected(old('prodi', $user->prodi) === 'Manajemen Informatika')>Manajemen Informatika</option>
								<option value="Teknik Informatika" @selected(old('prodi', $user->prodi) === 'Teknik Informatika')>Teknik Informatika</option>
								<option value="Teknik Komputer" @selected(old('prodi', $user->prodi) === 'Teknik Komputer')>Teknik Komputer</option>
								<option value="Teknologi Rekayasa Komputer" @selected(old('prodi', $user->prodi) === 'Teknologi Rekayasa Komputer')>Teknologi Rekayasa Komputer</option>
							</select>
							@error('prodi')<div class="error-text">{{ $message }}</div>@enderror
							<div class="hint-text">Program studi dosen</div>
						</div>
					</div>
					<input type="hidden" name="role" value="dosen">
					<div class="form-actions">
						<button type="submit" class="btn btn-success" id="submitBtn">💾 Simpan Perubahan</button>
						<a href="{{ route('users.dosen') }}" class="btn btn-ghost">❌ Batal</a>
					</div>
				</div>
			</form>
		</div>
	</div>
	<script>
		const photoFile = document.getElementById('photoFile');
		const fotoUrl = document.getElementById('fotoUrl');
		const photoImg = document.getElementById('photoImg');
		const photoInitial = document.getElementById('photoInitial');
		const namaInput = document.getElementById('nama');
		const editForm = document.getElementById('editForm');
		const submitBtn = document.getElementById('submitBtn');
		let isSubmitting = false;
		
		editForm.addEventListener('submit', function(e) {
			if (isSubmitting) { e.preventDefault(); return false; }
			isSubmitting = true;
			submitBtn.disabled = true;
			submitBtn.textContent = '⏳ Menyimpan...';
		});
		
		photoFile.addEventListener('change', (e) => {
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
		
		namaInput.addEventListener('input', () => {
			const nama = namaInput.value.trim();
			if (nama && !photoImg.src) {
				const words = nama.split(/\s+/);
				const initials = words.slice(0, 2).map(w => w.charAt(0).toUpperCase()).join('');
				photoInitial.textContent = initials || '👨‍🏫';
				photoInitial.style.display = 'block';
			}
		});
		
		window.addEventListener('load', () => {
			isSubmitting = false;
			submitBtn.disabled = false;
			submitBtn.textContent = '💾 Simpan Perubahan';
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