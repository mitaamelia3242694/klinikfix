@extends('main')

@section('title', 'Edit Pengambilan Obat - Klinik')

@section('content')
    <section class="blank-content">
        <h3 style="margin-bottom: 1rem; color: rgb(33, 106, 178); text-align:left;">Edit Pengambilan Obat Pasien</h3>

        <form method="POST" action="{{ route('pengambilan-obat-pasien.update', $pengambilan->id) }}"
            style="max-width: 1000px; display: flex; gap: 2rem; flex-wrap: wrap;" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div style="flex: 1; min-width: 300px;">
                <label style="display:block; text-align:left;"><strong>Resep</strong></label>
                <select name="resep_id" required class="form-input">
                    <option value="{{ $pengambilan->resep_id }}">
                        {{ $pengambilan->resep->pasien->nama ?? 'Tidak Ada Pasien' }} -
                        {{ \Carbon\Carbon::parse($pengambilan->resep->tanggal)->format('d-m-Y') }}</option>
                    {{-- @foreach ($reseps as $resep)
                        <option value="{{ $resep->id }}" {{ $pengambilan->resep_id == $resep->id ? 'selected' : '' }}>
                            {{ $resep->resep->pasien->nama ?? 'Tidak Ada Pasien' }} -
                            {{ \Carbon\Carbon::parse($resep->tanggal)->format('d-m-Y') }}
                        </option>
                    @endforeach --}}
                </select>

                <label style="display:block; text-align:left;"><strong>Petugas Apotek</strong></label>
                <select name="user_id" required class="form-input">
                    <option value="">-- Pilih Petugas --</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $pengambilan->user_id == $user->id ? 'selected' : '' }}>
                            {{ $user->nama_lengkap }}
                        </option>
                    @endforeach
                </select><label style="display:block; text-align:left;"><strong>Nama Pengambil Obat</strong></label>
                <input type="text" name="nama_pengambil" value="{{ $pengambilan->nama_pengambil ?? '' }}"
                    class="form-input" required><br><br>

                <label style="display:block; text-align:left;"><strong>Bukti Foto</strong></label>
                <input type="file" name="bukti_foto" id="bukti_foto" class="form-input"><br><br>
            </div>

            <div style="flex: 1; min-width: 300px;">

                <label style="display:block; text-align:left;"><strong>Tanggal Pengambilan</strong></label>
                <input type="date" name="tanggal_pengambilan" value="{{ $pengambilan->tanggal_pengambilan }}" required
                    class="form-input">
                <label style="display:block; text-align:left;"><strong>Status Pengambilan</strong></label>
                <select name="status_checklist" id="status_checklist" required class="form-input">
                    <option value="">-- Pilih Status --</option>
                    <option value="sudah diambil" {{ $pengambilan->status_checklist == 'sudah diambil' ? 'selected' : '' }}>
                        Sudah Diambil
                    </option>
                    <option value="diambil setengah"
                        {{ $pengambilan->status_checklist == 'diambil setengah' ? 'selected' : '' }}>
                        Diambil Setengah</option>
                    <option value="belum" {{ $pengambilan->status_checklist == 'belum' ? 'selected' : '' }}>
                        Belum</option>
                </select>
            </div>

            <div class="obat-checklist-container">
                <table class="table-obat">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Obat</th>
                            <th style="width: 50px;">Dosis</th>
                            <th>Sediaan</th>
                            <th>Checklist</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reseps as $key => $resep)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $resep->obat->nama_obat ?? 'Tidak Ada Obat' }}</td>
                                <td style="text-align: center;">{{ $resep->jumlah ?? 'Tidak Ada Obat' }}</td>
                               <td>
                                    @if ($resep->obat->sediaan && $resep->obat->sediaan->count() > 0)
                                        <table class="table-sediaan">
                                            @foreach ($resep->obat->sediaan as $sediaan)
                                                @php
                                                    // Cari detail pengambilan yang sudah ada
                                                    $existingDetail = $resep->pengambilanObatDetail?->firstWhere(
                                                        'sediaan_obat_id',
                                                        $sediaan->id,
                                                    );
                                                    $jumlahDiambil = $existingDetail
                                                        ? $existingDetail->jumlah_diambil
                                                        : 0;
                                                @endphp
                                                <tr>
                                                    <td>
                                                        <div class="sediaan-item">
                                                            <span>Kadaluarsa:
                                                                {{ Carbon\Carbon::parse($sediaan->tanggal_kadaluarsa)->translatedFormat('d F Y') }}</span>
                                                            <span>Stok: {{ $sediaan->jumlah }}</span>
                                                            <select
                                                                name="sediaan[{{ $resep->id }}][{{ $sediaan->id }}]"
                                                                class="select-jumlah" disabled>
                                                                @php
                                                                    $maxAvailable = min(
                                                                        $sediaan->jumlah,
                                                                        $resep->jumlah,
                                                                    );
                                                                @endphp
                                                                @for ($i = 0; $i <= $maxAvailable; $i++)
                                                                    <option value="{{ $i }}"
                                                                        {{ $i == $jumlahDiambil ? 'selected' : '' }}>
                                                                        {{ $i }}
                                                                    </option>
                                                                @endfor
                                                            </select>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    @else
                                        <span style="color: red;">Tidak ada stok tersedia</span>
                                    @endif
                                </td>
                                <td>
                                    <input type="checkbox" class="obat-checkbox" name="checklist_ids[]"
                                        value="{{ $resep->id }}"
                                        {{ $resep->tanggal_pengambilan ? 'checked disabled' : '' }} checked>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="margin-top: 1rem; display: flex; flex-direction: column; align-items: flex-end; gap: 0.5rem;">
                <a href="{{ route('pengambilan-obat-pasien.index') }}" class="btn-cancel">Batal</a>
                <button type="submit" class="btn-submit">Update</button>
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
        .obat-checklist-container {
            max-height: 300px;
            overflow-y: auto;
            border: 1px solid #ddd;
            border-radius: 6px;
            margin-top: 1rem;
        }

        .table-obat {
            width: 100%;
            border-collapse: collapse;
        }

        .table-obat th,
        .table-obat td {
            padding: 0.6rem;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .table-obat th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .table-obat tr:hover {
            background-color: #f9f9f9;
        }

        .form-input {
            width: 100%;
            margin-bottom: 0.6rem;
            padding: 0.6rem;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }

        .btn-submit {
            padding: 0.5rem 1.2rem;
            background: rgb(33, 106, 178);
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .btn-cancel {
            padding: 0.5rem 1.2rem;
            background: #ccc;
            color: #333;
            border: none;
            border-radius: 8px;
            text-decoration: none;
        }
    </style>
    <script>
        // Fungsi untuk update status berdasarkan checklist
        function updateStatusChecklist() {
            const checkboxes = document.querySelectorAll('.obat-checkbox');
            const total = checkboxes.length;
            let checked = 0;

            checkboxes.forEach(cb => {
                if (cb.checked) checked++;
            });

            const statusSelect = document.getElementById('status_checklist');

            if (checked === total) {
                statusSelect.value = 'sudah diambil';
            } else if (checked > 0 && checked < total) {
                statusSelect.value = 'diambil setengah';
            } else {
                statusSelect.value = 'belum';
            }
        }

        // Pasang event listener
        document.querySelectorAll('.obat-checkbox').forEach(cb => {
            cb.addEventListener('change', updateStatusChecklist);
        });

        // Jalankan saat pertama kali load (optional)
        document.addEventListener('DOMContentLoaded', updateStatusChecklist);
    </script>
@endsection
