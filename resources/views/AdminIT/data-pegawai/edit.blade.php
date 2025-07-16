@extends('main')

@section('title', 'Edit Pegawai - Klinik')

@section('content')
<section class="blank-content">
    <h3 style="margin-bottom: 1rem; color: rgb(33, 106, 178); text-align:left;">Edit Data Pegawai</h3>

    <form method="POST" action="{{ route('data-pegawai.update', $pegawai->id) }}"
        style="max-width: 1000px; display: flex; gap: 2rem; flex-wrap: wrap;">
        @csrf
        @method('PUT')

        <div style="flex: 1; min-width: 300px;">
            <label style="display:block; text-align:left;"><strong>NIK</strong></label>
            <input type="text" name="nik" value="{{ $pegawai->nik }}" required class="form-input">

            <label style="display:block; text-align:left;"><strong>NIP</strong></label>
            <input type="text" name="nip" value="{{ $pegawai->nip }}" class="form-input">

            <label style="display:block; text-align:left;"><strong>Nama Lengkap</strong></label>
            <input type="text" name="nama_lengkap" value="{{ $pegawai->nama_lengkap }}" required class="form-input">

            <label style="display:block; text-align:left;"><strong>Gelar</strong></label>
            <input type="text" name="gelar" value="{{ $pegawai->gelar }}" class="form-input">

            <label style="display:block; text-align:left;"><strong>Jenis Kelamin</strong></label>
            <select name="jenis_kelamin" required class="form-input">
                <option value="L" {{ $pegawai->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ $pegawai->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>

            <label style="display:block; text-align:left;"><strong>Tanggal Lahir</strong></label>
            <input type="date" name="ttl" value="{{ \Carbon\Carbon::parse($pegawai->ttl)->format('Y-m-d') }}" required
                class="form-input">

            <label style="display:block; text-align:left;"><strong>Alamat</strong></label>
            <textarea name="alamat" rows="2" required class="form-input">{{ $pegawai->alamat }}</textarea>
        </div>

        <div style="flex: 1; min-width: 300px;">
            <label style="display:block; text-align:left;"><strong>No Telepon</strong></label>
            <input type="text" name="no_telp" value="{{ $pegawai->no_telp }}" required class="form-input">

            <label style="display:block; text-align:left;"><strong>STR</strong></label>
            <input type="text" name="str" value="{{ $pegawai->str }}" class="form-input">

            <label style="display:block; text-align:left;"><strong>SIP</strong></label>
            <input type="text" name="sip" value="{{ $pegawai->sip }}" class="form-input">

            <label style="display:block; text-align:left;"><strong>Jabatan</strong></label>
            <select name="jabatan_id" required class="form-input">
                <option value="">-- Pilih Jabatan --</option>
                @foreach ($jabatans as $jabatan)
                <option value="{{ $jabatan->id }}" {{ $pegawai->jabatan_id == $jabatan->id ? 'selected' : '' }}>
                    {{ $jabatan->nama_jabatan }}
                </option>
                @endforeach
            </select>

            <label style="display:block; text-align:left;"><strong>Instansi Induk</strong></label>
            <input type="text" name="instansi_induk" value="{{ $pegawai->instansi_induk }}" class="form-input">

            <label style="display:block; text-align:left;"><strong>Tanggal Berlaku</strong></label>
            <input type="date" name="tanggal_berlaku"
                value="{{ \Carbon\Carbon::parse($pegawai->tanggal_berlaku)->format('Y-m-d') }}" class="form-input">

            <div style="display:flex; justify-content: flex-end; gap: 0.5rem; margin-top: 1rem;">
                <a href="{{ route('data-pegawai.index') }}" class="btn-cancel">Batal</a>
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
