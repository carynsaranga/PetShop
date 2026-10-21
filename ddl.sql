DROP DATABASE if exists proyek_pbd;

CREATE DATABASE proyek_pbd;
USE proyek_pbd;

-- DDL : MEMBUAT TABEL (tabel induk dibuat dulu, baru tabel anak)

CREATE TABLE satuan (
  idsatuan INT PRIMARY KEY,
  nama_satuan VARCHAR(45),
  status TINYINT
);

CREATE TABLE barang (
  idbarang INT PRIMARY KEY,
  jenis CHAR(1),
  nama VARCHAR(45),
  idsatuan INT,
  status TINYINT,
  harga INT,
  FOREIGN KEY (idsatuan) REFERENCES satuan(idsatuan)
);

CREATE TABLE vendor (
  idvendor INT PRIMARY KEY,
  nama_vendor VARCHAR(100),
  badan_hukum CHAR(1),
  status CHAR(1)
);

CREATE TABLE role (
  idrole INT PRIMARY KEY,
  nama_role VARCHAR(45)
);

CREATE TABLE user (
  iduser INT PRIMARY KEY,
  username VARCHAR(45),
  password VARCHAR(100),
  idrole INT,
  FOREIGN KEY (idrole) REFERENCES role(idrole)
);

CREATE TABLE margin_penjualan (
  idmargin_penjualan INT PRIMARY KEY,
  created_at TIMESTAMP,
  persen DOUBLE,
  status TINYINT,
  iduser INT,
  updated_at TIMESTAMP,
  FOREIGN KEY (iduser) REFERENCES user(iduser)
);

CREATE TABLE pengadaan (
  idpengadaan BIGINT PRIMARY KEY,
  timestamp TIMESTAMP,
  user_iduser INT,
  status CHAR(1),
  vendor_idvendor INT,
  subtotal_nilai INT,
  ppn INT,
  total_nilai INT,
  FOREIGN KEY (user_iduser) REFERENCES user(iduser),
  FOREIGN KEY (vendor_idvendor) REFERENCES vendor(idvendor)
);

CREATE TABLE detail_pengadaan (
  iddetail_pengadaan BIGINT PRIMARY KEY,
  harga_satuan INT,
  jumlah INT,
  sub_total INT,
  idbarang INT,
  idpengadaan BIGINT,
  FOREIGN KEY (idbarang) REFERENCES barang(idbarang),
  FOREIGN KEY (idpengadaan) REFERENCES pengadaan(idpengadaan)
);

CREATE TABLE penerimaan (
  idpenerimaan BIGINT PRIMARY KEY,
  created_at TIMESTAMP,
  status CHAR(1),
  idpengadaan BIGINT,
  iduser INT,
  FOREIGN KEY (idpengadaan) REFERENCES pengadaan(idpengadaan),
  FOREIGN KEY (iduser) REFERENCES user(iduser)
);

CREATE TABLE detail_penerimaan (
  iddetail_penerimaan BIGINT PRIMARY KEY,
  idpenerimaan BIGINT,
  barang_idbarang INT,
  jumlah_terima INT,
  harga_satuan_terima INT,
  sub_total_terima INT,
  FOREIGN KEY (idpenerimaan) REFERENCES penerimaan(idpenerimaan),
  FOREIGN KEY (barang_idbarang) REFERENCES barang(idbarang)
);

CREATE TABLE retur_barang (
  idretur BIGINT PRIMARY KEY,
  created_at TIMESTAMP,
  idpenerimaan BIGINT,
  iduser INT,
  FOREIGN KEY (idpenerimaan) REFERENCES penerimaan(idpenerimaan),
  FOREIGN KEY (iduser) REFERENCES user(iduser)
);

CREATE TABLE detail_retur (
  iddetail_retur INT PRIMARY KEY,
  jumlah INT,
  alasan VARCHAR(200),
  idretur BIGINT,
  iddetail_penerimaan BIGINT,
  FOREIGN KEY (idretur) REFERENCES retur_barang(idretur),
  FOREIGN KEY (iddetail_penerimaan) REFERENCES detail_penerimaan(iddetail_penerimaan)
);

CREATE TABLE penjualan (
  idpenjualan INT PRIMARY KEY,
  created_at TIMESTAMP,
  subtotal_nilai INT,
  ppn INT,
  total_nilai INT,
  iduser INT,
  idmargin_penjualan INT,
  FOREIGN KEY (iduser) REFERENCES user(iduser),
  FOREIGN KEY (idmargin_penjualan) REFERENCES margin_penjualan(idmargin_penjualan)
);

CREATE TABLE detail_penjualan (
  iddetail_penjualan BIGINT PRIMARY KEY,
  harga_satuan INT,
  jumlah INT,
  subtotal INT,
  penjualan_idpenjualan INT,
  idbarang INT,
  FOREIGN KEY (penjualan_idpenjualan) REFERENCES penjualan(idpenjualan),
  FOREIGN KEY (idbarang) REFERENCES barang(idbarang)
);

CREATE TABLE kartu_stok (
  idkartu_stok BIGINT PRIMARY KEY,
  jenis_transaksi CHAR(1),
  masuk INT,
  keluar INT,
  stock INT,
  created_at TIMESTAMP,
  idtransaksi INT,
  idbarang INT,
  FOREIGN KEY (idbarang) REFERENCES barang(idbarang)
);