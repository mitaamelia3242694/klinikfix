@extends('main')

@section('title', 'Dashboard Perawat - Klinik')

@section('content')
<section class="dashboard">
    <h2>Dashboard Perawat</h2>

    <div class="dashboard-grid">
        <!-- Box: Pengkajian Awal -->
        <div class="dashboard-box">
            <div class="box-icon">
                <i class="fas fa-file-medical-alt"></i>
            </div>
            <div class="box-content">
                <h3>Data Pengkajian Awal</h3>
                <p>Total: {{ $totalPengkajian }} data</p>
                <a href="/data-kajian-awal" class="btn btn-link">Lihat Pengkajian</a>
            </div>
        </div>

        <!-- Box: Diagnosa Awal -->
        <div class="dashboard-box">
            <div class="box-icon">
                <i class="fas fa-diagnoses"></i>
            </div>
            <div class="box-content">
                <h3>Data Diagnosa Awal</h3>
                <p>Total: {{ $totalDiagnosa }} data</p>
                <a href="/data-diagnosa-awal" class="btn btn-link">Lihat Diagnosa</a>
            </div>
        </div>

        <!-- Box: Manajemen Tindakan -->
        <div class="dashboard-box">
            <div class="box-icon">
                <i class="fas fa-hand-holding-medical"></i>
            </div>
            <div class="box-content">
                <h3>Manajemen Tindakan</h3>
                <p>Total: {{ $totalTindakan }} tindakan</p>
                <a href="/manajemen-tindakan" class="btn btn-link">Kelola Tindakan</a>
            </div>
        </div>
    </div>

    <!-- Grafik -->
    <div style="margin-top: 40px;">
        <canvas id="grafikDashboard" height="100"></canvas>
    </div>
</section>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('grafikDashboard').getContext('2d');
const grafikDashboard = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Pengkajian Awal', 'Diagnosa Awal', 'Tindakan'],
        datasets: [{
            label: 'Jumlah Data',
            data: [{
                    {
                        $totalPengkajian
                    }
                },
                {
                    {
                        $totalDiagnosa
                    }
                },
                {
                    {
                        $totalTindakan
                    }
                }
            ],
            backgroundColor: [
                'rgba(33, 106, 178, 0.7)',
                'rgba(39, 174, 96, 0.7)',
                'rgba(231, 76, 60, 0.7)'
            ],
            borderRadius: 8
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                enabled: true
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    precision: 0
                }
            }
        }
    }
});
</script>

<!-- Style -->
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
    flex-shrink: 0;
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