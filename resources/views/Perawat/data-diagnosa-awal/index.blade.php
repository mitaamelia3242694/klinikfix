@extends('main')

@section('title', 'Data Diagnosa Awal - Klinik')

@section('content')
    <section class="blank-content">
        <div class="table-header">
            <h3>Data Diagnosa Awal</h3>
            <button onclick="document.getElementById('modalTambah').style.display='flex'"
                style="padding: 0.5rem 1rem; background:rgb(33, 106, 178); color:#fff; border:none; border-radius:8px; cursor:pointer;">
                Tambah Diagnosa
            </button>
        </div>

        <form method="GET" action="{{ route('data-diagnosa-awal.index') }}"
            style="margin-bottom: 1rem; display: flex; gap: 0.5rem; flex-wrap: wrap;">
            <input type="text" name="search" placeholder="Cari Perawat atau Pasien" value="{{ request('search') }}"
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
                    <th>Perawat</th>
                    <th>Tanggal</th>
                    <th>Diagnosa</th>
                    <th>Status</th>
                    <th>Master Diagnosa</th>
                    <th>Pelayanan</th>

                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($diagnosas as $index => $item)
                    <tr>
                        <td>{{ $diagnosas->firstItem() + $index }}</td>
                        <td>{{ $item->pasien->nama ?? '-' }}</td>
                        <td>{{ $item->user->nama_lengkap ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                        <td>{{ $item->diagnosa }}</td>
                        <td>
                            @if ($item->status === 'sudah_diperiksa')
                                <span class="badge badge-sudah">Sudah Diperiksa</span>
                            @else
                                <span class="badge badge-belum">Belum Diperiksa</span>
                            @endif
                        </td>
                        <td>{{ $item->masterDiagnosa->nama ?? '-' }}</td>
                        <td>{{ $item->pelayanan->nama_pelayanan ?? '-' }}</td>

                        <td>
                            <div style="display: flex; gap: 0.4rem; flex-wrap: wrap;">
                                <a href="{{ route('data-diagnosa-awal.show', $item->id) }}"
                                    class="btn btn-info no-underline"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('data-diagnosa-awal.edit', $item->id) }}"
                                    class="btn btn-warning no-underline"><i class="fas fa-pen"></i></a>
                                <form action="{{ route('data-diagnosa-awal.destroy', $item->id) }}" method="POST"
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
        @if ($diagnosas->hasPages())
            <ul class="pagination">
                {{-- Previous Page Link --}}
                @if ($diagnosas->onFirstPage())
                    <li class="disabled"><span>«</span></li>
                @else
                    <li><a href="{{ $diagnosas->previousPageUrl() }}" rel="prev">«</a></li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($diagnosas->links()->elements[0] as $page => $url)
                    @if ($page == $diagnosas->currentPage())
                        <li class="active"><span>{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($diagnosas->hasMorePages())
                    <li><a href="{{ $diagnosas->nextPageUrl() }}" rel="next">»</a></li>
                @else
                    <li class="disabled"><span>»</span></li>
                @endif
            </ul>
        @endif

        <!-- Modal Tambah Diagnosa -->
        <div id="modalTambah" onclick="if(event.target === this) this.style.display='none'"
            style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.6); justify-content:center; align-items:center; z-index:9999;">
            <div
                style="background:#fff; padding:2rem; border-radius:12px; width:90%; max-width:500px; max-height:90vh; overflow:auto; box-shadow:0 5px 20px rgba(0,0,0,0.2); position:relative;">
                <span onclick="document.getElementById('modalTambah').style.display='none'"
                    style="position:absolute; top:1rem; right:1rem; font-size:1.5rem; cursor:pointer; color:rgb(33, 106, 178);">&times;</span>
                <h3 style="margin-bottom:1rem; color:rgb(33, 106, 178); text-align:left;">Tambah Diagnosa Awal</h3>

                <form method="POST" action="{{ route('data-diagnosa-awal.store') }}">
                    @csrf

                    <label style="display:block; text-align:left;"><strong>Pasien</strong></label>
                    <select name="pasien_id" required class="input-style">
                        <option value="">-- Pilih Pasien --</option>
                        @foreach ($pendaftarans as $pendaftaran)
                            <option value="{{ $pendaftaran->pasien->id }}">{{ $pendaftaran->pasien->nama }}</option>
                        @endforeach
                    </select>

                    <label style="display:block; text-align:left;"><strong>Tanggal</strong></label>
                    <input type="date" name="tanggal" required class="input-style">

                    <label style="display:block; text-align:left;"><strong>Diagnosa</strong></label>
                    <textarea name="diagnosa" rows="2" required class="input-style"></textarea>

                    <label style="display:block; text-align:left;"><strong>Master Diagnosa</strong></label>
                    <select name="master_diagnosa_id" required class="input-style">
                        <option value="">-- Pilih Diagnosa --</option>
                        @foreach ($masters as $master)
                            <option value="{{ $master->id }}">{{ $master->nama }}</option>
                        @endforeach
                    </select>

                    <!-- Pelayanan -->
                    <label style="display:block; text-align:left;"><strong>Pelayanan</strong></label>
                    <select name="pelayanan_id" class="input-style" required>
                        <option value="">-- Pilih Pelayanan --</option>
                        @foreach ($layanans as $layanan)
                            <option value="{{ $layanan->id }}">{{ $layanan->nama_pelayanan }}</option>
                        @endforeach
                    </select>



                    <label style="display:block; text-align:left;"><strong>Status</strong></label>
                    <select name="status" required class="input-style">
                        <option value="">-- Pilih Status --</option>
                        <option value="belum_diperiksa">Belum Diperiksa</option>
                        <option value="sudah_diperiksa">Sudah Diperiksa</option>
                    </select>

                    <label style="display:block; text-align:left;"><strong>Perawat</strong></label>
                    <input type="hidden" name="user_id" class="input-style" required value="{{ $perawats->id }}" readonly>
                    <input type="text" class="input-style" value="{{ $perawats->nama_lengkap }}" readonly>

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
        .badge {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: bold;
            display: inline-block;
        }

        .badge-sudah {
            background-color: #d4edda;
            color: #155724;
        }

        .badge-belum {
            background-color: #e2e3e5;
            color: #6c757d;
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
@endsection
