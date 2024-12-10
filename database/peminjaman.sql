-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 10, 2024 at 02:35 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */
;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */
;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */
;
/*!40101 SET NAMES utf8mb4 */
;

--
-- Database: `peminjaman`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_aktivitas`
--

CREATE TABLE `tb_aktivitas` (
    `id_aktivitas` int NOT NULL,
    `pengguna` varchar(100) NOT NULL,
    `jenis_aktivitas` varchar(50) NOT NULL,
    `keterangan` text NOT NULL,
    `waktu` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_aktivitas`
--

INSERT INTO
    `tb_aktivitas` (
        `id_aktivitas`,
        `pengguna`,
        `jenis_aktivitas`,
        `keterangan`,
        `waktu`
    )
VALUES (
        1,
        'staff1',
        'create_peminjaman',
        'Peminjaman baru dibuat untuk ruangan: R004',
        '2024-12-09 05:25:03'
    ),
    (
        2,
        'admin123',
        'create_user',
        'User baru dibuat: user user',
        '2024-12-09 05:34:21'
    ),
    (
        3,
        'admin1234',
        'create_user',
        'User baru dibuat: user user',
        '2024-12-09 05:36:23'
    ),
    (
        4,
        'admin1234',
        'update_user',
        'User user user telah diperbarui',
        '2024-12-09 05:41:44'
    ),
    (
        5,
        'admin1234',
        'delete_user',
        'User admin1234 telah dihapus',
        '2024-12-09 05:46:12'
    ),
    (
        6,
        '5',
        'delete_peminjaman',
        'Peminjaman 5 telah dihapus',
        '2024-12-09 05:48:47'
    ),
    (
        7,
        'admin',
        'create_ruangan',
        'Ruangan baru ditambahkan: Kelas-04',
        '2024-12-09 05:51:44'
    ),
    (
        8,
        'admin',
        'delete_ruangan',
        'Ruangan R004 telah dihapus',
        '2024-12-09 05:51:51'
    ),
    (
        9,
        'admin',
        'create_peminjaman',
        'Peminjaman baru dibuat untuk ruangan: R002',
        '2024-12-09 05:53:05'
    ),
    (
        10,
        'admin',
        'update_peminjaman',
        'Peminjaman telah diupdate untuk ruangan: R002',
        '2024-12-09 05:53:13'
    ),
    (
        11,
        'admin',
        'delete_peminjaman',
        'Peminjaman 10 telah dihapus',
        '2024-12-09 05:53:17'
    ),
    (
        12,
        'leonardo',
        'create_user',
        'User baru dibuat: Leonardo Start',
        '2024-12-09 07:29:19'
    ),
    (
        13,
        'admin',
        'create_ruangan',
        'Ruangan baru ditambahkan: Kelas-04',
        '2024-12-09 07:29:41'
    ),
    (
        14,
        'leonardo',
        'create_peminjaman',
        'Peminjaman baru dibuat untuk ruangan: R004',
        '2024-12-09 07:30:34'
    ),
    (
        15,
        'admin',
        'create_ruangan',
        'Ruangan baru ditambahkan: Kelas-05',
        '2024-12-09 13:53:09'
    ),
    (
        16,
        'admin',
        'update_peminjaman',
        'Peminjaman telah diupdate untuk ruangan: R001',
        '2024-12-09 13:55:25'
    ),
    (
        17,
        'admin111',
        'create_user',
        'User baru dibuat: leon',
        '2024-12-10 09:23:55'
    ),
    (
        18,
        'leonardo',
        'create_peminjaman',
        'Peminjaman baru dibuat untuk ruangan: R005',
        '2024-12-10 09:25:08'
    ),
    (
        19,
        'leonardo',
        'update_peminjaman',
        'Peminjaman telah diupdate untuk ruangan: R005',
        '2024-12-10 09:25:21'
    ),
    (
        20,
        'admin',
        'create_user',
        'User baru dibuat: Andi Amalia Ramadani',
        '2024-12-10 09:45:37'
    ),
    (
        21,
        'admin',
        'create_peminjaman',
        'Peminjaman baru dibuat untuk ruangan: R005',
        '2024-12-10 09:46:25'
    ),
    (
        22,
        'admin',
        'update_peminjaman',
        'Peminjaman telah diupdate untuk ruangan: R005',
        '2024-12-10 09:46:35'
    ),
    (
        23,
        'admin',
        'create_user',
        'User baru dibuat: popol',
        '2024-12-10 09:55:02'
    );

-- --------------------------------------------------------

--
-- Table structure for table `tb_detail_peminjaman`
--

CREATE TABLE `tb_detail_peminjaman` (
    `id_detail_peminjaman` int NOT NULL,
    `id_peminjaman` int NOT NULL,
    `tanggal_pinjam` date NOT NULL,
    `tanggal_pengembalian` date DEFAULT NULL,
    `kondisi_kelas_awal` enum('baik', 'kurang', 'buruk') NOT NULL,
    `status` enum(
        'belum dikembalikan',
        'telah dikembalikan'
    ) DEFAULT 'belum dikembalikan',
    `kondisi_kelas_pengembalian` enum('baik', 'kurang', 'buruk') DEFAULT NULL,
    `keterangan` text
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_detail_peminjaman`
--

INSERT INTO
    `tb_detail_peminjaman` (
        `id_detail_peminjaman`,
        `id_peminjaman`,
        `tanggal_pinjam`,
        `tanggal_pengembalian`,
        `kondisi_kelas_awal`,
        `status`,
        `kondisi_kelas_pengembalian`,
        `keterangan`
    )
VALUES (
        1,
        1,
        '2024-12-09',
        '2024-12-12',
        'baik',
        'belum dikembalikan',
        'baik',
        'hallo'
    ),
    (
        2,
        11,
        '2024-12-11',
        '2024-12-16',
        'baik',
        'belum dikembalikan',
        'kurang',
        'lapor ke kepsek jika sudah dipinjam'
    ),
    (
        3,
        12,
        '2024-12-10',
        '2024-12-11',
        'baik',
        'belum dikembalikan',
        'baik',
        'saat'
    );

-- --------------------------------------------------------

--
-- Table structure for table `tb_peminjaman`
--

CREATE TABLE `tb_peminjaman` (
    `id_peminjaman` int NOT NULL,
    `id_ruangan` varchar(10) NOT NULL,
    `username` varchar(10) NOT NULL,
    `waktu_pengajuan` datetime NOT NULL,
    `waktu_penyetujuan` datetime DEFAULT NULL,
    `waktu_pengembalian` datetime DEFAULT NULL,
    `status_pinjam` enum(
        'Diajukan',
        'Disetujui',
        'Menunggu',
        'Ditolak'
    ) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Diajukan',
    `keterangan` varchar(255) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_peminjaman`
--

INSERT INTO
    `tb_peminjaman` (
        `id_peminjaman`,
        `id_ruangan`,
        `username`,
        `waktu_pengajuan`,
        `waktu_penyetujuan`,
        `waktu_pengembalian`,
        `status_pinjam`,
        `keterangan`
    )
VALUES (
        1,
        'R001',
        'staff1',
        '2024-12-13 20:08:00',
        NULL,
        NULL,
        'Disetujui',
        'wasa'
    ),
    (
        3,
        'R001',
        'admin',
        '2024-12-27 23:17:00',
        NULL,
        NULL,
        'Menunggu',
        'aa'
    ),
    (
        11,
        'R004',
        'leonardo',
        '2024-12-09 07:29:00',
        NULL,
        NULL,
        'Diajukan',
        'Rapat'
    ),
    (
        12,
        'R005',
        'leonardo',
        '2024-12-10 09:25:00',
        NULL,
        NULL,
        'Disetujui',
        'saa'
    ),
    (
        13,
        'R005',
        'Amelia',
        '2024-12-10 09:45:00',
        NULL,
        NULL,
        'Disetujui',
        'tunggu kepsek'
    );

-- --------------------------------------------------------

--
-- Table structure for table `tb_ruangan`
--

CREATE TABLE `tb_ruangan` (
    `id_ruangan` varchar(10) NOT NULL,
    `nama_ruangan` varchar(50) NOT NULL,
    `status` enum('Tersedia', 'Dipinjam') NOT NULL DEFAULT 'Tersedia'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_ruangan`
--

INSERT INTO
    `tb_ruangan` (
        `id_ruangan`,
        `nama_ruangan`,
        `status`
    )
VALUES (
        'R001',
        'Kelas-01',
        'Dipinjam'
    ),
    (
        'R002',
        'Kelas-02',
        'Tersedia'
    ),
    (
        'R003',
        'Kelas-03',
        'Dipinjam'
    ),
    (
        'R004',
        'Kelas-04',
        'Tersedia'
    ),
    (
        'R005',
        'Kelas-05',
        'Tersedia'
    );

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
    `username` varchar(10) NOT NULL,
    `fullname` varchar(50) NOT NULL,
    `password` varchar(255) NOT NULL,
    `level` enum('Admin', 'User', 'Staff') NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_user`
--

INSERT INTO
    `tb_user` (
        `username`,
        `fullname`,
        `password`,
        `level`
    )
VALUES (
        'admin',
        'Administrator',
        '$2y$10$1MCOgmXGCYn5Lw.nJDPVY.Vy.qUKbTMidgDbwLRY980o12HpZA4Q2',
        'Admin'
    ),
    (
        'admin111',
        'leon',
        '$2y$10$vR.igXba11usa8Sn6r1tEuNHRGHCu2O0GrPtOjKAzsbUVTo7kr9I.',
        'Admin'
    ),
    (
        'admin123',
        'user user',
        '$2y$10$8o.05ZScqE4mb.qqwz3iRuzWt0/Oitx3jHeJwiIaYrW1hImJ98fJu',
        'Admin'
    ),
    (
        'Amelia',
        'Andi Amalia Ramadani',
        '$2y$10$sGVpLe9EEKauQI.9xTeuv.9LnW27SrnXF5hnP0mtggtCvf9RF/bfi',
        'User'
    ),
    (
        'leonardo',
        'Leonardo Start',
        '$2y$10$mF9qLcLzxP9O3KJj73AcJuOlwbIg9PaS0Bvu.cniqU2hxlJqN9vIi',
        'Admin'
    ),
    (
        'popol',
        'popol',
        '$2y$10$NNvV601IHdhQAlrjvMx7aeD7bBD/MRacYxs7VenENsaruH.k.7iv.',
        'Admin'
    ),
    (
        'staff1',
        'Staff Satu',
        '$2y$10$4xbJ4t.621ecQiNmOKuqXux3sw2JQmRhVLx6PqMAGBiOZ54F2YsZu',
        'Staff'
    );

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_aktivitas`
--
ALTER TABLE `tb_aktivitas` ADD PRIMARY KEY (`id_aktivitas`);

--
-- Indexes for table `tb_detail_peminjaman`
--
ALTER TABLE `tb_detail_peminjaman`
ADD PRIMARY KEY (`id_detail_peminjaman`),
ADD KEY `fk_peminjaman` (`id_peminjaman`);

--
-- Indexes for table `tb_peminjaman`
--
ALTER TABLE `tb_peminjaman`
ADD PRIMARY KEY (`id_peminjaman`),
ADD KEY `fk_peminjaman_ruangan` (`id_ruangan`),
ADD KEY `fk_peminjaman_user` (`username`);

--
-- Indexes for table `tb_ruangan`
--
ALTER TABLE `tb_ruangan` ADD PRIMARY KEY (`id_ruangan`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user` ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_aktivitas`
--
ALTER TABLE `tb_aktivitas`
MODIFY `id_aktivitas` int NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 24;

--
-- AUTO_INCREMENT for table `tb_detail_peminjaman`
--
ALTER TABLE `tb_detail_peminjaman`
MODIFY `id_detail_peminjaman` int NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 4;

--
-- AUTO_INCREMENT for table `tb_peminjaman`
--
ALTER TABLE `tb_peminjaman`
MODIFY `id_peminjaman` int NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_detail_peminjaman`
--
ALTER TABLE `tb_detail_peminjaman`
ADD CONSTRAINT `fk_peminjaman` FOREIGN KEY (`id_peminjaman`) REFERENCES `tb_peminjaman` (`id_peminjaman`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_peminjaman`
--
ALTER TABLE `tb_peminjaman`
ADD CONSTRAINT `fk_peminjaman_ruangan` FOREIGN KEY (`id_ruangan`) REFERENCES `tb_ruangan` (`id_ruangan`) ON DELETE CASCADE,
ADD CONSTRAINT `fk_peminjaman_user` FOREIGN KEY (`username`) REFERENCES `tb_user` (`username`) ON DELETE CASCADE;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
;