document.addEventListener('DOMContentLoaded', function () {
    let laporanIdToDelete; // Variabel untuk menyimpan ID laporan yang akan dihapus
  
    // Event listener untuk tombol Delete
    document.querySelectorAll('.delete-button').forEach(button => {
      button.addEventListener('click', function () {
        laporanIdToDelete = this.dataset.id; // Ambil ID laporan dari tombol yang diklik
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show(); // Tampilkan modal konfirmasi
      });
    });
  
    // Event listener untuk tombol Hapus di dalam modal
    document.getElementById('confirmDeleteButton').addEventListener('click', function () {
      // Lakukan request Ajax untuk delete data
      fetch('delete_laporan.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ laporanId: laporanIdToDelete })
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            location.reload();  // Refresh halaman untuk menampilkan data terbaru
          } else {
            alert('Gagal menghapus laporan.');
          }
        })
        .catch(error => console.error('Error:', error));
    });
  });
  