-- --------------------------------------------------------
-- Servidor:                     localhost
-- Versão do servidor:           5.7.33 - MySQL Community Server (GPL)
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Copiando dados para a tabela api-laravel.clientes: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` (`recnum`, `empresa`, `codigo`, `razao_social`, `tipo`, `cpf_cnpj`, `created_at`, `updated_at`) VALUES
	(11, 7979, 1742150895, 'EmpresN1', 'PF', '42871079858', '2025-03-16 18:48:15', '2025-03-17 14:03:34'),
	(12, 6456, 1742152244, 'EmpresN2', 'PJ', '14545545455455', '2025-03-16 19:10:45', '2025-03-16 19:10:45'),
	(13, 7777, 1742152327, 'EmpresN3', 'PF', '44455588895', '2025-03-16 19:12:07', '2025-03-16 19:12:07');
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;

-- Copiando dados para a tabela api-laravel.empresas: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `empresas` DISABLE KEYS */;
INSERT INTO `empresas` (`recnum`, `codigo`, `empresa`, `sigla`, `razao_social`, `created_at`, `updated_at`) VALUES
	(7, 7979, 2315, 'EN1', 'EmpresN1', '2025-03-16 18:39:23', '2025-03-16 18:40:04'),
	(8, 6456, 5465, 'EN2', 'EmpresN2', '2025-03-16 18:47:21', '2025-03-16 18:47:21'),
	(9, 7777, 7878, 'EN3', 'EmpresN3', '2025-03-16 18:47:36', '2025-03-17 13:28:26');
/*!40000 ALTER TABLE `empresas` ENABLE KEYS */;

-- Copiando dados para a tabela api-laravel.failed_jobs: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;

-- Copiando dados para a tabela api-laravel.migrations: ~6 rows (aproximadamente)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2025_03_15_164933_create_empresas_table', 2),
	(6, '2025_03_15_164934_create_clientes_table', 2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Copiando dados para a tabela api-laravel.password_reset_tokens: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;

-- Copiando dados para a tabela api-laravel.personal_access_tokens: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;

-- Copiando dados para a tabela api-laravel.users: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
