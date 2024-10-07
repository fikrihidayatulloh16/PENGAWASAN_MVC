document.addEventListener('DOMContentLoaded', function() {
    // Ambil elemen yang diperlukan
    const dateInput = document.getElementById('tanggalInput');
    const errorLabel = document.getElementById('tanggalError_tambahcco');
    const submitButton = document.getElementById('submitButton');
    const form = document.getElementById('formTambahCco');

    // Ambil startDate dan endDate dari atribut data
    const startDate = new Date(dateInput.getAttribute('data-start'));
    const endDate = new Date(dateInput.getAttribute('data-end'));

    // Fungsi untuk memvalidasi tanggal
    function validateDate() {
        const inputDate = new Date(dateInput.value);

        // Cek jika tanggal dalam rentang yang benar
        if (inputDate < startDate || inputDate > endDate) {
            errorLabel.style.display = 'inline'; // Tampilkan pesan error
            submitButton.disabled = true; // Nonaktifkan tombol submit
            return false; // Indikasi validasi gagal
        } else {
            errorLabel.style.display = 'none'; // Sembunyikan pesan error
            submitButton.disabled = false; // Aktifkan tombol submit
            return true; // Indikasi validasi berhasil
        }
    }

    // Event listener untuk input tanggal
    dateInput.addEventListener('input', validateDate);

    // Cegah submit jika tanggal tidak valid
    form.addEventListener('submit', function(event) {
        if (!validateDate()) {
            event.preventDefault(); // Cegah submit form
        }
    });
});
