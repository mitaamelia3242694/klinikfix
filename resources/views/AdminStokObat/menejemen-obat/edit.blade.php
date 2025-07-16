@extends('main')

@section('title', 'Edit Obat - Klinik')

@section('content')
<section class="blank-content">
    <h3 style="margin-bottom: 1rem; color: rgb(33, 106, 178); text-align:left;">Edit Data Obat</h3>

    <form method="POST" action="{{ route('menejemen-obat.update', $obat->id) }}"
        style="max-width: 1000px; display: flex; gap: 2rem; flex-wrap: wrap;">
        @csrf
        @method('PUT')

        <div style="flex: 1; min-width: 300px;">
            <label style="display:block; text-align:left;"><strong>Nama Obat</strong></label>
            <input type="text" name="nama_obat" value="{{ $obat->nama_obat }}" required class="form-input">

            <label style="display:block; text-align:left;"><strong>Satuan</strong></label>
            <select name="satuan_id" required class="form-input">
                <option value="">-- Pilih Satuan --</option>
                @foreach ($satuans as $satuan)
                <option value="{{ $satuan->id }}" {{ $obat->satuan_id == $satuan->id ? 'selected' : '' }}>
                    {{ $satuan->nama_satuan }}
                </option>
                @endforeach
            </select>

            <label style="display:block; text-align:left;"><strong>Stok Total</strong></label>
            <input type="number" name="stok_total" min="0" value="{{ $obat->stok_total }}" required class="form-input">
        </div>

        <div style="flex: 1; min-width: 300px;">
            <label style="display:block; text-align:left;"><strong>Keterangan</strong></label>
            <textarea name="keterangan" rows="5" class="form-input">{{ $obat->keterangan }}</textarea>

            <div style="display:flex; justify-content: flex-end; gap: 0.5rem; margin-top: 1rem;">
                <a href="{{ route('menejemen-obat.index') }}" class="btn-cancel">Batal</a>
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