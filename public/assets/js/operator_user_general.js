// Inisialisasi semua tooltips pada halaman
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

/// Fungsi untuk menampilkan spinner dan menonaktifkan tombol
function handleButtonSpinner(button) {
    button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';
    button.disabled = true;
}

// Event listener untuk semua form dengan kelas 'spinner-form'
document.querySelectorAll('.spinner-form').forEach(function(form) {
    form.onsubmit = function(event) {
        // Temukan tombol submit di dalam form yang memiliki kelas 'spinner-button'
        const submitButton = form.querySelector('.spinner-button');
        if (submitButton) {
            handleButtonSpinner(submitButton); // Panggil fungsi spinner
        }
        // Jangan batalkan submit dengan return false atau event.preventDefault() di sini
        return true; // Pastikan form tetap disubmit
    };
});