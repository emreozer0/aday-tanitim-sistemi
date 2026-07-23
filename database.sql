-- phpMyAdmin SQL Dump
-- Aday Tanıtım Sistemi - Veritabanı Şeması
-- Bu dosya sadece tablo yapılarını içerir, örnek veri barındırmaz.
-- Kurulum sonrası admin paneli üzerinden içerikleri kendiniz ekleyebilirsiniz.

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `aday_tanitim_db`
--

-- --------------------------------------------------------

CREATE TABLE `admin_kullanicilar` (
  `id` int(11) NOT NULL,
  `kullanici_adi` varchar(50) NOT NULL,
  `sifre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE `ayarlar` (
  `id` int(11) NOT NULL,
  `anahtar` varchar(50) NOT NULL,
  `deger` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE `galeri` (
  `id` int(11) NOT NULL,
  `fotograf` varchar(255) NOT NULL,
  `olusturma_tarihi` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE `haberler` (
  `id` int(11) NOT NULL,
  `baslik` varchar(255) NOT NULL,
  `icerik` text DEFAULT NULL,
  `fotograf` varchar(255) DEFAULT NULL,
  `tarih` date NOT NULL,
  `olusturma_tarihi` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE `hizmet_kartlari` (
  `id` int(11) NOT NULL,
  `baslik` varchar(100) NOT NULL,
  `sira` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE `iletisim_mesajlari` (
  `id` int(11) NOT NULL,
  `ad_soyad` varchar(100) NOT NULL,
  `eposta` varchar(100) NOT NULL,
  `telefon` varchar(20) DEFAULT NULL,
  `mesaj` text NOT NULL,
  `gonderim_tarihi` timestamp NOT NULL DEFAULT current_timestamp(),
  `okundu_mu` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE `ozgecmis` (
  `id` int(11) NOT NULL,
  `icerik` text DEFAULT NULL,
  `fotograf` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- İndeksler
--

ALTER TABLE `admin_kullanicilar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kullanici_adi` (`kullanici_adi`);

ALTER TABLE `ayarlar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `anahtar` (`anahtar`);

ALTER TABLE `galeri`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `haberler`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `hizmet_kartlari`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `iletisim_mesajlari`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ozgecmis`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT değerleri
--

ALTER TABLE `admin_kullanicilar` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `ayarlar` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `galeri` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `haberler` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `hizmet_kartlari` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `iletisim_mesajlari` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `ozgecmis` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;