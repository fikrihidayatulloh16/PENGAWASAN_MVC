document.addEventListener('DOMContentLoaded', () => {
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
                        top: 50,
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

        return new Chart(canvas.getContext('2d'), config);
    }

    // Buat chart
    const chart1 = createChart('chart1', dataPointsJson1);
    const chart2 = createChart('chart2', dataPointsJson2);

    // Tunggu hingga chart dirender sepenuhnya
    console.log('Waiting for chart rendering...');

    setTimeout(async () => {
        console.log('Timeout reached, starting pie chart save process...');
        // Pastikan chart sudah dirender
        if (chart1 && chart2) {
            const image1 = chart1.toBase64Image();
            const image2 = chart2.toBase64Image();
            
            // Kirim gambar ke server
            const response = await fetch(`${PUBLICURL}/operator/save_piechart/${ID_LAPORAN_HARIAN}/${ID_PROJEK}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `image1=${encodeURIComponent(image1)}&image2=${encodeURIComponent(image2)}`
            });

            // Tampilkan hasil respon
            const result = await response.text();
            console.log(result);
            //console.log(document.getElementById("pdf"));  // Memastikan elemen ditemukan

            // Jika penyimpanan berhasil, tampilkan elemen dengan id="pdf"
            if (response.ok) {
                document.getElementById("pdf").style.display = "block";
            } else {
                console.error('Error saving pie chart');
            }
        } else {
            console.error('One or both charts are not defined.');
        }
    }, 1000); // Menunggu 1 detik
});
