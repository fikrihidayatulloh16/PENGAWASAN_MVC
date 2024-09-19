document.addEventListener('DOMContentLoaded', function () {
    const tables = document.querySelectorAll('.sortable');
    let sortDirection = {};  // Track the sorting direction for each column

    tables.forEach((table, tableIndex) => {
        const rows = table.querySelectorAll('tbody tr');
        const container = document.createElement('div');
        container.classList.add('d-flex', 'justify-content-between', 'align-items-center', 'mb-3');
        table.after(container);

        const rowsPerPageContainer = document.createElement('div');
        rowsPerPageContainer.classList.add('d-flex', 'align-items-center');
        rowsPerPageContainer.innerHTML = `
            <span class="me-2">Jumlah baris: </span>
            <select class="rowsPerPage">
                <option value="15">15</option>
                <option value="30">30</option>
                <option value="60">60</option>
                <option value="all">All</option>
            </select>
        `;

        const pagination = document.createElement('div');
        pagination.classList.add('pagination');
        
        container.appendChild(rowsPerPageContainer);
        container.appendChild(pagination);

        const rowsPerPageSelect = rowsPerPageContainer.querySelector('.rowsPerPage');

        let currentPage = 1;
        let rowsPerPage = parseInt(rowsPerPageSelect.value);

        // Function to sort table
        function sortTable(columnIndex) {
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

            displayPage(currentPage);
            updateRowNumbers(); // Update row numbers after sorting
        }

        

        // Pagination function
        function displayPage(page) {
            let start = (page - 1) * rowsPerPage;
            let end = start + rowsPerPage;

            if (rowsPerPage === 'all') {
                start = 0;
                end = rows.length;
            }

            rows.forEach((row, i) => {
                row.style.display = (i >= start && i < end) || rowsPerPage === 'all' ? '' : 'none';
            });

            pagination.innerHTML = '';
            if (rowsPerPage !== 'all') {
                for (let i = 1; i <= Math.ceil(rows.length / rowsPerPage); i++) {
                    const pageLink = document.createElement('button');
                    pageLink.innerText = i;
                    pageLink.classList.add('btn', 'btn-sm', 'btn-primary', 'me-1');
                    pageLink.onclick = () => {
                        currentPage = i;
                        displayPage(currentPage);
                    };
                    pagination.appendChild(pageLink);
                }
            }
        }

        // Initialize sorting and pagination for each table
        table.querySelectorAll('th').forEach((th, columnIndex) => {
            th.style.cursor = 'pointer';
            th.onclick = () => sortTable(columnIndex);
        });

        rowsPerPageSelect.addEventListener('change', function () {
            rowsPerPage = this.value === 'all' ? 'all' : parseInt(this.value);
            displayPage(1);
        });

        displayPage(currentPage);
    });
});
