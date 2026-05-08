<div class="container">

    <div class="row">

        <!-- BAR CHART -->
        <div class="col-md-8 mb-4">
            <div class="card">
                <div class="card-header">
                    Diagram Batang Pengunjung
                </div>

                <div class="card-body">
                    <canvas id="visitorChart"></canvas>
                </div>
            </div>
        </div>

        <!-- PIE CHART -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header">
                    Diagram Lingkaran Tahunan
                </div>

                <div class="card-body">
                    <canvas id="yearChart"></canvas>
                </div>
            </div>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

// ========================
// DATA BULANAN
// ========================

const data = <?= json_encode($visitorChart) ?>;

const bulanNama = [
    '', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
    'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
];

const labels = data.map(d => {
    return bulanNama[d.bulan] + ' ' + d.tahun;
});

const values = data.map(d => d.total);

new Chart(document.getElementById('visitorChart'), {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Jumlah Pengunjung',
            data: values
        }]
    }
});


// ========================
// DATA TAHUNAN
// ========================

const yearData = <?= json_encode($visitorYearChart) ?>;

const yearLabels = yearData.map(d => d.tahun);
const yearValues = yearData.map(d => d.total);

new Chart(document.getElementById('yearChart'), {
    type: 'pie',
    data: {
        labels: yearLabels,
        datasets: [{
            label: 'Pengunjung per Tahun',
            data: yearValues
        }]
    }
});

</script>