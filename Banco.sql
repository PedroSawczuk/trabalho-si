CREATE DATABASE 'trabalho_si';

USE 'trabalho_si';

CREATE TABLE `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `permissao` varchar(50) NOT NULL,
  `data_cadastro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB AUTO_INCREMENT = 15 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

CREATE TABLE `vendedores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int DEFAULT NULL,
  `nome_loja` varchar(255) NOT NULL,
  `categorias` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `vendedores_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`)
) ENGINE = InnoDB AUTO_INCREMENT = 6 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

CREATE TABLE `produtos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `vendedor_id` int DEFAULT NULL,
  `nome` varchar(255) NOT NULL,
  `valor` decimal(10, 2) NOT NULL,
  `descricao` text,
  `foto` blob,
  PRIMARY KEY (`id`),
  KEY `vendedor_id` (`vendedor_id`),
  CONSTRAINT `produtos_ibfk_1` FOREIGN KEY (`vendedor_id`) REFERENCES `vendedores` (`id`)
) ENGINE = InnoDB AUTO_INCREMENT = 19 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

INSERT INTO `usuarios` VALUES
  (2, 'kaleb', 'kaleb@gmail.com', '$2y$10$kLxCd4O.ePNiOJchAAOPeeUJvKMDoLxImm0FBXz.NRw2B8zXqkeDO', '', '2024-03-04 18:04:07'),
  (6, 'ruthynathyelle', 'ruthynathyelle@gmail.com', '$2y$10$SCzWEeDW/005o9xpbKxqJ.Qs/vlDTzIC.h1O5DO.GuRtNFdB6uLIe', 'admin', '2024-03-04 18:17:56'),
  (7, 'juniorcardoso', 'juniorcardoso@gmail.com', '$2y$10$M51dmhTvL2bWCVd.CSpFC.TSSGWpDBHd/YaQkav7SkS034nQQI9tK', 'admin', '2024-03-04 18:18:23'),
  (8, 'josestevao', 'josestevao@gmail.com', '$2y$10$4GgIb8AcRvCJfNb2rKwdreVaYB9eaDOxMN4miSF7zcbNLwoaW9zJ.', 'vendedor', '2024-03-04 18:35:08'),
  (10, 'marcos', 'marcos@gmail.com', '$2y$10$fLkulMbMBXt6s2jxyAU7Se4sXBuyEiZGy.WMyddFKC5Wbw/GGzm7.', 'Cliente', '2024-03-04 18:40:54'),
  (11, 'mylena', 'mylena@gmail.com', '$2y$10$sBVUDQsIK2QNHuxqs1xbNuVVIRrsqDOsDeey7fGHugd9JyYXFHLPq', 'vendedor', '2024-03-05 14:25:38'),
  (13, 'pedrosawczuk', 'pedrosawczuk@gmail.com', '$2y$10$miSc1HAUyK9/onhnC23Udu/CuIDQl/5o363d0ElqqteKhE7ztYeSa', 'admin', '2024-03-08 14:39:43'),
  (14, 'topolniak', 'topolniak@gmail.com', '$2y$10$shUyjPPxceatmXzWs3sjTuFarQkSe8O49Tu6Oduy0z6If498UmGUW', 'Admin', '2024-03-08 14:52:42');

INSERT INTO `vendedores` VALUES
  (3, 2, 'KalebStore', 'esportes'),
  (4, 8, 'GalodaMassa', 'esportes'),
  (5, 11, 'Compass', 'software');

INSERT INTO `produtos` VALUES
  (16, 4, 'Camisa do Galo', 199.90, 'Camiseta do Galo', _binary '../media/produtos/GalodaMassa/fotos/produto-65e73146a8b75.jpg'),
  (17, 4, 'Camiseta Atlético Mineiro', 199.90, 'Camiseta Atlético Mineiro', _binary '../media/produtos/GalodaMassa/fotos/produto-2.jpg'),
  (18, 5, 'Intel I5 10Th', 970.05, 'Processador Intel', _binary '../media/produtos/Compass/fotos/produto-1.png');

