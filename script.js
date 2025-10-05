document.addEventListener('DOMContentLoaded', function () {
    // Ambil elemen-elemen DOM
    const transactionForm = document.getElementById('transaction-form');
    const transactionsList = document.getElementById('transactions-list');
    const totalIncomeEl = document.getElementById('total-income');
    const totalExpenseEl = document.getElementById('total-expense');
    const balanceEl = document.getElementById('balance');
    const filterCategoryEl = document.getElementById('filter-category');
    const filterDateEl = document.getElementById('filter-date');
    const clearFiltersBtn = document.getElementById('clear-filters');
    const noTransactionsMessage = document.getElementById('no-transactions-message');

    let currentTransactions = []; // Simpan data sementara di client

    // Fungsi untuk mendapatkan label kategori
    function getCategoryLabel(categoryKey) {
        const labels = {
            'makanan': 'Makanan & Minuman',
            'transportasi': 'Transportasi',
            'buku': 'Buku & Alat Tulis',
            'hiburan': 'Hiburan',
            'lainnya': 'Lainnya'
        };
        return labels[categoryKey] || categoryKey;
    }

    // Fungsi untuk memformat angka ke format Rupiah
    const formatToRupiah = (number) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);

    // Fungsi utama: mengambil data dari server dan merender tampilan
    async function fetchAndRenderTransactions() {
        const categoryFilter = filterCategoryEl.value;
        const dateFilter = filterDateEl.value;

        // Bangun URL dengan parameter filter
        let url = `api.php?action=get&category=${categoryFilter}`;
        if (dateFilter) {
            url += `&date=${dateFilter}`;
        }

        try {
            const response = await fetch(url);
            const transactions = await response.json();
            currentTransactions = transactions; // Update data di client

            transactionsList.innerHTML = ''; // Kosongkan list

            if (transactions.length === 0) {
                noTransactionsMessage.style.display = 'block';
            } else {
                noTransactionsMessage.style.display = 'none';
                transactions.forEach(transaction => {
                    const li = document.createElement('li');
                    li.className = `transaction-item ${transaction.type}`;
                    li.innerHTML = `
                        <div class="transaction-details">
                            <strong>${transaction.description}</strong>
                            <span>${transaction.date} | ${getCategoryLabel(transaction.category)}</span>
                        </div>
                        <div class="transaction-amount">${transaction.type === 'income' ? '+' : '-'}${formatToRupiah(transaction.amount)}</div>
                        <div class="transaction-actions">
                            <button class="edit-btn" data-id="${transaction.id}">Edit</button>
                            <button class="delete-btn" data-id="${transaction.id}">Hapus</button>
                        </div>
                    `;
                    transactionsList.appendChild(li);
                });
            }
            updateSummary(transactions);
        } catch (error) {
            console.error('Gagal mengambil data:', error);
        }
    }

    // Fungsi untuk update ringkasan
    function updateSummary(transactions) {
        const income = transactions.filter(t => t.type === 'income').reduce((sum, t) => sum + parseFloat(t.amount), 0);
        const expense = transactions.filter(t => t.type === 'expense').reduce((sum, t) => sum + parseFloat(t.amount), 0);
        const balance = income - expense;

        totalIncomeEl.textContent = formatToRupiah(income);
        totalExpenseEl.textContent = formatToRupiah(expense);
        balanceEl.textContent = formatToRupiah(balance);
        balanceEl.className = balance < 0 ? 'balance balance-negative' : 'balance';
    }

    // Handler untuk form submit (menangani add dan update)
    transactionForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        const formData = new FormData(transactionForm);
        const transactionId = formData.get('id');
        
        // Tentukan aksi: update jika ada ID, add jika tidak
        const action = transactionId ? 'update' : 'add';
        
        try {
            const response = await fetch(`api.php?action=${action}`, {
                method: 'POST',
                body: formData
            });
            const result = await response.json();

            if (result.success) {
                resetForm();
                await fetchAndRenderTransactions(); // Ambil data terbaru
            } else {
                alert('Gagal menyimpan transaksi: ' + (result.error || ''));
            }
        } catch (error) {
            console.error('Error saat menyimpan:', error);
        }
    });

    // Event listener untuk tombol di daftar transaksi (edit dan hapus)
    transactionsList.addEventListener('click', function(e) {
        if (e.target.classList.contains('edit-btn')) {
            const id = e.target.dataset.id;
            const transaction = currentTransactions.find(t => t.id == id);
            if (transaction) {
                // Isi form dengan data yang akan di-edit
                document.getElementById('transaction-id').value = transaction.id;
                document.getElementById('description').value = transaction.description;
                document.getElementById('amount').value = transaction.amount;
                document.getElementById('type').value = transaction.type;
                document.getElementById('category').value = transaction.category;
                document.getElementById('date').value = transaction.date;
                transactionForm.querySelector('button[type="submit"]').textContent = 'Update Transaksi';
                document.getElementById('form-section').scrollIntoView({ behavior: 'smooth' });
            }
        }

        if (e.target.classList.contains('delete-btn')) {
            const id = e.target.dataset.id;
            if (confirm('Yakin ingin menghapus transaksi ini?')) {
                deleteTransaction(id);
            }
        }
    });

    // Fungsi untuk menghapus transaksi
    async function deleteTransaction(id) {
        const formData = new FormData();
        formData.append('id', id);

        try {
            const response = await fetch('api.php?action=delete', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();
            if (result.success) {
                await fetchAndRenderTransactions(); // Refresh
            } else {
                alert('Gagal menghapus transaksi.');
            }
        } catch (error) {
            console.error('Error saat menghapus:', error);
        }
    }
    
    // Fungsi untuk mereset form ke kondisi awal
    function resetForm() {
        transactionForm.reset();
        document.getElementById('transaction-id').value = '';
        transactionForm.querySelector('button[type="submit"]').textContent = 'Tambah Transaksi';
    }

    // Event listener untuk filter
    filterCategoryEl.addEventListener('change', fetchAndRenderTransactions);
    filterDateEl.addEventListener('change', fetchAndRenderTransactions);
    clearFiltersBtn.addEventListener('click', function() {
        filterCategoryEl.value = 'all';
        filterDateEl.value = '';
        fetchAndRenderTransactions();
    });

    // Inisialisasi: Panggil data pertama kali saat halaman dimuat
    fetchAndRenderTransactions();
});