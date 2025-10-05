![alt text](https://github.com/Vrilll/KantongKu/blob/main/kantongku.png?raw=true)

# KantongKu - Aplikasi Budgeting

## Deskripsi
Aplikasi web CRUD sederhana untuk membantu mahasiswa melacak pemasukan dan pengeluaran. Proyek ini dibuat sebagai Capstone Project untuk HACKTIV8.

**Link Aplikasi Live:** https://kantongku.evrilrizki.com/

## Fitur
- Menambah transaksi pemasukan dan pengeluaran.
- Melihat daftar semua transaksi.
- Mengedit transaksi yang sudah ada.
- Menghapus transaksi.
- Filter transaksi berdasarkan kategori dan tanggal.
- Ringkasan saldo otomatis.

## Teknologi yang Digunakan
- **Frontend:** HTML, CSS, Vanilla JavaScript
- **Backend:** PHP
- **Database:** MySQL
- **Development Assistant:** IBM Granite AI
- **Hosting:** cPanel

## Penjelasan Dukungan AI (AI Support Explanation)
IBM Granite AI digunakan secara ekstensif selama fase pengembangan untuk mempercepat proses coding. Contohnya:
- **Generasi Kode Awal:** Fungsi `fetchAndRenderTransactions()` di `script.js` pada awalnya dibuat kerangkanya menggunakan Granite, yang memberikan dasar logika `async/await` untuk berkomunikasi dengan backend.
- **Query SQL:** Query untuk memfilter data di `api.php` dioptimalkan dengan bantuan Granite untuk memastikan efisiensi.
- **Dampak:** Penggunaan AI menghemat sekitar 30-40% waktu development, memungkinkan saya untuk lebih fokus pada logika bisnis dan pengalaman pengguna.

## Setup di Lingkungan Lokal (XAMPP)
1.  Clone repositori ini.
2.  Tempatkan folder di `htdocs` XAMPP Anda.
3.  Buat database MySQL dan import file `.sql` yang disediakan.
4.  Sesuaikan detail koneksi di file `db.php`.
5.  Akses melalui `http://localhost/namafolder`.
