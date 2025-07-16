@extends('main')

@section('title', 'Edit Satuan Obat - Klinik')

@section('content')
<section class="blank-content">
    <h3 style="margin-bottom: 1rem; color: rgb(33, 106, 178); text-align:left;">Edit Satuan Obat</h3>

    <form method="POST" action="{{ route('satuan-obat.update', $satuan->id) }}"
        style="max-width: 900px; background:#fff; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);">
        @csrf
        @method('PUT')

        <label style="display:block; text-align:left; margin-bottom: 0.5rem;"><strong>Nama Satuan</strong></label>
        <input type="text" name="nama_satuan" value="{{ old('nama_satuan', $satuan->nama_satuan) }}" required
            class="input-style">

        <div style="display:flex; justify-content: flex-end; gap: 0.5rem; margin-top: 1rem;">
            <a href="{{ route('satuan-obat.index') }}" class="btn btn-warning">Batal</a>
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
</section>

<style>
.input-style {
    width: 100%;
    padding: 0.6rem;
    border: 1px solid #ccc;
    border-radius: 6px;
    box-sizing: border-box;
}

.btn {
    padding: 0.5rem 1.2rem;
    border: none;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    cursor: pointer;
}

.btn-primary {
    background-color: #007bff;
    color: white;
}

.btn-warning {
    background-color: #ffc107;
    color: black;
}
</style>
@endsection
