@extends('main')

@section('title', 'Dashboard Admin IT - Klinik')

@section('content')
<section class="dashboard">
    <h2>Selamat Datang, Admin IT</h2>

    <div class="dashboard-cards">
        <!-- Data Pegawai -->
        <div class="card">
            <h3>Data Pegawai</h3>
            <p>Total: <strong>{{ $totalPegawai }}</strong> pegawai</p>
            <a href="{{ route('data-pegawai.index') }}" class="btn btn-primary">Kelola Pegawai</a>
        </div>

        <!-- Data Jabatan -->
        <div class="card">
            <h3>Data Jabatan</h3>
            <p>Total: <strong>{{ $totalJabatan }}</strong> jabatan</p>
            <a href="{{ route('data-jabatan.index') }}" class="btn btn-primary">Kelola Jabatan</a>
        </div>

        <!-- Manajemen Pengguna -->
        <div class="card">
            <h3>Manajemen Pengguna</h3>
            <p>Total: <strong>{{ $totalPengguna }}</strong> pengguna</p>
            <a href="{{ route('manajemen-pengguna.index') }}" class="btn btn-primary">Kelola Pengguna</a>
        </div>
    </div>
</section>

<style>
.dashboard {
    padding: 20px;
}

.dashboard h2 {
    margin-bottom: 20px;
    font-size: 24px;
    color: #2c3e50;
}

.dashboard-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.card {
    background: #ffffff;
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    transition: box-shadow 0.3s ease;
}

.card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.card h3 {
    margin-top: 0;
    font-size: 18px;
    color: #333;
}

.card p {
    color: #666;
    font-size: 14px;
    margin: 10px 0 15px;
}

.btn-primary {
    display: inline-block;
    padding: 8px 16px;
    background-color: rgb(33, 106, 178);
    color: #fff;
    border-radius: 6px;
    text-decoration: none;
    font-size: 14px;
}
</style>
@endsection
