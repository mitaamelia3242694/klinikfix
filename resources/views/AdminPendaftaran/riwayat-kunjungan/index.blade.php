@extends('main')

@section('title', 'Data Riwayat Kunjungan - Klinik')

@section('content')
    <section class="blank-content">
        <div class="table-header">
            <h3>Data Riwayat Kunjungan</h3>
            {{-- <button
            style="padding: 0.5rem 1rem; background:rgb(33, 106, 178); color:#fff; border:none; border-radius:8px; cursor:pointer;"
            onclick="document.getElementById('modalTambah').style.display='flex'" class="btn btn-primary">
            Tambah Asal
        </button> --}}
        </div>

        {{-- Success Alert --}}
        @if (session('success'))
            <div class="alert-success" id="successAlert">{{ session('success') }}</div>
        @endif

        {{-- Table --}}
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pasien</th>
                    <th>Tanggal Pendaftaran</th>
                    <th>Keluhan</th>
                    <th>Tindakan</th>
                    <th>Diagnosa Awal</th>
                    <th>Diagnosa Akhir</th>
                    <th>Resep Obat</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($riwayatKunjungan as $i => $riwayat)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $riwayat->pasien->nama }}</td>
                        <td>{{ $riwayat->created_at->format('d F Y') }}</td>
                        <td>{{ $riwayat->riwayat->keluhan ?? ($riwayat->keluhan ?? '-') }}</td>
                        <td>{{ $riwayat->tindakan->jenis_tindakan }}</td>
                        <td>{{ $riwayat->diagnosaAwal->diagnosa ?? '-' }}</td>
                        <td>{{ $riwayat->diagnosaAkhir->diagnosa ?? '-' }}</td>
                        <td>
                            @if ($riwayat->resep->isNotEmpty())
                                @foreach ($riwayat->resep as $resep)
                                    {{-- <strong>{{ \Carbon\Carbon::parse($resep->tanggal)->format('d M Y') }}</strong><br> --}}
                                    <ul style="padding-left: 1rem; margin: 0;">
                                        @foreach ($resep->detail as $detail)
                                            <li>
                                                {{ $detail->obat->nama_obat ?? '-' }} - {{ $detail->dosis }}
                                                ({{ $detail->aturan_pakai }})
                                            </li>
                                        @endforeach
                                    </ul>
                                @endforeach
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center;">Tidak ada riwayat kunjungan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>

    {{-- Style --}}
    <style>
        .input-style {
            width: 100%;
            padding: 0.6rem;
            margin-bottom: 0.6rem;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th,
        .data-table td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        .data-table th {
            background-color: #f0f0f0;
        }

        .btn {
            padding: 6px 10px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-sm {
            padding: 4px 8px;
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


        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-left: 5px solid #28a745;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 1rem;
        }
    </style>

    {{-- Script --}}
    <script>
        window.onload = function() {
            const alert = document.getElementById('successAlert');
            if (alert) {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    setTimeout(() => alert.style.display = 'none', 500);
                }, 4000);
            }
        }
    </script>
@endsection
