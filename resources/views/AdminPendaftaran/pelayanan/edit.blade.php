@extends('main')

@section('title', 'Edit Data Pelayanan - Klinik')

@section('content')
<section class="blank-content">
    <h3 style="margin-bottom: 1rem; color: rgb(33, 106, 178); text-align:left;">Edit Data Pelayanan</h3>

    <form method="POST" action="{{ route('data-pelayanan.update', $layanan->id) }}"
        style="max-width: 1000px; display: flex; gap: 2rem; flex-wrap: wrap;">
        @csrf
        @method('PUT')

        <div style="flex: 1; min-width: 300px;">
            <label style="display:block; text-align:left;"><strong>Nama Pelayanan</strong></label>
            <input type="text" name="nama_pelayanan" value="{{ $layanan->nama_pelayanan }}" required class="form-input">

            <label style="display:block; text-align:left;"><strong>Biaya</strong></label>
            <input type="number" name="biaya" step="0.01" value="{{ $layanan->biaya }}" required class="form-input">

            <label style="display:block; text-align:left;"><strong>Status</strong></label>
            <select name="status" required class="form-input">
                <option value="Aktif" {{ $layanan->status === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="Nonaktif" {{ $layanan->status === 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>

        <div style="flex: 1; min-width: 300px;">
            <label style="display:block; text-align:left;"><strong>Deskripsi</strong></label>
            <textarea name="deskripsi" rows="5" class="form-input">{{ $layanan->deskripsi }}</textarea>

            <div style="display:flex; justify-content: flex-end; gap: 0.5rem; margin-top: 1rem;">
                <a href="{{ route('data-pelayanan.index') }}" class="btn-cancel">Batal</a>
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
