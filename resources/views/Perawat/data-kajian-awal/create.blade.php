@extends('main')

@section('title', 'Tambah Data Kajian Awal - Klinik')

@section('content')
    <section class="blank-content">
        <h3 style="margin-bottom: 1rem; color: rgb(33, 106, 178); text-align:left;">Tambah Data Kajian Awal</h3>

        <form method="POST" action="{{ route('data-kajian-awal.store') }}"
            style="max-width: 1000px; display: flex; gap: 2rem; flex-wrap: wrap;">
            @csrf

            <div style="flex: 1; min-width: 300px;">
                <!-- Pilih Pasien -->
                <label style="display:block; text-align:left;"><strong>Pasien</strong></label>
                <select name="pendaftaran_id" class="form-input" required>
                    <option value="">-- Pilih Pasien --</option>
                    @foreach ($pendaftarans as $item)
                        <option value="{{ $item->id }}" {{ isset($selectedPasien) && $selectedPasien == $item->id ? 'selected' : '' }}>{{ $item->pasien->nama }}</option>
                    @endforeach
                </select>

                <!-- Perawat -->
                <label style="display:block; text-align:left;"><strong>Perawat</strong></label>
                <input type="hidden" name="user_id" class="form-input" required value="{{ $perawats->id }}" readonly>
                <input type="text" class="form-input" value="{{ $perawats->nama_lengkap }}" readonly>

                <!-- Tanggal -->
                <label style="display:block; text-align:left;"><strong>Tanggal</strong></label>
                <input type="date" name="tanggal" class="form-input" required value="{{ date('Y-m-d') }}">

                <!-- Keluhan Utama -->
                <label style="display:block; text-align:left;"><strong>Keluhan Utama</strong></label>
                <textarea name="keluhan_utama" rows="4" required class="form-input"></textarea>

                <!-- Sistol -->
                <label style="display:block; text-align:left;"><strong>Sistol</strong></label>
                <input type="text" name="sistol" required class="form-input">

                <!-- Diastol -->
                <label style="display:block; text-align:left;"><strong>Diastol</strong></label>
                <input type="text" name="diastol" required class="form-input">

                <!-- Suhu Tubuh -->
                <label style="display:block; text-align:left;"><strong>Suhu Tubuh</strong></label>
                <input type="text" name="suhu_tubuh" required class="form-input">
            </div>

            <div style="flex: 1; min-width: 300px;">
                <!-- Diagnosa Awal -->
                <label style="display:block; text-align:left;"><strong>Kajian Awal</strong></label>
                <textarea name="diagnosa_awal" rows="3" class="form-input"></textarea>

                <!-- Pelayanan -->
                <label style="display:block; text-align:left;"><strong>Pelayanan</strong></label>
                <select name="pelayanan_id" class="form-input" required>
                    <option value="">-- Pilih Pelayanan --</option>
                    @foreach ($layanans as $layanan)
                        <option value="{{ $layanan->id }}" {{ isset($selectedPelayanan) && $selectedPelayanan == $layanan->id ? 'selected' : '' }}>{{ $layanan->nama_pelayanan }}</option>
                    @endforeach
                </select>

                <!-- Catatan (opsional) -->
                <!-- <label style="display:block; text-align:left;"><strong>Catatan</strong></label>
                <textarea name="catatan" rows="3" class="form-input"></textarea> -->

                <div style="display:flex; justify-content: flex-end; gap: 0.5rem; margin-top: 1rem;">
                    <a href="{{ route('data-kajian-awal.index') }}" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-submit">Simpan</button>
                </div>
            </div>
        </form>
    </section>
    <style>
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
@endsection
