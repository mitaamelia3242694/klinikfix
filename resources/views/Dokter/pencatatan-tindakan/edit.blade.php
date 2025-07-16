@extends('main')

@section('title', 'Edit Tindakan - Klinik')

@section('content')
<section class="blank-content">
    <h3 style="margin-bottom: 1rem; color: rgb(33, 106, 178); text-align:left;">Edit Pencatatan Tindakan</h3>

    <form method="POST" action="{{ route('pencatatan-tindakan.update', $tindakan->id) }}"
        style="max-width: 1000px; display: flex; gap: 2rem; flex-wrap: wrap;">
        @csrf
        @method('PUT')

        <div style="flex: 1; min-width: 300px;">
            <label style="display:block; text-align:left;"><strong>Pasien</strong></label>
            <select name="pasien_id" required class="form-input">
                <option value="">-- Pilih Pasien --</option>
                @foreach ($pasiens as $pasien)
                <option value="{{ $pasien->id }}" {{ $tindakan->pasien_id == $pasien->id ? 'selected' : '' }}>
                    {{ $pasien->nama }}
                </option>
                @endforeach
            </select>

            <label style="display:block; text-align:left;"><strong>Dokter</strong></label>
            <select name="user_id" required class="form-input">
                <option value="">-- Pilih Dokter --</option>
                @foreach ($dokters as $dokter)
                <option value="{{ $dokter->id }}" {{ $tindakan->user_id == $dokter->id ? 'selected' : '' }}>
                    {{ $dokter->nama_lengkap }}
                </option>
                @endforeach
            </select>

            <label style="display:block; text-align:left;"><strong>Tanggal</strong></label>
            <input type="date" name="tanggal" value="{{ $tindakan->tanggal }}" required class="form-input">
        </div>

        <div style="flex: 1; min-width: 300px;">
            <label style="display:block; text-align:left;"><strong>Jenis Tindakan</strong></label>
            <input type="text" name="jenis_tindakan" value="{{ $tindakan->jenis_tindakan }}" required
                class="form-input">

            <label style="display:block; text-align:left;"><strong>Tarif (Rp)</strong></label>
            <input type="number" step="0.01" name="tarif" value="{{ $tindakan->tarif }}" required class="form-input">

            <label style="display:block; text-align:left;"><strong>Catatan</strong></label>
            <textarea name="catatan" rows="4" class="form-input">{{ $tindakan->catatan }}</textarea>

            <div style="display:flex; justify-content: flex-end; gap: 0.5rem; margin-top: 1rem;">
                <a href="{{ route('pencatatan-tindakan.index') }}" class="btn-cancel">Batal</a>
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