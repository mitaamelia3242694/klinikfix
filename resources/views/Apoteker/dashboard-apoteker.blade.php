@extends('main')

@section('title', 'Dashboard Apoteker - Klinik')

@section('content')
<section class="dashboard">
    <h2>Dashboard Apoteker</h2>

    <div class="dashboard-grid">
        <!-- Box: Menerima Resep -->
        <div class="dashboard-box">
            <div class="box-icon">
                <i class="fas fa-prescription-bottle-alt"></i>
            </div>
            <div class="box-content">
                <h3>Menerima Resep</h3>
                <p>5 resep menunggu</p>
                <a href="{{route('data-resep.index')}}" class="btn btn-link">Lihat Resep</a>
            </div>
        </div>

        <!-- Box: Manajemen Obat -->
        <div class="dashboard-box">
            <div class="box-icon">
                <i class="fas fa-pills"></i>
            </div>
            <div class="box-content">
                <h3>Manajemen Obat</h3>
                <p>120 jenis obat tersedia</p>
                
            </div>
        </div>
    </div>
</section>

<style>
.dashboard {
    padding: 20px;
    font-family: Arial, sans-serif;
}

.dashboard h2 {
    font-size: 24px;
    color: #2c3e50;
    margin-bottom: 25px;
}

.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
}

.dashboard-box {
    background: #fff;
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
