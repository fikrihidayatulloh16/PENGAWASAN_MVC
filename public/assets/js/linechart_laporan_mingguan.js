src="https://cdn.jsdelivr.net/npm/chart.js";
src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels";

// Line chart setup
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Rencana Progres Kumulatif',
            data: rencanaKumulatifData,
            borderColor: 'rgba(75, 192, 192, 1)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            fill: false,
            tension: 0.1
        },
        {
            label: 'Realisasi Progres Kumulatif',
            data: realisasiKumulatifData,
            borderColor: 'rgba(255, 99, 132, 1)',
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
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
                display: true,
                text: 'Grafik Progres Kumulatif'
            }
        },
        scales: {
            x: {
                title: {
                    display: true,
                    text: 'Minggu Ke-'
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

// Fungsi untuk menangkap grafik dan mengirimkannya ke server
function saveChart() {
    var imageBase64 = myChart.toBase64Image(); // Mengambil gambar grafik dalam format base64
    
    fetch(`<?= PUBLICURL ?>/laporanmingguan/save_linechart/<?= $data['id_projek'] ?>`, {
        method: 'POST',
        body: JSON.stringify({ image: imageBase64 }),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log('Gambar berhasil disimpan:', data);
        // Lakukan sesuatu setelah gambar disimpan, misalnya menampilkan notifikasi
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// Simpan gambar saat halaman dimuat
window.onload = saveChart;