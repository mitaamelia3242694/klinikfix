@extends('main')

@section('title', 'Ketersediaan Obat - Klinik')

@section('content')
    <section class="blank-content">
        <div class="table-header">
            <h3>Ketersediaan Obat</h3>
            <button onclick="document.getElementById('modalTambah').style.display='flex'"
                style="padding: 0.5rem 1rem; background:rgb(33, 106, 178); color:#fff; border:none; border-radius:8px; cursor:pointer;">
                Tambah Ketersediaan
            </button>
        </div>

        <!-- Filter Baru dengan Toggle Switch -->
        <div
            style="margin-bottom: 1rem; padding: 16px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 12px; border: 1px solid #dee2e6;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                <div class="toggle-switch">
                    <input type="checkbox" id="filter90Days" class="toggle-input" onchange="toggleFilter90Days(this)">
                    <label for="filter90Days" class="toggle-label">
                        <span class="toggle-slider"></span>
                    </label>
                </div>
                <label for="filter90Days" style="cursor: pointer; font-weight: 600; color: #495057; font-size: 15px;">
                    🎯 Filter Obat Kadaluarsa 90 Hari
                </label>
                <span id="filterStatus"
                    style="padding: 4px 12px; border-radius: 20px; font-size: 12px; background: #6c757d; color: white;">
                    NONAKTIF
                </span>
            </div>
            <div id="filterInfo" style="font-size: 13px; color: #6c757d; display: none;">
                📅 Menampilkan obat yang akan kadaluarsa dalam 90 hari ke depan (termasuk yang sudah kadaluarsa)
            </div>
        </div>

        @if (session('success'))
            <div class="alert-success" id="successAlert">
                {{ session('success') }}
            </div>
        @endif

        <div id="loadingIndicator"
            style="display: none; text-align: center; padding: 20px; background: #f8f9fa; border-radius: 8px; margin-bottom: 1rem;">
            <div
                style="display: inline-block; width: 20px; height: 20px; border: 3px solid #f3f3f3; border-top: 3px solid rgb(33, 106, 178); border-radius: 50%; animation: spin 1s linear infinite;">
            </div>
            <span style="margin-left: 10px; color: #666;">Memfilter data obat...</span>
        </div>

        <table class="data-table" id="dataTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Obat</th>
                    <th>Stok Awal</th>
                    <th>Tanggal Masuk</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                    <th>Total Stok</th>
                    <th>Keluar</th>
                    <th>Tanggal Keluar</th>
                    <th>Stok Akhir</th>
                    <th>Kadaluarsa</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                <!-- Data akan diisi oleh JavaScript -->
            </tbody>
        </table>

        <!-- Summary Information -->
        <div id="summaryBox"
            style="display: none; margin-top: 1rem; padding: 16px; background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%); border-radius: 8px; border-left: 4px solid #2196f3;">
            <h4 style="margin: 0 0 10px 0; color: #1976d2;">📊 Ringkasan Filter</h4>
            <div id="summaryContent"></div>
        </div>

        <!-- Modals tetap sama -->
        <div id="modalRiwayat"
            style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.5); justify-content:center; align-items:center; z-index:9999;">
            <div
                style="background:#fff; padding:2rem; border-radius:12px; width:90%; max-width:600px; max-height:80vh; overflow:auto; position:relative;">
                <span onclick="document.getElementById('modalRiwayat').style.display='none'"
                    style="position:absolute; top:1rem; right:1rem; font-size:1.5rem; cursor:pointer;">&times;</span>
                <h3 style="margin-bottom:1rem; color:#216ab2;">Riwayat Pengeluaran Obat (Bulan Ini)</h3>
                <div id="riwayatContent"></div>
            </div>
        </div>

        <!-- Modal Tambah -->
        <div id="modalTambah" onclick="if(event.target === this) this.style.display='none'"
            style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.6); justify-content:center; align-items:center; z-index:9999;">
            <div
                style="background:#fff; padding:2rem; border-radius:12px; width:90%; max-width:500px; max-height:90vh; overflow:auto; box-shadow:0 5px 20px rgba(0,0,0,0.2); position:relative;">
                <span onclick="document.getElementById('modalTambah').style.display='none'"
                    style="position:absolute; top:1rem; right:1rem; font-size:1.5rem; cursor:pointer; color:rgb(33, 106, 178);">&times;</span>
                <h3 style="margin-bottom:1rem; color:rgb(33, 106, 178); text-align:left;">Tambah Ketersediaan Obat</h3>

                <form method="POST" action="{{ route('kesediaan-obat.store') }}">
                    @csrf
                    <label style="display:block; text-align:left;"><strong>Nama Obat</strong></label>
                    <select name="obat_id" required class="input-style" id="obatSelect" onchange="hitungStok(this)">
                        <option value="">-- Pilih Obat --</option>
                        @foreach ($obats as $obat)
                            <option value="{{ $obat->id }}" data-total="{{ $obat->stok_total }}">
                                {{ $obat->nama_obat }}
                            </option>
                        @endforeach
                    </select>

                    <label style="display:block; text-align:left;"><strong>Jumlah (Masuk)</strong></label>
                    <input type="number" id="jumlahInput" class="input-style" name="jumlah">

                    <label style="display:block; text-align:left;"><strong>Stok Awal</strong></label>
                    <input type="number" id="stokAwal" class="input-style" name="stok_awal">

                    <label style="display:block; text-align:left;"><strong>Stok Akhir</strong></label>
                    <input type="number" id="stokAkhir" class="input-style" name="stok_akhir">

                    <label style="display:block; text-align:left;"><strong>Total Stok</strong></label>
                    <input type="number" id="totalStok" class="input-style" name="total_stok">

                    <label style="display:block; text-align:left;"><strong>Tanggal Masuk</strong></label>
                    <input type="date" name="tanggal_masuk" required class="input-style">

                    <label><strong>Tanggal Keluar</strong></label>
                    <input type="date" name="tanggal_keluar" class="input-style">

                    <label style="display:block; text-align:left;"><strong>Tanggal Kadaluarsa</strong></label>
                    <input type="date" name="tanggal_kadaluarsa" required class="input-style">

                    <label style="display:block; text-align:left;"><strong>Keterangan</strong></label>
                    <textarea name="keterangan" rows="2" class="input-style"></textarea>

                    <div style="display:flex; justify-content: flex-end; gap: 0.5rem; margin-top: 1rem;">
                        <button type="button" onclick="document.getElementById('modalTambah').style.display='none'"
                            class="btn btn-warning">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <style>
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-left: 5px solid #28a745;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 1rem;
            position: relative;
            animation: fadeSlide 0.5s ease-out;
        }

        @keyframes fadeSlide {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .input-style {
            width: 100%;
            padding: 0.6rem;
            margin-bottom: 0.6rem;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .data-table th,
        .data-table td {
            padding: 10px 12px;
            border: 1px solid #ddd;
        }

        .data-table th {
            background-color: #f0f0f0;
        }

        .btn {
            padding: 6px 10px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            margin-right: 4px;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-warning {
            background-color: #ffc107;
            color: black;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn-info {
            color: white;
            background-color: rgb(4, 135, 109);
        }

        .no-underline {
            text-decoration: none;
        }

        /* Toggle Switch Styles */
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }

        .toggle-input {
            opacity: 0;
            width: 0;
            height: 0;
            position: absolute;
        }

        .toggle-label {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 24px;
            display: block;
        }

        .toggle-slider {
            position: absolute;
            content: '';
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
            display: block;
        }

        .toggle-input:checked+.toggle-label {
            background-color: rgb(33, 106, 178);
        }

        .toggle-input:checked+.toggle-label .toggle-slider {
            transform: translateX(26px);
        }

        .toggle-input:focus+.toggle-label {
            box-shadow: 0 0 1px rgb(33, 106, 178);
        }

        /* Row highlight styles */
        .row-expired {
            background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 100%);
            border-left: 4px solid #f44336;
        }

        .row-warning {
            background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
            border-left: 4px solid #ff9800;
        }

        .row-caution {
            background: linear-gradient(135deg, #fff8e1 0%, #fff176 100%);
            border-left: 4px solid #ffc107;
        }
    </style>

    <script>
        // Data obat dari server
        const allSediaans = @json($sediaans);
        const riwayatObat = @json($riwayatObat);

        // State management
        let isFilter90DaysActive = false;
        let filteredData = [];

        // Initialize pada load
        window.onload = function() {
            console.log('Total data sediaan:', allSediaans.length);
            renderTable(allSediaans);

            // Hide success alert after 5 seconds
            const successAlert = document.getElementById('successAlert');
            if (successAlert) {
                setTimeout(() => {
                    successAlert.style.transition = 'opacity 0.5s ease';
                    successAlert.style.opacity = '0';
                    setTimeout(() => successAlert.style.display = 'none', 500);
                }, 5000);
            }
        };

        /**
         * Function untuk toggle filter 90 hari
         */
        function toggleFilter90Days(checkbox) {
            const status = document.getElementById('filterStatus');
            const info = document.getElementById('filterInfo');
            const loading = document.getElementById('loadingIndicator');

            isFilter90DaysActive = checkbox.checked;

            console.log('Toggle clicked, active:', isFilter90DaysActive);

            // Show loading
            loading.style.display = 'block';

            setTimeout(() => {
                if (isFilter90DaysActive) {
                    // Aktifkan filter
                    status.textContent = 'AKTIF';
                    status.style.background = 'linear-gradient(135deg, #28a745, #20c997)';
                    info.style.display = 'block';

                    // Filter data
                    filteredData = filterObat90Hari(allSediaans);
                    console.log('Filtered data (90 hari):', filteredData.length);
                    renderTable(filteredData);
                    showSummary(filteredData);

                } else {
                    // Nonaktifkan filter
                    status.textContent = 'NONAKTIF';
                    status.style.background = '#6c757d';
                    info.style.display = 'none';

                    // Tampilkan semua data
                    renderTable(allSediaans);
                    hideSummary();
                }

                // Hide loading
                loading.style.display = 'none';
            }, 500);
        }

        /**
         * Function untuk filter obat yang akan kadaluarsa dalam 90 hari
         */
        function filterObat90Hari(sediaans) {
            const today = new Date();
            const filtered = [];

            sediaans.forEach(sediaan => {
                try {
                    // Parse tanggal kadaluarsa
                    const kadaluarsa = new Date(sediaan.tanggal_kadaluarsa);

                    // Hitung selisih hari
                    const diffTime = kadaluarsa.getTime() - today.getTime();
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                    console.log(
                        `Obat: ${sediaan.obat?.nama_obat}, Kadaluarsa: ${sediaan.tanggal_kadaluarsa}, Selisih hari: ${diffDays}`
                    );

                    // Filter: tampilkan jika <= 90 hari (termasuk yang sudah kadaluarsa)
                    if (diffDays <= 90) {
                        filtered.push({
                            ...sediaan,
                            daysDiff: diffDays
                        });
                    }

                } catch (error) {
                    console.error('Error parsing date:', sediaan.tanggal_kadaluarsa, error);
                }
            });

            // Sort berdasarkan prioritas (yang sudah/akan kadaluarsa dulu)
            filtered.sort((a, b) => a.daysDiff - b.daysDiff);

            return filtered;
        }

        /**
         * Function untuk render tabel
         */
        function renderTable(data) {
            const tbody = document.getElementById('tableBody');

            if (data.length === 0) {
                tbody.innerHTML = `
                <tr>
                    <td colspan="12" style="text-align: center; padding: 2rem; background: #f9f9f9; color: #666;">
                        <div style="font-size: 16px; margin-bottom: 8px;">
                            ${isFilter90DaysActive ? '📅 Tidak ada obat yang akan kadaluarsa dalam 90 hari ke depan' : '📦 Data obat tidak tersedia'}
                        </div>
                        <small style="color: #888;">
                            ${isFilter90DaysActive ? 'Semua obat masih aman untuk digunakan' : 'Silakan tambah data ketersediaan obat'}
                        </small>
                    </td>
                </tr>`;
                return;
            }

            let html = '';
            data.forEach((sediaan, index) => {
                const daysDiff = sediaan.daysDiff !== undefined ? sediaan.daysDiff : calculateDaysDiff(sediaan
                    .tanggal_kadaluarsa);
                const {
                    rowClass,
                    textColor,
                    icon,
                    statusText
                } = getRowStyle(daysDiff);

                // Perhitungan stok akhir yang benar
                // const stokTotal = sediaan.obat?.stok_total || 0;
                // const jumlahKeluar = calculateJumlahKeluar(sediaan);
                // const jumlahKeluar = sediaan.jumlah_keluar_hari_ini || 0;
                // const stokAkhir = Math.max(stokTotal - jumlahKeluar, 0);
                // const isDemoData = jumlahKeluar > 0 && sediaan.pengambilan_details.length === 0;
                const obat = sediaan.obat || {};
                const stokTotal = obat.stok_total || 0;
                const jumlahKeluar = sediaan.jumlah_keluar_hari_ini || 0;
                const stokAkhir = Math.max(stokTotal - jumlahKeluar, 0);

                // Safe check for pengambilan_details
                const pengambilanDetails = sediaan.pengambilan_details || [];
                const isDemoData = jumlahKeluar > 0 && pengambilanDetails.length === 0;

                // Debug logging untuk stok akhir
                console.log(
                    `Obat: ${sediaan.obat?.nama_obat}, Stok Total: ${stokTotal}, Jumlah Keluar: ${jumlahKeluar}, Stok Akhir: ${stokAkhir}`
                );

                html += `
                <tr class="${rowClass}">
                    <td>${index + 1}</td>
                    <td>${icon} ${sediaan.obat?.nama_obat || '-'}</td>
                    <td>${sediaan.obat?.stok_total - sediaan.jumlah}</td> <!-- stok awal -->
                    <td>${formatDate(sediaan.tanggal_masuk)}</td>
                    <td>${sediaan.jumlah}</td> <!-- jumlah masuk -->
                    <td>${sediaan.obat?.satuan?.nama_satuan || '-'}</td>
                    <td>${sediaan.obat?.stok_total}</td> <!-- total -->
                    <td>
                        ${jumlahKeluar > 0 ?
                            `<span style="color:red; font-weight:bold;">
                                            Berkurang (${jumlahKeluar}) hari ini

                                        </span>` :
                            '<span style="color:gray;">-</span>'
                        }
                    </td>
                    <td>${formatDate(sediaan.tanggal_keluar)}</td>
                    <td style="font-weight: bold; color: ${sediaan.obat?.stok_total <= 10 ? '#dc3545' : sediaan.obat?.stok_total <= 50 ? '#ffc107' : '#28a745'};">
                        ${sediaan.obat?.stok_total}
                        ${sediaan.obat?.stok_total <= 10 ? ' <small style="color: #dc3545;">(Stok Rendah)</small>' : ''}
                    </td>
                    <td style="${textColor}">
                        ${formatDate(sediaan.tanggal_kadaluarsa)}
                        <br><small>${statusText}</small>
                    </td>
                    <td>
                        <button class="btn btn-primary no-underline" onclick="showModal(${sediaan.obat_id || sediaan.obat?.id})">
                            <i class="fas fa-history"></i>
                        </button>
                        <a href="/kesediaan-obat/${sediaan.id}" class="btn btn-info no-underline">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="/kesediaan-obat/${sediaan.id}/edit" class="btn btn-warning no-underline">
                            <i class="fas fa-pen"></i>
                        </a>
                        <form action="/kesediaan-obat/${sediaan.id}" method="POST"
                            style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="${getCSRFToken()}">
                            <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>`;
            });

            tbody.innerHTML = html;
        }

        /**
         * Function untuk menghitung jumlah keluar obat
         */
        function calculateJumlahKeluar(sediaan) {
            // Coba beberapa kemungkinan struktur data
            let jumlahKeluar = 0;

            // Opsi 1: dari resep_details
            if (sediaan.obat?.resep_details && Array.isArray(sediaan.obat.resep_details)) {
                jumlahKeluar = sediaan.obat.resep_details.reduce((total, detail) => {
                    return total + (detail.jumlah || 0);
                }, 0);
            }

            // Opsi 2: dari resep_details_sum_jumlah (jika sudah dihitung di server)
            if (sediaan.obat?.resep_details_sum_jumlah !== undefined) {
                jumlahKeluar = sediaan.obat.resep_details_sum_jumlah;
            }

            // Opsi 3: dari properti lain yang mungkin ada
            if (sediaan.jumlah_keluar !== undefined) {
                jumlahKeluar = sediaan.jumlah_keluar;
            }

            // Opsi 4: dari total_keluar
            if (sediaan.total_keluar !== undefined) {
                jumlahKeluar = sediaan.total_keluar;
            }

            return jumlahKeluar || 0;
        }

        /**
         * Function untuk mendapatkan CSRF token
         */
        function getCSRFToken() {
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            return token || '';
        }

        /**
         * Function untuk menghitung selisih hari
         */
        function calculateDaysDiff(dateString) {
            const today = new Date();
            const targetDate = new Date(dateString);
            const diffTime = targetDate.getTime() - today.getTime();
            return Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        }

        /**
         * Function untuk mendapatkan style baris berdasarkan hari
         */
        function getRowStyle(daysDiff) {
            if (daysDiff < 0) {
                return {
                    rowClass: 'row-expired',
                    textColor: 'color: #d32f2f; font-weight: bold;',
                    icon: '🚨',
                    statusText: `(Sudah kadaluarsa ${Math.abs(daysDiff)} hari)`
                };
            } else if (daysDiff <= 30) {
                return {
                    rowClass: 'row-warning',
                    textColor: 'color: #f57c00; font-weight: bold;',
                    icon: '⚠️',
                    statusText: `(${daysDiff} hari lagi)`
                };
            } else if (daysDiff <= 90) {
                return {
                    rowClass: 'row-caution',
                    textColor: 'color: #f9a825;',
                    icon: '🔔',
                    statusText: `(${daysDiff} hari lagi)`
                };
            } else {
                return {
                    rowClass: '',
                    textColor: 'color: #2e7d32;',
                    icon: '✅',
                    statusText: `(${daysDiff} hari lagi)`
                };
            }
        }

        /**
         * Function untuk format tanggal
         */
        function formatDate(dateString) {
            if (!dateString) return '-';
            const date = new Date(dateString);
            return date.toLocaleDateString('id-ID');
        }

        /**
         * Function untuk menampilkan summary
         */
        function showSummary(data) {
            const summaryBox = document.getElementById('summaryBox');
            const summaryContent = document.getElementById('summaryContent');

            let expired = 0,
                warning = 0,
                caution = 0;

            data.forEach(sediaan => {
                const daysDiff = sediaan.daysDiff !== undefined ? sediaan.daysDiff : calculateDaysDiff(sediaan
                    .tanggal_kadaluarsa);
                if (daysDiff < 0) expired++;
                else if (daysDiff <= 30) warning++;
                else if (daysDiff <= 90) caution++;
            });

            summaryContent.innerHTML = `
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px;">
                ${expired > 0 ? `<div style="background: #ffcdd2; padding: 12px; border-radius: 8px; border-left: 4px solid #f44336;">
                                    <div style="font-weight: bold; color: #d32f2f;">🚨 Sudah Kadaluarsa</div>
                                    <div style="font-size: 24px; color: #d32f2f;">${expired} obat</div>
                                </div>` : ''}
                ${warning > 0 ? `<div style="background: #ffe0b2; padding: 12px; border-radius: 8px; border-left: 4px solid #ff9800;">
                                    <div style="font-weight: bold; color: #f57c00;">⚠️ Kritis (≤30 hari)</div>
                                    <div style="font-size: 24px; color: #f57c00;">${warning} obat</div>
                                </div>` : ''}
                ${caution > 0 ? `<div style="background: #fff9c4; padding: 12px; border-radius: 8px; border-left: 4px solid #ffc107;">
                                    <div style="font-weight: bold; color: #f9a825;">🔔 Perhatian (31-90 hari)</div>
                                    <div style="font-size: 24px; color: #f9a825;">${caution} obat</div>
                                </div>` : ''}
                <div style="background: #e3f2fd; padding: 12px; border-radius: 8px; border-left: 4px solid #2196f3;">
                    <div style="font-weight: bold; color: #1976d2;">📋 Total Ditampilkan</div>
                    <div style="font-size: 24px; color: #1976d2;">${data.length} obat</div>
                </div>
            </div>`;

            summaryBox.style.display = 'block';
        }

        /**
         * Function untuk hide summary
         */
        function hideSummary() {
            document.getElementById('summaryBox').style.display = 'none';
        }

        /**
         * Function untuk show modal riwayat
         */
        function showModal(obatId) {
            const data = riwayatObat[obatId] || [];
            const modal = document.getElementById('modalRiwayat');
            const content = document.getElementById('riwayatContent');

            if (data.length === 0) {
                content.innerHTML = '<p style="color:gray;">Tidak ada pengeluaran bulan ini.</p>';
            } else {
                let html =
                    `<table style="width:100%; border-collapse:collapse;">
                    <tr style="background:#f0f0f0;"><th style="padding:8px; border:1px solid #ccc;">Tanggal</th><th style="padding:8px; border:1px solid #ccc;">Jumlah</th></tr>`;
                data.forEach(item => {
                    html += `<tr>
                    <td style="padding:6px 8px; border:1px solid #ccc;">${item.tanggal}</td>
                    <td style="padding:6px 8px; border:1px solid #ccc;">${item.jumlah}</td>
                </tr>`;
                });
                html += `</table>`;
                content.innerHTML = html;
            }

            modal.style.display = 'flex';
        }

        /**
         * Function untuk hitung stok
         */
        function hitungStok(select) {
            const selectedOption = select.selectedOptions[0];
            const total = parseInt(selectedOption.dataset.total || 0);

            document.getElementById("jumlahInput").value = total;
            document.getElementById("stokAwal").value = total;
            document.getElementById("stokAkhir").value = total;
            document.getElementById("totalStok").value = total;
        }

        function hitungStok(select) {
            const selectedOption = select.options[select.selectedIndex];
            const totalStok = parseInt(selectedOption.dataset.total || 0);
            const jumlahInput = document.getElementById('jumlahInput');
            const stokAwal = document.getElementById('stokAwal');
            const stokAkhir = document.getElementById('stokAkhir');
            const totalStokInput = document.getElementById('totalStok');

            jumlahInput.addEventListener('input', () => {
                const jumlah = parseInt(jumlahInput.value || 0);
                stokAwal.value = totalStok;
                stokAkhir.value = totalStok + jumlah;
                totalStokInput.value = totalStok + jumlah;
            });
        }
    </script>
@endsection
