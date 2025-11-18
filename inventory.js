window.onload = function() {
    loadItems();
    setupFilters();
};

function setupFilters() {
    document.getElementById('categoryFilter').addEventListener('change', loadItems);
    document.getElementById('statusFilter').addEventListener('change', loadItems);
    document.getElementById('searchFilter').addEventListener('input', loadItems);
}

function loadItems() {
    const category = document.getElementById('categoryFilter').value;
    const status = document.getElementById('statusFilter').value;
    const search = document.getElementById('searchFilter').value;

    let url = 'get_items.php?';
    const params = [];
    if (category) params.push('category=' + encodeURIComponent(category));
    if (status) params.push('status=' + encodeURIComponent(status));
    if (search) params.push('search=' + encodeURIComponent(search));
    url += params.join('&');

    fetch(url)
        .then(response => response.json())
        .then(items => {
            displayItems(items);
        })
        .catch(error => {
            console.error('Error loading items:', error);
            alert('Error loading items. Check console.');
        });
}

function displayItems(items) {
    const tbody = document.getElementById('inventoryTableBody');
    tbody.innerHTML = '';

    if(items.length === 0) {
        tbody.innerHTML = '<tr><td colspan="5" style="text-align:center; padding:40px;">No items found. Add your first item!</td></tr>';
        return;
    }

    items.forEach(item => {
        const status = item.quantity > 0 ? 'Available' : 'Unavailable';
        const statusClass = item.quantity > 0 ? 'available' : 'unavailable';

        const row = `
            <tr>
                <td>${item.name}</td>
                <td>${item.category}</td>
                <td>${item.quantity}</td>
                <td><span class="status-badge ${statusClass}">${status}</span></td>
                <td>
                    <button class="update-btn" onclick="openUpdateModal(${item.id}, '${item.name.replace(/'/g, "\\'")}', '${item.category}', ${item.quantity})">Update</button>
                    <button class="delete-btn" onclick="deleteItem(${item.id})">Delete</button>
                </td>
            </tr>
        `;
        tbody.innerHTML += row;
    });
}

function openAddModal() {
    document.getElementById('addModal').style.display = 'flex';
}

function closeAddModal() {
    document.getElementById('addModal').style.display = 'none';
    document.getElementById('addForm').reset();
}

function addItem(event) {
    event.preventDefault();

    const name = document.getElementById('itemName').value;
    const category = document.getElementById('itemCategory').value;
    const quantity = document.getElementById('itemQuantity').value;

    const formData = new FormData();
    formData.append('name', name);
    formData.append('category', category);
    formData.append('quantity', quantity);

    fetch('add_item.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            alert('Item added successfully!');
            closeAddModal();
            loadItems();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error adding item. Check console.');
    });
}

function openUpdateModal(id, name, category, quantity) {
    document.getElementById('updateItemId').value = id;
    document.getElementById('updateItemName').value = name;
    document.getElementById('updateItemCategory').value = category;
    document.getElementById('updateItemQuantity').value = quantity;
    document.getElementById('updateModal').style.display = 'flex';
}

function closeUpdateModal() {
    document.getElementById('updateModal').style.display = 'none';
    document.getElementById('updateForm').reset();
}

function updateItem(event) {
    event.preventDefault();

    const id = document.getElementById('updateItemId').value;
    const name = document.getElementById('updateItemName').value;
    const category = document.getElementById('updateItemCategory').value;
    const quantity = document.getElementById('updateItemQuantity').value;

    const formData = new FormData();
    formData.append('id', id);
    formData.append('name', name);
    formData.append('category', category);
    formData.append('quantity', quantity);

    fetch('update_item.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            alert('Item updated successfully!');
            closeUpdateModal();
            loadItems();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error updating item. Check console.');
    });
}

function deleteItem(id) {
    if(confirm('Are you sure you want to delete this item?')) {
        const formData = new FormData();
        formData.append('id', id);

        fetch('delete_item.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                alert('Item deleted successfully!');
                loadItems();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting item. Check console.');
        });
    }
}

window.onclick = function(event) {
    const addModal = document.getElementById('addModal');
    const updateModal = document.getElementById('updateModal');
    
    if (event.target == addModal) {
        closeAddModal();
    }
    if (event.target == updateModal) {
        closeUpdateModal();
    }
}