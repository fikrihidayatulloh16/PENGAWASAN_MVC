document.addEventListener('DOMContentLoaded', function () {
    let myChart;

    if (typeof labels !== 'undefined' && typeof rencanaKumulatifData !== 'undefined' && typeof realisasiKumulatifData !== 'undefined') {
        function createDataset(label, data, color) {
            return {
                label: label,
                data: data,
                borderColor: color,
                backgroundColor: color,
                fill: false
            };
        }

        const datasets = [];

        Object.keys(rencanaKumulatifData).forEach((key) => {
            if (key == 'cco0') {
                datasets.push(createDataset(
                    'Rencana Kumulatif - Kontrak Awal',
                    rencanaKumulatifData[key],
                    `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 1)`
                ));
            } else {
                datasets.push(createDataset(
                    'Rencana Kumulatif - ' + key,
                    rencanaKumulatifData[key],
                    `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 1)`
                ));
            }
        });

        Object.keys(realisasiKumulatifData).forEach((key) => {
            if (key == 'cco0') {
                datasets.push(createDataset(
                    'Realisasi Kumulatif - Kontrak Awal',
                    realisasiKumulatifData[key],
                    `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 1)`
                ));
            } else {
                datasets.push(createDataset('Realisasi Kumulatif - ' + key, realisasiKumulatifData[key], `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 1)`));
            }
        });

        const data = {
            labels: labels,
            datasets: datasets
        };

        const config = {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Minggu ke-'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Nilai'
                        },
                        beginAtZero: true
                    }
                },
                plugins: {
                    zoom: {
                        pan: {
                            enabled: true,
                            mode: 'xy', 
                        },
                        zoom: {
                            wheel: {
                                enabled: false // Disable zoom with the mouse wheel
                            },
                            pinch: {
                                enabled: true
                            },
                            mode: 'xy'
                        }
                    }
                }
            },
            plugins: [{
                id: 'custom-tooltip-plugin',
                afterDatasetsDraw: (chart) => {
                    const { ctx, data } = chart;
                    ctx.save();

                    // Draw custom tooltips for each active element
                    chart.data.datasets.forEach((dataset, datasetIndex) => {
                        dataset.data.forEach((dataPoint, index) => {
                            if (dataPoint !== null) {  // Avoid null data points
                                const meta = chart.getDatasetMeta(datasetIndex);
                                const model = meta.data[index].getProps(['x', 'y'], true);

                                const tooltipText = `(${index + 1}, ${dataPoint})`;

                                // Adjust the vertical position to avoid overlap
                                const tooltipModel = {
                                    x: model.x,
                                    y: model.y - 30 - (datasetIndex * 10), // Offset each tooltip by dataset index to prevent overlap
                                    label: tooltipText
                                };

                                // Draw tooltip background
                                ctx.fillStyle = 'rgba(0,0,0,0.7)';
                                ctx.fillRect(tooltipModel.x - 25, tooltipModel.y - 10, 50, 20);

                                // Draw tooltip text
                                ctx.fillStyle = '#fff';
                                ctx.font = '12px Arial';
                                ctx.textAlign = 'center';
                                ctx.fillText(tooltipModel.label, tooltipModel.x, tooltipModel.y);
                            }
                        });
                    });

                    ctx.restore();
                }
            }]
        };

        myChart = new Chart(document.getElementById('myChart'), config);

        // Zoom In Button
        document.getElementById('zoomIn').addEventListener('click', function() {
            myChart.zoom(1.2); // Zoom in by 20%
        });

        // Zoom Out Button
        document.getElementById('zoomOut').addEventListener('click', function() {
            myChart.zoom(0.8); // Zoom out by 20%
        });

        // Reset Zoom Button
        document.getElementById('resetZoom').addEventListener('click', function() {
            myChart.resetZoom(); // Reset the chart to original zoom level
        });

        setTimeout(async () => {
            if (myChart) {
                const image = myChart.toBase64Image();

                const response = await fetch(`${PUBLICURL}/laporanmingguan/save_linechart/${ID_PROJEK}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `image=${encodeURIComponent(image)}`
                });

                const result = await response.text();
                console.log(result);
            }
        }, 1000);
    } else {
        console.error('Data untuk chart tidak tersedia.');
    }
});
