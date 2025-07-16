@extends('main')

@section('title', 'Dashboard Apoteker - Klinik')

@section('content')
<section class="dashboard">
    <h2>Dashboard Apoteker</h2>

    <div class="dashboard-grid">
        <!-- Menu 1: Manajemen Obat -->
        <div class="dashboard-box">
            <div class="box-icon">
                <i class="fas fa-capsules"></i>
            </div>
            <div class="box-content">
                <h3>Manajemen Obat</h3>
                <p>Kelola data obat yang tersedia.</p>
                <a href="/menejemen-obat" class="btn btn-link">Lihat</a>
            </div>
        </div>

        <!-- Menu 2: Ketersediaan Obat -->
        <div class="dashboard-box">
            <div class="box-icon">
                <i class="fas fa-warehouse"></i>
            </div>
            <div class="box-content">
                <h3>Ketersediaan Obat</h3>
                <p>Cek stok dan masa kadaluarsa.</p>
                <a href="/kesediaan-obat" class="btn btn-link">Lihat</a>
            </div>
        </div>

        <!-- Menu 3: Satuan Obat -->
        <div class="dashboard-box">
            <div class="box-icon">
                <i class="fas fa-ruler-combined"></i>
            </div>
            <div class="box-content">
                <h3>Satuan Obat</h3>
                <p>Atur satuan obat: strip, botol, tablet.</p>
                <a href="/satuan-obat" class="btn btn-link">Lihat</a>
            </div>
        </div>
    </div>
</section>

<style>
.dashboard {
    padding: 20px;
}

.dashboard h2 {
    font-size: 24px;
    margin-bottom: 25px;
    color: #2c3e50;
}

.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.dashboard-box {
    background-color: #fff;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    display: flex;
    align-items: center;
    gap: 16px;
    transition: transform 0.2s ease;
}

.dashboard-box:hover {
    transform: translateY(-4px);
}

.box-icon {
    font-size: 32px;
    color: rgb(33, 106, 178);
    min-width: 40px;
}

.box-content h3 {
    margin: 0;
    font-size: 18px;
    color: #333;
}

.box-content p {
    margin: 4px 0 10px;
    color: #666;
    font-size: 14px;
}

.btn-link {
    background-color: rgb(33, 106, 178);
    color: white;
    padding: 6px 12px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 14px;
}
</style>
@endsection