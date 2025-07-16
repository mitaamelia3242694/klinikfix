@extends('main')

@section('title', 'Edit Pengambilan Obat - Klinik')

@section('content')
<section class="blank-content">
    <h3 style="margin-bottom: 1rem; color: rgb(33, 106, 178); text-align:left;">Edit Pengambilan Obat</h3>

    <form method="POST" action="{{ route('pengambilan-obat.update', $pengambilan->id) }}"
        style="max-width: 1000px; display: flex; gap: 2rem; flex-wrap: wrap;">
        @csrf
        @method('PUT')

        <div style="flex: 1; min-width: 300px;">
            <label style="display:block; text-align:left;"><strong>Resep</strong></label>
            <select name="resep_id" required class="form-input">
                <option value="">-- Pilih Resep --</option>
                @foreach ($reseps as $resep)
                <option value="{{ $resep->id }}" {{ $pengambilan->resep_id == $resep->id ? 'selected' : '' }}>
                    {{ $resep->pasien->nama ?? 'Pasien tidak ditemukan' }} -
                    {{ \Carbon\Carbon::parse($resep->tanggal)->format('d-m-Y') }}
                </option>
                @endforeach
            </select>

            <label style="display:block; text-align:left;"><strong>Petugas Apotek</strong></label>
            <select name="user_id" required class="form-input">
                <option value="">-- Pilih Petugas --</option>
                @foreach ($users as $user)
                <option value="{{ $user->id }}" {{ $pengambilan->user_id == $user->id ? 'selected' : '' }}>
                    {{ $user->nama_lengkap }}
                </option>
                @endforeach
            </select>

            <label style="display:block; text-align:left;"><strong>Tanggal Pengambilan</strong></label>
            <input type="date" name="tanggal_pengambilan" value="{{ $pengambilan->tanggal_pengambilan }}" required
                class="form-input">
        </div>

        <div style="flex: 1; min-width: 300px;">
            <label style="display:block; text-align:left;"><strong>Status Pengambilan</strong></label>
            <select name="status_checklist" required class="form-input">
                <option value="">-- Pilih Status --</option>
                <option value="sudah" {{ $pengambilan->status_checklist == 'sudah' ? 'selected' : '' }}>Sudah
                </option>
                <option value="belum" {{ $pengambilan->status_checklist == 'belum' ? 'selected' : '' }}>
                    Belum</option>
            </select>

            <div style="display:flex; justify-content: flex-end; gap: 0.5rem; margin-top: 1rem;">
                <a href="{{ route('pengambilan-obat.index') }}" class="btn-cancel">Batal</a>
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
