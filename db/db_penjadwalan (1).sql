-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 07 Agu 2024 pada 06.45
-- Versi server: 10.3.16-MariaDB
-- Versi PHP: 7.1.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_penjadwalan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `constraint`
--

CREATE TABLE `constraint` (
  `id_constraint` int(7) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `jenis` enum('soft','hard') NOT NULL,
  `konstanta` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `constraint`
--

INSERT INTO `constraint` (`id_constraint`, `keterangan`, `jenis`, `konstanta`) VALUES
(1, 'Perawat mendapatkan shift malam kembali  atau libur setelah shift malam', 'soft', 15),
(2, 'Perawat maksimal mendaptkan shift malam sebanyak 2 kali secara berturut turut .', 'soft', 15),
(3, 'Perawat yang mengisi permohonan jadwal harus mendapatkan jadwal sesuai permohonan', 'soft', 15),
(4, 'Perawat yang sedang hamil tidak boleh mendapatkan shift malam lebih dari 2 kali di setiap periode jadwal shift', 'soft', 15),
(5, 'Perawat tidak boleh mendapakan jadwal shift ketika sedang mengajukan cuti', 'hard', 40);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cuti`
--

CREATE TABLE `cuti` (
  `id_cuti` int(7) NOT NULL,
  `id_perawat` int(7) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `perawat_pengganti` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `cuti`
--

INSERT INTO `cuti` (`id_cuti`, `id_perawat`, `tanggal_mulai`, `tanggal_selesai`, `keterangan`, `perawat_pengganti`) VALUES
(1, 5, '2024-07-10', '2024-07-12', 'cuti hamil', 'keyla'),
(2, 5, '2024-07-30', '2024-08-01', 'cuti nifas', 'keyla '),
(3, 5, '2024-07-04', '2024-07-06', 'ke malaysia', 'keylaa');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal`
--

CREATE TABLE `jadwal` (
  `id_jadwal` int(7) NOT NULL,
  `hari` varchar(20) NOT NULL,
  `tanggal` date NOT NULL,
  `waktu_shift` varchar(20) NOT NULL,
  `status` varchar(50) NOT NULL,
  `id_perawat` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kebutuhan_shift`
--

CREATE TABLE `kebutuhan_shift` (
  `id_kebutuhanshift` int(7) NOT NULL,
  `waktu_shift` varchar(100) NOT NULL,
  `kebutuhan` int(7) NOT NULL,
  `unit` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `kebutuhan_shift`
--

INSERT INTO `kebutuhan_shift` (`id_kebutuhanshift`, `waktu_shift`, `kebutuhan`, `unit`) VALUES
(1, 'pagi', 7, 'nusa indah'),
(2, 'siang', 6, 'nusa indah'),
(3, 'malam', 5, 'nusa indah');

-- --------------------------------------------------------

--
-- Struktur dari tabel `perawat`
--

CREATE TABLE `perawat` (
  `id_perawat` int(7) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jenis_kelamin` enum('laki-laki','perempuan') NOT NULL,
  `unit` varchar(100) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `alamat` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `perawat`
--

INSERT INTO `perawat` (`id_perawat`, `username`, `password`, `nama`, `jenis_kelamin`, `unit`, `jabatan`, `status`, `alamat`) VALUES
(1, 'adminpenjadwalan', 'adminpenjadwalan123', 'deniwijaya', 'laki-laki', 'sistem informasii', 'admin penjadwalan', '', 'jl. narogong xi'),
(4, 'miladewisri', 'miladewisri123', 'mila dewi sri', 'perempuan', 'rekam medis', 'ketua tim', '', 'jl. merpati no 11'),
(5, 'daynooou', 'Bisa123', 'jihaan nabiilah', 'perempuan', 'rekam medis', 'perawat pelaksana', '', 'Perumahan Kota Harapan Indah, Cluster Ifolia XII, Blok HY12 No.26 RT 4., Pusaka Rakyat, Taruma Jaya,, Bekasi 17214'),
(6, 'kkaaiiaa', 'kkaaiiaa123', 'kaia qanita', 'laki-laki', 'rekam medis', 'perawat pelaksana', '', 'jl. merpati '),
(8, 'dwianna', 'dwianna', 'Dwi Anna Yudianti, Bsc.AMd.MIKRM', 'perempuan', 'Rekam Medis', 'Kepala Unit', '', 'Jl. Narogong No XI '),
(9, 'rachmadhidayat', 'rachmadhidayat', 'Rachmad Hidayat, SE', 'laki-laki', 'Rekam Medis', 'Perawat Pelaksana', '', 'Jl. Mustikajaya No.112 '),
(10, 'iikadika', 'iikadika', 'Iik Adika Hardian, SE', 'laki-laki', 'rekam medis', 'perawat pelaksana', '', 'Gg. Haji Naim No.14'),
(11, 'baihaqiluthfi', 'baihaqiluthfi', 'Baihaqi Luthfi AMd.KOM', 'laki-laki', 'rekam medis', 'perawat pelaksana', '', 'Jl. Neo N0.9'),
(12, 'ibnudanang', 'ibnudanang', 'Danang Ibnu Pamungkas', 'laki-laki', 'rekam medis', 'perawat pelaksana', '', 'Jl. Haji Ismail No. 118 '),
(13, 'dedeherdin', 'dedeherdin', 'Dede Herdin', 'laki-laki', 'rekam medis', 'perawat pelaksana', '', 'jl. Iskandar No.112 Tangerang'),
(14, 'suburarif', 'suburarif', 'Subur Arifin', 'laki-laki', 'rekam medis', 'perawat pelaksana', '', 'Jl. Raya Gede No.14'),
(15, 'sitilatifah', 'sitilatifah', 'Siti Latifah', 'perempuan', 'rekam medis', 'perawat pelaksana', '', 'Gg. Lebak No.112'),
(16, 'trivanadju', 'trivanadju', 'Trivina Fjuniarti Puspitasari, AMK', 'perempuan', 'icu', 'kepala unit', '', 'Jl Cemara No.08'),
(17, 'syafaatun', 'syafaatun', 'Syafaatun Yuliyarti', 'perempuan', 'icu', 'ketua tim', '', 'Jl. Anggrek No 14 Suka Asih'),
(18, 'jihaanazhaar', 'jihaanazhaar', 'Jihaan Azhaar Farahwati, A.Md. Kep', 'perempuan', 'icu', 'perawat pelaksana', '', 'Jl. Narogong No.XI'),
(19, 'adriyantiher', 'adiyantiher', 'Adriyanti Herawat, A.Md.Kep', 'perempuan', 'icu', 'perawat pelaksana', '', 'jl. Baru Raya Barat No. 14'),
(20, 'tirtamelia', 'tirtamelia', 'Ns. Tirta Melia, S. Kep', 'perempuan', 'nusa indah', 'perawat pelaksana', '', 'jl nusa indah no 112'),
(21, 'yulianti', 'yulianti', 'Yulianti, AMK', 'perempuan', 'nusa indah', 'perawat pelaksana', '', 'jl nusa indah no 112'),
(22, 'zahrotunnisa', 'zahrotunnisa', 'Zahrotun Nisa, A.Md. Kep', 'perempuan', 'nusa indah', 'perawat pelaksana', '', 'jl nusa indah no 112'),
(23, 'nurulkhotimah', 'nurulkhotimah', 'Nurul Khotimah, A.Md. Kep', 'perempuan', 'nusa indah', 'perawat pelaksana', '', 'jl nusa indah no 112'),
(24, 'arianhidayatulloh', 'arianhidayatulloh', 'Arian Hidayatulloh, A.Md. Kep', 'perempuan', 'nusa indah', 'perawat pelaksana', '', 'jl nusa indah no 112'),
(25, 'lestariputri', 'lestariputri', 'Lestari Putri, A.Md. Kep', 'perempuan', 'nusa indah', 'perawat pelaksana', '', 'jl nusa indah no 112'),
(26, 'yonapravita', 'yonapravita', 'Yona Pravita, S. Kep', 'perempuan', 'nusa indah', 'perawat pelaksana', 'hamil', 'jl nusa indah no 112'),
(27, 'yulinuryati', 'yulinuryati', 'Yuli Nuryati, AMK', 'perempuan', 'nusa indah', 'perawat pelaksana', '', 'jl nusa indah no 112'),
(28, 'tutimurdianti', 'tutimurdianti', 'Ns. Tuti Murdianti, S. Kep', 'perempuan', 'nusa indah', 'perawat pelaksana', '', 'jl nusa indah no 112'),
(29, 'juniriani', 'juniriani', 'Juni Riani, AMK', 'perempuan', 'nusa indah', 'perawat pelaksana', '', 'jl nusa indah no 112'),
(30, 'khoribnur', 'khoribnur', 'Khorib Nur, A.Md. Kep', 'perempuan', 'nusa indah', 'perawat pelaksana', '', 'jl nusa indah no 112'),
(31, 'winarti', 'winarti', 'Winarti, A.Md. Kep', 'perempuan', 'nusa indah', 'perawat pelaksana', '', 'jl nusa indah no 112'),
(32, 'mellymulyawati', 'mellymulyawati', 'Melly Mulyawati, A.Md. Kep', 'perempuan', 'nusa indah', 'perawat pelaksana', '', 'jl nusa indah no 112'),
(33, 'novitalimbongtiku', 'novitalimbongtiku', 'Ns. Novita Limbongtiku, S. Kep', 'perempuan', 'nusa indah', 'perawat pelaksana', '', 'jl nusa indah no 112'),
(34, 'tatikwahyu', 'tatikwahyu', 'Ns. Tatik Wahyu, S. Kep', 'perempuan', 'nusa indah', 'perawat pelaksana', '', 'jl nusa indah no 112'),
(35, 'yowsaibra', 'yowsaibra', 'Ns. Yowsa Ibra, S. Kep', 'perempuan', 'nusa indah', 'perawat pelaksana', '', 'jl nusa indah no 112'),
(36, 'nurmamegawati', 'nurmamegawati', 'Ns. Nurma Megawati, S. Kep', 'perempuan', 'nusa indah', 'perawat pelaksana', '', 'jl nusa indah no 112'),
(37, 'sukmahambali', 'sukmahambali', 'Ns. M. Sukma Hambali, S. Kep', 'perempuan', 'nusa indah', 'perawat pelaksana', '', 'jl nusa indah no 112'),
(38, 'inkasaputri', 'inkasaputri', 'Ns. Inka Saputri, S. Kep', 'perempuan', 'nusa indah', 'perawat pelaksana', '', 'jl nusa indah no 112'),
(39, 'irmapurnama', 'irmapurnama', 'Irma Purnama', 'perempuan', 'nusa indah', 'POS', '', 'jl nusa indah no 112'),
(40, 'nurazizah', 'nurazizah', 'Nur Azizah', 'perempuan', 'nusa indah', 'POS', '', 'jl nusa indah no 112'),
(41, 'itarosita', 'itarosita', 'Ita Rosita', 'perempuan', 'nusa indah', 'POS', '', 'jl nusa indah no 112'),
(42, 'dianselvia', 'dianselvia', 'Dian Selvia, AMK', 'perempuan', 'nusa indah', 'kepala unit', '', 'jl nusa indah no 12'),
(43, 'indrihapijiah', 'indrihapijiah', 'Ns. Indri Hapijiah, S. Kep', 'perempuan', 'nusa indah', 'ketua tim', '', 'jl pramuka no 113');

-- --------------------------------------------------------

--
-- Struktur dari tabel `permohonan_jadwal`
--

CREATE TABLE `permohonan_jadwal` (
  `id_permohonan` int(7) NOT NULL,
  `id_perawat` int(7) NOT NULL,
  `hari` varchar(20) NOT NULL,
  `tanggal` date NOT NULL,
  `waktu_shift` varchar(20) NOT NULL,
  `keterangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `permohonan_jadwal`
--

INSERT INTO `permohonan_jadwal` (`id_permohonan`, `id_perawat`, `hari`, `tanggal`, `waktu_shift`, `keterangan`) VALUES
(1, 4, 'senin', '2024-07-01', 'pagi', 'mau belanja ke arab'),
(2, 4, 'kamis', '2024-07-11', 'libur', 'mau renang di spanyol'),
(3, 5, 'senin', '2024-07-01', 'siang', 'ke bandung');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `constraint`
--
ALTER TABLE `constraint`
  ADD PRIMARY KEY (`id_constraint`);

--
-- Indeks untuk tabel `cuti`
--
ALTER TABLE `cuti`
  ADD PRIMARY KEY (`id_cuti`),
  ADD KEY `id_perawat` (`id_perawat`);

--
-- Indeks untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id_jadwal`);

--
-- Indeks untuk tabel `kebutuhan_shift`
--
ALTER TABLE `kebutuhan_shift`
  ADD PRIMARY KEY (`id_kebutuhanshift`);

--
-- Indeks untuk tabel `perawat`
--
ALTER TABLE `perawat`
  ADD PRIMARY KEY (`id_perawat`);

--
-- Indeks untuk tabel `permohonan_jadwal`
--
ALTER TABLE `permohonan_jadwal`
  ADD PRIMARY KEY (`id_permohonan`),
  ADD KEY `id_perawat` (`id_perawat`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `constraint`
--
ALTER TABLE `constraint`
  MODIFY `id_constraint` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `cuti`
--
ALTER TABLE `cuti`
  MODIFY `id_cuti` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id_jadwal` int(7) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kebutuhan_shift`
--
ALTER TABLE `kebutuhan_shift`
  MODIFY `id_kebutuhanshift` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `perawat`
--
ALTER TABLE `perawat`
  MODIFY `id_perawat` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT untuk tabel `permohonan_jadwal`
--
ALTER TABLE `permohonan_jadwal`
  MODIFY `id_permohonan` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `cuti`
--
ALTER TABLE `cuti`
  ADD CONSTRAINT `cuti_ibfk_1` FOREIGN KEY (`id_perawat`) REFERENCES `perawat` (`id_perawat`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `permohonan_jadwal`
--
ALTER TABLE `permohonan_jadwal`
  ADD CONSTRAINT `permohonan_jadwal_ibfk_1` FOREIGN KEY (`id_perawat`) REFERENCES `perawat` (`id_perawat`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
