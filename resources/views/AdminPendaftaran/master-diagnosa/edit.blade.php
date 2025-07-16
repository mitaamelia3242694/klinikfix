@extends('main')

@section('title', 'Edit Master Diagnosa - Klinik')

@section('content')
<section class="blank-content">
    <h3 style="margin-bottom: 1rem; color: rgb(33, 106, 178); text-align:left;">Edit Data Diagnosa</h3>

    <form method="POST" action="{{ route('master-diagnosa.update', $diagnosa->id) }}" style="max-width: 600px;">
        @csrf
        @method('PUT')

        <label style="display:block; text-align:left;"><strong>Nama Diagnosa</strong></label>
        <input type="text" name="nama" value="{{ $diagnosa->nama }}" required class="form-input">

        <div style="display:flex; justify-content: flex-end; gap: 0.5rem; margin-top: 1rem;">
            <a href="{{ route('master-diagnosa.index') }}" class="btn-cancel">Batal</a>
            <button type="submit" class="btn-submit">Update</button>
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
