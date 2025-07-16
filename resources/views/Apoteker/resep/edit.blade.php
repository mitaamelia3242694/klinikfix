@extends('main')

@section('title', 'Edit Data Resep - Klinik')

@section('content')
<section class="blank-content">
    <h3 style="margin-bottom: 1rem; color: rgb(33, 106, 178); text-align:left;">Edit Data Resep</h3>

    <form method="POST" action="{{ route('data-resep.update', $resep->id) }}"
        style="max-width: 1000px; display: flex; gap: 2rem; flex-wrap: wrap;">
        @csrf
        @method('PUT')

        <div style="flex: 1; min-width: 300px;">
            <label style="display:block; text-align:left;"><strong>Nama Pasien</strong></label>
            <select name="pasien_id" required class="form-input">
                <option value="">-- Pilih Pasien --</option>
                @foreach ($pasiens as $pasien)
                <option value="{{ $pasien->id }}" {{ $resep->pasien_id == $pasien->id ? 'selected' : '' }}>
                    {{ $pasien->nama }}
                </option>
                @endforeach
            </select>

            <label style="display:block; text-align:left;"><strong>Dokter</strong></label>
            <select name="user_id" required class="form-input">
                <option value="">-- Pilih Dokter --</option>
                @foreach ($users as $user)
                <option value="{{ $user->id }}" {{ $resep->user_id == $user->id ? 'selected' : '' }}>
                    {{ $user->nama_lengkap }}
                </option>
                @endforeach
            </select>

            <label style="display:block; text-align:left;"><strong>Tanggal Resep</strong></label>
            <input type="date" name="tanggal" value="{{ $resep->tanggal }}" required class="form-input">
        </div>

        <div style="flex: 1; min-width: 300px;">
            <label style="display:block; text-align:left;"><strong>Catatan</strong></label>
            <textarea name="catatan" rows="5" class="form-input">{{ $resep->catatan }}</textarea>

            <label style="display:block; text-align:left;"><strong>Pelayanan</strong></label>
            <select name="pelayanan_id" required class="form-input">
                <option value="">-- Pilih Pelayanan --</option>
                @foreach ($pelayanans as $pelayanan)
                <option value="{{ $pelayanan->id }}" {{ $resep->pelayanan_id == $pelayanan->id ? 'selected' : '' }}>
                    {{ $pelayanan->nama_pelayanan }}
                </option>
                @endforeach
            </select>


            <div style="display:flex; justify-content: flex-end; gap: 0.5rem; margin-top: 1rem;">
                <a href="{{ route('data-resep.index') }}" class="btn-cancel">Batal</a>
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
