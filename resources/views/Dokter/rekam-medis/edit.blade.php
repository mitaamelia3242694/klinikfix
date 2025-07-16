@extends('main')

@section('title', 'Edit Rekam Medis - Klinik')

@section('content')
<section class="blank-content">
    <h3 style="margin-bottom: 1rem; color: rgb(33, 106, 178); text-align:left;">Edit Rekam Medis</h3>

    <form method="POST" action="{{ route('rekam-medis.update', $rekam->id) }}"
        style="max-width: 1000px; display: flex; gap: 2rem; flex-wrap: wrap;">
        @csrf
        @method('PUT')

        {{-- Kolom Kiri --}}
        <div style="flex: 1; min-width: 300px;">
            <label style="display:block; text-align:left;"><strong>Pasien</strong></label>
            <select name="pasien_id" required class="form-input">
                <option value="">-- Pilih Pasien --</option>
                @foreach ($pasiens as $pasien)
                <option value="{{ $pasien->id }}" {{ $rekam->pasien_id == $pasien->id ? 'selected' : '' }}>
                    {{ $pasien->nama }}
                </option>
                @endforeach
            </select>

            <label style="display:block; text-align:left;"><strong>Tanggal Kunjungan</strong></label>
            <input type="date" name="tanggal_kunjungan" value="{{ $rekam->tanggal_kunjungan }}" required
                class="form-input">

            <label style="display:block; text-align:left;"><strong>Diagnosa</strong></label>
            <input type="text" name="diagnosa" value="{{ $rekam->diagnosa }}" class="form-input">

            <label style="display:block; text-align:left;"><strong>Catatan Tambahan</strong></label>
            <textarea name="catatan_tambahan" rows="4" class="form-input">{{ $rekam->catatan_tambahan }}</textarea>
        </div>

        {{-- Kolom Kanan --}}
        <div style="flex: 1; min-width: 300px;">
            <label style="display:block; text-align:left;"><strong>Keluhan</strong></label>
            <textarea name="keluhan" rows="6" class="form-input" required>{{ $rekam->keluhan }}</textarea>

            <label style="display:block; text-align:left;"><strong>Tindakan</strong></label>
            <select name="tindakan_id" class="form-input">
                <option value="">-- Pilih Tindakan --</option>
                @foreach ($tindakans as $tindakan)
                <option value="{{ $tindakan->id }}" {{ $rekam->tindakan_id == $tindakan->id ? 'selected' : '' }}>
                    {{ $tindakan->jenis_tindakan }}
                </option>
                @endforeach
            </select>

            <div style="display:flex; justify-content: flex-end; gap: 0.5rem; margin-top: 2rem;">
                <a href="{{ route('rekam-medis.index') }}" class="btn-cancel">Batal</a>
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
