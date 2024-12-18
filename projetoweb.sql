-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 18/12/2024 às 20:44
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `projetoweb`
--
CREATE DATABASE IF NOT EXISTS `projetoweb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `projetoweb`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `agendamentos`
--

CREATE TABLE `agendamentos` (
  `id` int(11) NOT NULL,
  `usuario_id` varchar(50) DEFAULT NULL,
  `id_disponibilidade` int(11) DEFAULT NULL,
  `data_agendamento` date DEFAULT NULL,
  `horario_inicio` time DEFAULT NULL,
  `horario_fim` time DEFAULT NULL,
  `status` enum('pendente','confirmado','aberto_com_ocorrencia','finalizado') DEFAULT NULL,
  `avaliacao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `agendamentos`
--

INSERT INTO `agendamentos` (`id`, `usuario_id`, `id_disponibilidade`, `data_agendamento`, `horario_inicio`, `horario_fim`, `status`, `avaliacao`) VALUES
(10, 'lmsolera', 6, '2024-12-25', '12:00:00', '18:00:00', 'finalizado', NULL),
(11, 'teste', 8, '2024-12-20', '14:00:00', '16:00:00', 'aberto_com_ocorrencia', 'Deixaram o ambiente muito sujo após o uso.'),
(12, 'hduarte', 6, '2024-12-25', '12:00:00', '18:00:00', 'confirmado', NULL),
(13, 'hduarte', 5, '2024-12-19', '14:00:00', '18:00:00', 'finalizado', NULL),
(14, 'lmsolera', 5, '2024-12-19', '14:00:00', '18:00:00', 'finalizado', NULL),
(15, 'teste', 5, '2024-12-19', '14:00:00', '18:00:00', 'finalizado', NULL),
(16, 'lmsolera', 5, '2024-12-19', '14:00:00', '18:00:00', 'finalizado', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `disponibilidade`
--

CREATE TABLE `disponibilidade` (
  `id` int(11) NOT NULL,
  `data` date NOT NULL,
  `horario_inicio` time NOT NULL,
  `horario_fim` time NOT NULL,
  `status` enum('livre','reservado') DEFAULT 'livre'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `disponibilidade`
--

INSERT INTO `disponibilidade` (`id`, `data`, `horario_inicio`, `horario_fim`, `status`) VALUES
(5, '2024-12-19', '14:00:00', '18:00:00', 'reservado'),
(6, '2024-12-25', '12:00:00', '18:00:00', 'reservado'),
(8, '2024-12-20', '14:00:00', '16:00:00', 'reservado'),
(9, '2024-12-22', '13:00:00', '16:00:00', 'livre'),
(10, '2024-12-22', '13:00:00', '16:00:00', 'reservado');

-- --------------------------------------------------------

--
-- Estrutura para tabela `espacos`
--

CREATE TABLE `espacos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL,
  `disponivel` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `espacos`
--

INSERT INTO `espacos` (`id`, `nome`, `descricao`, `disponivel`) VALUES
(1, 'Auditorio', 'Lugar bom ', 1),
(2, 'Auditorio', 'Lugar bom ', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `nomeusuario` varchar(50) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `senha` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`nomeusuario`, `nome`, `senha`) VALUES
('admin', 'Administrador', 'admin1248'),
('hduarte', 'Henrique Duarte', 'hduarte123'),
('lmsolera', 'Luis Miguel', 'lm123'),
('teste', 'Usuário Teste', 'teste123');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `agendamentos`
--
ALTER TABLE `agendamentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `id_disponibilidade` (`id_disponibilidade`);

--
-- Índices de tabela `disponibilidade`
--
ALTER TABLE `disponibilidade`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `espacos`
--
ALTER TABLE `espacos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`nomeusuario`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `agendamentos`
--
ALTER TABLE `agendamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `disponibilidade`
--
ALTER TABLE `disponibilidade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `espacos`
--
ALTER TABLE `espacos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `agendamentos`
--
ALTER TABLE `agendamentos`
  ADD CONSTRAINT `agendamentos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`nomeusuario`),
  ADD CONSTRAINT `agendamentos_ibfk_2` FOREIGN KEY (`id_disponibilidade`) REFERENCES `disponibilidade` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
