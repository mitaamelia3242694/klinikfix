@extends('main')

@section('title', 'Edit Diagnosa - Klinik')

@section('content')
<section class="blank-content">
    <h3 style="margin-bottom: 1rem; color: rgb(33, 106, 178); text-align:left;">Edit Pencatatan Diagnosa</h3>

    <form method="POST" action="{{ route('pencatatan-diagnosa.update', $diagnosa->id) }}"
        style="max-width: 1000px; display: flex; gap: 2rem; flex-wrap: wrap;">
        @csrf
        @method('PUT')

        <div style="flex: 1; min-width: 300px;">
            <label style="display:block; text-align:left;"><strong>Pasien</strong></label>
            <select name="pasien_id" required class="form-input">
                <option value="">-- Pilih Pasien --</option>
                @foreach ($pasiens as $pasien)
                <option value="{{ $pasien->id }}" {{ $diagnosa->pasien_id == $pasien->id ? 'selected' : '' }}>
                    {{ $pasien->nama }}
                </option>
                @endforeach
            </select>

            <label style="display:block; text-align:left;"><strong>Dokter</strong></label>
            <select name="user_id" required class="form-input">
                <option value="">-- Pilih Dokter --</option>
                @foreach ($dokters as $dokter)
                <option value="{{ $dokter->id }}" {{ $diagnosa->user_id == $dokter->id ? 'selected' : '' }}>
                    {{ $dokter->nama_lengkap }}
                </option>
                @endforeach
            </select>

            <label style="display:block; text-align:left;"><strong>Tanggal</strong></label>
            <input type="date" name="tanggal" value="{{ $diagnosa->tanggal }}" required class="form-input">

            <label style="display:block; text-align:left;"><strong>Diagnosa Akhir</strong></label>
            <textarea name="diagnosa" rows="4" required class="form-input">{{ $diagnosa->diagnosa }}</textarea>

        </div>

        <div style="flex: 1; min-width: 300px;">

            <!-- Master Diagnosa -->
            <label style="display:block; text-align:left;"><strong>Master Diagnosa</strong></label>
            <select name="master_diagnosa_id" class="form-input" required>
                <option value="">-- Pilih Diagnosa --</option>
                @foreach ($masters as $master)
                <option value="{{ $master->id }}" {{ $diagnosa->master_diagnosa_id == $master->id ? 'selected' : '' }}>
                    {{ $master->nama }}
                </option>
                @endforeach
            </select>

            <!-- Pelayanan -->
            <label style="display:block; text-align:left;"><strong>Pelayanan</strong></label>
            <select name="pelayanan_id" class="form-input" required>
                <option value="">-- Pilih Pelayanan --</option>
                @foreach ($layanans as $layanan)
                <option value="{{ $layanan->id }}" {{ $diagnosa->pelayanan_id == $layanan->id ? 'selected' : '' }}>
                    {{ $layanan->nama_pelayanan }}
                </option>
                @endforeach
            </select>


            <label style="display:block; text-align:left;"><strong>Catatan</strong></label>
            <textarea name="catatan" rows="4" class="form-input">{{ $diagnosa->catatan }}</textarea>

            <div style="display:flex; justify-content: flex-end; gap: 0.5rem; margin-top: 1rem;">
                <a href="{{ route('pencatatan-diagnosa.index') }}" class="btn-cancel">Batal</a>
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