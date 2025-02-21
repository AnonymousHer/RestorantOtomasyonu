-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 28 May 2022, 13:20:57
-- Sunucu sürümü: 10.4.21-MariaDB
-- PHP Sürümü: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `restaurant_otomasyonu`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `siparisler`
--

CREATE TABLE `siparisler` (
  `masaid` int(11) NOT NULL,
  `masa_ad` varchar(30) COLLATE utf8mb4_turkish_ci NOT NULL,
  `masa_id` int(11) NOT NULL,
  `masa_kisi` int(10) NOT NULL,
  `masa_bos` varchar(5) COLLATE utf8mb4_turkish_ci NOT NULL DEFAULT '1',
  `masa_tarih` datetime NOT NULL DEFAULT current_timestamp(),
  `kizartma_adet` int(3) NOT NULL,
  `kizartma` varchar(11) COLLATE utf8mb4_turkish_ci NOT NULL,
  `kizartma_TL` int(2) NOT NULL,
  `dolma_adet` int(11) NOT NULL,
  `dolma` varchar(55) COLLATE utf8mb4_turkish_ci NOT NULL,
  `dolma_TL` int(2) NOT NULL,
  `kurufasulye_adet` int(11) NOT NULL,
  `kurufasulye` varchar(50) COLLATE utf8mb4_turkish_ci NOT NULL,
  `kurufasulye_TL` int(2) NOT NULL,
  `patlican_adet` int(3) NOT NULL,
  `patlican` varchar(30) COLLATE utf8mb4_turkish_ci NOT NULL,
  `patlican_TL` int(2) NOT NULL,
  `bumbar_adet` int(3) NOT NULL,
  `bumbar` varchar(30) COLLATE utf8mb4_turkish_ci NOT NULL,
  `bumbar_TL` int(2) NOT NULL,
  `kellepaca_adet` int(3) NOT NULL,
  `kellepaca` varchar(30) COLLATE utf8mb4_turkish_ci NOT NULL,
  `kellepaca_TL` int(2) NOT NULL,
  `Meysu_adet` int(3) NOT NULL,
  `Meysu` varchar(30) COLLATE utf8mb4_turkish_ci NOT NULL,
  `Meysu_TL` int(2) NOT NULL,
  `ColaTurka_adet` int(3) NOT NULL,
  `ColaTurka` varchar(30) COLLATE utf8mb4_turkish_ci NOT NULL,
  `ColaTurka_TL` int(2) NOT NULL,
  `cappy_adet` int(3) NOT NULL,
  `cappy` varchar(30) COLLATE utf8mb4_turkish_ci NOT NULL,
  `cappy_TL` int(2) NOT NULL,
  `limonata_adet` int(11) NOT NULL,
  `limonata` varchar(30) COLLATE utf8mb4_turkish_ci NOT NULL,
  `limonata_TL` int(2) NOT NULL,
  `ayran_adet` int(3) NOT NULL,
  `ayran` varchar(30) COLLATE utf8mb4_turkish_ci NOT NULL,
  `ayran_TL` int(2) NOT NULL,
  `salgam_adet` int(3) NOT NULL,
  `salgam` varchar(30) COLLATE utf8mb4_turkish_ci NOT NULL,
  `salgam_TL` int(2) NOT NULL,
  `puding_adet` int(3) NOT NULL,
  `puding` varchar(30) COLLATE utf8mb4_turkish_ci NOT NULL,
  `puding_TL` int(2) NOT NULL,
  `sutlac_adet` int(3) NOT NULL,
  `sutlac` varchar(30) COLLATE utf8mb4_turkish_ci NOT NULL,
  `sutlac_TL` int(2) NOT NULL,
  `sekerpare_adet` int(3) NOT NULL,
  `sekerpare` varchar(30) COLLATE utf8mb4_turkish_ci NOT NULL,
  `sekerpare_TL` int(2) NOT NULL,
  `baklava_adet` int(3) NOT NULL,
  `baklava` varchar(30) COLLATE utf8mb4_turkish_ci NOT NULL,
  `baklava_TL` int(2) NOT NULL,
  `yaspasta_adet` int(3) NOT NULL,
  `yaspasta` varchar(30) COLLATE utf8mb4_turkish_ci NOT NULL,
  `yaspasta_TL` int(2) NOT NULL,
  `kemalpasa_adet` int(3) NOT NULL,
  `kemalpasa` varchar(30) COLLATE utf8mb4_turkish_ci NOT NULL,
  `kemalpasa_TL` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `siparisler`
--
ALTER TABLE `siparisler`
  ADD PRIMARY KEY (`masaid`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `siparisler`
--
ALTER TABLE `siparisler`
  MODIFY `masaid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
