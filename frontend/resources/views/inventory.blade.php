<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Items</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <div class="container">
        <h2>Item Inventory</h2>

        <div class="msg" id="msg"></div>

        <div class="card" style="display: flex; justify-content: flex-end;">
            <button class="btn-primary" onclick="openAddModal()">+ Tambah Item</button>
        </div>

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Stock</th>
                        <th>Price</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="table"></tbody>
            </table>
        </div>
    </div>

    <div class="modal" id="addModal">
        <div class="modal-content">
            <div class="modal-header">Tambah Item Baru</div>
            <div class="error" id="addError"></div>
            <div class="form-group">
                <input id="add-name" placeholder="Nama Item">
                <input id="add-category" placeholder="Kategori">
                <input id="add-stock" type="number" placeholder="Stok">
                <input id="add-price" type="number" placeholder="Harga">
            </div>
            <div class="modal-footer">
                <button onclick="closeAddModal()">Batal</button>
                <button class="btn-primary" onclick="store()">Simpan</button>
            </div>
        </div>
    </div>

    <div class="modal" id="updateModal">
        <div class="modal-content">
            <div class="modal-header">Update Item</div>
            <div class="error" id="updateError"></div>
            <div class="form-group">
                <input id="update-name" placeholder="Nama Item">
                <input id="update-category" placeholder="Kategori">
                <input id="update-stock" type="number" placeholder="Stok">
                <input id="update-price" type="number" placeholder="Harga">
            </div>
            <div class="modal-footer">
                <button onclick="closeUpdateModal()">Batal</button>
                <button class="btn-warning" onclick="saveUpdate()">Update</button>
            </div>
        </div>
    </div>

    <script>
        const api = '/api/items';
        const tableBody = document.getElementById('table');
        const msg = document.getElementById('msg');
        let currentId = null;

        function showMsg(text) {
            msg.textContent = text;
            setTimeout(() => msg.textContent = '', 3000);
        }

        function load() {
            fetch(api)
                .then(r => r.json())
                .then(data => {
                    tableBody.innerHTML = '';
                    data.forEach(i => {
                        tableBody.innerHTML += `
                            <tr>
                                <td data-label="Name">${i.name}</td>
                                <td data-label="Category">${i.category}</td>
                                <td data-label="Stock">${i.stock}</td>
                                <td data-label="Price">${new Intl.NumberFormat('id-ID').format(i.price)}</td>
                                <td class="actions">
                                    <button class="btn-warning" onclick="openUpdateModal(${i.id}, '${i.name}', '${i.category}', ${i.stock}, ${i.price})">Edit</button>
                                    <button class="btn-danger" onclick="destroy(${i.id})">Hapus</button>
                                </td>
                            </tr>`;
                    });
                });
        }

        function openAddModal() {
            document.getElementById('addError').textContent = '';
            document.querySelectorAll('#addModal input').forEach(i => i.value = '');
            document.getElementById('addModal').style.display = 'flex';
        }

        function closeAddModal() { document.getElementById('addModal').style.display = 'none'; }

        function openUpdateModal(id, name, category, stock, price) {
            currentId = id;
            document.getElementById('updateError').textContent = '';
            document.getElementById('update-name').value = name;
            document.getElementById('update-category').value = category;
            document.getElementById('update-stock').value = stock;
            document.getElementById('update-price').value = price;
            document.getElementById('updateModal').style.display = 'flex';
        }

        function closeUpdateModal() { document.getElementById('updateModal').style.display = 'none'; }

        function validate(n, c, s, p) {
            if (!n || !c || !s || !p) return "Semua field wajib diisi!";
            if (s <= 0 || p <= 0) return "Stok dan Harga harus lebih dari 0!";
            return null;
        }

        function store() {
            const n = document.getElementById('add-name').value,
                  c = document.getElementById('add-category').value,
                  s = document.getElementById('add-stock').value,
                  p = document.getElementById('add-price').value;

            const err = validate(n, c, s, p);
            if(err) return document.getElementById('addError').textContent = err;

            fetch(api, {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({name:n, category:c, stock:s, price:p})
            }).then(r => r.json()).then(res => {
                showMsg(res.message);
                closeAddModal();
                load();
            });
        }

        function saveUpdate() {
            const n = document.getElementById('update-name').value,
                  c = document.getElementById('update-category').value,
                  s = document.getElementById('update-stock').value,
                  p = document.getElementById('update-price').value;

            const err = validate(n, c, s, p);
            if(err) return document.getElementById('updateError').textContent = err;

            fetch(`${api}/${currentId}`, {
                method: 'PUT',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({name:n, category:c, stock:s, price:p})
            }).then(r => r.json()).then(res => {
                showMsg(res.message);
                closeUpdateModal();
                load();
            });
        }

        function destroy(id) {
            if(!confirm('Apakah Anda yakin ingin menghapus item ini?')) return;
            fetch(`${api}/${id}`, { method: 'DELETE' })
                .then(r => r.json())
                .then(res => {
                    showMsg(res.message);
                    load();
                });
        }

        window.onclick = e => {
            if (e.target.className === 'modal') {
                closeAddModal();
                closeUpdateModal();
            }
        };

        load();
    </script>
</body>
</html>
