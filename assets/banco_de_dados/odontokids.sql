-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 08-Nov-2024 às 20:28
-- Versão do servidor: 10.4.22-MariaDB
-- versão do PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `odontokids`
CREATE DATABASE `odontokids`;
USE `odontokids`;
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `consulta`
--

CREATE TABLE `consulta` (
  `id` int(11) NOT NULL,
  `horario` time NOT NULL,
  `data` date NOT NULL,
  `id_dependente` int(11) NOT NULL,
  `cod_tratamento` int(11) NOT NULL,
  `relatorio` varchar(500) NOT NULL,
  `id_medico` int(11) NOT NULL,
  `id_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `consulta`
--

INSERT INTO `consulta` (`id`, `horario`, `data`, `id_dependente`, `cod_tratamento`, `relatorio`, `id_medico`, `id_status`) VALUES
(1, '09:15:00', '2024-12-05', 1, 1, '', 1, 1),
(2, '10:45:00', '2024-12-08', 2, 2, '', 2, 1),
(3, '11:20:00', '2024-12-10', 3, 3, '', 1, 1),
(4, '14:00:00', '2024-12-12', 4, 4, '', 2, 1),
(5, '15:30:00', '2024-12-15', 5, 5, '', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `dependentes`
--

CREATE TABLE `dependentes` (
  `id_responsavel` int(11) NOT NULL,
  `nome` varchar(80) NOT NULL,
  `nasc` date NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `id` int(11) NOT NULL,
  `id_sexo` int(11) NOT NULL,
  `tel_emergencia` varchar(11) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `foto` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `dependentes`
--

INSERT INTO `dependentes` (`id_responsavel`, `nome`, `nasc`, `cpf`, `id`, `id_sexo`, `tel_emergencia`, `endereco`, `foto`) VALUES
(1, 'Beatriz', '2023-05-15', '44222311352', 1, 2, '999999999', 'Rua Exemplo, 123', NULL),
(1, 'Carlos', '2022-07-20', '44222311353', 2, 1, '988888888', 'Avenida Teste, 456', NULL),
(1, 'Diana', '2021-09-30', '44222311354', 3, 2, '977777777', 'Praça Modelo, 789', NULL),
(1, 'Eduardo', '2020-03-11', '44222311355', 4, 1, '966666666', 'Rua Principal, 101', NULL),
(1, 'Fernanda', '2019-12-25', '44222311356', 5, 2, '955555555', 'Avenida Central, 202', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `especialidade`
--

CREATE TABLE `especialidade` (
  `Id` int(11) NOT NULL,
  `funcao` varchar(50) NOT NULL,
  `descricao` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `especialidade`
--

INSERT INTO `especialidade` (`Id`, `funcao`, `descricao`) VALUES
(1, 'Dentista', 'Especialista em odontologia geral'),
(2, 'Ortodontista', 'Especialista em aparelhos dentários');

-- --------------------------------------------------------

--
-- Estrutura da tabela `medico`
--

CREATE TABLE `medico` (
  `Id` int(11) NOT NULL,
  `nome` varchar(80) NOT NULL,
  `email` varchar(150) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `telefone` varchar(11) NOT NULL,
  `nasc` date NOT NULL,
  `id_sexo` int(11) NOT NULL,
  `senha` varchar(70) NOT NULL,
  `CRM` varchar(10) NOT NULL,
  `cod_especialidade` int(11) NOT NULL,
  `foto` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `medico`
--

INSERT INTO `medico` (`Id`, `nome`, `email`, `cpf`, `telefone`, `nasc`, `id_sexo`, `senha`, `CRM`, `cod_especialidade`, `foto`) VALUES
(1, 'Dr. João Silva', 'joao.silva@odontokids.com', '12345678901', '11987654321', '1985-01-01', 1, 'senha123', 'CRM123456', 1, NULL),
(2, 'Dra. Maria Oliveira', 'maria.oliveira@odontokids.com', '10987654321', '11987654322', '1990-02-10', 2, 'senha456', 'CRM654321', 2, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `medico_tratamento`
--

CREATE TABLE `medico_tratamento` (
  `Id_tratamento` int(11) NOT NULL,
  `id_medico` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `prontuario`
--

CREATE TABLE `prontuario` (
  `id_consulta` int(11) NOT NULL,
  `arquivo_prontuario` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `responsavel`
--

CREATE TABLE `responsavel` (
  `Id` int(11) NOT NULL,
  `nome` varchar(80) NOT NULL,
  `email` varchar(150) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `telefone` varchar(11) NOT NULL,
  `nasc` date NOT NULL,
  `id_sexo` int(11) NOT NULL,
  `senha` varchar(80) NOT NULL,
  `foto` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `responsavel`
--

INSERT INTO `responsavel` (`Id`, `nome`, `email`, `cpf`, `telefone`, `nasc`, `id_sexo`, `senha`, `foto`) VALUES
(1, 'Hernandes', 'hernandes@gmail', '44222311356', '11987654321', '2007-02-07', 1, '123456', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `sexo`
--

CREATE TABLE `sexo` (
  `id_sexo` int(11) NOT NULL,
  `sexo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `sexo`
--

INSERT INTO `sexo` (`id_sexo`, `sexo`) VALUES
(1, 'Masculino'),
(2, 'Feminino');

-- --------------------------------------------------------

--
-- Estrutura da tabela `status`
--

CREATE TABLE `status` (
  `id_status` int(11) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `status`
--

INSERT INTO `status` (`id_status`, `status`) VALUES
(1, 'Agendada'),
(2, 'Realizada'),
(3, 'Cancelada'),
(4, 'Ausente');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tratamento`
--

CREATE TABLE `tratamento` (
  `Id` int(11) NOT NULL,
  `Tratamento` varchar(50) NOT NULL,
  `Descricao` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tratamento`
--

INSERT INTO `tratamento` (`Id`, `Tratamento`, `Descricao`) VALUES
(1, 'Limpeza', 'Procedimento de limpeza dental'),
(2, 'Clareamento', 'Tratamento de clareamento dental'),
(3, 'Canal', 'Tratamento de canal dentário'),
(4, 'Extração', 'Extração de dente'),
(5, 'Restauração', 'Restauração de dente com material específico');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `consulta`
--
ALTER TABLE `consulta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_dependente` (`id_dependente`),
  ADD KEY `cod_tratamento` (`cod_tratamento`),
  ADD KEY `id_medico` (`id_medico`),
  ADD KEY `id_status` (`id_status`);

--
-- Índices para tabela `dependentes`
--
ALTER TABLE `dependentes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_responsavel` (`id_responsavel`),
  ADD KEY `id_sexo` (`id_sexo`);

--
-- Índices para tabela `especialidade`
--
ALTER TABLE `especialidade`
  ADD PRIMARY KEY (`Id`);

--
-- Índices para tabela `medico`
--
ALTER TABLE `medico`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `id_sexo` (`id_sexo`),
  ADD KEY `cod_especialidade` (`cod_especialidade`);

--
-- Índices para tabela `medico_tratamento`
--
ALTER TABLE `medico_tratamento`
  ADD UNIQUE KEY `Id_tratamento` (`Id_tratamento`),
  ADD KEY `id_medico` (`id_medico`);

--
-- Índices para tabela `prontuario`
--
ALTER TABLE `prontuario`
  ADD UNIQUE KEY `id_consulta` (`id_consulta`);

--
-- Índices para tabela `responsavel`
--
ALTER TABLE `responsavel`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `id_sexo` (`id_sexo`);

--
-- Índices para tabela `sexo`
--
ALTER TABLE `sexo`
  ADD PRIMARY KEY (`id_sexo`);

--
-- Índices para tabela `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id_status`);

--
-- Índices para tabela `tratamento`
--
ALTER TABLE `tratamento`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `consulta`
--
ALTER TABLE `consulta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `dependentes`
--
ALTER TABLE `dependentes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `especialidade`
--
ALTER TABLE `especialidade`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `medico`
--
ALTER TABLE `medico`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `medico_tratamento`
--
ALTER TABLE `medico_tratamento`
  MODIFY `Id_tratamento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `prontuario`
--
ALTER TABLE `prontuario`
  MODIFY `id_consulta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `responsavel`
--
ALTER TABLE `responsavel`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `sexo`
--
ALTER TABLE `sexo`
  MODIFY `id_sexo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `status`
--
ALTER TABLE `status`
  MODIFY `id_status` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `tratamento`
--
ALTER TABLE `tratamento`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `consulta`
--
ALTER TABLE `consulta`
  ADD CONSTRAINT `consulta_ibfk_1` FOREIGN KEY (`id_dependente`) REFERENCES `dependentes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `consulta_ibfk_2` FOREIGN KEY (`cod_tratamento`) REFERENCES `tratamento` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `consulta_ibfk_3` FOREIGN KEY (`id_medico`) REFERENCES `medico` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `consulta_ibfk_4` FOREIGN KEY (`id_status`) REFERENCES `status` (`id_status`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `dependentes`
--
ALTER TABLE `dependentes`
  ADD CONSTRAINT `dependentes_ibfk_1` FOREIGN KEY (`id_responsavel`) REFERENCES `responsavel` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `dependentes_ibfk_2` FOREIGN KEY (`id_sexo`) REFERENCES `sexo` (`id_sexo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `medico`
--
ALTER TABLE `medico`
  ADD CONSTRAINT `medico_ibfk_1` FOREIGN KEY (`id_sexo`) REFERENCES `sexo` (`id_sexo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `medico_ibfk_2` FOREIGN KEY (`cod_especialidade`) REFERENCES `especialidade` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `medico_tratamento`
--
ALTER TABLE `medico_tratamento`
  ADD CONSTRAINT `medico_tratamento_ibfk_1` FOREIGN KEY (`Id_tratamento`) REFERENCES `tratamento` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `medico_tratamento_ibfk_2` FOREIGN KEY (`id_medico`) REFERENCES `medico` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `prontuario`
--
ALTER TABLE `prontuario`
  ADD CONSTRAINT `prontuario_ibfk_1` FOREIGN KEY (`id_consulta`) REFERENCES `consulta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `responsavel`
--
ALTER TABLE `responsavel`
  ADD CONSTRAINT `responsavel_ibfk_1` FOREIGN KEY (`id_sexo`) REFERENCES `sexo` (`id_sexo`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;