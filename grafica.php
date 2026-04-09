<div>
  <canvas id='grafica' class='marc'></canvas>
</div>

<script src='https://cdn.jsdelivr.net/npm/chart.js'></script>
<script src='https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0'></script>


<script>
const ctx        = document.getElementById('grafica');
const tempINT    = <?php echo json_encode($tempINT); ?>;
const humINT     = <?php echo json_encode($humINT); ?>;
const tempEXT    = <?php echo json_encode($tempEXT); ?>;
const humEXT     = <?php echo json_encode($humEXT); ?>;

const labels = Array.from({ length: 24 }, (_, i) => String(i).padStart(2,'0')+"h");

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [
            {
            label: 'Humitat interior',
                order: 1,
                data: humINT,
                type: 'line',
                yAxisID: 'y1',
                borderColor: '#6f7df5',
                backgroundColor: '#6f7df5',
                tension: 0.4,
                borderWidth: 3,
                pointRadius: 3,
                pointStyle: 'rectRounded'
            },
            {
                label: 'Humitat exterior',
                order: 0,
                data: humEXT,
                type: 'line',
                yAxisID: 'y1',
                pointStyle: 'rectRounded',
                borderColor: '#78feb7ff',
                backgroundColor: '#78feb7ff',
                tension: 0.4,
                borderWidth: 3,
                pointRadius: 3                
            },
            {
                label: 'Temp interior',
                order: 3,
                data: tempINT,
                yAxisID: 'y',
                backgroundColor: '#97a0f1',
                borderColor: '#97a0f1',
                borderWidth: 1,
                barPercentage: 1,
                categoryPercentage: 0.6,
                borderRadius: 20
            },
            {
                label: 'Temp exterior',
                order: 2,
                data: tempEXT,
                yAxisID: 'y',
                backgroundColor: '#92e4b9ff',
                borderColor: '#92e4b9ff',
                borderWidth: 1,
                barPercentage: 1,
                categoryPercentage: 0.6,
                borderRadius: 20
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: { mode: 'index', intersect: false },
        plugins: {
            legend: { position: 'bottom' },
            tooltip: { enabled: true }
        },
    scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        maxRotation: 45, // girem les etiquetes per a millor llegibilitat
                        minRotation: 0
                    }
                },
                y: {
                    beginAtZero: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Temperatura'
                    },
                    suggestedMin: 10,
                    suggestedMax: 25,
                    grid: {
                        color: 'rgba(255, 0, 0, 0.1)',
                    },
                    ticks: {  // llegenda de temperatura
                        callback: function(value) {
                            return value + 'ºC';
                        }
                    }
                },
                y1: {
                    beginAtZero: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Humitat'
                    },
                    grid: {
                        color: 'rgba(97, 97, 97, 1)',
                    },
                    suggestedMin: 0,
                    suggestedMax: 100,
                            
                    ticks: {  //llegenda de'humitat
                        callback: function(value) {
                            return value + '%';
                        }
                    }
                }
            }
        }
    });
</script>
