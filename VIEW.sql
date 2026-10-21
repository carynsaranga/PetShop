USE proyek_pbd;

-- satuan
CREATE OR REPLACE VIEW satuan_v 
AS SELECT s.idsatuan, s.nama_satuan,
IF(s.status = 1, 'Aktif', 'Nonaktif') AS status_satuan
FROM satuan s;

-- role
CREATE OR REPLACE VIEW role_v
AS SELECT r.idrole, r.nama_role
FROM role r;

-- barang (dan nama satuannya)
CREATE OR REPLACE VIEW barang_v
AS SELECT b.idbarang, b.nama AS nama_barang, b.jenis, s.nama_satuan, b.harga,
IF(b.status = 1, 'Aktif', 'Nonaktif') AS status_barang
FROM barang b
JOIN satuan s ON b.idsatuan = s.idsatuan;

-- vendor
CREATE OR REPLACE VIEW vendor_v
AS SELECT v.idvendor, v.nama_vendor, v.badan_hukum,
CASE v.badan_hukum
    WHEN 'P' THEN 'PT'
	WHEN 'C' THEN 'CV'
	ELSE 'Lainnya'
END AS nama_badan_hukum,
CASE v.status
	WHEN 'A' THEN 'Aktif'
	WHEN 'N' THEN 'Nonaktif'
	ELSE v.status
END AS status_vendor
FROM vendor v;

-- user (dan nama rolenya tp tanpa password)
CREATE OR REPLACE VIEW user_v
AS SELECT u.iduser, u.username, r.nama_role
FROM `user` u
JOIN role r ON u.idrole = r.idrole;

-- margin penjualan
CREATE OR REPLACE VIEW marginpenjualan_v 
as SELECT m.idmargin_penjualan, m.persen,
IF(m.status = 1, 'Aktif', 'Nonaktif') AS status_margin, u.username AS dibuat_oleh, m.created_at, m.updated_at
FROM margin_penjualan m
JOIN `user` u ON m.iduser = u.iduser;

-- margin penjualan namun hanya yang aktif
CREATE OR REPLACE VIEW marginaktif_v
AS SELECT m.idmargin_penjualan, m.persen, u.username AS dibuat_oleh, m.created_at, m.updated_at
FROM margin_penjualan m
JOIN `user` u ON m.iduser = u.iduser
WHERE m.status = 1;


SELECT * FROM satuan_v;
SELECT * FROM role_v;
SELECT * FROM barang_v;
SELECT * FROM vendor_v;
SELECT * FROM user_v;
SELECT * FROM marginpenjualan_v;
SELECT * FROM marginaktif_v;

SELECT idbarang, status_barang FROM barang_v;