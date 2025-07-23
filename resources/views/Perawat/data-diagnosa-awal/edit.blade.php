@extends('main')

@section('title', 'Edit Data Diagnosa Awal - Klinik')

@section('content')
    <section class="blank-content">
        <h3 style="margin-bottom: 1rem; color: rgb(33, 106, 178); text-align:left;">Edit Data Diagnosa Awal</h3>

        <form method="POST" action="{{ route('data-diagnosa-awal.update', $diagnosa->id) }}"
            style="max-width: 1000px; display: flex; gap: 2rem; flex-wrap: wrap;">
            @csrf
            @method('PUT')

            <div style="flex: 1; min-width: 300px;">
                <label style="display:block; text-align:left;"><strong>Pasien</strong></label>
                <select name="pasien_id" required class="form-input">
                    <option value="">-- Pilih Pasien --</option>
                    @foreach ($pendaftarans as $pendaftaran)
                        <option value="{{ $pendaftaran->pasien->id }}"
                            {{ $diagnosa->pasien_id == $pendaftaran->pasien->id ? 'selected' : '' }}>
                            {{ $pendaftaran->pasien->nama }}
                        </option>
                    @endforeach
                </select>

                <label style="display:block; text-align:left;"><strong>Perawat</strong></label>
                <input type="hidden" name="user_id" class="form-input" required value="{{ $perawats->id }}" readonly>
                <input type="text" class="form-input" value="{{ $perawats->nama_lengkap }}" readonly>

                <label style="display:block; text-align:left;"><strong>Tanggal</strong></label>
                <input type="date" name="tanggal" value="{{ $diagnosa->tanggal }}" required class="form-input">

                <label style="display:block; text-align:left;"><strong>Diagnosa</strong></label>
                <textarea name="diagnosa" rows="4" required class="form-input">{{ $diagnosa->diagnosa }}</textarea>
            </div>

            <div style="flex: 1; min-width: 300px;">
                <!-- Master Diagnosa -->
                <label style="display:block; text-align:left;"><strong>Master Diagnosa</strong></label>
                <select name="master_diagnosa_id" class="form-input" required>
                    <option value="">-- Pilih Diagnosa --</option>
                    @foreach ($masters as $master)
                        <option value="{{ $master->id }}"
                            {{ $diagnosa->master_diagnosa_id == $master->id ? 'selected' : '' }}>
                            {{ $master->nama }}
                        </option>
                    @endforeach
                </select>

                <!-- Pelayanan -->
                <label style="display:block; text-align:left;"><strong>Pelayanan</strong></label>
                <select name="pelayanan_id" class="form-input" required>
                    <option value="">-- Pilih Pelayanan --</option>
                    @foreach ($layanans as $layanan)
                        <option value="{{ $layanan->id }}"
                            {{ $diagnosa->pelayanan_id == $layanan->id ? 'selected' : '' }}>
                            {{ $layanan->nama_pelayanan }}
                        </option>
                    @endforeach
                </select>


                <label style="display:block; text-align:left;"><strong>Status</strong></label>
                <select name="status" required class="form-input">
                    <option value="">-- Pilih Status --</option>
                    <option value="belum_diperiksa" {{ $diagnosa->status == 'belum_diperiksa' ? 'selected' : '' }}>Belum
                        Diperiksa</option>
                    <option value="sudah_diperiksa" {{ $diagnosa->status == 'sudah_diperiksa' ? 'selected' : '' }}>Sudah
                        Diperiksa</option>
                </select>

                <div style="display:flex; justify-content: flex-end; gap: 0.5rem; margin-top: 1rem;">
                    <a href="{{ route('data-diagnosa-awal.index') }}" class="btn-cancel">Batal</a>
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
