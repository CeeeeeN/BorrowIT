window.onload = function() {
    loadRecords();
    setupFilters();
};

function setupFilters() {
    document.getElementById('applyFilters').addEventListener('click', loadRecords);
    document.getElementById('clearFilters').addEventListener('click', clearFilters);
}

function clearFilters() {
    document.getElementById('statusFilter').value = '';
    document.getElementById('borrowerSearch').value = '';
    document.getElementById('itemSearch').value = '';
    document.getElementById('startDate').value = '';
    document.getElementById('endDate').value = '';
    loadRecords();
}

function loadRecords() {
    const status = document.getElementById('statusFilter').value;
    const borrower = document.getElementById('borrowerSearch').value;
    const item = document.getElementById('itemSearch').value;
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;

    let url = 'get_records.php?';
    const params = [];
    if (status) params.push('status=' + encodeURIComponent(status));
    if (borrower) params.push('borrower=' + encodeURIComponent(borrower));
    if (item) params.push('item=' + encodeURIComponent(item));
    if (startDate) params.push('start_date=' + encodeURIComponent(startDate));
    if (endDate) params.push('end_date=' + encodeURIComponent(endDate));
    url += params.join('&');

    fetch(url)
        .then(response => response.json())
        .then(records => {
            displayRecords(records);
        })
        .catch(error => {
            console.error('Error loading records:', error);
            alert('Error loading records. Check console.');
        });
}

function displayRecords(records) {
    const tbody = document.getElementById('recordsTableBody');
    tbody.innerHTML = '';

    if(records.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" style="text-align:center; padding:40px;">No records found.</td></tr>';
        return;
    }

    records.forEach(record => {
        const returnDateCell = record.return_date ?
            record.return_date :
            `<form action='mark_returned.php' method='POST' style='display:inline;'>
                <input type='hidden' name='borrow_log_id' value='${record.borrow_log_id}'>
                <button type='submit' class='action-btn primary'>Mark Returned</button>
            </form>`;

        const row = `
            <tr>
                <td>${record.student_name}<br>${record.student_number}<br>${record.year_section}</td>
                <td>${record.item_name}</td>
                <td>${record.quantity_borrowed}</td>
                <td>${record.borrow_date}</td>
                <td>${returnDateCell}</td>
                <td>${record.log_status}</td>
            </tr>
        `;
        tbody.innerHTML += row;
    });
}
