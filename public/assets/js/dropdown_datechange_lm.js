document.getElementById('dropdown').addEventListener('change', function () {
    var selectedValue = this.value;
    if (selectedValue) {
        var dates = JSON.parse(selectedValue);
        document.getElementById('tanggal_mulai').innerText = new Date(dates.start).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
        document.getElementById('tanggal_selesai').innerText = new Date(dates.end).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });

        // Set the hidden input values
        document.getElementById('hidden_tanggal_mulai').value = dates.start;
        document.getElementById('hidden_tanggal_selesai').value = dates.end;
    }
});