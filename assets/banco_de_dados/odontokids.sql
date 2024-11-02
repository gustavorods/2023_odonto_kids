-- Banco de dados: `odontokids`
CREATE DATABASE `odontokids`;
USE `odontokids`;

-- Estrutura da tabela `responsavel`
CREATE TABLE `responsavel` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) NOT NULL,
  `email` varchar(150) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `telefone` varchar(11) NOT NULL,
  `nasc` date NOT NULL,
  `genero` varchar(30) NOT NULL,
  `senha` varchar(80) NOT NULL,
  `foto_perfil` BLOB NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- Estrutura da tabela `dependentes`
CREATE TABLE `dependentes` (
  `id_responsavel` int(11) NOT NULL,
  `nome` varchar(80) NOT NULL,
  `nasc` date NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- Estrutura da tabela `tratamento`
CREATE TABLE `tratamento` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Tratamento` varchar(50) NOT NULL,
  `Descricao` varchar(200) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- Estrutura da tabela `especialidade`
CREATE TABLE `especialidade` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `funcao` varchar(50) NOT NULL,
  `descricao` varchar(200) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Estrutura da tabela `medico`
CREATE TABLE `medico` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) NOT NULL,
  `email` varchar(150) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `telefone` varchar(11) NOT NULL,
  `nasc` date NOT NULL,
  `genero` varchar(50) NOT NULL,
  `senha` varchar(70) NOT NULL,
  `CRM` varchar(6) NOT NULL,
  `cod_especialidade` int(11) NOT NULL,
  `foto_perfil` BLOB NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- Estrutura da tabela `consulta`
CREATE TABLE `consulta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `horario` time NOT NULL,
  `data` date NOT NULL,
  `id_dependente` int(11) NOT NULL,
  `cod_tratamento` int(11) NOT NULL,
  `relatorio` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- Estrutura da tabela `medico_tratamento`
CREATE TABLE `medico_tratamento` (
  `Id_tratamento` int(11) NOT NULL,
  `id_medico` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- Estrutura da tabela `prontuario`
CREATE TABLE `prontuario` (
  `id_consulta` int(11) NOT NULL,
  `arquivo_prontuario` blob NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;
