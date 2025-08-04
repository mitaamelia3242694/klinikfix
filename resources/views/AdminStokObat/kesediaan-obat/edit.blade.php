@extends('main')

@section('title', 'Edit Ketersediaan Obat - Klinik')

@section('content')
<section class="blank-content">
    <h3 style="margin-bottom: 1rem; color: rgb(33, 106, 178); text-align:left;">Edit Ketersediaan Obat</h3>

    @if (session('success'))
    <div class="alert-success" id="successAlert">
        {{ session('success') }}
    </div>
    @endif

    <form method="POST" action="{{ route('kesediaan-obat.update', $sediaan->id) }}"
        style="max-width: 1000px; display: flex; gap: 2rem; flex-wrap: wrap;">
        @csrf
        @method('PUT')

        <div style="flex: 1; min-width: 300px;">
            <label style="display:block; text-align:left;"><strong>Nama Obat</strong></label>
            <select name="obat_id" required class="form-input">
                <option value="">-- Pilih Obat --</option>
                @foreach ($obats as $obat)
                <option value="{{ $obat->id }}" {{ $sediaan->obat_id == $obat->id ? 'selected' : '' }}>
                    {{ $obat->nama_obat }}
                </option>
                @endforeach
            </select>

            <label style="display:block; text-align:left;"><strong>Stok yang akan ditambahkan</strong></label>
            <input type="number" name="stok_total" min="1" class="form-input">
            @php
            $terpakai = $sediaan->obat->resepDetails->sum('jumlah') ?? 0;
            $stokTersisa = $sediaan->obat->stok_total - $terpakai;
            @endphp
            <label style="display:block; text-align:left;"><strong>Stok Total Saat Ini</strong></label>
            <input type="number" value="{{ $stokTersisa }}" class="form-input" readonly>

            <label style="display:block; text-align:left;"><strong>Tanggal Masuk</strong></label>
            <input type="date" name="tanggal_masuk" value="{{ $sediaan->tanggal_masuk }}" class="form-input">

        </div>

        <div style="flex: 1; min-width: 300px;">
            <label style="display:block; text-align:left;"><strong>Tanggal Keluar</strong></label>
            <input type="date" name="tanggal_keluar" value="{{ $sediaan->tanggal_keluar }}" class="form-input">


            <label style="display:block; text-align:left;"><strong>Tanggal Kadaluarsa</strong></label>
            <input type="date" name="tanggal_kadaluarsa" value="{{ $sediaan->tanggal_kadaluarsa }}" class="form-input">

            <label style="display:block; text-align:left;"><strong>Keterangan</strong></label>
            <textarea name="keterangan" rows="5" class="form-input">{{ $sediaan->keterangan }}</textarea>

            <div style="display:flex; justify-content: flex-end; gap: 0.5rem; margin-top: 1rem;">
                <a href="{{ route('kesediaan-obat.index') }}" class="btn-cancel">Batal</a>
                <button type="submit" class="btn-submit">Update</button>
            </div>
        </div>
    </form>
</section>

<style>
.alert-success {
    background-color: #d4edda;
    color: #155724;
    border-left: 5px solid #28a745;
    padding: 12px 16px;
    border-radius: 8px;
    margin-bottom: 1rem;
    position: relative;
    animation: fadeSlide 0.5s ease-out;
}

@keyframes fadeSlide {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

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

<script>
// Sembunyikan alert setelah 5 detik
window.onload = function() {
    const successAlert = document.getElementById('successAlert');
    if (successAlert) {
        setTimeout(() => {
            successAlert.style.transition = 'opacity 0.5s ease';
            successAlert.style.opacity = '0';
            setTimeout(() => successAlert.style.display = 'none', 500);
        }, 5000);
    }
};
</script>
@endsection
