var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,  // Pastikan variabel 'labels' didefinisikan
                datasets: [{
                    label: 'Rencana Progres Kumulatif',
                    data: rencanaKumulatifData,  // Pastikan variabel 'rencanaKumulatifData' didefinisikan
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    fill: false,
                    tension: 0.1
                },
                {
                    label: 'Realisasi Progres Kumulatif',
                    data: realisasiKumulatifData,  // Pastikan variabel 'realisasiKumulatifData' didefinisikan
                    borderColor: 'darkblue',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: false,
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                    title: {
                        display: false,
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Minggu Ke-',
                            position: 'left',
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Progres Kumulatif (%)'
                        },
                        beginAtZero: true
                    }
                }
            }
        });

        // Tunggu hingga chart dirender sepenuhnya
        myChart.update();

        // Konversi chart menjadi gambar base64
        setTimeout(async () => {
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
        }, 1000); // Menunggu 1 detik