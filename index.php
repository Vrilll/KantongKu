<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KantongKu - Anggaran untuk Pelajar</title>
    
    <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%232E7D32'%3E%3Cpath d='M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm-1 14H5c-.55 0-1-.45-1-1V8h16v9c0 .55-.45 1-1 1zM5 6h14v1H5V6z'/%3E%3C/svg%3E">
    
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="header-content">
            <svg class="logo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white">
                <path d="M21 7H3C1.9 7 1 7.9 1 9v10c0 1.1.9 2 2 2h18c1.1 0 2-.9 2-2V9c0-1.1-.9-2-2-2zM3 9h18v2H3V9zm0 8v-5h18v5H3z"/>
                <path d="M10 14h4v2h-4z"/>
            </svg>
            <div class="header-text">
                <h1>KantongKu</h1>
                <p>Atur keuanganmu dengan mudah</p>
            </div>
        </div>
    </header>

    <main>
        <section id="form-section">
            <h2>Tambah / Edit Transaksi</h2>
            <form id="transaction-form">
                <input type="hidden" id="transaction-id" name="id">
                <div class="form-group">
                    <label for="description">Deskripsi:</label>
                    <input type="text" id="description" name="description" placeholder="Contoh: Beli makan siang" required>
                </div>
                <div class="form-group">
                    <label for="amount">Jumlah (Rp):</label>
                    <input type="number" id="amount" name="amount" step="1" placeholder="0" required>
                </div>
                <div class="form-group">
                    <label for="type">Jenis:</label>
                    <select id="type" name="type" required>
                        <option value="income">Pemasukan</option>
                        <option value="expense">Pengeluaran</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="category">Kategori:</label>
                    <select id="category" name="category" required>
                        <option value="makanan">Makanan & Minuman</option>
                        <option value="transportasi">Transportasi</option>
                        <option value="buku">Buku & Alat Tulis</option>
                        <option value="hiburan">Hiburan</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="date">Tanggal:</label>
                    <input type="date" id="date" name="date" required>
                </div>
                <button type="submit">Tambah Transaksi</button>
            </form>
        </section>

        <section id="summary-section">
            <h2>Ringkasan Keuangan</h2>
            <div class="summary-box">
                <p>Total Pemasukan: <span id="total-income">Rp 0</span></p>
                <p>Total Pengeluaran: <span id="total-expense">Rp 0</span></p>
                <p class="balance">Saldo: <span id="balance">Rp 0</span></p>
            </div>
        </section>

        <section id="transactions-section">
            <h2>Daftar Transaksi</h2>
            <div class="filters">
                <div class="form-group">
                    <label for="filter-category">Filter Kategori:</label>
                    <select id="filter-category">
                        <option value="all">Semua</option>
                        <option value="income">Pemasukan</option>
                        <option value="expense">Pengeluaran</option>
                        <option value="makanan">Makanan & Minuman</option>
                        <option value="transportasi">Transportasi</option>
                        <option value="buku">Buku & Alat Tulis</option>
                        <option value="hiburan">Hiburan</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="filter-date">Filter Tanggal:</label>
                    <input type="date" id="filter-date">
                    <button id="clear-filters">Clear Filter</button>
                </div>
            </div>
            <ul id="transactions-list"></ul>
            <p id="no-transactions-message" style="display: none;">Tidak ada transaksi yang cocok.</p>
        </section>
    </main>

    <script src="script.js"></script>
</body>
</html>