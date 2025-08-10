@extends('main')

@section('title', 'Pencatatan Diagnosa - Klinik')

@section('content')
    <section class="blank-content">
        <div class="table-header">
            <h3>Data Diagnosa Akhir</h3>
        </div>

        <!-- Search dipindahkan ke bawah tombol tambah -->
        <form method="GET" action="{{ route('pencatatan-diagnosa.index') }}"
            style="margin-bottom: 1rem; display: flex; gap: 0.5rem; flex-wrap: wrap;">
            <input type="text" name="keyword" placeholder="Cari Nama Pasien / Dokter" value="{{ request('keyword') }}"
                class="input-style" style="max-width: 250px;">
        </form>


        @if (session('success'))
            <div class="alert-success" id="successAlert">
                {{ session('success') }}
            </div>
        @endif

        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Pasien</th>
                    <th>Dokter</th>
                    <th>Tanggal</th>
                    <th>Keluhan</th>
                    <th>Pengkajian Awal</th>
                    <th>Pelayanan</th>
                    <th>Catatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pendaftarans as $index => $item)
                    <tr>
                        <td>{{ $pendaftarans->firstItem() + $index }}</td>
                        <td>{{ $item->pasien->nama ?? '-' }}</td>
                        <td>{{ $item->dokter->nama_lengkap }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                        <td>{{ $item->keluhan }}</td>
                        <td>{{ $item->pengkajianAwal->keluhan_utama ?? '-' }}</td>
                        <td>{{ $item->pengkajianAwal->pelayanan->nama_pelayanan ?? '-' }}</td>
                        <td>{{ $item->diagnosaAkhir->catatan ?? '-' }}</td>
                        <td>
                            <div style="display: flex; gap: 0.4rem; flex-wrap: wrap;">
                                <a href="{{ route('pencatatan-diagnosa.show', $item->id) }}"
                                    class="btn btn-info no-underline"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('pencatatan-diagnosa.edit', $item->id) }}"
                                    class="btn btn-warning no-underline"><i class="fas fa-pen"></i></a>

                                @if ($item->diagnosaAkhir == null)
                                    <button class="btn-diagnosa" data-pasien-id="{{ $item->pasien->id }}"
                                        data-pasien-nama="{{ $item->pasien->nama }}"
                                        data-created-at="{{ $item->created_at->format('Y-m-d') }}"
                                        data-master-id="{{ $item->diagnosaAwal->master_diagnosa_id ?? '' }}"
                                        data-pelayanan-id="{{ $item->pengkajianAwal->pelayanan_id ?? '' }}"
                                        onclick="openModalDiagnosa(this)"
                                        style="padding: 0.5rem 1rem; background:rgb(33, 106, 178); color:#fff; border:none; border-radius:8px; cursor:pointer;">
                                        <i class="fas fa-stethoscope"></i>
                                    </button>
                                @else
                                    <button class="btn-diagnosa"
                                        style="padding: 0.5rem 1rem; background:#ccc; color:#666; border:none; border-radius:8px; cursor:pointer;"
                                        disabled>
                                        <i class="fas fa-stethoscope"></i>
                                    </button>
                                @endif

                                @if ($item->diagnosaAkhir->tanggal == null)
                                    <button class="btn-tindakan" data-pasien-id="{{ $item->pasien->id }}"
                                        data-pasien-nama="{{ $item->pasien->nama }}"
                                        data-created-at="{{ $item->created_at->format('Y-m-d') }}"
                                        onclick="openModalTindakan(this)"
                                        style="padding: 0.5rem 1rem; background:rgb(33, 106, 178); color:#fff; border:none; border-radius:8px; cursor:pointer;">
                                        <i class="fas fa-hand-holding-heart"></i>
                                    </button>
                                @else
                                    <button class="btn-tindakan"
                                        style="padding: 0.5rem 1rem; background:#ccc; color:#666; border:none; border-radius:8px; cursor:pointer;">
                                        <i class="fas fa-hand-holding-heart"></i>
                                    </button>
                                @endif

                                @if ($item->pengkajianAwal->pelayanan_id == null)
                                    <button class="btn-resep" data-pasien-id="{{ $item->pasien->id }}"
                                        data-pasien-nama="{{ $item->pasien->nama }}"
                                        data-created-at="{{ $item->created_at->format('Y-m-d') }}"
                                        data-pelayanan-id="{{ $item->pengkajianAwal->pelayanan_id ?? '' }}"
                                        onclick="openModalResep(this)"
                                        style="padding: 0.5rem 1rem; background:rgb(33, 106, 178); color:#fff; border:none; border-radius:8px; cursor:pointer;">
                                        <i class="fas fa-prescription-bottle-alt"></i>
                                    </button>
                                @else
                                    <button class="btn-diagnosa"
                                        style="padding: 0.5rem 1rem; background:#ccc; color:#666; border:none; border-radius:8px; cursor:pointer;"
                                        disabled>
                                        <i class="fas fa-prescription-bottle-alt"></i>
                                    </button>
                                @endif

                                <a href="{{ route('rekam-medis.index') }}"
                                    style="padding: 0.5rem 1rem; background:rgb(33, 106, 178); color:#fff; border:none; border-radius:8px; cursor:pointer;">
                                    <i class="fas fa-notes-medical"></i>
                                </a>

                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if ($pendaftarans->hasPages())
            <ul class="pagination">
                @if ($pendaftarans->onFirstPage())
                    <li class="disabled"><span>«</span></li>
                @else
                    <li><a href="{{ $pendaftarans->previousPageUrl() }}" rel="prev">«</a></li>
                @endif

                @foreach ($pendaftarans->links()->elements[0] as $page => $url)
                    @if ($page == $pendaftarans->currentPage())
                        <li class="active"><span>{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach

                @if ($pendaftarans->hasMorePages())
                    <li><a href="{{ $pendaftarans->nextPageUrl() }}" rel="next">»</a></li>
                @else
                    <li class="disabled"><span>»</span></li>
                @endif
            </ul>
        @endif


        <!-- Modal Tambah Diagnosa -->
        <div id="modalTambahDiagnosa" onclick="if(event.target === this) this.style.display='none'"
            style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.6); justify-content:center; align-items:center; z-index:9999;">
            <div
                style="background:#fff; padding:2rem; border-radius:12px; width:90%; max-width:500px; max-height:90vh; overflow:auto; box-shadow:0 5px 20px rgba(0,0,0,0.2); position:relative;">
                <span onclick="document.getElementById('modalTambah').style.display='none'"
                    style="position:absolute; top:1rem; right:1rem; font-size:1.5rem; cursor:pointer; color:rgb(33, 106, 178);">&times;</span>
                <h3 style="margin-bottom:1rem; color:rgb(33, 106, 178); text-align:left;">Tambah Diagnosa</h3>

                <form method="POST" action="{{ route('pencatatan-diagnosa.store') }}">
                    @csrf

                    <input type="hidden" name="pasien_id" id="inputPasienId">

                    <label style="display:block; text-align:left;"><strong>Pasien</strong></label>
                    <input type="text" id="inputPasienNama" class="input-style" disabled>

                    <label style="display:block; text-align:left;"><strong>Tanggal</strong></label>
                    <input type="date" name="tanggal" required class="input-style" id="inputTanggalDiagnosa">

                    <label style="display:block; text-align:left;"><strong>Diagnosa Akhir</strong></label>
                    <textarea name="diagnosa" rows="3" required class="input-style"></textarea>

                    <label style="display:block; text-align:left;"><strong>Master Diagnosa</strong></label>
                    <select name="master_diagnosa_id" required class="input-style" onmousedown="return false;"
                        style="pointer-events: none;">
                        <option value="">-- Pilih Diagnosa --</option>
                        @foreach ($masters as $master)
                            <option value="{{ $master->id }}">{{ $master->nama }}</option>
                        @endforeach
                    </select>

                    <!-- Pelayanan -->
                    <label style="display:block; text-align:left;"><strong>Pelayanan</strong></label>
                    <select name="pelayanan_id" class="input-style" required onmousedown="return false;"
                        style="pointer-events: none;">
                        <option value="">-- Pilih Pelayanan --</option>
                        @foreach ($layanans as $layanan)
                            <option value="{{ $layanan->id }}">{{ $layanan->nama_pelayanan }}</option>
                        @endforeach
                    </select>

                    <label style="display:block; text-align:left;"><strong>Catatan</strong></label>
                    <textarea name="catatan" rows="2" class="input-style"></textarea>

                    <label style="display:block; text-align:left;"><strong>Dokter</strong></label>
                    <input type="hidden" name="user_id" class="input-style" required value="{{ $dokters->id }}"
                        readonly>
                    <input type="text" class="input-style" value="{{ $dokters->nama_lengkap }}" readonly>

                    <div style="display:flex; justify-content: flex-end; gap: 0.5rem; margin-top: 1rem;">
                        <button type="button" onclick="document.getElementById('modalTambah').style.display='none'"
                            class="btn btn-warning">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="modalTambahTindakan" onclick="if(event.target === this) this.style.display='none'"
            style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.6); justify-content:center; align-items:center; z-index:9999;">
            <div
                style="background:#fff; padding:2rem; border-radius:12px; width:90%; max-width:500px; max-height:90vh; overflow:auto; box-shadow:0 5px 20px rgba(0,0,0,0.2); position:relative;">
                <span onclick="document.getElementById('modalTambah').style.display='none'"
                    style="position:absolute; top:1rem; right:1rem; font-size:1.5rem; cursor:pointer; color:rgb(33, 106, 178);">&times;</span>
                <h3 style="margin-bottom:1rem; color:rgb(33, 106, 178); text-align:left;">Tambah Tindakan</h3>

                <form method="POST" action="{{ route('pencatatan-tindakan.store') }}">
                    @csrf

                    <label style="display:block; text-align:left;"><strong>Pasien</strong></label>
                    <input type="hidden" name="pasien_id" id="tindakanPasienId">
                    <input type="text" id="tindakanPasienNama" class="input-style" disabled>

                    <label style="display:block; text-align:left;"><strong>Tanggal</strong></label>
                    <input type="date" name="tanggal" required class="input-style" id="inputTanggalTindakan">

                    <label style="display:block; text-align:left;"><strong>Jenis Tindakan</strong></label>
                    <select name="jenis_tindakan" id="jenis_tindakan" required class="input-style">
                        <option value="">-- Pilih Tindakan --</option>
                        @foreach ($layanans as $item)
                            <option value="{{ $item->nama_pelayanan }}" data-biaya="{{ $item->biaya }}">
                                {{ $item->nama_pelayanan }} - Rp. {{ number_format($item->biaya, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>

                    <label style="display:block; text-align:left;"><strong>Tarif</strong></label>
                    <input type="number" step="0.01" name="tarif" id="tarif" required class="input-style"
                        readonly>

                    <label style="display:block; text-align:left;"><strong>Catatan</strong></label>
                    <textarea name="catatan" rows="2" class="input-style"></textarea>

                    <label style="display:block; text-align:left;"><strong>Dokter</strong></label>
                    <input type="hidden" name="user_id" class="input-style" required value="{{ $dokters->id }}"
                        readonly>
                    <input type="text" class="input-style" value="{{ $dokters->nama_lengkap }}" readonly>

                    <div style="display:flex; justify-content: flex-end; gap: 0.5rem; margin-top: 1rem;">
                        <button type="button" onclick="document.getElementById('modalTambah').style.display='none'"
                            class="btn btn-warning">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="modalTambahResep" onclick="if(event.target === this) this.style.display='none'"
            style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.6); justify-content:center; align-items:center; z-index:9999;">
            <div
                style="background:#fff; padding:2rem; border-radius:12px; width:90%; max-width:500px; max-height:90vh; overflow:auto; box-shadow:0 5px 20px rgba(0,0,0,0.2); position:relative;">
                <span onclick="document.getElementById('modalTambahResep').style.display='none'"
                    style="position:absolute; top:1rem; right:1rem; font-size:1.5rem; cursor:pointer; color:rgb(33, 106, 178);">&times;</span>
                <h3 style="margin-bottom:1rem; color:rgb(33, 106, 178); text-align:left;">Tambah Resep</h3>

                <form method="POST" action="{{ route('penerbitan-resep.store') }}">
                    @csrf

                    <label style="display:block; text-align:left;"><strong>Pasien</strong></label>
                    <input type="hidden" id="resepPasienId" name="pasien_id">
                    <input type="text" id="resepPasienNama" name="pasien_nama" class="input-style">
                    {{-- <input type="hidden" name="pasien_id" id="resepPasienId">
                    <input type="text" id="resepPasienIdNama" class="input-style" disabled> --}}

                    <label style="display:block; text-align:left;"><strong>Tanggal</strong></label>
                    <input type="date" name="tanggal" class="input-style" id="inputTanggalResep" required>

                    <label style="display:block; text-align:left;"><strong>Dokter</strong></label>
                    <input type="hidden" name="user_id" class="input-style" required value="{{ $dokters->id }}"
                        readonly>
                    <input type="text" class="input-style" value="{{ $dokters->nama_lengkap }}" readonly>

                    <label style="display:block; text-align:left;"><strong>Pelayanan</strong></label>
                    <select name="pelayanan_id" required class="input-style" onmousedown="return false;"
                        style="pointer-events: none;">
                        <option value="">-- Pilih Pelayanan --</option>
                        @foreach ($layanans as $pelayanan)
                            <option value="{{ $pelayanan->id }}">{{ $pelayanan->nama_pelayanan }}</option>
                        @endforeach
                    </select>

                    <label style="display:block; text-align:left;"><strong>Catatan</strong></label>
                    <textarea name="catatan" class="input-style" rows="2"></textarea>

                    <hr style="margin:1rem 0;">
                    <h4 style="color:#216ab2; text-align:left; margin-bottom:12px;">Detail Obat</h4>

                    <div id="detailContainer">
                        <div class="detail-row-group" style="margin-bottom: 1rem;">
                            <!-- Pilih Obat -->
                            <select name="obat_id[]" required class="input-style" onchange="updateSatuan(this)">
                                <option value="">-- Pilih Obat --</option>
                                @foreach ($obats as $obat)
                                    <option value="{{ $obat->id }}" data-satuan="{{ $obat->satuan->nama_satuan }}">
                                        {{ $obat->nama_obat }}
                                    </option>
                                @endforeach
                            </select>

                            <!-- Jumlah + Satuan Input (bersebelahan) -->
                            <div style="display: flex; gap: 0.5rem;">
                                <input type="number" name="jumlah[]" required class="input-style" placeholder="Jumlah"
                                    min="1" style="flex: 2;">
                                <input type="text" class="input-style satuan-field" placeholder="Satuan" disabled
                                    style="flex: 1; background-color: #f5f5f5;">
                            </div>

                            <!-- Lainnya -->
                            <input type="text" name="dosis[]" required class="input-style" placeholder="Dosis">
                            <input type="text" name="aturan_pakai[]" required class="input-style"
                                placeholder="Aturan Pakai">
                        </div>

                    </div>

                    <button type="button" onclick="tambahDetail()" class="btn btn-info" style="margin:0.5rem 0;">+
                        Tambah
                        Obat</button>

                    <div style="display:flex; justify-content:flex-end; gap:0.5rem;">
                        <button type="button" class="btn btn-warning"
                            onclick="document.getElementById('modalTambahResep').style.display='none'">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="modalTambahRekam" onclick="if(event.target === this) this.style.display='none'"
            style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.6); justify-content:center; align-items:center; z-index:9999;">
            <div
                style="background:#fff; padding:2rem; border-radius:12px; width:90%; max-width:500px; max-height:90vh; overflow:auto; box-shadow:0 5px 20px rgba(0,0,0,0.2); position:relative;">
                <span onclick="document.getElementById('modalTambah').style.display='none'"
                    style="position:absolute; top:1rem; right:1rem; font-size:1.5rem; cursor:pointer; color:rgb(33, 106, 178);">&times;</span>
                <h3 style="margin-bottom:1rem; color:rgb(33, 106, 178); text-align:left;">Tambah Rekam Medis</h3>

                <form method="POST" action="{{ route('rekam-medis.store') }}">
                    @csrf

                    <label style="display:block; text-align:left;"><strong>Pasien</strong></label>
                    <input type="hidden" name="pasien_id" id="rekamPasienId">
                    <input type="text" id="rekamPasienNama" class="input-style" disabled>

                    <label style="display:block; text-align:left;"><strong>Tanggal Kunjungan</strong></label>
                    <input type="date" name="tanggal_kunjungan" class="input-style" required>

                    <label style="display:block; text-align:left;"><strong>Keluhan</strong></label>
                    <textarea name="keluhan" class="input-style" rows="2" required></textarea>

                    <label style="display:block; text-align:left;"><strong>Diagnosa</strong></label>
                    <textarea name="diagnosa" class="input-style" rows="2"></textarea>

                    <label style="display:block; text-align:left;"><strong>Tindakan</strong></label>
                    <select name="tindakan_id" class="input-style">
                        <option value="">-- Pilih Tindakan --</option>
                        @foreach ($tindakans as $tindakan)
                            <option value="{{ $tindakan->id }}">{{ $tindakan->jenis_tindakan }}</option>
                        @endforeach
                    </select>

                    <label style="display:block; text-align:left;"><strong>Catatan Tambahan</strong></label>
                    <textarea name="catatan_tambahan" class="input-style" rows="2"></textarea>

                    <div style="display:flex; justify-content:flex-end; gap:0.5rem;">
                        <button type="button" class="btn btn-warning"
                            onclick="document.getElementById('modalTambah').style.display='none'">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <style>
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

        .data-table td div {
            flex-wrap: wrap;
            justify-content: flex-start;
        }


        /* Pagination custom minimalis */
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 1rem;
            gap: 0.5rem;
            flex-wrap: wrap;
            list-style: none;
            padding: 0;
        }

        .pagination li {
            margin: 0;
        }

        .pagination li span,
        .pagination li a {
            display: block;
            padding: 8px 12px;
            border-radius: 6px;
            text-decoration: none;
            color: rgb(33, 106, 178);
            background-color: #f2f2f2;
            transition: background-color 0.2s, color 0.2s;
        }

        .pagination li a:hover {
            background-color: rgb(33, 106, 178);
            color: #fff;
        }

        .pagination li.active span {
            background-color: rgb(33, 106, 178);
            color: #fff;
            font-weight: bold;
        }

        .pagination li.disabled span {
            color: #aaa;
            background-color: #eee;
            cursor: default;
        }
    </style>

    <script>
        // Sembunyikan alert setelah 5 detik
        window.onload = function() {
            const successAlert = document.getElementById('successAlert');
            if (successAlert) {
                setTimeout(() => {
                    successAlert.style.transition = 'opacity 0.5s ease';
                    successAlert.style.opacity = '0';
                    setTimeout(() => successAlert.style.display = 'none', 500);
                }, 5000);
            }
        };
    </script>

    <script>
        function openModalDiagnosa(button) {
            const pasienId = button.dataset.pasienId;
            const pasienNama = button.dataset.pasienNama;
            const createdAt = button.dataset.createdAt;
            const masterId = button.dataset.masterId;
            const pelayananId = button.dataset.pelayananId;

            document.getElementById('inputPasienId').value = pasienId;
            document.getElementById('inputPasienNama').value = pasienNama;
            document.getElementById('inputTanggalDiagnosa').value = createdAt;

            // Set Master Diagnosa
            const masterSelect = document.querySelector('select[name="master_diagnosa_id"]');
            if (masterSelect && masterId) {
                masterSelect.value = masterId;
            }

            // Set Pelayanan
            const pelayananSelect = document.querySelector('select[name="pelayanan_id"]');
            if (pelayananSelect && pelayananId) {
                pelayananSelect.value = pelayananId;
            }

            document.getElementById('modalTambahDiagnosa').style.display = 'flex';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        function openModalTindakan(button) {
            const pasienId = button.dataset.pasienId;
            const pasienNama = button.dataset.pasienNama;
            const createdAt = button.dataset.createdAt;

            document.getElementById('tindakanPasienId').value = pasienId;
            document.getElementById('tindakanPasienNama').value = pasienNama;
            document.getElementById('inputTanggalTindakan').value = createdAt;
            document.getElementById('modalTambahTindakan').style.display = 'flex';
        }

        // function openModalResep(button) {
        //     const pasienId = button.dataset.pasienId;
        //     const pasienNama = button.dataset.pasienNama;

        //     document.getElementById('modalTambahResep').style.display = 'flex';
        //     document.getElementById('resepPasienId').value = pasienId;
        //     document.getElementById('resepPasienNama').value = pasienNama;
        // }
        function openModalResep(button) {
            const pasienId = button.dataset.pasienId;
            const pasienNama = button.dataset.pasienNama;
            const createdAt = button.dataset.createdAt;
            const pelayananId = button.dataset.pelayananId;

            const modal = document.getElementById('modalTambahResep');
            const inputPasienId = document.getElementById('resepPasienId');
            const inputPasienNama = document.getElementById('resepPasienNama');
            document.getElementById('inputTanggalResep').value = createdAt;
            const selectPelayanan = modal.querySelector('select[name="pelayanan_id"]');

            // const pelayananSelect = document.querySelector('select[name="pelayanan_id"]');
            // if (pelayananSelect && pelayananId) {
            //     pelayananSelect.value = pelayananId;
            // }

            if (modal && inputPasienId && inputPasienNama && selectPelayanan) {
                modal.style.display = 'flex';
                inputPasienId.value = pasienId;
                inputPasienNama.value = pasienNama;

                // Set dropdown pelayanan otomatis
                if (pelayananId) {
                    selectPelayanan.value = pelayananId;
                } else {
                    selectPelayanan.value = ""; // fallback kalau kosong
                }

            } else {
                console.error('Modal atau input tidak ditemukan!');
                if (!modal) console.error('Modal dengan ID modalTambahResep tidak ditemukan');
                if (!inputPasienId) console.error('Input dengan ID resepPasienId tidak ditemukan');
                if (!inputPasienNama) console.error('Input dengan ID resepPasienNama tidak ditemukan');
                if (!selectPelayanan) console.error('Dropdown pelayanan tidak ditemukan');
            }
        }

        const obatData = @json($obats);

        function tambahDetail() {
            const container = document.getElementById('detailContainer');
            const newGroup = document.createElement('div');
            newGroup.classList.add('detail-row-group');
            newGroup.style.marginBottom = '1rem';

            // Bangun opsi obat
            let options = '<option value="">-- Pilih Obat --</option>';
            obatData.forEach(obat => {
                const satuan = obat.satuan?.nama_satuan || '';
                options += `<option value="${obat.id}" data-satuan="${satuan}">${obat.nama_obat}</option>`;
            });

            newGroup.innerHTML = `
                                <select name="obat_id[]" required class="input-style" onchange="updateSatuan(this)">
                                ${options}
                            </select>

                            <div style="display: flex; gap: 0.5rem;">
                                <input type="number" name="jumlah[]" required class="input-style" placeholder="Jumlah" min="1" style="flex: 2;">
                                <input type="text" class="input-style satuan-field" placeholder="Satuan" disabled style="flex: 1; background-color: #f5f5f5;">
                            </div>

                            <input type="text" name="dosis[]" required class="input-style" placeholder="Dosis">
                            <input type="text" name="aturan_pakai[]" required class="input-style" placeholder="Aturan Pakai">
                        `;

            container.appendChild(newGroup);
        }

        function updateSatuan(selectElement) {
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            const satuan = selectedOption.getAttribute('data-satuan');

            const container = selectElement.closest('.detail-row-group');
            const satuanInput = container.querySelector('.satuan-field');

            if (satuanInput) {
                satuanInput.value = satuan || '';
            }
        }

        function hapusDetail(button) {
            const detailGroup = button.closest('.detail-row-group');
            if (detailGroup) {
                detailGroup.remove();
            }
        }

        function openModalRekam(button) {
            const pasienId = button.dataset.pasienId;
            const pasienNama = button.dataset.pasienNama;

            document.getElementById('modalTambahRekam').style.display = 'flex';
            document.getElementById('rekamPasienId').value = pasienId;
            document.getElementById('rekamPasienNama').value = pasienNama;
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const select = document.getElementById('jenis_tindakan');
            const tarifInput = document.getElementById('tarif');

            select.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const biaya = selectedOption.getAttribute('data-biaya');
                tarifInput.value = biaya ? parseFloat(biaya) : '';
            });
        });
    </script>

@endsection
