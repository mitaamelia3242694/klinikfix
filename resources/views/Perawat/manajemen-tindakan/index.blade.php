@extends('main')

@section('title', 'Manajemen Tindakan - Klinik')

@section('content')
    <section class="blank-content">
        <div class="table-header">
            <h3>Manajemen Tindakan</h3>
        </div>

        <form method="GET" action="{{ route('manajemen-tindakan.index') }}"
            style="margin-bottom: 1rem; display: flex; gap: 0.5rem; flex-wrap: wrap;">
            <input type="text" name="search" placeholder="Cari Perawat atau Pasien" value="{{ request('search') }}"
                class="input-style" style="max-width: 250px;">
        </form>

        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Pasien</th>
                    <th>Diagnosa Awal</th>
                    <th>Diagnosa Akhir</th>
                    <th>Tindakan</th>
                    <th>Tanggal</th>
                    <th>Dokter</th>
                    <th>Catatan</th>
                    {{-- <th>Aksi</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($pendaftarans as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->pasien->nama ?? '-' }}</td>
                        <td>{{ $item->diagnosaAwal->diagnosa ?? '-' }}</td>
                        <td>{{ $item->diagnosaAkhir->diagnosa ?? '-' }}</td>
                        <td>{{ $item->jenis_kunjungan ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
                        <td>{{ $item->perawat->nama_lengkap ?? '-' }}</td>
                        <td>{{ $item->keluhan ?? '-' }}</td>
                        {{-- <td>
                            <a href="{{ route('manajemen-tindakan.show', $item->id) }}" class="btn btn-info"><i
                                    class="fas fa-eye"></i></a>
                        </td> --}}
                    </tr>
                @endforeach


            </tbody>
        </table>


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
