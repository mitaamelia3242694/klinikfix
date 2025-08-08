@extends('main')

@section('title', 'Tambah Pengambilan Obat - Klinik')

@section('content')
    <section class="blank-content">
        <h3 style="margin-bottom: 1rem; color: rgb(33, 106, 178); text-align:left;">Tambah Pengambilan Obat</h3>

        <form method="POST" action="{{ route('pengambilan-obat.store') }}"
            style="max-width: 1000px; display: flex; gap: 2rem; flex-wrap: wrap;">
            @csrf

            <div style="flex: 1; min-width: 300px;">
                <label style="display:block; text-align:left;"><strong>Resep</strong></label>
                <select name="resep_id" required class="form-input" id="resep_id">
                    <option value="">-- Pilih Resep --</option>
                    @foreach ($reseps as $resep)
                        <option value="{{ $resep->id }}">
                            {{ $resep->pasien->nama ?? 'Tidak Ada Pasien' }} ({{ $resep->pasien->no_rm ?? '-' }}) -
                            {{ \Carbon\Carbon::parse($resep->tanggal)->format('d-m-Y') }}
                        </option>
                    @endforeach
                </select>

                <div id="pasien-info" style="margin-bottom: 1rem; display: none;">
                    <label style="display:block; text-align:left;"><strong>Info Pasien</strong></label>
                    <div style="background-color: #f9f9f9; padding: 0.8rem; border-radius: 6px;">
                        <p style="margin: 0;"><strong>Nama:</strong> <span id="pasien-nama"></span></p>
                        <p style="margin: 0;"><strong>Dokter:</strong> <span id="pasien-dokter"></span></p>
                        <p style="margin: 0;"><strong>Pelayanan:</strong> <span id="pasien-pelayanan"></span></p>
                        <p style="margin: 0;"><strong>Tanggal Resep:</strong> <span id="pasien-tanggal"></span></p>
                    </div>
                </div>

                <label style="display:block; text-align:left;"><strong>Petugas Apotek</strong></label>
                <select name="user_id" required class="form-input">
                    <option value="">-- Pilih Petugas --</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->nama_lengkap }}</option>
                    @endforeach
                </select>
            </div>

            <div style="flex: 1; min-width: 300px;">
                <label style="display:block; text-align:left;"><strong>Tanggal Pengambilan</strong></label>
                <input type="date" name="tanggal_pengambilan" value="{{ date('Y-m-d') }}" required class="form-input"
                    readonly>
                <label style="display:block; text-align:left;"><strong>Status Pengambilan</strong></label>
                <select name="status_checklist" id="status_checklist" required class="form-input">
                    <option value="">-- Pilih Status --</option>
                    <option value="sudah diambil">Sudah Diambil</option>
                    <option value="diambil setengah">Diambil Setengah</option>
                    <option value="belum">Belum</option>
                </select>
            </div>

            <div style="width: 100%;">
                <div class="obat-checklist-container" id="daftar-obat">
                    <!-- Daftar obat dari resep akan dimuat via AJAX -->
                    <p style="text-align: center; padding: 1rem; color: #666;">Pilih resep untuk menampilkan daftar obat</p>
                </div>
            </div>

            <div
                style="margin-top: 1rem; display: flex; flex-direction: column; align-items: flex-end; gap: 0.5rem; width: 100%;">
                <a href="{{ route('pengambilan-obat.index') }}" class="btn-cancel">Batal</a>
                <button type="submit" class="btn-submit">Simpan</button>
            </div>
        </form>
    </section>

    <style>
        .table-obat {
            width: 100%;
            border-collapse: collapse;
        }

        .table-obat th,
        .table-obat td {
            border: 1px solid #ddd;
            padding: 8px;
            vertical-align: top;
            text-align: left;
        }

        .table-sediaan {
            width: 100%;
            border: none;
        }

        .sediaan-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
            margin-bottom: 8px;
            background-color: #f9f9f9;
            padding: 8px;
            border-radius: 5px;
        }

        .select-jumlah {
            width: 100%;
            padding: 4px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        .btn-cancel,
        .btn-submit {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .btn-cancel {
            background-color: #ccc;
            color: #000;
        }

        .btn-cancel:hover {
            background-color: #aaa;
        }

        .btn-submit {
            background-color: #216ab2;
            color: #fff;
        }

        .btn-submit:hover {
            background-color: #1e5ca0;
        }

        .obat-checklist-container {
            width: 100%;
            max-height: 300px;
            overflow-y: auto;
            border: 1px solid #ddd;
            border-radius: 6px;
            margin-top: 1rem;
        }

        .table-obat th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .form-input {
            width: 100%;
            margin-bottom: 0.6rem;
            padding: 0.6rem;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }

        .stok-info {
            font-size: 0.8em;
            color: #666;
        }

        .stok-available {
            color: green;
        }

        .stok-low {
            color: orange;
        }

        .stok-empty {
            color: red;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const resepSelect = document.getElementById('resep_id');
            const pasienInfoDiv = document.getElementById('pasien-info');
            const daftarObatDiv = document.getElementById('daftar-obat');

            resepSelect.addEventListener('change', function() {
                const resepId = this.value;

                // Reset display
                pasienInfoDiv.style.display = 'none';
                daftarObatDiv.innerHTML =
                    '<p style="text-align: center; padding: 1rem; color: #666;">Memuat data...</p>';

                if (resepId) {
                    fetch(`/resep/${resepId}/info`)
                        .then(response => {
                            if (!response.ok) throw new Error('Network response was not ok');
                            return response.json();
                        })
                        .then(data => {
                            // Update patient info
                            document.getElementById('pasien-nama').textContent = data.pasien.nama;
                            document.getElementById('pasien-dokter').textContent = data.dokter;
                            document.getElementById('pasien-pelayanan').textContent = data.pelayanan;
                            document.getElementById('pasien-tanggal').textContent = data.tanggal;
                            pasienInfoDiv.style.display = 'block';

                            // Update medicine list
                            if (data.obat && data.obat.length > 0) {
                                let html = `
                                    <table class="table-obat">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama Obat</th>
                                                <th>Jumlah</th>
                                                <th>Dosis & Aturan Pakai</th>
                                                <th>Sediaan & Stok</th>
                                                <th>Checklist</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                `;

                                data.obat.forEach((obat, index) => {
                                    // Prepare sediaan options
                                    let sediaanOptions = '';
                                    if (obat.sediaan && obat.sediaan.length > 0) {
                                        obat.sediaan.forEach(sediaan => {
                                            const stokClass = sediaan.stok <= 0 ?
                                                'stok-empty' :
                                                (sediaan.stok < obat.jumlah ?
                                                    'stok-low' : 'stok-available');

                                            sediaanOptions += `
                                                <div class="sediaan-item">

                                                    <span class="stok-info ${stokClass}">
                                                        Stok: ${sediaan.stok} | Kadaluarsa: ${sediaan.kadaluarsa}
                                                    </span>
                                                    <select name="sediaan[${obat.id}][${sediaan.id}]" class="select-jumlah">
                                                        ${generateJumlahOptions(obat.jumlah, sediaan.stok)}
                                                    </select>
                                                </div>
                                            `;
                                        });
                                    } else {
                                        sediaanOptions =
                                            '<div class="sediaan-item"><em>Tidak ada sediaan tersedia</em></div>';
                                    }

                                    html += `
                                        <tr>
                                            <td>${index + 1}</td>
                                            <td>${obat.nama_obat}</td>
                                            <td>${obat.jumlah}</td>
                                            <td>${obat.dosis} | ${obat.aturan_pakai}</td>
                                            <td>${sediaanOptions}</td>
                                            <td><input type="checkbox" class="obat-checkbox" name="checklist_ids[]" value="${obat.id}"></td>
                                        </tr>
                                    `;
                                });

                                html += `</tbody></table>`;
                                daftarObatDiv.innerHTML = html;
                            } else {
                                daftarObatDiv.innerHTML =
                                    '<p style="text-align: center; padding: 1rem; color: #666;">Tidak ada obat dalam resep ini.</p>';
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            daftarObatDiv.innerHTML =
                                '<p style="text-align: center; padding: 1rem; color: red;">Gagal memuat data resep.</p>';
                        });
                } else {
                    daftarObatDiv.innerHTML =
                        '<p style="text-align: center; padding: 1rem; color: #666;">Pilih resep untuk menampilkan daftar obat</p>';
                }
            });

            // Function to generate jumlah options
            function generateJumlahOptions(jumlahResep, stok) {
                let options = '<option value="0">0 (tidak diambil)</option>';
                const maxAvailable = Math.min(jumlahResep, stok);

                for (let i = 1; i <= maxAvailable; i++) {
                    options += `<option value="${i}">${i}</option>`;
                }

                if (stok < jumlahResep) {
                    options += `<option value="${stok}">${stok} (hanya stok tersedia)</option>`;
                }

                return options;
            }

            // Update status automatically based on checklist
            function updateStatusChecklist() {
                const checkboxes = document.querySelectorAll('.obat-checkbox');
                const total = checkboxes.length;
                let checked = 0;

                checkboxes.forEach(cb => {
                    if (cb.checked) checked++;
                });

                const statusSelect = document.getElementById('status_checklist');

                if (checked === total && total > 0) {
                    statusSelect.value = 'sudah diambil';
                } else if (checked > 0 && checked < total) {
                    statusSelect.value = 'diambil setengah';
                } else {
                    statusSelect.value = 'belum';
                }
            }

            // Event delegation for dynamically loaded checkboxes
            document.addEventListener('change', function(e) {
                if (e.target.classList.contains('obat-checkbox')) {
                    updateStatusChecklist();
                }
            });
        });
    </script>
@endsection
