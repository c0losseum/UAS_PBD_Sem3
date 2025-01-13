CREATE TABLE pembeli (
    id_pembeli INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100),
    no_telepon BIGINT(16),
    alamat VARCHAR(150)
);

CREATE TABLE penjualan (
    id_penjualan INT AUTO_INCREMENT PRIMARY KEY,
    tanggal_penjualan DATE,
    metode_transaksi VARCHAR(100) CHECK (metode_transaksi = 'online' OR metode_transaksi = 'offline')
);

CREATE TABLE pesan (
    id_pesan INT AUTO_INCREMENT PRIMARY KEY,
    id_pembeli INT,
    id_penjualan INT,
    tanggal_penjualan DATE,
    total_harga DECIMAL(15,2),
    FOREIGN KEY (id_pembeli) REFERENCES pembeli (id_pembeli),
    FOREIGN KEY (id_penjualan) REFERENCES penjualan (id_penjualan)
);

CREATE TABLE produk (
    id_produk INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(50),
    kategori VARCHAR(25),
    harga DECIMAL(15,2)
);

CREATE TABLE detail (
    id_detail INT AUTO_INCREMENT PRIMARY KEY,
    id_penjualan INT,
    id_produk INT,
    jumlah INT,
    subtotal DECIMAL(15,2),
    FOREIGN KEY (id_penjualan) REFERENCES penjualan (id_penjualan),
    FOREIGN KEY (id_produk) REFERENCES produk (id_produk)
);

CREATE TABLE pemasok (
    id_pemasok INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100),
    jumlah_pasokan INT,
    tanggal DATE
);

CREATE TABLE penyimpanan (
    id_penyimpanan INT AUTO_INCREMENT PRIMARY KEY,
    id_produk INT,
    id_pemasok INT,
    stok INT,
    FOREIGN KEY (id_produk) REFERENCES produk (id_produk),
    FOREIGN KEY (id_pemasok) REFERENCES pemasok (id_pemasok)
);

-- Insert Data untuk Tabel Pembeli
INSERT INTO pembeli (nama, no_telepon, alamat) VALUES
('Adi Pratama', 6281234567890, 'Jl. Sudirman No.10, Jakarta'),
('Budi Santoso', 6289876543210, 'Jl. Merdeka No.15, Bandung'),
('Citra Dewi', 6281111111111, 'Jl. Diponegoro No.25, Surabaya'),
('Dewi Lestari', 6282222222222, 'Jl. Gajah Mada No.5, Yogyakarta'),
('Eko Saputra', 6283333333333, 'Jl. Slamet Riyadi No.30, Solo'),
('Fajar Hidayat', 6284444444444, 'Jl. Ahmad Yani No.7, Malang'),
('Gilang Pradipta', 6285555555555, 'Jl. Pemuda No.20, Semarang'),
('Hilda Safitri', 6286666666666, 'Jl. Pahlawan No.18, Medan'),
('Indra Lesmana', 6287777777777, 'Jl. Kartini No.12, Bali'),
('Joko Susilo', 6288888888888, 'Jl. Thamrin No.8, Jakarta');

-- Insert Data untuk Tabel Penjualan
INSERT INTO penjualan (tanggal_penjualan, metode_transaksi) VALUES
('2025-01-01', 'online'),
('2025-01-02', 'offline'),
('2025-01-03', 'online'),
('2025-01-04', 'offline'),
('2025-01-05', 'online'),
('2025-01-06', 'offline'),
('2025-01-07', 'online'),
('2025-01-08', 'offline'),
('2025-01-09', 'online'),
('2025-01-10', 'offline');

-- Insert Data untuk Tabel Pesan
INSERT INTO pesan (id_pembeli, id_penjualan, tanggal_penjualan, total_harga) VALUES
(1, 1, '2025-01-01', 750000),
(2, 2, '2025-01-02', 1500000),
(3, 3, '2025-01-03', 500000),
(4, 4, '2025-01-04', 2000000),
(5, 5, '2025-01-05', 1000000),
(6, 6, '2025-01-06', 1250000),
(7, 7, '2025-01-07', 300000),
(8, 8, '2025-01-08', 1750000),
(9, 9, '2025-01-09', 2250000),
(10, 10, '2025-01-10', 600000);

-- Insert Data untuk Tabel Produk
INSERT INTO produk (nama, kategori, harga) VALUES
('Meja Kantor', 'Furniture', 750000),
('Kursi Kayu', 'Furniture', 250000),
('Lemari Pakaian', 'Furniture', 1500000),
('Sofa Minimalis', 'Furniture', 2000000),
('Rak Buku', 'Furniture', 500000),
('Kasur Springbed', 'Bedroom', 3000000),
('Meja Belajar', 'Furniture', 800000),
('Bangku Cafe', 'Furniture', 450000),
('Buffet TV', 'Living Room', 1250000),
('Meja Tamu', 'Living Room', 1750000);

-- Insert Data untuk Tabel Detail
INSERT INTO detail (id_penjualan, id_produk, jumlah, subtotal) VALUES
(1, 1, 1, 750000),
(2, 3, 1, 1500000),
(3, 5, 1, 500000),
(4, 4, 1, 2000000),
(5, 6, 1, 1000000),
(6, 8, 1, 1250000),
(7, 7, 1, 300000),
(8, 2, 2, 500000),
(9, 10, 1, 1750000),
(10, 9, 1, 600000);

-- Insert Data untuk Tabel Pemasok
INSERT INTO pemasok (nama, jumlah_pasokan, tanggal) VALUES
('Pemasok A', 20, '2025-01-01'),
('Pemasok B', 15, '2025-01-02'),
('Pemasok C', 30, '2025-01-03'),
('Pemasok D', 25, '2025-01-04'),
('Pemasok E', 40, '2025-01-05'),
('Pemasok F', 50, '2025-01-06'),
('Pemasok G', 35, '2025-01-07'),
('Pemasok H', 45, '2025-01-08'),
('Pemasok I', 60, '2025-01-09'),
('Pemasok J', 55, '2025-01-10');

-- Insert Data untuk Tabel Penyimpanan
INSERT INTO penyimpanan (id_produk, id_pemasok, stok) VALUES
(1, 1, 20),
(2, 2, 15),
(3, 3, 30),
(4, 4, 25),
(5, 5, 40),
(6, 6, 50),
(7, 7, 35),
(8, 8, 45),
(9, 9, 60),
(10, 10, 55);
