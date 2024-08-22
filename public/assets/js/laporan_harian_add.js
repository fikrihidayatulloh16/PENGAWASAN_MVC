//Vailidasi tanggal
document.addEventListener("DOMContentLoaded", function() {
    // Function to validate date input
    function validateDateRange(startDate, endDate, additionalDate, inputDate, errorElement) {
        var startDateValue = new Date(startDate);
        var endDateValue = new Date(endDate);
        var inputDateValue = new Date(inputDate.value);
        var additionalDateValue = additionalDate ? new Date(additionalDate) : null;

        // Clear previous error
        errorElement.style.display = 'none';

        // Validate that input date is within the range of start and end date (or additional date if exists)
        if (inputDateValue < startDateValue || (additionalDateValue ? inputDateValue > additionalDateValue : inputDateValue > endDateValue)) {
            errorElement.style.display = 'block';
            return false;
        }

        return true;
    }

    // Event listener for form submission
    document.getElementById('lh_tambah').addEventListener('submit', function(event) {
        var startDate = "<?= $tanggal_mulai ?>";
        var endDate = "<?= $tanggal_selesai ?>";
        var additionalDate = "<?= $tambahan_waktu ?>";
        var inputDate = document.getElementById('tanggal');
        var errorElement = document.getElementById('tanggalError_tambah');

        if (!validateDateRange(startDate, endDate, additionalDate, inputDate, errorElement)) {
            event.preventDefault();
        }
    });
});

//JS Check Box
document.getElementById('dropdown').addEventListener('change', function() {
    var selectedOption = this.value;
    var checkboxes = document.getElementById('checkboxes').children;

    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].classList.add('hidden');
    }

    document.getElementById(selectedOption).classList.remove('hidden');
});

// Saat halaman dimuat, sembunyikan semua opsi checkbox kecuali yang pertama dipilih
window.addEventListener('DOMContentLoaded', function() {
    var selectedOption = document.getElementById('dropdown').value;
    var checkboxes = document.getElementById('checkboxes').children;

    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].classList.add('hidden');
    }

    document.getElementById(selectedOption).classList.remove('hidden');
});

//JS validasi checkbox
document.addEventListener('DOMContentLoaded', function() {
const form = document.querySelector('form'); // pastikan Anda menarget form yang benar
const checkboxes = document.querySelectorAll('#checkboxes input[type="checkbox"]');
const errorElement = document.getElementById('checkboxError');

form.addEventListener('submit', function(event) {
    let isChecked = false;

    checkboxes.forEach(function(checkbox) {
        if (checkbox.checked) {
            isChecked = true;
        }
    });

    if (!isChecked) {
        event.preventDefault();
        errorElement.style.display = 'block';
    } else {
        errorElement.style.display = 'none';
    }
});
});

// JavaScript untuk menampilkan modalError jika terjadi kesalahan
document.addEventListener('DOMContentLoaded', function() {
const form = document.querySelector('form'); // pastikan Anda menarget form yang benar
const checkboxes = document.querySelectorAll('#checkboxes input[type="checkbox"]');
const errorElement = document.getElementById('checkboxError');
const modalError = document.getElementById('modalError');

form.addEventListener('submit', function(event) {
    let isChecked = false;

    checkboxes.forEach(function(checkbox) {
        if (checkbox.checked) {
            isChecked = true;
        }
    });

    if (!isChecked) {
        event.preventDefault();
        errorElement.style.display = 'block';
        modalError.style.display = 'block'; // Tampilkan pesan modalError
    } else {
        errorElement.style.display = 'none';
        modalError.style.display = 'none'; // Sembunyikan pesan modalError
    }

    // Validasi tanggal
    var startDate = "<?= $tanggal_mulai ?>";
    var endDate = "<?= $tanggal_selesai ?>";
    var additionalDate = "<?= $tambahan_waktu ?>";
    var inputDate = document.getElementById('tanggal');
    var dateErrorElement = document.getElementById('tanggalError_tambah');

    if (!validateDateRange(startDate, endDate, additionalDate, inputDate, dateErrorElement)) {
        event.preventDefault();
        modalError.style.display = 'block'; // Tampilkan pesan modalError jika tanggal tidak valid
    } else {
        dateErrorElement.style.display = 'none';
    }
});
});