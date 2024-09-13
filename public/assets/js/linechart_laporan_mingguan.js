document.addEventListener('DOMContentLoaded', function () {
    let myChart;

    // Pastikan data tersedia
    if (typeof labels !== 'undefined' && typeof rencanaKumulatifData !== 'undefined' && typeof realisasiKumulatifData !== 'undefined') {
        // Function to create datasets from provided data and labels
        function createDataset(label, data, color) {
            return {
                label: label,
                data: data,
                borderColor: color,
                backgroundColor: color + '0.2',
                fill: false
            };
        }

        // Prepare datasets for Chart.js
        const datasets = [];
        
        // Create datasets for rencana kumulatif
        Object.keys(rencanaKumulatifData).forEach((key) => {
            datasets.push(createDataset('Rencana Kumulatif - ' + key, rencanaKumulatifData[key], `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 1)`));
        });

        // Create datasets for realisasi kumulatif
        Object.keys(realisasiKumulatifData).forEach((key) => {
            datasets.push(createDataset('Realisasi Kumulatif - ' + key, realisasiKumulatifData[key], `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 1)`));
        });

        // Data untuk chart
        const data = {
            labels: labels, // Gunakan label dari PHP
            datasets: datasets
        };

        // Konfigurasi chart
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
                }
            }
        };

        // Buat chart
        myChart = new Chart(
            document.getElementById('myChart'),
            config
        );

        // Konversi chart menjadi gambar base64
        setTimeout(async () => {
            if (myChart) {
                const image = myChart.toBase64Image();

                // Kirim gambar ke server
                const response = await fetch(`${PUBLICURL}/laporanmingguan/save_linechart/${ID_PROJEK}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `image=${encodeURIComponent(image)}`
                });

                // Tampilkan hasil respon
                const result = await response.text();
                console.log(result);
            }
        }, 1000); // Menunggu 1 detik
    } else {
        console.error('Data untuk chart tidak tersedia.');
    }
});
