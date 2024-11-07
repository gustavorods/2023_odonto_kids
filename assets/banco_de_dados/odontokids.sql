CREATE DATABASE `odontokids`;
USE `odontokids`;

-- Tabela de Responsável
CREATE TABLE `responsavel` (
    `Id` INTEGER NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(80) NOT NULL,
    `email` VARCHAR(150) NOT NULL,
    `cpf` VARCHAR(11) NOT NULL,
    `telefone` VARCHAR(11) NOT NULL,
    `nasc` DATE NOT NULL,
    `genero` VARCHAR(30) NOT NULL,
    `senha` VARCHAR(80) NOT NULL,
    `foto` VARCHAR(250),  -- Campo foto adicionado
    PRIMARY KEY(`Id`)
);

-- Tabela de Dependentes
CREATE TABLE `dependentes` (
    `id_responsavel` INTEGER NOT NULL,
    `nome` VARCHAR(80) NOT NULL,
    `nasc` DATE NOT NULL,
    `cpf` VARCHAR(11) NOT NULL,
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `id_sexo` INTEGER NOT NULL,
    `tel_emergencia` VARCHAR(11) NOT NULL,
    `endereco` VARCHAR(255) NOT NULL,
    `foto` VARCHAR(250),  -- Campo foto adicionado
    PRIMARY KEY(`id`)
);

-- Tabela de Consulta
CREATE TABLE `consulta` (
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `horario` TIME NOT NULL,
    `data` DATE NOT NULL,
    `id_dependente` INTEGER NOT NULL,
    `cod_tratamento` INTEGER NOT NULL,
    `relatorio` VARCHAR(500) NOT NULL,
    `id_medico` INTEGER NOT NULL,
    `id_status` INTEGER NOT NULL,
    PRIMARY KEY(`id`)
);

-- Tabela de Prontuário
CREATE TABLE `prontuario` (
    `id_consulta` INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
    `arquivo_prontuario` BLOB
);

-- Tabela de Tratamento
CREATE TABLE `tratamento` (
    `Id` INTEGER NOT NULL AUTO_INCREMENT,
    `Tratamento` VARCHAR(50) NOT NULL,
    `Descricao` VARCHAR(200) NOT NULL,
    PRIMARY KEY(`Id`)
);

-- Tabela de Médico e Tratamento
CREATE TABLE `medico_tratamento` (
    `Id_tratamento` INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
    `id_medico` INTEGER NOT NULL
);

-- Tabela de Médico
CREATE TABLE `medico` (
    `Id` INTEGER NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(80) NOT NULL,
    `email` VARCHAR(150) NOT NULL,
    `cpf` VARCHAR(11) NOT NULL,
    `telefone` VARCHAR(11) NOT NULL,
    `nasc` DATE NOT NULL,
    `genero` VARCHAR(50) NOT NULL,
    `senha` VARCHAR(70) NOT NULL,
    `CRM` VARCHAR(10) NOT NULL,
    `cod_especialidade` INTEGER NOT NULL,
    `foto` VARCHAR(250),  -- Campo foto adicionado
    PRIMARY KEY(`Id`)
);

-- Tabela de Especialidade
CREATE TABLE `especialidade` (
    `Id` INTEGER NOT NULL AUTO_INCREMENT,
    `funcao` VARCHAR(50) NOT NULL,
    `descricao` VARCHAR(200) NOT NULL,
    PRIMARY KEY(`Id`)
);

-- Tabela de Status
CREATE TABLE `status` (
    `id_status` INTEGER NOT NULL AUTO_INCREMENT,
    `status` VARCHAR(255) NOT NULL,
    PRIMARY KEY(`id_status`)
);

-- Tabela de Sexo
CREATE TABLE `sexo` (
    `id_sexo` INTEGER NOT NULL AUTO_INCREMENT,
    `sexo` VARCHAR(255) NOT NULL,
    PRIMARY KEY(`id_sexo`)
);

-- Definindo as relações de chave estrangeira
ALTER TABLE `dependentes`
    ADD FOREIGN KEY(`id_responsavel`) REFERENCES `responsavel`(`Id`)
    ON UPDATE NO ACTION ON DELETE NO ACTION;

ALTER TABLE `consulta`
    ADD FOREIGN KEY(`id_dependente`) REFERENCES `dependentes`(`id`)
    ON UPDATE NO ACTION ON DELETE NO ACTION;

ALTER TABLE `prontuario`
    ADD FOREIGN KEY(`id_consulta`) REFERENCES `consulta`(`id`)
    ON UPDATE NO ACTION ON DELETE NO ACTION;

ALTER TABLE `consulta`
    ADD FOREIGN KEY(`cod_tratamento`) REFERENCES `tratamento`(`Id`)
    ON UPDATE NO ACTION ON DELETE NO ACTION;

ALTER TABLE `medico_tratamento`
    ADD FOREIGN KEY(`Id_tratamento`) REFERENCES `tratamento`(`Id`)
    ON UPDATE NO ACTION ON DELETE NO ACTION;

ALTER TABLE `medico_tratamento`
    ADD FOREIGN KEY(`id_medico`) REFERENCES `medico`(`Id`)
    ON UPDATE NO ACTION ON DELETE NO ACTION;

ALTER TABLE `medico`
    ADD FOREIGN KEY(`cod_especialidade`) REFERENCES `especialidade`(`Id`)
    ON UPDATE NO ACTION ON DELETE NO ACTION;

ALTER TABLE `consulta`
    ADD FOREIGN KEY(`id_medico`) REFERENCES `medico`(`Id`)
    ON UPDATE NO ACTION ON DELETE NO ACTION;

ALTER TABLE `consulta`
    ADD FOREIGN KEY(`id_status`) REFERENCES `status`(`id_status`)
    ON UPDATE NO ACTION ON DELETE NO ACTION;

ALTER TABLE `dependentes`
    ADD FOREIGN KEY(`id_sexo`) REFERENCES `sexo`(`id_sexo`)
    ON UPDATE NO ACTION ON DELETE NO ACTION;

-- Inserção na tabela responsavel
INSERT INTO `responsavel` (`Id`, `nome`, `email`, `cpf`, `telefone`, `nasc`, `genero`, `senha`, `foto`) VALUES
(1, 'Hernandes', 'hernandes@gmail', '44222311356', '11987654321', '2007-02-07', 'Masculino', '123456', NULL);
COMMIT;

-- Inserção na tabela sexo
INSERT INTO `sexo` (`sexo`) VALUES
('Masculino'),
('Feminino');
COMMIT;

-- Inserção na tabela dependentes
INSERT INTO `dependentes` (`id_responsavel`, `nome`, `nasc`, `cpf`, `id_sexo`, `tel_emergencia`, `endereco`, `foto`) VALUES
(1, 'Beatriz', '2023-05-15', '44222311352', 2, '999999999', 'Rua Exemplo, 123', NULL),
(1, 'Carlos', '2022-07-20', '44222311353', 1, '988888888', 'Avenida Teste, 456', NULL),
(1, 'Diana', '2021-09-30', '44222311354', 2, '977777777', 'Praça Modelo, 789', NULL),
(1, 'Eduardo', '2020-03-11', '44222311355', 1, '966666666', 'Rua Principal, 101', NULL),
(1, 'Fernanda', '2019-12-25', '44222311356', 2, '955555555', 'Avenida Central, 202', NULL);
COMMIT;

-- Inserção na tabela tratamento
INSERT INTO `tratamento` (`Id`, `Tratamento`, `Descricao`) VALUES
(1, 'Limpeza', 'Procedimento de limpeza dental'),
(2, 'Clareamento', 'Tratamento de clareamento dental'),
(3, 'Canal', 'Tratamento de canal dentário'),
(4, 'Extração', 'Extração de dente'),
(5, 'Restauração', 'Restauração de dente com material específico');
COMMIT;

-- Inserção na tabela status
INSERT INTO `status` (`id_status`, `status`) VALUES
(1, 'Agendada'),
(2, 'Realizada'),
(3, 'Cancelada'),
(4, 'Ausente');
COMMIT;

-- Inserção na tabela especialidade
INSERT INTO `especialidade` (`funcao`, `descricao`) VALUES
('Dentista', 'Especialista em odontologia geral'),
('Ortodontista', 'Especialista em aparelhos dentários');
COMMIT;

-- Inserção na tabela medico
INSERT INTO `medico` (`nome`, `email`, `cpf`, `telefone`, `nasc`, `genero`, `senha`, `CRM`, `cod_especialidade`, `foto`) VALUES
('Dr. João Silva', 'joao.silva@odontokids.com', '12345678901', '11987654321', '1985-01-01', 'Masculino', 'senha123', 'CRM123456', 1, NULL),
('Dra. Maria Oliveira', 'maria.oliveira@odontokids.com', '10987654321', '11987654322', '1990-02-10', 'Feminino', 'senha456', 'CRM654321', 2, NULL);
COMMIT;

-- Inserção na tabela consulta (status 'Agendada')
INSERT INTO `consulta` (`horario`, `data`, `id_dependente`, `cod_tratamento`, `relatorio`, `id_status`, `id_medico`) VALUES
('09:15:00', '2024-12-05', 1, 1, '', 1, 1),  -- id_medico 1
('10:45:00', '2024-12-08', 2, 2, '', 1, 2),  -- id_medico 2
('11:20:00', '2024-12-15', 3, 3, '', 1, 1),  -- id_medico 1
('08:00:00', '2024-12-22', 4, 4, '', 1, 2),  -- id_medico 2
('17:30:00', '2024-12-29', 5, 5, '', 1, 1);  -- id_medico 1