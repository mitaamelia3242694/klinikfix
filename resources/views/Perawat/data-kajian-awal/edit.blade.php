@extends('main')

@section('title', 'Edit Data Kajian Awal - Klinik')

@section('content')
    <section class="blank-content">
        <h3 style="margin-bottom: 1rem; color: rgb(33, 106, 178); text-align:left;">Edit Data Kajian Awal</h3>

        <form method="POST" action="{{ route('data-kajian-awal.update', $kajian->id) }}"
            style="max-width: 1000px; display: flex; gap: 2rem; flex-wrap: wrap;">
            @csrf
            @method('PUT')

            <div style="flex: 1; min-width: 300px;">
                <label style="display:block; text-align:left;"><strong>Pasien</strong></label>
                <input type="hidden" name="pasien_id" class="form-input" value="{{$kajian->pendaftaran->pasien->id}}">
                <input type="text" class="form-input" value="{{$kajian->pendaftaran->pasien->nama}}">

                <label style="display:block; text-align:left;"><strong>Perawat</strong></label>
                <input type="hidden" name="user_id" class="form-input" required value="{{ $perawats->id }}"
                        readonly>
                    <input type="text" class="form-input" value="{{ $perawats->nama_lengkap }}" readonly>

                <label style="display:block; text-align:left;"><strong>Tanggal</strong></label>
                <input type="date" name="tanggal" value="{{ $kajian->tanggal }}" required class="form-input">

                <label style="display:block; text-align:left;"><strong>Keluhan Utama</strong></label>
                <textarea name="keluhan_utama" rows="4" required class="form-input">{{ $kajian->keluhan_utama }}</textarea>

                <label style="display:block; text-align:left;"><strong>Sistol</strong></label>
                <input type="text" name="sistol" value="{{ $kajian->sistol }}" required class="form-input">

                <label style="display:block; text-align:left;"><strong>Diastol</strong></label>
                <input type="text" name="diastol" value="{{ $kajian->diastol }}" required class="form-input">

                <label style="display:block; text-align:left;"><strong>Suhu Tubuh</strong></label>
                <input type="text" name="suhu_tubuh" value="{{ $kajian->suhu_tubuh }}" required class="form-input">

            </div>

            <div style="flex: 1; min-width: 300px;">

                <!-- Diagnosa Awal -->
                <label style="display:block; text-align:left;"><strong>Diagnosa Awal</strong></label>
                <textarea name="diagnosa_awal" rows="3"  class="form-input">{{ $kajian->diagnosa_awal }}</textarea>

                <!-- Pelayanan -->
                <label style="display:block; text-align:left;"><strong>Pelayanan</strong></label>
                <select name="pelayanan_id" class="form-input" required>
                    <option value="">-- Pilih Pelayanan --</option>
                    @foreach ($layanans as $layanan)
                        <option value="{{ $layanan->id }}" {{ $kajian->pelayanan_id == $layanan->id ? 'selected' : '' }}>
                            {{ $layanan->nama_pelayanan }}
                        </option>
                    @endforeach
                </select>

                <div style="display:flex; justify-content: flex-end; gap: 0.5rem; margin-top: 1rem;">
                    <a href="{{ route('data-kajian-awal.index') }}" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-submit">Update</button>
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
