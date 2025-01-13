-- SELECT
SELECT metode_transaksi, COUNT(id_penjualan) AS total_transaksi
FROM penjualan
GROUP BY metode_transaksi;

SELECT kategori, SUM(stok) AS total_stok
FROM produk
GROUP BY kategori;

SELECT kategori, AVG(harga) AS rata_rata_harga
FROM produk
GROUP BY kategori;

-- ORDER BY
SELECT tanggal, SUM(jumlah_pasokan) AS total_pasokan
FROM pemasok
GROUP BY tanggal
ORDER BY total_pasokan DESC;

SELECT tanggal_penjualan, SUM(total_harga) AS total_penjualan
FROM pesan
GROUP BY tanggal_penjualan
ORDER BY tanggal_penjualan DESC;

SELECT nama, stok
FROM produk
ORDER BY stok ASC;

-- HAVING
SELECT kategori, SUM(stok) AS total_stok
FROM produk
GROUP BY kategori
HAVING total_stok > 10;

SELECT metode_transaksi, COUNT(id_penjualan) AS total_transaksi
FROM penjualan
GROUP BY metode_transaksi
HAVING total_transaksi > 2;

SELECT tanggal, SUM(jumlah_pasokan) AS total_pasokan
FROM pemasok
GROUP BY tanggal
HAVING total_pasokan > 30;

-- JOIN
SELECT p.nama, COUNT(d.id_produk) AS jumlah_produk_terjual, SUM(d.subtotal) AS total_pembelian
FROM pembeli p
JOIN pesan ps ON p.id_pembeli = ps.id_pembeli
JOIN detail d ON ps.id_penjualan = d.id_penjualan
GROUP BY p.nama;

SELECT pr.nama AS produk, SUM(d.subtotal) AS total_pemasukan
FROM produk pr
JOIN detail d ON pr.id_produk = d.id_produk
GROUP BY pr.nama;

SELECT p.tanggal, SUM(ps.jumlah_tersimpan) AS total_tersimpan
FROM pemasok p
JOIN penyimpanan ps ON p.id_pemasok = ps.id_pemasok
GROUP BY p.tanggal;

-- SELECT, ORDER BY, HAVING, JOIN DENGAN AGREGASI
SELECT produk.nama AS Nama_Produk,
    SUM(detail.subtotal) AS Total_Pendapatan
FROM detail JOIN produk 
ON detail.id_produk = produk.id_produk
GROUP BY produk.nama
HAVING Total_Pendapatan > 3000000
ORDER BY Total_Pendapatan DESC;

SELECT pembeli.nama AS Nama_Pembeli,
    COUNT(pesan.id_pesan) AS Jumlah_Transaksi,
    SUM(pesan.total_harga) AS Total_Belanja
FROM pesan JOIN pembeli 
ON pesan.id_pembeli = pembeli.id_pembeli
GROUP BY pembeli.nama
HAVING Jumlah_Transaksi >= 2
ORDER BY Total_Belanja DESC;

SELECT produk.kategori AS Kategori,
    SUM(detail.jumlah) AS Total_Produk_Terjual
FROM detail JOIN produk 
ON detail.id_produk = produk.id_produk
GROUP BY produk.kategori
HAVING Total_Produk_Terjual > 2
ORDER BY Total_Produk_Terjual DESC;

-- CAMPUR
SELECT produk.nama AS Nama_Produk, 
	SUM(detail.jumlah) AS Total_Jumlah_Terjual, 
	SUM(detail.subtotal) AS Total_Pendapatan
FROM detail JOIN produk 
ON detail.id_produk = produk.id_produk
GROUP BY produk.nama 
ORDER BY Total_Pendapatan DESC;

SELECT pembeli.nama AS Nama_Pembeli,
    SUM(pesan.total_harga) AS Total_Belanja
FROM pesan JOIN pembeli 
ON pesan.id_pembeli = pembeli.id_pembeli
GROUP BY pembeli.nama
HAVING Total_Belanja > 4000000
ORDER BY Total_Belanja DESC;

SELECT pemasok.id_pemasok AS ID_Pemasok,
    SUM(penyimpanan.jumlah_tersimpan) AS Total_Produk_Tersimpan
FROM penyimpanan JOIN pemasok 
ON penyimpanan.id_pemasok = pemasok.id_pemasok
GROUP BY pemasok.id_pemasok
HAVING Total_Produk_Tersimpan > 10
ORDER BY Total_Produk_Tersimpan DESC;

SELECT penjualan.tanggal_penjualan AS Tanggal,
    pembeli.nama AS Nama_Pembeli,
    produk.nama AS Nama_Produk,
    detail.jumlah AS Jumlah,
    detail.subtotal AS Subtotal
FROM penjualan JOIN pesan 
ON penjualan.id_penjualan = pesan.id_penjualan
JOIN pembeli 
ON pesan.id_pembeli = pembeli.id_pembeli
JOIN detail 
ON penjualan.id_penjualan = detail.id_penjualan
JOIN produk 
ON detail.id_produk = produk.id_produk
ORDER BY penjualan.tanggal_penjualan ASC;
