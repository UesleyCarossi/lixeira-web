-- --------------------------------------------------------

--
-- Estrutura da tabela `evento_imagem`
--

CREATE TABLE `evento_imagem` (
  `id` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nome` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `data` mediumblob NOT NULL,
  `evento` int(11) UNSIGNED NOT NULL,
  FOREIGN KEY (`evento`) REFERENCES `evento`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
