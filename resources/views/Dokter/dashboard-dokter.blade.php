@extends('main')

@section('title', 'Dashboard Dokter - Klinik')

@section('content')
<section class="dashboard">
    <h2>Dashboard Dokter</h2>

    <div class="dashboard-grid">
        <!-- Stat: Pasien Hari Ini -->
        <div class="dashboard-box stat-box">
            <div class="box-icon">
                <i class="fas fa-calendar-day"></i>
            </div>
            <div class="box-content">
                <h3>Pasien Hari Ini</h3>
                <p>{{ $pasienHarian }}</p>
            </div>
        </div>

        <!-- Stat: Pasien Bulan Ini -->
        <div class="dashboard-box stat-box">
            <div class="box-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="box-content">
                <h3>Pasien Bulan Ini</h3>
                <p>{{ $pasienBulanan }}</p>
            </div>
        </div>

        <!-- Box: Diagnosa -->
        <div class="dashboard-box">
            <div class="box-icon">
                <i class="fas fa-stethoscope"></i>
            </div>
            <div class="box-content">
                <h3>Pencatatan Diagnosa</h3>
                <p>Catat dan kelola diagnosa pasien</p>
                <a href="/pencatatan-diagnosa" class="btn btn-link">Catat Diagnosa</a>
            </div>
        </div>

        <!-- Box: Tindakan -->
        <div class="dashboard-box">
            <div class="box-icon">
                <i class="fas fa-notes-medical"></i>
            </div>
            <div class="box-content">
                <h3>Pencatatan Tindakan</h3>
                <p>Rekam tindakan medis pasien</p>
                <a href="/pencatatan-tindakan" class="btn btn-link">Catat Tindakan</a>
            </div>
        </div>

        <!-- Box: Resep -->
        <div class="dashboard-box">
            <div class="box-icon">
                <i class="fas fa-prescription"></i>
            </div>
            <div class="box-content">
                <h3>Penerbitan Resep</h3>
                <p>Buat dan kirim resep ke apotek</p>
                <a href="/penerbitan-resep" class="btn btn-link">Buat Resep</a>
            </div>
        </div>
    </div>

    <!-- Grafik -->
    <div class="chart-container">
        <h3>Grafik Pasien per Bulan</h3>
        <canvas id="chartPasienBulanan" height="100"></canvas>
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

/* Optional: agar grafik punya jarak */
.chart-container {
    margin-top: 40px;
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.chart-container h3 {
    margin-bottom: 16px;
    font-size: 18px;
    color: #2c3e50;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('chartPasienBulanan').getContext('2d');
const chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [
            'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
            'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
        ],
        datasets: [{
            label: 'Jumlah Pasien',
            data: @json($dataChart),
            backgroundColor: 'rgba(33, 106, 178, 0.7)',
            borderRadius: 5
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                callbacks: {
                    label: context => ` ${context.parsed.y} pasien`
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});
</script>
@endsection
