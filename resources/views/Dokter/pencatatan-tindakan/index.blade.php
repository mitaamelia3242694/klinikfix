@extends('main')

@section('title', 'Pencatatan Tindakan - Klinik')

@section('content')
    <section class="blank-content">
        <div class="table-header">
            <h3>Data Tindakan Medis</h3>
            <button onclick="document.getElementById('modalTambah').style.display='flex'"
                style="padding: 0.5rem 1rem; background:rgb(33, 106, 178); color:#fff; border:none; border-radius:8px; cursor:pointer;">
                Tambah Tindakan
            </button>
        </div>

        <!-- Search dipindahkan ke bawah tombol tambah -->
        <form method="GET" action="" style="margin-bottom: 1rem; display: flex; gap: 0.5rem; flex-wrap: wrap;">
            <input type="text" name="keyword" placeholder="Cari Nama Pasien / Dokter" value="" class="input-style"
                style="max-width: 250px;">
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
                    <th>Jenis Tindakan</th>
                    <th>Tarif</th>
                    <th>Asuransi</th>
                    <th>Status Pembayaran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tindakans as $index => $item)
                    <tr>
                        <td>{{ $tindakans->firstItem() + $index }}</td>
                        <td>{{ $item->pasien->nama ?? '-' }}</td>
                        <td>{{ $item->user->nama_lengkap ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                        <td>{{ $item->jenis_tindakan }}</td>
                        <td>Rp {{ number_format($item->tarif, 0, ',', '.') }}</td>
                        <td>{{ $item->pasien->asuransi->nama_perusahaan ?? '-' }}</td>
                        <td>
                            @if ($item->pasien->asuransi)
                                <span style="color: green; font-weight: bold;">Asuransi</span>
                            @else
                                <span style="color: gray; font-weight: bold;">Non Asuransi</span>
                            @endif
                        </td>
                        <td>
                            <div style="display: flex; gap: 0.4rem; flex-wrap: wrap;">
                                <a href="{{ route('pencatatan-tindakan.show', $item->id) }}"
                                    class="btn btn-info no-underline"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('pencatatan-tindakan.edit', $item->id) }}"
                                    class="btn btn-warning no-underline"><i class="fas fa-pen"></i></a>
                                <form action="{{ route('pencatatan-tindakan.destroy', $item->id) }}" method="POST"
                                    style="display:inline-block;"
                                    onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if ($tindakans->hasPages())
            <ul class="pagination">
                @if ($tindakans->onFirstPage())
                    <li class="disabled"><span>«</span></li>
                @else
                    <li><a href="{{ $tindakans->previousPageUrl() }}" rel="prev">«</a></li>
                @endif

                @foreach ($tindakans->links()->elements[0] as $page => $url)
                    @if ($page == $tindakans->currentPage())
                        <li class="active"><span>{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach

                @if ($tindakans->hasMorePages())
                    <li><a href="{{ $tindakans->nextPageUrl() }}" rel="next">»</a></li>
                @else
                    <li class="disabled"><span>»</span></li>
                @endif
            </ul>
        @endif


        <!-- Modal Tambah Tindakan -->
        <div id="modalTambah" onclick="if(event.target === this) this.style.display='none'"
            style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.6); justify-content:center; align-items:center; z-index:9999;">
            <div
                style="background:#fff; padding:2rem; border-radius:12px; width:90%; max-width:500px; max-height:90vh; overflow:auto; box-shadow:0 5px 20px rgba(0,0,0,0.2); position:relative;">
                <span onclick="document.getElementById('modalTambah').style.display='none'"
                    style="position:absolute; top:1rem; right:1rem; font-size:1.5rem; cursor:pointer; color:rgb(33, 106, 178);">&times;</span>
                <h3 style="margin-bottom:1rem; color:rgb(33, 106, 178); text-align:left;">Tambah Tindakan</h3>

                <form method="POST" action="{{ route('pencatatan-tindakan.store') }}">
                    @csrf

                    <label style="display:block; text-align:left;"><strong>Pasien</strong></label>
                    <select name="pasien_id" required class="input-style">
                        <option value="">-- Pilih Pasien --</option>
                        @foreach ($pasiens as $pasien)
                            <option value="{{ $pasien->id }}">{{ $pasien->nama }}</option>
                        @endforeach
                    </select>

                    <label style="display:block; text-align:left;"><strong>Tanggal</strong></label>
                    <input type="date" name="tanggal" required class="input-style">

                    <label style="display:block; text-align:left;"><strong>Jenis Tindakan</strong></label>
                    <select name="jenis_tindakan" id="jenis_tindakan" required class="input-style">
                        <option value="">-- Pilih Tindakan --</option>
                        @foreach ($layanan as $item)
                            <option value="{{ $item->nama_pelayanan }}" data-biaya="{{ $item->biaya }}">
                                {{ $item->nama_pelayanan }} - Rp. {{ number_format($item->biaya, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>

                    <label style="display:block; text-align:left;"><strong>Tarif</strong></label>
                    <input type="number" step="0.01" name="tarif" id="tarif" required class="input-style" readonly>

                    <label style="display:block; text-align:left;"><strong>Catatan</strong></label>
                    <textarea name="catatan" rows="2" class="input-style"></textarea>

                    <label style="display:block; text-align:left;"><strong>Dokter</strong></label>
                    <input type="hidden" name="user_id" class="input-style" required value="{{ $dokters->id }}" readonly>
                    <input type="text" class="input-style" value="{{ $dokters->nama_lengkap }}" readonly>

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
