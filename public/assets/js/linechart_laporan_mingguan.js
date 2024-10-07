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
                            enabled: true,    // Mengaktifkan fitur pan
                            mode: 'xy',       // Bisa geser secara horizontal dan vertikal
                            speed: 10,        // Kecepatan pan
                            threshold: 5      // Berapa jauh pan harus terjadi sebelum mulai
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
            }
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
                // Jika penyimpanan berhasil, tampilkan elemen dengan id="pdf"
            if (response.ok) {
                document.getElementById("pdf").style.display = "block";
            } else {
                console.error('Error saving pie chart');
            }
            }
        }, 1000);
    } else {
        console.error('Data untuk chart tidak tersedia.');
    }
});
