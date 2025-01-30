-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 30-Jan-2025 às 17:37
-- Versão do servidor: 10.4.27-MariaDB
-- versão do PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `db_academia`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `aluno`
--

CREATE TABLE `aluno` (
  `aluno_cod` int(11) NOT NULL,
  `aluno_nome` text NOT NULL,
  `aluno_cpf` varchar(20) NOT NULL,
  `aluno_endereco` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `aluno`
--

INSERT INTO `aluno` (`aluno_cod`, `aluno_nome`, `aluno_cpf`, `aluno_endereco`) VALUES
(5, 'julia', '30445', 'Rua jardim'),
(6, 'Luiz', '33322', 'Rua Longe'),
(7, 'Cibely', '88844', 'Rua Dois'),
(8, 'Ana Maria', '65667', 'Rua da luz'),
(9, 'Catarina', '222233', 'Rua Dois'),
(10, 'Claudio', '556677', 'Rua dos banzeiros'),
(11, 'Flavio', '77456', 'Avenida Brasil');

-- --------------------------------------------------------

--
-- Estrutura da tabela `aula`
--

CREATE TABLE `aula` (
  `aula_cod` int(11) NOT NULL,
  `aula_tipo` varchar(200) NOT NULL,
  `aula_data` datetime NOT NULL,
  `fk_instrutor_cod` int(11) NOT NULL,
  `fk_aluno_cod` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `aula`
--

INSERT INTO `aula` (`aula_cod`, `aula_tipo`, `aula_data`, `fk_instrutor_cod`, `fk_aluno_cod`) VALUES
(1, 'zumba', '2025-01-30 15:42:48', 1, 10),
(2, 'natação', '2025-01-30 15:44:17', 2, 11),
(3, 'Crossfit', '2025-01-30 15:44:42', 3, 9),
(4, 'musculação', '2025-01-30 15:45:05', 4, 6),
(5, 'yoga', '2025-01-30 15:45:39', 5, 8),
(6, 'Pilates', '2025-01-30 15:46:12', 6, 8),
(7, 'Boxe', '2025-01-30 15:46:27', 7, 7);

-- --------------------------------------------------------

--
-- Estrutura da tabela `instrutores`
--

CREATE TABLE `instrutores` (
  `instrutor_cod` int(11) NOT NULL,
  `instrutor_nome` text NOT NULL,
  `instrutor_especialidade` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `instrutores`
--

INSERT INTO `instrutores` (`instrutor_cod`, `instrutor_nome`, `instrutor_especialidade`) VALUES
(1, 'amanda', 'zumba'),
(2, 'Beatriz', 'Natação'),
(3, 'Pedro', 'Crossfit'),
(4, 'Mario', 'Musculação'),
(5, 'Júlia', 'Yoga'),
(6, 'Roberto', 'pilates'),
(7, 'Adriano', 'Boxe');

-- --------------------------------------------------------

--
-- Estrutura da tabela `telefone`
--

CREATE TABLE `telefone` (
  `telefone_cod` int(11) NOT NULL,
  `fk_aluno_cod` int(11) NOT NULL,
  `telefone` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `telefone`
--

INSERT INTO `telefone` (`telefone_cod`, `fk_aluno_cod`, `telefone`) VALUES
(2, 5, '888888'),
(3, 6, '999999'),
(4, 7, '777777'),
(5, 8, '666666'),
(6, 9, '666666'),
(7, 10, '555555'),
(8, 11, '444444');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `aluno`
--
ALTER TABLE `aluno`
  ADD PRIMARY KEY (`aluno_cod`);

--
-- Índices para tabela `aula`
--
ALTER TABLE `aula`
  ADD PRIMARY KEY (`aula_cod`),
  ADD KEY `fk_aluno_cod` (`fk_aluno_cod`),
  ADD KEY `fk_instrutor_cod` (`fk_instrutor_cod`);

--
-- Índices para tabela `instrutores`
--
ALTER TABLE `instrutores`
  ADD PRIMARY KEY (`instrutor_cod`);

--
-- Índices para tabela `telefone`
--
ALTER TABLE `telefone`
  ADD PRIMARY KEY (`telefone_cod`),
  ADD KEY `fk_aluno_cod` (`fk_aluno_cod`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `aluno`
--
ALTER TABLE `aluno`
  MODIFY `aluno_cod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `aula`
--
ALTER TABLE `aula`
  MODIFY `aula_cod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `instrutores`
--
ALTER TABLE `instrutores`
  MODIFY `instrutor_cod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `telefone`
--
ALTER TABLE `telefone`
  MODIFY `telefone_cod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `aula`
--
ALTER TABLE `aula`
  ADD CONSTRAINT `aula_ibfk_1` FOREIGN KEY (`fk_aluno_cod`) REFERENCES `aluno` (`aluno_cod`),
  ADD CONSTRAINT `aula_ibfk_2` FOREIGN KEY (`fk_instrutor_cod`) REFERENCES `instrutores` (`instrutor_cod`);

--
-- Limitadores para a tabela `telefone`
--
ALTER TABLE `telefone`
  ADD CONSTRAINT `telefone_ibfk_1` FOREIGN KEY (`fk_aluno_cod`) REFERENCES `aluno` (`aluno_cod`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
