-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 17, 2026 at 06:05 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `skripsi_yu`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `knn_prediction_histories`
--

CREATE TABLE `knn_prediction_histories` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_siswa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nilai_matematika` tinyint UNSIGNED NOT NULL,
  `nilai_ipa` tinyint UNSIGNED NOT NULL,
  `nilai_ips` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `nilai_bahasa_indonesia` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `nilai_pjok` tinyint UNSIGNED NOT NULL,
  `nilai_seni_budaya` tinyint UNSIGNED NOT NULL,
  `minat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prestasi_non_akademik` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `k_value` tinyint UNSIGNED NOT NULL,
  `hasil_rekomendasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tetangga_terdekat` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `knn_prediction_histories`
--

INSERT INTO `knn_prediction_histories` (`id`, `nama_siswa`, `nilai_matematika`, `nilai_ipa`, `nilai_ips`, `nilai_bahasa_indonesia`, `nilai_pjok`, `nilai_seni_budaya`, `minat`, `prestasi_non_akademik`, `k_value`, `hasil_rekomendasi`, `tetangga_terdekat`, `created_at`, `updated_at`) VALUES
(27, 'Abdi Wijaya', 83, 81, 84, 80, 81, 85, 'Otomatis', 0, 3, 'Voli', '[{\"rank\": 21, \"jarak\": 3, \"nilai\": {\"IPA\": 81, \"IPS\": 84, \"PJOK\": 83, \"Matematika\": 83, \"Seni Budaya\": 83, \"Bahasa Indonesia\": 79}, \"nama_siswa\": \"MUTIA RAMADHANI\", \"ekstrakurikuler\": \"Voli\", \"selisih_kuadrat\": {\"IPA\": 0, \"IPS\": 0, \"PJOK\": 4, \"Matematika\": 0, \"Seni Budaya\": 4, \"Bahasa Indonesia\": 1}, \"total_selisih_kuadrat\": 9}, {\"rank\": 20, \"jarak\": 3.873, \"nilai\": {\"IPA\": 81, \"IPS\": 85, \"PJOK\": 83, \"Matematika\": 83, \"Seni Budaya\": 86, \"Bahasa Indonesia\": 83}, \"nama_siswa\": \"ANNISA PUTRI FAUZIAH\", \"ekstrakurikuler\": \"Voli\", \"selisih_kuadrat\": {\"IPA\": 0, \"IPS\": 1, \"PJOK\": 4, \"Matematika\": 0, \"Seni Budaya\": 1, \"Bahasa Indonesia\": 9}, \"total_selisih_kuadrat\": 15}, {\"rank\": 19, \"jarak\": 4.2426, \"nilai\": {\"IPA\": 83, \"IPS\": 84, \"PJOK\": 83, \"Matematika\": 83, \"Seni Budaya\": 84, \"Bahasa Indonesia\": 83}, \"nama_siswa\": \"AZZARIA THALITA ARYANDI\", \"ekstrakurikuler\": \"Tahfiz\", \"selisih_kuadrat\": {\"IPA\": 4, \"IPS\": 0, \"PJOK\": 4, \"Matematika\": 0, \"Seni Budaya\": 1, \"Bahasa Indonesia\": 9}, \"total_selisih_kuadrat\": 18}]', '2026-06-11 03:54:01', '2026-06-11 03:54:01'),
(28, 'Abdi Wijaya', 83, 81, 84, 80, 81, 85, 'Otomatis', 0, 3, 'Voli', '[{\"rank\": 21, \"jarak\": 3, \"nilai\": {\"IPA\": 81, \"IPS\": 84, \"PJOK\": 83, \"Matematika\": 83, \"Seni Budaya\": 83, \"Bahasa Indonesia\": 79}, \"nama_siswa\": \"MUTIA RAMADHANI\", \"ekstrakurikuler\": \"Voli\", \"selisih_kuadrat\": {\"IPA\": 0, \"IPS\": 0, \"PJOK\": 4, \"Matematika\": 0, \"Seni Budaya\": 4, \"Bahasa Indonesia\": 1}, \"total_selisih_kuadrat\": 9}, {\"rank\": 20, \"jarak\": 3.873, \"nilai\": {\"IPA\": 81, \"IPS\": 85, \"PJOK\": 83, \"Matematika\": 83, \"Seni Budaya\": 86, \"Bahasa Indonesia\": 83}, \"nama_siswa\": \"ANNISA PUTRI FAUZIAH\", \"ekstrakurikuler\": \"Voli\", \"selisih_kuadrat\": {\"IPA\": 0, \"IPS\": 1, \"PJOK\": 4, \"Matematika\": 0, \"Seni Budaya\": 1, \"Bahasa Indonesia\": 9}, \"total_selisih_kuadrat\": 15}, {\"rank\": 19, \"jarak\": 4.2426, \"nilai\": {\"IPA\": 83, \"IPS\": 84, \"PJOK\": 83, \"Matematika\": 83, \"Seni Budaya\": 84, \"Bahasa Indonesia\": 83}, \"nama_siswa\": \"AZZARIA THALITA ARYANDI\", \"ekstrakurikuler\": \"Tahfiz\", \"selisih_kuadrat\": {\"IPA\": 4, \"IPS\": 0, \"PJOK\": 4, \"Matematika\": 0, \"Seni Budaya\": 1, \"Bahasa Indonesia\": 9}, \"total_selisih_kuadrat\": 18}]', '2026-06-11 08:13:24', '2026-06-11 08:13:24'),
(29, 'Abdi Wijaya', 83, 81, 84, 80, 81, 85, 'Otomatis', 0, 3, 'Voli', '[{\"rank\": 21, \"jarak\": 3, \"nilai\": {\"IPA\": 81, \"IPS\": 84, \"PJOK\": 83, \"Matematika\": 83, \"Seni Budaya\": 83, \"Bahasa Indonesia\": 79}, \"nama_siswa\": \"MUTIA RAMADHANI\", \"ekstrakurikuler\": \"Voli\", \"selisih_kuadrat\": {\"IPA\": 0, \"IPS\": 0, \"PJOK\": 4, \"Matematika\": 0, \"Seni Budaya\": 4, \"Bahasa Indonesia\": 1}, \"total_selisih_kuadrat\": 9}, {\"rank\": 20, \"jarak\": 3.873, \"nilai\": {\"IPA\": 81, \"IPS\": 85, \"PJOK\": 83, \"Matematika\": 83, \"Seni Budaya\": 86, \"Bahasa Indonesia\": 83}, \"nama_siswa\": \"ANNISA PUTRI FAUZIAH\", \"ekstrakurikuler\": \"Voli\", \"selisih_kuadrat\": {\"IPA\": 0, \"IPS\": 1, \"PJOK\": 4, \"Matematika\": 0, \"Seni Budaya\": 1, \"Bahasa Indonesia\": 9}, \"total_selisih_kuadrat\": 15}, {\"rank\": 19, \"jarak\": 4.2426, \"nilai\": {\"IPA\": 83, \"IPS\": 84, \"PJOK\": 83, \"Matematika\": 83, \"Seni Budaya\": 84, \"Bahasa Indonesia\": 83}, \"nama_siswa\": \"AZZARIA THALITA ARYANDI\", \"ekstrakurikuler\": \"Tahfiz\", \"selisih_kuadrat\": {\"IPA\": 4, \"IPS\": 0, \"PJOK\": 4, \"Matematika\": 0, \"Seni Budaya\": 1, \"Bahasa Indonesia\": 9}, \"total_selisih_kuadrat\": 18}]', '2026-06-11 08:21:39', '2026-06-11 08:21:39'),
(30, 'Rerey', 83, 81, 84, 80, 81, 85, 'Otomatis', 0, 9, 'Musik', '[{\"rank\": 21, \"jarak\": 3, \"nilai\": {\"IPA\": 81, \"IPS\": 84, \"PJOK\": 83, \"Matematika\": 83, \"Seni Budaya\": 83, \"Bahasa Indonesia\": 79}, \"nama_siswa\": \"MUTIA RAMADHANI\", \"ekstrakurikuler\": \"Voli\", \"selisih_kuadrat\": {\"IPA\": 0, \"IPS\": 0, \"PJOK\": 4, \"Matematika\": 0, \"Seni Budaya\": 4, \"Bahasa Indonesia\": 1}, \"total_selisih_kuadrat\": 9}, {\"rank\": 20, \"jarak\": 3.873, \"nilai\": {\"IPA\": 81, \"IPS\": 85, \"PJOK\": 83, \"Matematika\": 83, \"Seni Budaya\": 86, \"Bahasa Indonesia\": 83}, \"nama_siswa\": \"ANNISA PUTRI FAUZIAH\", \"ekstrakurikuler\": \"Voli\", \"selisih_kuadrat\": {\"IPA\": 0, \"IPS\": 1, \"PJOK\": 4, \"Matematika\": 0, \"Seni Budaya\": 1, \"Bahasa Indonesia\": 9}, \"total_selisih_kuadrat\": 15}, {\"rank\": 19, \"jarak\": 4.2426, \"nilai\": {\"IPA\": 83, \"IPS\": 84, \"PJOK\": 83, \"Matematika\": 83, \"Seni Budaya\": 84, \"Bahasa Indonesia\": 83}, \"nama_siswa\": \"AZZARIA THALITA ARYANDI\", \"ekstrakurikuler\": \"Tahfiz\", \"selisih_kuadrat\": {\"IPA\": 4, \"IPS\": 0, \"PJOK\": 4, \"Matematika\": 0, \"Seni Budaya\": 1, \"Bahasa Indonesia\": 9}, \"total_selisih_kuadrat\": 18}, {\"rank\": 25, \"jarak\": 4.5826, \"nilai\": {\"IPA\": 77, \"IPS\": 83, \"PJOK\": 83, \"Matematika\": 83, \"Seni Budaya\": 85, \"Bahasa Indonesia\": 80}, \"nama_siswa\": \"KIARA SALSABILLA\", \"ekstrakurikuler\": \"Voli\", \"selisih_kuadrat\": {\"IPA\": 16, \"IPS\": 1, \"PJOK\": 4, \"Matematika\": 0, \"Seni Budaya\": 0, \"Bahasa Indonesia\": 0}, \"total_selisih_kuadrat\": 21}, {\"rank\": 24, \"jarak\": 6.9282, \"nilai\": {\"IPA\": 76, \"IPS\": 83, \"PJOK\": 85, \"Matematika\": 82, \"Seni Budaya\": 84, \"Bahasa Indonesia\": 78}, \"nama_siswa\": \"AZZAHRA\", \"ekstrakurikuler\": \"Tahfiz\", \"selisih_kuadrat\": {\"IPA\": 25, \"IPS\": 1, \"PJOK\": 16, \"Matematika\": 1, \"Seni Budaya\": 1, \"Bahasa Indonesia\": 4}, \"total_selisih_kuadrat\": 48}, {\"rank\": 13, \"jarak\": 7.4162, \"nilai\": {\"IPA\": 81, \"IPS\": 85, \"PJOK\": 83, \"Matematika\": 83, \"Seni Budaya\": 86, \"Bahasa Indonesia\": 87}, \"nama_siswa\": \"AZZAHRA ADENG PRATIWI\", \"ekstrakurikuler\": \"Musik\", \"selisih_kuadrat\": {\"IPA\": 0, \"IPS\": 1, \"PJOK\": 4, \"Matematika\": 0, \"Seni Budaya\": 1, \"Bahasa Indonesia\": 49}, \"total_selisih_kuadrat\": 55}, {\"rank\": 18, \"jarak\": 8.124, \"nilai\": {\"IPA\": 80, \"IPS\": 86, \"PJOK\": 85, \"Matematika\": 83, \"Seni Budaya\": 91, \"Bahasa Indonesia\": 83}, \"nama_siswa\": \"FEBI ANISA PUTRI\", \"ekstrakurikuler\": \"Musik\", \"selisih_kuadrat\": {\"IPA\": 1, \"IPS\": 4, \"PJOK\": 16, \"Matematika\": 0, \"Seni Budaya\": 36, \"Bahasa Indonesia\": 9}, \"total_selisih_kuadrat\": 66}, {\"rank\": 9, \"jarak\": 8.1854, \"nilai\": {\"IPA\": 85, \"IPS\": 85, \"PJOK\": 84, \"Matematika\": 84, \"Seni Budaya\": 91, \"Bahasa Indonesia\": 82}, \"nama_siswa\": \"ANDIKA SAPUTRA\", \"ekstrakurikuler\": \"Musik\", \"selisih_kuadrat\": {\"IPA\": 16, \"IPS\": 1, \"PJOK\": 9, \"Matematika\": 1, \"Seni Budaya\": 36, \"Bahasa Indonesia\": 4}, \"total_selisih_kuadrat\": 67}, {\"rank\": 23, \"jarak\": 8.7178, \"nilai\": {\"IPA\": 78, \"IPS\": 81, \"PJOK\": 86, \"Matematika\": 81, \"Seni Budaya\": 80, \"Bahasa Indonesia\": 78}, \"nama_siswa\": \"SALSHA AMANDA PUTRI\", \"ekstrakurikuler\": \"Musik\", \"selisih_kuadrat\": {\"IPA\": 9, \"IPS\": 9, \"PJOK\": 25, \"Matematika\": 4, \"Seni Budaya\": 25, \"Bahasa Indonesia\": 4}, \"total_selisih_kuadrat\": 76}]', '2026-06-12 08:40:19', '2026-06-12 08:40:19'),
(31, 'Rerey', 83, 81, 84, 80, 81, 85, 'Otomatis', 0, 9, 'Musik', '[{\"rank\": 21, \"jarak\": 3, \"nilai\": {\"IPA\": 81, \"IPS\": 84, \"PJOK\": 83, \"Matematika\": 83, \"Seni Budaya\": 83, \"Bahasa Indonesia\": 79}, \"nama_siswa\": \"MUTIA RAMADHANI\", \"ekstrakurikuler\": \"Voli\", \"selisih_kuadrat\": {\"IPA\": 0, \"IPS\": 0, \"PJOK\": 4, \"Matematika\": 0, \"Seni Budaya\": 4, \"Bahasa Indonesia\": 1}, \"total_selisih_kuadrat\": 9}, {\"rank\": 20, \"jarak\": 3.873, \"nilai\": {\"IPA\": 81, \"IPS\": 85, \"PJOK\": 83, \"Matematika\": 83, \"Seni Budaya\": 86, \"Bahasa Indonesia\": 83}, \"nama_siswa\": \"ANNISA PUTRI FAUZIAH\", \"ekstrakurikuler\": \"Voli\", \"selisih_kuadrat\": {\"IPA\": 0, \"IPS\": 1, \"PJOK\": 4, \"Matematika\": 0, \"Seni Budaya\": 1, \"Bahasa Indonesia\": 9}, \"total_selisih_kuadrat\": 15}, {\"rank\": 19, \"jarak\": 4.2426, \"nilai\": {\"IPA\": 83, \"IPS\": 84, \"PJOK\": 83, \"Matematika\": 83, \"Seni Budaya\": 84, \"Bahasa Indonesia\": 83}, \"nama_siswa\": \"AZZARIA THALITA ARYANDI\", \"ekstrakurikuler\": \"Tahfiz\", \"selisih_kuadrat\": {\"IPA\": 4, \"IPS\": 0, \"PJOK\": 4, \"Matematika\": 0, \"Seni Budaya\": 1, \"Bahasa Indonesia\": 9}, \"total_selisih_kuadrat\": 18}, {\"rank\": 25, \"jarak\": 4.5826, \"nilai\": {\"IPA\": 77, \"IPS\": 83, \"PJOK\": 83, \"Matematika\": 83, \"Seni Budaya\": 85, \"Bahasa Indonesia\": 80}, \"nama_siswa\": \"KIARA SALSABILLA\", \"ekstrakurikuler\": \"Voli\", \"selisih_kuadrat\": {\"IPA\": 16, \"IPS\": 1, \"PJOK\": 4, \"Matematika\": 0, \"Seni Budaya\": 0, \"Bahasa Indonesia\": 0}, \"total_selisih_kuadrat\": 21}, {\"rank\": 24, \"jarak\": 6.9282, \"nilai\": {\"IPA\": 76, \"IPS\": 83, \"PJOK\": 85, \"Matematika\": 82, \"Seni Budaya\": 84, \"Bahasa Indonesia\": 78}, \"nama_siswa\": \"AZZAHRA\", \"ekstrakurikuler\": \"Tahfiz\", \"selisih_kuadrat\": {\"IPA\": 25, \"IPS\": 1, \"PJOK\": 16, \"Matematika\": 1, \"Seni Budaya\": 1, \"Bahasa Indonesia\": 4}, \"total_selisih_kuadrat\": 48}, {\"rank\": 13, \"jarak\": 7.4162, \"nilai\": {\"IPA\": 81, \"IPS\": 85, \"PJOK\": 83, \"Matematika\": 83, \"Seni Budaya\": 86, \"Bahasa Indonesia\": 87}, \"nama_siswa\": \"AZZAHRA ADENG PRATIWI\", \"ekstrakurikuler\": \"Musik\", \"selisih_kuadrat\": {\"IPA\": 0, \"IPS\": 1, \"PJOK\": 4, \"Matematika\": 0, \"Seni Budaya\": 1, \"Bahasa Indonesia\": 49}, \"total_selisih_kuadrat\": 55}, {\"rank\": 18, \"jarak\": 8.124, \"nilai\": {\"IPA\": 80, \"IPS\": 86, \"PJOK\": 85, \"Matematika\": 83, \"Seni Budaya\": 91, \"Bahasa Indonesia\": 83}, \"nama_siswa\": \"FEBI ANISA PUTRI\", \"ekstrakurikuler\": \"Musik\", \"selisih_kuadrat\": {\"IPA\": 1, \"IPS\": 4, \"PJOK\": 16, \"Matematika\": 0, \"Seni Budaya\": 36, \"Bahasa Indonesia\": 9}, \"total_selisih_kuadrat\": 66}, {\"rank\": 9, \"jarak\": 8.1854, \"nilai\": {\"IPA\": 85, \"IPS\": 85, \"PJOK\": 84, \"Matematika\": 84, \"Seni Budaya\": 91, \"Bahasa Indonesia\": 82}, \"nama_siswa\": \"ANDIKA SAPUTRA\", \"ekstrakurikuler\": \"Musik\", \"selisih_kuadrat\": {\"IPA\": 16, \"IPS\": 1, \"PJOK\": 9, \"Matematika\": 1, \"Seni Budaya\": 36, \"Bahasa Indonesia\": 4}, \"total_selisih_kuadrat\": 67}, {\"rank\": 23, \"jarak\": 8.7178, \"nilai\": {\"IPA\": 78, \"IPS\": 81, \"PJOK\": 86, \"Matematika\": 81, \"Seni Budaya\": 80, \"Bahasa Indonesia\": 78}, \"nama_siswa\": \"SALSHA AMANDA PUTRI\", \"ekstrakurikuler\": \"Musik\", \"selisih_kuadrat\": {\"IPA\": 9, \"IPS\": 9, \"PJOK\": 25, \"Matematika\": 4, \"Seni Budaya\": 25, \"Bahasa Indonesia\": 4}, \"total_selisih_kuadrat\": 76}]', '2026-06-12 08:41:43', '2026-06-12 08:41:43'),
(32, 'Siswa Baru', 85, 85, 85, 85, 85, 85, 'Otomatis', 0, 3, 'Tahfiz', '[{\"rank\": 19, \"jarak\": 4.2426, \"nilai\": {\"IPA\": 83, \"IPS\": 84, \"PJOK\": 83, \"Matematika\": 83, \"Seni Budaya\": 84, \"Bahasa Indonesia\": 83}, \"nama_siswa\": \"AZZARIA THALITA ARYANDI\", \"ekstrakurikuler\": \"Tahfiz\", \"selisih_kuadrat\": {\"IPA\": 4, \"IPS\": 1, \"PJOK\": 4, \"Matematika\": 4, \"Seni Budaya\": 1, \"Bahasa Indonesia\": 4}, \"total_selisih_kuadrat\": 18}, {\"rank\": 11, \"jarak\": 4.3589, \"nilai\": {\"IPA\": 86, \"IPS\": 88, \"PJOK\": 84, \"Matematika\": 83, \"Seni Budaya\": 85, \"Bahasa Indonesia\": 87}, \"nama_siswa\": \"NADA FAJRIA SAL SABILA\", \"ekstrakurikuler\": \"Paskibraka\", \"selisih_kuadrat\": {\"IPA\": 1, \"IPS\": 9, \"PJOK\": 1, \"Matematika\": 4, \"Seni Budaya\": 0, \"Bahasa Indonesia\": 4}, \"total_selisih_kuadrat\": 19}, {\"rank\": 13, \"jarak\": 5.3852, \"nilai\": {\"IPA\": 81, \"IPS\": 85, \"PJOK\": 83, \"Matematika\": 83, \"Seni Budaya\": 86, \"Bahasa Indonesia\": 87}, \"nama_siswa\": \"AZZAHRA ADENG PRATIWI\", \"ekstrakurikuler\": \"Musik\", \"selisih_kuadrat\": {\"IPA\": 16, \"IPS\": 0, \"PJOK\": 4, \"Matematika\": 4, \"Seni Budaya\": 1, \"Bahasa Indonesia\": 4}, \"total_selisih_kuadrat\": 29}]', '2026-06-12 09:10:46', '2026-06-12 09:10:46'),
(33, 'Abdi Wijaya', 83, 81, 84, 80, 81, 85, 'Otomatis', 0, 3, 'Voli', '[{\"rank\": 21, \"jarak\": 3, \"nilai\": {\"IPA\": 81, \"IPS\": 84, \"PJOK\": 83, \"Matematika\": 83, \"Seni Budaya\": 83, \"Bahasa Indonesia\": 79}, \"nama_siswa\": \"MUTIA RAMADHANI\", \"ekstrakurikuler\": \"Voli\", \"selisih_kuadrat\": {\"IPA\": 0, \"IPS\": 0, \"PJOK\": 4, \"Matematika\": 0, \"Seni Budaya\": 4, \"Bahasa Indonesia\": 1}, \"total_selisih_kuadrat\": 9}, {\"rank\": 20, \"jarak\": 3.873, \"nilai\": {\"IPA\": 81, \"IPS\": 85, \"PJOK\": 83, \"Matematika\": 83, \"Seni Budaya\": 86, \"Bahasa Indonesia\": 83}, \"nama_siswa\": \"ANNISA PUTRI FAUZIAH\", \"ekstrakurikuler\": \"Voli\", \"selisih_kuadrat\": {\"IPA\": 0, \"IPS\": 1, \"PJOK\": 4, \"Matematika\": 0, \"Seni Budaya\": 1, \"Bahasa Indonesia\": 9}, \"total_selisih_kuadrat\": 15}, {\"rank\": 19, \"jarak\": 4.2426, \"nilai\": {\"IPA\": 83, \"IPS\": 84, \"PJOK\": 83, \"Matematika\": 83, \"Seni Budaya\": 84, \"Bahasa Indonesia\": 83}, \"nama_siswa\": \"AZZARIA THALITA ARYANDI\", \"ekstrakurikuler\": \"Tahfiz\", \"selisih_kuadrat\": {\"IPA\": 4, \"IPS\": 0, \"PJOK\": 4, \"Matematika\": 0, \"Seni Budaya\": 1, \"Bahasa Indonesia\": 9}, \"total_selisih_kuadrat\": 18}]', '2026-06-12 18:51:05', '2026-06-12 18:51:05');

-- --------------------------------------------------------

--
-- Table structure for table `knn_training_samples`
--

CREATE TABLE `knn_training_samples` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_siswa` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nilai_matematika` tinyint UNSIGNED NOT NULL,
  `nilai_ipa` tinyint UNSIGNED NOT NULL,
  `nilai_ips` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `nilai_bahasa_indonesia` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `nilai_pjok` tinyint UNSIGNED NOT NULL,
  `nilai_seni_budaya` tinyint UNSIGNED NOT NULL,
  `minat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prestasi_non_akademik` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `rank` int UNSIGNED NOT NULL DEFAULT '999',
  `ekstrakurikuler` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `knn_training_samples`
--

INSERT INTO `knn_training_samples` (`id`, `nama_siswa`, `nilai_matematika`, `nilai_ipa`, `nilai_ips`, `nilai_bahasa_indonesia`, `nilai_pjok`, `nilai_seni_budaya`, `minat`, `prestasi_non_akademik`, `rank`, `ekstrakurikuler`, `created_at`, `updated_at`) VALUES
(369, 'ADAM ROMARTA', 84, 88, 88, 95, 88, 91, 'Tidak Dicantumkan', 0, 2, 'Voli', '2026-06-10 09:06:51', '2026-06-10 09:06:51'),
(370, 'AISYA VANDRILLA', 83, 81, 89, 80, 83, 93, 'Tidak Dicantumkan', 0, 17, 'Tari', '2026-06-10 09:06:51', '2026-06-10 09:06:51'),
(371, 'AJRA TUILHAM', 72, 75, 77, 75, 82, 73, 'Tidak Dicantumkan', 0, 31, 'Basket', '2026-06-10 09:06:51', '2026-06-10 09:06:51'),
(372, 'ANDIKA SAPUTRA', 84, 85, 85, 82, 84, 91, 'Tidak Dicantumkan', 0, 9, 'Musik', '2026-06-10 09:06:51', '2026-06-10 09:06:51'),
(373, 'ANNISA PUTRI FAUZIAH', 83, 81, 85, 83, 83, 86, 'Tidak Dicantumkan', 0, 20, 'Voli', '2026-06-10 09:06:51', '2026-06-10 09:06:51'),
(374, 'AYUNDA WULANDARI', 83, 82, 84, 85, 83, 92, 'Tidak Dicantumkan', 0, 16, 'Musik', '2026-06-10 09:06:51', '2026-06-10 09:06:51'),
(375, 'AZKA APRILLIO AMLI', 83, 90, 84, 88, 84, 89, 'Tidak Dicantumkan', 0, 12, 'Musik', '2026-06-10 09:06:51', '2026-06-10 09:06:51'),
(376, 'AZZAHRA', 82, 76, 83, 78, 85, 84, 'Tidak Dicantumkan', 0, 24, 'Tahfiz', '2026-06-10 09:06:51', '2026-06-10 09:06:51'),
(377, 'AZZAHRA ADENG PRATIWI', 83, 81, 85, 87, 83, 86, 'Tidak Dicantumkan', 0, 13, 'Musik', '2026-06-10 09:06:51', '2026-06-10 09:06:51'),
(378, 'AZZARIA THALITA ARYANDI', 83, 83, 84, 83, 83, 84, 'Tidak Dicantumkan', 0, 19, 'Tahfiz', '2026-06-10 09:06:51', '2026-06-10 09:06:51'),
(379, 'DAFFA MUHAMMAD AKBAR', 85, 90, 87, 94, 84, 91, 'Tidak Dicantumkan', 0, 6, 'Marching Band', '2026-06-10 09:06:51', '2026-06-10 09:06:51'),
(380, 'EGI ALFAREZI', 82, 85, 87, 87, 86, 94, 'Tidak Dicantumkan', 0, 10, 'Musik', '2026-06-10 09:06:51', '2026-06-10 09:06:51'),
(381, 'ERYN DWI AZ ZAHRA', 84, 94, 93, 94, 86, 90, 'Tidak Dicantumkan', 0, 1, 'Tari', '2026-06-10 09:06:51', '2026-06-10 09:06:51'),
(382, 'FAJRI', 76, 78, 85, 77, 85, 84, 'Tidak Dicantumkan', 0, 28, 'Musik', '2026-06-10 09:06:51', '2026-06-10 09:06:51'),
(383, 'FARIS', 78, 78, 80, 77, 80, 80, 'Tidak Dicantumkan', 0, 27, 'Basket', '2026-06-10 09:06:51', '2026-06-10 09:06:51'),
(384, 'FATHIMAH NABILA', 83, 86, 90, 96, 86, 87, 'Tidak Dicantumkan', 0, 4, 'Tahfiz', '2026-06-10 09:06:51', '2026-06-10 09:06:51'),
(385, 'FEBI ANISA PUTRI', 83, 80, 86, 83, 85, 91, 'Tidak Dicantumkan', 0, 18, 'Musik', '2026-06-10 09:06:51', '2026-06-10 09:06:51'),
(386, 'FUTIHAT RIZKIYAH FADHLIL', 84, 85, 90, 88, 90, 93, 'Tidak Dicantumkan', 0, 3, 'Basket', '2026-06-10 09:06:51', '2026-06-10 09:06:51'),
(387, 'GIBRAN KHALFANI ARDIANSYAH HAR', 83, 83, 89, 95, 82, 91, 'Tidak Dicantumkan', 0, 15, 'Musik', '2026-06-10 09:06:51', '2026-06-10 09:06:51'),
(388, 'HAIKAL HUSNAYAN ADNAN', 83, 82, 84, 78, 83, 95, 'Tidak Dicantumkan', 0, 14, 'Marching Band', '2026-06-10 09:06:51', '2026-06-10 09:06:51'),
(389, 'INDRI FEBRIA DINATA', 83, 82, 88, 91, 83, 95, 'Tidak Dicantumkan', 0, 7, 'Musik', '2026-06-10 09:06:51', '2026-06-10 09:06:51'),
(390, 'KIARA SALSABILLA', 83, 77, 83, 80, 83, 85, 'Tidak Dicantumkan', 0, 25, 'Voli', '2026-06-10 09:06:51', '2026-06-10 09:06:51'),
(391, 'MARTA APRIL ANANDA', 83, 75, 77, 78, 86, 76, 'Tidak Dicantumkan', 0, 29, 'Musik', '2026-06-10 09:06:51', '2026-06-10 09:06:51'),
(392, 'MUHAMMAD AQIL MUQSITH', 81, 81, 85, 78, 86, 77, 'Tidak Dicantumkan', 0, 26, 'Marching Band', '2026-06-10 09:06:51', '2026-06-10 09:06:51'),
(393, 'MUHAMMAD IQBAL', 79, 77, 86, 81, 86, 77, 'Tidak Dicantumkan', 0, 22, 'Musik', '2026-06-10 09:06:51', '2026-06-10 09:06:51'),
(394, 'MUTIA RAMADHANI', 83, 81, 84, 79, 83, 83, 'Tidak Dicantumkan', 0, 21, 'Voli', '2026-06-10 09:06:51', '2026-06-10 09:06:51'),
(395, 'NADA FAJRIA SAL SABILA', 83, 86, 88, 87, 84, 85, 'Tidak Dicantumkan', 0, 11, 'Paskibraka', '2026-06-10 09:06:51', '2026-06-10 09:06:51'),
(396, 'NAFADIL', 75, 73, 72, 75, 86, 72, 'Tidak Dicantumkan', 0, 30, 'Sepakbola', '2026-06-10 09:06:51', '2026-06-10 09:06:51'),
(397, 'REZA MUHAMMAD VELEFI', 73, 76, 72, 75, 86, 72, 'Tidak Dicantumkan', 0, 32, 'Marching Band', '2026-06-10 09:06:51', '2026-06-10 09:06:51'),
(398, 'SALSHA AMANDA PUTRI', 81, 78, 81, 78, 86, 80, 'Tidak Dicantumkan', 0, 23, 'Musik', '2026-06-10 09:06:51', '2026-06-10 09:06:51'),
(399, 'ZACKY APRILIO', 83, 91, 87, 91, 86, 91, 'Tidak Dicantumkan', 0, 8, 'Marching Band', '2026-06-10 09:06:51', '2026-06-10 09:06:51'),
(400, 'ZAHIRA AZALIA QISYA', 83, 85, 84, 87, 90, 88, 'Tidak Dicantumkan', 0, 5, 'Voli', '2026-06-10 09:06:51', '2026-06-10 09:06:51');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_05_29_000001_create_knn_training_samples_table', 1),
(5, '2026_05_29_000002_create_knn_prediction_histories_table', 1),
(6, '2026_05_31_000003_add_ips_and_bahasa_indonesia_to_knn_tables', 2),
(7, '2026_06_02_000001_add_role_to_users_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('1HpOrKnwTyamZqJthyG0D9iuCMvVH0NkgNuHQawF', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/149.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJJQ0VWejVJcUpUY3NxWUZkaDZXQlc1ZlZhTUYyV0RjdWFQV1ZoM25FIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwIiwicm91dGUiOiJrbm4uaW5kZXgifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6M30=', 1781278980),
('1LUbQ8Sq3M0YcDuwxkFOr2uR1z2CpRVxCOxamWOM', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/149.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJLSFNwNkJXdmxDaDN2T3plWjZOdXhtMXBTQ2NIMHV2WnF2WElMaFozIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwIiwicm91dGUiOiJrbm4uaW5kZXgifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6M30=', 1781279049),
('5UFldLo3kGqwHKaeBytN18IYFd9goA6f05tx0rGL', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/149.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJVT1pkY1Z5Q0hHWVBaNFpUdndYNXFnbEZrWklvbnh2UWo3Um9Ub1N6IiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvbG9jYWxob3N0OjgwMDBcL2xvZ2luIiwicm91dGUiOiJsb2dpbiJ9fQ==', 1781280663),
('Hh5SJoO9MpoRoQ5ZkxkbyEkz9WPGUtfUkuiEirsd', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJ5Zmk5R213NjQzYjhkU3NqSG9JaTdWWjN3RWZVVU1xNnlTRkpudEJjIiwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDAifSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOiJrbm4uaW5kZXgifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6Mn0=', 1781278217),
('KWaYiVzrwy1Ue6IHbD4TafXRQPltH7ftcCraWwrd', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/149.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiI5SmtjbG5JWVNhakpoZlJrWXlUQU00dWVZS0J2ZHpTcDVtWTBxVFdlIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwIiwicm91dGUiOiJrbm4uaW5kZXgifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6Mn0=', 1781278820),
('MXEJv4mCTc7eZZoq9SmlR6OkEHMjsXqebhrojjNG', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/149.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJ4N0N6YnJKNHlyNVFLd0JPcUlhY3ZLRUg4dXdkV2YzYUlLWEVvQ2V2IiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvbG9jYWxob3N0OjgwMDAiLCJyb3V0ZSI6Imtubi5pbmRleCJ9LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6M30=', 1781278915),
('O3oZsmKu8epnH0sPem4KXCiajmQKwivEgb0A13ql', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiI5QzVrbFlVQ0UzM2VUblV2S2s0NnNUUmw3VjlDeWVOaDBjcFB2a3ZFIiwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDAifSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOiJrbm4uaW5kZXgifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6Mn0=', 1781315466),
('z0eniLhYxl9h2hyMnP8AVWisVikG9SHOk6oEVfy4', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/149.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJTSE54QmYyZWVvM1kydUlFeWNhQ0FDamJPOFc0ZlQ4c1pmWFpoVE9UIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwIiwicm91dGUiOiJrbm4uaW5kZXgifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6M30=', 1781280931);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'siswa',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Test User', 'test@example.com', NULL, '$2y$12$7/fWqsFq4UYqXPSRslQpDeXujzNBrrWlLExQLYqrcWxV1081l6H.u', 'admin', NULL, '2026-05-29 01:40:07', '2026-06-02 05:10:57'),
(2, 'Admin Ekskul', 'admin@example.com', NULL, '$2y$12$aL.8KVdNG/V2gZ9rxFUcKe.gpNR0Qu27vqb4Gky2kife0s90q9pnK', 'admin', '1Z6xjNpcEFPkDruG3hsijhCefoQBCtq0GZGhZ6aYdbgT2Zb139btpkKEro3d', '2026-06-02 05:07:36', '2026-06-02 05:10:56'),
(3, 'Siswa Ekskul', 'siswa@example.com', NULL, '$2y$12$qnKarkKLV/o4/rfJDbhjt.ruOfbPBOz2PghflKfxk31qWMFITSk/2', 'siswa', NULL, '2026-06-02 05:07:37', '2026-06-02 05:10:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `knn_prediction_histories`
--
ALTER TABLE `knn_prediction_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `knn_training_samples`
--
ALTER TABLE `knn_training_samples`
  ADD PRIMARY KEY (`id`),
  ADD KEY `knn_training_samples_ekstrakurikuler_minat_index` (`ekstrakurikuler`,`minat`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `knn_prediction_histories`
--
ALTER TABLE `knn_prediction_histories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `knn_training_samples`
--
ALTER TABLE `knn_training_samples`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=401;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
