USE proyek_pbd;

-- =======================DML============================
-- DML : MENGISI DATA (INSERT)
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE satuan;

INSERT INTO satuan (idsatuan, nama_satuan, status) VALUES
	(1, 'Pcs', 1),
	(2, 'Botol', 1),
	(3, 'Kg', 1),
	(4, 'Liter', 1),
	(5, 'Lusin', 1);

INSERT INTO role (idrole, nama_role) VALUES 
	(1, 'Admin'),
	(2, 'Gudang'),
	(3, 'Kasir'),
	(4, 'Manajer'),
	(5, 'Supervisor');

INSERT INTO user (iduser, username, password, idrole) VALUES
	(1, 'admin', 'admin123', 1),
	(2, 'gudang', 'gudang123', 2),
	(3, 'kasir', 'kasir123', 3),
	(4, 'manajer', 'manager123', 4),
	(5, 'supervisor', 'supervisor123', 5);

INSERT INTO vendor (idvendor, nama_vendor, badan_hukum, status) VALUES
	(1, 'PT Sumber Makmur Pet', 'P', 'A'),
	(2, 'CV Berkah Jaya Abadi', 'C', 'A'),
	(3, 'UD Maju Terus Bersama', 'U', 'A'),
	(4, 'PT Sinar Abadi Raya', 'P', 'A'),
	(5, 'CV Sukses Mandiri Sejahtera', 'C', 'A');

INSERT INTO barang (idbarang, jenis, nama, idsatuan, status, harga) VALUES
	(1, 'P', 'Pakan Kucing Dewasa', 3, 1, 45000),      -- idsatuan 3 = Kg
	(2, 'P', 'Pakan Anjing Puppy', 3, 1, 52000),       -- idsatuan 3 = Kg
	(3, 'V', 'Vitamin Bulu Kucing', 2, 1, 98000),      -- idsatuan 2 = Botol
	(4, 'B', 'Bedak Anjing Anti Kutu', 2, 1, 20000),   -- idsatuan 2 = Botol
	(5, 'K', 'Kalung Hewan', 1, 1, 18000);             -- idsatuan 1 = Pcs

INSERT INTO margin_penjualan (idmargin_penjualan, created_at, persen, status, iduser, updated_at) VALUES
	(1, NOW(), 20, 1, 1, NOW()),
	(2, NOW(), 15, 0, 1, NOW()),
	(3, NOW(), 25, 0, 4, NOW()),
	(4, NOW(), 10, 0, 4, NOW()),
	(5, NOW(), 30, 0, 5, NOW());

INSERT INTO pengadaan (idpengadaan, timestamp, user_iduser, status, vendor_idvendor, subtotal_nilai, ppn, total_nilai) VALUES
	(1, NOW(), 2, 'A', 1, 4000000, 440000, 4440000),
	(2, NOW(), 2, 'A', 2, 2250000, 247500, 2497500),
	(3, NOW(), 2, 'A', 3, 1600000, 176000, 1776000),
	(4, NOW(), 2, 'A', 4, 750000, 82500, 832500),
	(5, NOW(), 2, 'A', 5, 300000, 33000, 333000);

INSERT INTO detail_pengadaan (iddetail_pengadaan, harga_satuan, jumlah, sub_total, idbarang, idpengadaan) VALUES
	(1, 40000, 100, 4000000, 1, 1),  -- Beli Pakan Kucing Dewasa
	(2, 45000, 50, 2250000, 2, 2),   -- Beli Pakan Anjing Puppy
	(3, 80000, 20, 1600000, 3, 3),   -- Beli Vitamin Bulu Kucing
	(4, 15000, 50, 750000, 4, 4),    -- Beli Bedak Anjing
	(5, 15000, 20, 300000, 5, 5);    -- Beli Kalung Hewan

INSERT INTO penerimaan (idpenerimaan, created_at, status, idpengadaan, iduser) VALUES
	(1, NOW(), 'A', 1, 2),
	(2, NOW(), 'A', 2, 2),
	(3, NOW(), 'A', 3, 2),
	(4, NOW(), 'A', 4, 2),
	(5, NOW(), 'A', 5, 2);

INSERT INTO detail_penerimaan (iddetail_penerimaan, idpenerimaan, barang_idbarang, jumlah_terima, harga_satuan_terima, sub_total_terima) VALUES
	(1, 1, 1, 100, 40000, 4000000),
	(2, 2, 2, 50, 45000, 2250000),
	(3, 3, 3, 20, 80000, 1600000),
	(4, 4, 4, 50, 15000, 750000),
	(5, 5, 5, 20, 15000, 300000);

INSERT INTO retur_barang (idretur, created_at, idpenerimaan, iduser) VALUES
	(1, NOW(), 1, 2),
	(2, NOW(), 2, 2),
	(3, NOW(), 3, 2),
	(4, NOW(), 4, 2),
	(5, NOW(), 5, 2);

INSERT INTO detail_retur (iddetail_retur, jumlah, alasan, idretur, iddetail_penerimaan) VALUES
	(1, 2, 'Kemasan bocor/robek', 1, 1),
	(2, 3, 'Kadaluarsa dekat', 2, 2),
	(3, 1, 'Botol pecah', 3, 3),
	(4, 5, 'Varian tidak sesuai', 4, 4),
	(5, 4, 'Pengait kalung rusak', 5, 5);

INSERT INTO penjualan (idpenjualan, created_at, subtotal_nilai, ppn, total_nilai, iduser, idmargin_penjualan) VALUES
	(1, NOW(), 450000, 49500, 499500, 3, 1),  
	(2, NOW(), 260000, 28600, 288600, 3, 1),   
	(3, NOW(), 196000, 21560, 217560, 3, 1),  
	(4, NOW(), 120000, 13200, 133200, 3, 1),   
	(5, NOW(), 54000, 5940, 59940, 3, 1);     

INSERT INTO detail_penjualan (iddetail_penjualan, harga_satuan, jumlah, subtotal, penjualan_idpenjualan, idbarang) VALUES
	(1, 45000, 10, 450000, 1, 1),
	(2, 52000, 5, 260000, 2, 2),
	(3, 98000, 2, 196000, 3, 3),
	(4, 20000, 6, 120000, 4, 4),
	(5, 18000, 3, 54000, 5, 5);

INSERT INTO kartu_stok (idkartu_stok, jenis_transaksi, masuk, keluar, stock, created_at, idtransaksi, idbarang) VALUES
	(1, 'M', 100, 0, 100, NOW(), 1, 1),
	(2, 'M', 50, 0, 50, NOW(), 2, 2),
	(3, 'R', 0, 2, 98, NOW(), 1, 1),
	(4, 'K', 0, 10, 88, NOW(), 1, 1),
	(5, 'K', 0, 5, 45, NOW(), 2, 2);



-- DML : MELIHAT DATA (SELECT)

SELECT * FROM barang;

SELECT barang.nama, satuan.nama_satuan, barang.harga
FROM barang
JOIN satuan ON barang.idsatuan = satuan.idsatuan;

SELECT detail_pengadaan.idpengadaan, barang.nama, detail_pengadaan.jumlah, detail_pengadaan.sub_total
FROM detail_pengadaan
JOIN barang ON detail_pengadaan.idbarang = barang.idbarang;

SELECT COUNT(*) AS jumlah_barang, SUM(harga) AS total_harga FROM barang;


-- DML : UBAH DAN HAPUS DATA (UPDATE, DELETE)

UPDATE barang SET harga = 3700 WHERE idbarang = 1;

UPDATE vendor SET status = 'N' WHERE idvendor = 2;

DELETE FROM satuan WHERE idsatuan = 5;

INSERT INTO satuan (idsatuan, nama_satuan, status) VALUES (5, 'Lusin', 1);