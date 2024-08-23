let currentPage = 1;
    let rowsPerPage = 15;
    let sortDirection = {};

    function updateTable() {
        let selectedValue = document.getElementById('row_count').value;
        let tableBody = document.getElementById('table-body');
        let totalRows = tableBody.rows.length;

        if (selectedValue === "all") {
            rowsPerPage = totalRows; // Show all rows
        } else {
            rowsPerPage = parseInt(selectedValue);
        }

        displayTable(currentPage);
        generatePagination();
    }

    function displayTable(page) {
        let tableBody = document.getElementById('table-body');
        let rows = tableBody.rows;
        let start = (page - 1) * rowsPerPage;
        let end = start + rowsPerPage;
        
        for (let i = 0; i < rows.length; i++) {
            rows[i].style.display = (i >= start && i < end) ? '' : 'none';
        }
    }

    function generatePagination() {
        let tableBody = document.getElementById('table-body');
        let rows = tableBody.rows.length;
        let pages = Math.ceil(rows / rowsPerPage);
        let pagination = document.getElementById('pagination');
        
        pagination.innerHTML = '';
        
        for (let i = 1; i <= pages; i++) {
            let li = document.createElement('li');
            li.className = 'page-item' + (i === currentPage ? ' active' : '');
            li.innerHTML = `<a class="page-link" href="#" onclick="gotoPage(${i})">${i}</a>`;
            pagination.appendChild(li);
        }
    }

    function gotoPage(page) {
        currentPage = page;
        displayTable(page);
        generatePagination();
        updateRowNumbers(); // Hitung ulang nomor setelah navigasi halaman
    }

    function sortTable(columnIndex) {
        let table = document.getElementById("myTable");
        let rows = Array.from(table.querySelector('tbody').rows);

        // Tentukan arah penyortiran: toggle antara asc dan desc
        if (!sortDirection[columnIndex] || sortDirection[columnIndex] === 'desc') {
            sortDirection[columnIndex] = 'asc';
        } else {
            sortDirection[columnIndex] = 'desc';
        }

        let direction = sortDirection[columnIndex];

        let sortedRows = rows.sort((a, b) => {
            let cellA = a.cells[columnIndex].innerText.trim();
            let cellB = b.cells[columnIndex].innerText.trim();
            
            if (direction === 'asc') {
                return cellA.localeCompare(cellB, undefined, { numeric: true });
            } else {
                return cellB.localeCompare(cellA, undefined, { numeric: true });
            }
        });

        let tbody = table.querySelector('tbody');
        sortedRows.forEach(row => tbody.appendChild(row));

        document.querySelectorAll('.sort-icon').forEach(icon => {
            icon.classList.remove('fa-sort-up', 'fa-sort-down');
            icon.classList.add('fa-sort');
        });

        let icon = document.getElementById(`icon${columnIndex}`);
        if (direction === 'asc') {
            icon.classList.remove('fa-sort', 'fa-sort-down');
            icon.classList.add('fa-sort-up');
        } else {
            icon.classList.remove('fa-sort', 'fa-sort-up');
            icon.classList.add('fa-sort-down');
        }

        updateRowNumbers(); // Mengupdate nomor setelah penyortiran
    }

    function updateRowNumbers() {
        let tableBody = document.getElementById('table-body');
        let rows = tableBody.getElementsByTagName('tr');
        
        for (let i = 0; i < rows.length; i++) {
            // Mengatur ulang nomor berdasarkan urutan baris saat ini
            rows[i].getElementsByClassName('nomor')[0].innerText = i + 1;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Atur arah penyortiran awal ke ascending untuk kolom 1 ("Hari Ke-")
        sortDirection[1] = 'desc'; // Menetapkan arah sortir default ke ascending
        sortTable(1); // Sortir default berdasarkan kolom "Hari Ke-"
        displayTable(currentPage);
        generatePagination();
        updateRowNumbers(); // Hitung ulang nomor pada saat halaman dimuat
    });
