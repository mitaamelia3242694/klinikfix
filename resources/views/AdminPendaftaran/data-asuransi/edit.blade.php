@extends('main')

@section('title', 'Edit Data Asuransi - Klinik')

@section('content')
<section class="blank-content">
    <h3 style="margin-bottom: 1rem; color: rgb(33, 106, 178); text-align:left;">Edit Data Asuransi</h3>

    <form method="POST" action="{{ route('data-asuransi.update', $asuransi->id) }}"
        style="max-width: 1000px; display: flex; gap: 2rem; flex-wrap: wrap;">
        @csrf
        @method('PUT')

        <div style="flex: 1; min-width: 300px;">
            <label style="display:block; text-align:left;"><strong>Nama Perusahaan</strong></label>
            <input type="text" name="nama_perusahaan" value="{{ $asuransi->nama_perusahaan }}" required
                class="form-input">

            <label style="display:block; text-align:left;"><strong>Nomor Polis</strong></label>
            <input type="text" name="nomor_polis" value="{{ $asuransi->nomor_polis }}" required class="form-input">

            <label style="display:block; text-align:left;"><strong>Jenis Asuransi</strong></label>
            <input type="text" name="jenis_asuransi" value="{{ $asuransi->jenis_asuransi }}" required
                class="form-input">
        </div>

        <div style="flex: 1; min-width: 300px;">
            <label style="display:block; text-align:left;"><strong>Masa Berlaku Mulai</strong></label>
            <input type="date" name="masa_berlaku_mulai" value="{{ $asuransi->masa_berlaku_mulai }}" required
                class="form-input">

            <label style="display:block; text-align:left;"><strong>Masa Berlaku Akhir</strong></label>
            <input type="date" name="masa_berlaku_akhir" value="{{ $asuransi->masa_berlaku_akhir }}" required
                class="form-input">

            <label style="display:block; text-align:left;"><strong>Status</strong></label>
            <select name="status" required class="form-input">
                <option value="">-- Pilih Status --</option>
                <option value="Aktif" {{ $asuransi->status === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="Tidak Aktif" {{ $asuransi->status === 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif
                </option>
            </select>

            <div style="display:flex; justify-content: flex-end; gap: 0.5rem; margin-top: 1rem;">
                <a href="{{ route('data-asuransi.index') }}" class="btn-cancel">Batal</a>
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