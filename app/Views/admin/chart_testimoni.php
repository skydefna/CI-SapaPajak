<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="row mb-4">

    <!-- BAR CHART -->
    <div class="col-8">
      <div class="card shadow">
        <div class="card-body">
          <div class="card-title">Diagram Testimoni Pertahun</div>
          <canvas id="chartBarTahunan"></canvas>
        </div>
      </div>
    </div>

    <!-- PIE CHART -->
    <div class="col-4">
      <div class="card shadow">
        <div class="card-body">
          <div class="card-title">Diagram Testimoni</div>
          <canvas id="chartDonut"></canvas>
        </div>
      </div>
    </div>

  </div>

<script>

const dataChart = <?= json_encode($kepuasanChart) ?>;

// LABEL
const labels = dataChart.map(d => {

    switch(parseInt(d.kepuasan)) {

        case 1:
            return 'Sangat Puas';

        case 2:
            return 'Puas';

        case 3:
            return 'Cukup';

        case 4:
            return 'Kurang';

        default:
            return 'Lainnya';
    }
});

// VALUE
const values = dataChart.map(d => d.total);


// ========================
// BAR CHART
// ========================

const dataBar = {

    labels: labels,

    datasets: [{

        label: 'Jumlah Testimoni',

        data: values,

        backgroundColor: [
            'rgba(54, 162, 235, 0.7)',
            'rgba(75, 192, 192, 0.7)',
            'rgba(255, 206, 86, 0.7)',
            'rgba(255, 99, 132, 0.7)'
        ],

        borderWidth: 1
    }]
};


// ========================
// PIE CHART
// ========================

const dataPie = {

    labels: labels,

    datasets: [{

        data: values,

        backgroundColor: [
            "rgba(231,231,255,0.7)",
            "rgba(232,250,223,0.7)",
            "rgba(255,242,214,0.7)",
            "rgba(255,224,219,0.7)"
        ]
    }]
};


// ========================
// INIT BAR
// ========================

const bar = document.getElementById("chartBarTahunan");

if (bar) {

    new Chart(bar, {

        type: 'bar',

        data: dataBar,

        options: {
            responsive: true,

            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}


// ========================
// INIT PIE
// ========================

const pie = document.getElementById("chartDonut");

if (pie) {

    new Chart(pie, {

        type: 'pie',

        data: dataPie
    });
}

</script>