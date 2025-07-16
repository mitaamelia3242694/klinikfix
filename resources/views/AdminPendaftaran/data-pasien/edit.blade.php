@extends('main')

@section('title', 'Edit Data Pasien - Klinik')

@section('content')
<section class="blank-content">
    <h3 style="margin-bottom: 1rem; color: rgb(33, 106, 178); text-align:left;">Edit Data Pasien</h3>

    <form method="POST" action="{{ route('data-pasien.update', $pasien->id) }}"
        style="max-width: 1000px; display: flex; gap: 2rem; flex-wrap: wrap;">
        @csrf
        @method('PUT')

        <div style="flex: 1; min-width: 300px;">
            <label style="display:block; text-align:left;"><strong>NIK</strong></label>
            <input type="text" name="NIK" value="{{ $pasien->NIK }}" required class="form-input">

            <label style="display:block; text-align:left;"><strong>Nama</strong></label>
            <input type="text" name="nama" value="{{ $pasien->nama }}" required class="form-input">

            <label style="display:block; text-align:left;"><strong>Tanggal Lahir</strong></label>
            <input type="date" name="tanggal_lahir" value="{{ $pasien->tanggal_lahir }}" required class="form-input">

            <label style="display:block; text-align:left;"><strong>Jenis Kelamin</strong></label>
            <select name="jenis_kelamin" required class="form-input">
                <option value="">-- Pilih --</option>
                <option value="L" {{ $pasien->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ $pasien->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>

            <label style="display:block; text-align:left;"><strong>No HP</strong></label>
            <input type="text" name="no_hp" value="{{ $pasien->no_hp }}" required class="form-input">
        </div>

        <div style="flex: 1; min-width: 300px;">
            <label style="display:block; text-align:left;"><strong>Alamat</strong></label>
            <textarea name="alamat" rows="4" class="form-input" required>{{ $pasien->alamat }}</textarea>

            <label style="display:block; text-align:left;"><strong>Tanggal Daftar</strong></label>
            <input type="date" name="tanggal_daftar" value="{{ $pasien->tanggal_daftar }}" required class="form-input">

            <label style="display:block; text-align:left;"><strong>Asuransi</strong></label>
            <select name="asuransi_id" class="form-input">
                <option value="">-- Pilih Asuransi --</option>
                @foreach ($asuransis as $asuransi)
                <option value="{{ $asuransi->id }}" {{ $pasien->asuransi_id == $asuransi->id ? 'selected' : '' }}>
                    {{ $asuransi->nama_perusahaan }}
                </option>
                @endforeach
            </select>

            <div style="display:flex; justify-content: flex-end; gap: 0.5rem; margin-top: 1rem;">
                <a href="{{ route('data-pasien.index') }}" class="btn-cancel">Batal</a>
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
