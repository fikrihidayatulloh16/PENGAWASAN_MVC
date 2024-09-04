document.addEventListener('DOMContentLoaded', (event) => {
    // Fungsi untuk mengonfigurasi dan membuat chart
    function createChart(chartId, dataPoints) {
        const canvas = document.getElementById(chartId);
        if (!canvas) {
            console.error(`Canvas with ID ${chartId} not found.`);
            return;
        }

        const labels = dataPoints.map(point => point.name);
        const data = dataPoints.map(point => point.y);
        const backgroundColors = dataPoints.map(point => point.color);

        const chartData = {
            labels: labels,
            datasets: [{
                label: 'Data Cuaca Harian',
                data: data,
                backgroundColor: backgroundColors,
                hoverOffset: 4,
            }]
        };

        const config = {
            type: 'pie',
            data: chartData,
            options: {
                layout: {
                    padding: {
                        top:50,
                        bottom: 50,
                        left: 60,
                        right: 60,
                    }
                },
                plugins: {
                    legend: {
                        display: false,
                        position: 'top',
                    },
                    tooltip: {
                        enabled: false, // Menonaktifkan tooltip
                    },
                    datalabels: {
                        color: '#000',
                        anchor: 'end',
                        align: 'end',
                        formatter: (value, context) => {
                            return context.chart.data.labels[context.dataIndex];
                        },
                        font: {
                            size: 14 // Ukuran font label datalabels
                        },
                        padding: 5, // Menambahkan jarak antara label dan chart
                    },
                }
            },
            plugins: [ChartDataLabels],
        };

        new Chart(canvas.getContext('2d'), config);
    }



    // Buat chart
    createChart('chart1', dataPointsJson1);
    createChart('chart2', dataPointsJson2);
});