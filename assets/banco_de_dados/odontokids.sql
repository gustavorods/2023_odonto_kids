CREATE DATABASE `odontokids`;
USE `odontokids`;

CREATE TABLE `responsavel` (
	`Id` INTEGER NOT NULL AUTO_INCREMENT,
	`nome` VARCHAR(80) NOT NULL,
	`email` VARCHAR(150) NOT NULL,
	`cpf` VARCHAR(11) NOT NULL,
	`telefone` VARCHAR(11) NOT NULL,
	`nasc` DATE NOT NULL,
	`id_sexo` INTEGER NOT NULL,
	`senha` VARCHAR(80) NOT NULL,
	`foto` BLOB,
	PRIMARY KEY(`Id`)
);


CREATE TABLE `dependentes` (
	`id_responsavel` INTEGER NOT NULL,
	`nome` VARCHAR(80) NOT NULL,
	`nasc` DATE NOT NULL,
	`cpf` VARCHAR(11) NOT NULL,
	`id` INTEGER NOT NULL AUTO_INCREMENT,
	`id_sexo` INTEGER NOT NULL,
	`tel_emergencia` VARCHAR(11) NOT NULL,
	`endereco` VARCHAR(255) NOT NULL,
	`foto` BLOB,
	PRIMARY KEY(`id`)
);


CREATE TABLE `consulta` (
	`id` INTEGER NOT NULL AUTO_INCREMENT,
	`horario` TIME NOT NULL,
	`data` DATE NOT NULL,
	`id_dependente` INTEGER NOT NULL,
	`cod_tratamento` INTEGER NOT NULL,
	`relatorio` VARCHAR(500) NOT NULL,
	`id_medico` INTEGER NOT NULL,
	`status_consulta` INTEGER NOT NULL,
	PRIMARY KEY(`id`)
);


CREATE TABLE `prontuario` (
	`id_consulta` INTEGER NOT NULL,
	`arquivo_prontuario` BLOB
);


CREATE TABLE `tratamento` (
	`Id` INTEGER NOT NULL AUTO_INCREMENT,
	`Tratamento` VARCHAR(50) NOT NULL,
	`Descricao` VARCHAR(200) NOT NULL,
	PRIMARY KEY(`Id`)
);


CREATE TABLE `medico_tratamento` (
	`Id_tratamento` INTEGER NOT NULL,
	`id_medico` INTEGER NOT NULL
);


CREATE TABLE `medico` (
	`Id` INTEGER NOT NULL AUTO_INCREMENT,
	`nome` VARCHAR(80) NOT NULL,
	`email` VARCHAR(150) NOT NULL,
	`cpf` VARCHAR(11) NOT NULL,
	`telefone` VARCHAR(11) NOT NULL,
	`nasc` DATE NOT NULL,
	`id_sexo` INTEGER NOT NULL,
	`senha` VARCHAR(70) NOT NULL,
	`CRM` VARCHAR(10) NOT NULL,
	`cod_especialidade` INTEGER NOT NULL,
	`foto` BLOB,
	PRIMARY KEY(`Id`)
);


CREATE TABLE `especialidade` (
	`Id` INTEGER NOT NULL AUTO_INCREMENT,
	`funcao` VARCHAR(50) NOT NULL,
	`descricao` VARCHAR(200) NOT NULL,
	PRIMARY KEY(`Id`)
);


CREATE TABLE `status_consulta` (
	`id_status_consulta` INTEGER NOT NULL AUTO_INCREMENT,
	`status_consulta` VARCHAR(255) NOT NULL,
	PRIMARY KEY(`id_status_consulta`)
);


CREATE TABLE `sexo` (
	`id_sexo` INTEGER NOT NULL AUTO_INCREMENT,
	`sexo` VARCHAR(255) NOT NULL,
	PRIMARY KEY(`id_sexo`)
);


CREATE TABLE `dependente_tratamento` (
	`id_dependente` INTEGER NOT NULL,
	`id_tratamento` INTEGER NOT NULL,
	`data_inicio` DATE NOT NULL,
	`previsao_termino` DATE NOT NULL,
	`status_tratamento` INTEGER NOT NULL
);


CREATE TABLE `status_tratamento` (
	`id_status_tratamento` INTEGER NOT NULL AUTO_INCREMENT,
	`status_tratamento` VARCHAR(255) NOT NULL,
	PRIMARY KEY(`id_status_tratamento`)
);


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
ADD FOREIGN KEY(`status_consulta`) REFERENCES `status_consulta`(`id_status_consulta`)
ON UPDATE NO ACTION ON DELETE NO ACTION;
ALTER TABLE `dependentes`
ADD FOREIGN KEY(`id_sexo`) REFERENCES `sexo`(`id_sexo`)
ON UPDATE NO ACTION ON DELETE NO ACTION;
ALTER TABLE `depentente_tratamento`
ADD FOREIGN KEY(`id_tratamento`) REFERENCES `tratamento`(`Id`)
ON UPDATE NO ACTION ON DELETE NO ACTION;
ALTER TABLE `depentente_tratamento`
ADD FOREIGN KEY(`id_dependete`) REFERENCES `dependentes`(`id`)
ON UPDATE NO ACTION ON DELETE NO ACTION;
ALTER TABLE `depentente_tratamento`
ADD FOREIGN KEY(`status_tratamento`) REFERENCES `status_tratamento`(`id_status_tratamento`)
ON UPDATE NO ACTION ON DELETE NO ACTION;
ALTER TABLE `responsavel`
ADD FOREIGN KEY(`id_sexo`) REFERENCES `sexo`(`id_sexo`)
ON UPDATE NO ACTION ON DELETE NO ACTION;
ALTER TABLE `medico`
ADD FOREIGN KEY(`id_sexo`) REFERENCES `sexo`(`id_sexo`)
ON UPDATE NO ACTION ON DELETE NO ACTION;

INSERT INTO tratamento (Id, Tratamento, Descricao) VALUES
(1, 'Limpeza', 'Procedimento de limpeza dental para remoção de tártaro e placa bacteriana'),
(2, 'Clareamento', 'Tratamento de clareamento dental para melhorar a cor dos dentes'),
(3, 'Canal', 'Tratamento de canal dentário para tratar infecção ou dano ao nervo do dente'),
(4, 'Extração', 'Extração de dente, incluindo dentes temporários e permanentes'),
(5, 'Restauração', 'Restauração de dente com material específico como resina composta ou amálgama'),
(6, 'Aparelho Ortodôntico', 'Colocação de aparelho dentário fixo ou móvel para corrigir alinhamento dentário'),
(7, 'Facetas de Porcelana', 'Colocação de facetas de porcelana para melhorar a estética dos dentes'),
(8, 'Implante Dentário', 'Implante de pinos de titânio no maxilar para substituir dentes perdidos'),
(9, 'Prótese Dentária', 'Prótese fixa ou removível para substituir dentes faltantes'),
(10, 'Cirurgia Gengival', 'Procedimentos cirúrgicos para tratar doenças nas gengivas e melhorar a estética'),
(11, 'Profilaxia', 'Procedimento preventivo para a saúde bucal, incluindo aplicação de flúor e orientação de higiene'),
(12, 'Restauração Estética', 'Restauração dental com materiais estéticos para aparência mais natural'),
(13, 'Tratamento de DTM (Disfunção Temporomandibular)', 'Tratamento de problemas na articulação temporomandibular que causam dor e desconforto'),
(14, 'Ortodontia Preventiva', 'Tratamento ortodôntico precoce para corrigir problemas dentários em crianças'),
(15, 'Odontopediatria', 'Tratamento odontológico especializado para crianças, incluindo limpeza, restaurações e acompanhamento'),
(16, 'Tratamento de Gengivite', 'Tratamento para inflamação nas gengivas causada por acúmulo de placa bacteriana'),
(17, 'Raspagem e Alisamento Radicular', 'Tratamento para eliminar tártaro e placa acumulados nas raízes dos dentes'),
(18, 'Cirurgia Ortognática', 'Procedimento cirúrgico para corrigir problemas graves de oclusão e mandíbula'),
(19, 'Ajuste de Aparelho Ortodôntico', 'Ajustes periódicos no aparelho ortodôntico para garantir a movimentação correta dos dentes'),
(20, 'Consultoria em Higiene Bucal', 'Sessões educativas para melhorar os hábitos de higiene bucal e prevenir doenças dentárias');

INSERT INTO status_tratamento (status_tratamento) VALUES
('Em andamento'),
('Aguardando'),
('Concluído'),
('Pendente');

INSERT INTO `status_consulta` (`id_status_consulta`, `status_consulta`) VALUES
(1, 'Agendada'),
(2, 'Realizada'),
(3, 'Cancelada'),
(4, 'Ausente');

INSERT INTO `sexo` (`id_sexo`, `sexo`) VALUES
(1, 'Masculino'),
(2, 'Feminino');

INSERT INTO especialidade (Id, funcao, descricao) VALUES
(1, 'Dentista', 'Especialista em odontologia geral, responsável pelo cuidado preventivo e tratamento de doenças bucais'),
(2, 'Ortodontista', 'Especialista em aparelhos dentários, focado no diagnóstico, prevenção e correção de problemas de alinhamento dentário'),
(3, 'Endodontista', 'Especialista em tratamento de canais (tratamento endodôntico) e doenças da polpa dentária'),
(4, 'Periodontista', 'Especialista no tratamento das gengivas e tecidos de suporte dos dentes, incluindo doenças periodontais como gengivite e periodontite'),
(5, 'Cirurgião Bucomaxilofacial', 'Especialista em cirurgias faciais e bucais, incluindo remoção de dentes, correção de deformidades e tratamentos de fraturas faciais'),
(6, 'Protesista', 'Especialista em próteses dentárias, responsável por criar e ajustar dentes artificiais para substituir dentes perdidos ou danificados'),
(7, 'Odontopediatra', 'Especialista em odontologia pediátrica, cuidando da saúde bucal das crianças desde a infância até a adolescência'),
(8, 'Implantodontista', 'Especialista em implantes dentários, realizando a colocação de pinos de titânio para substituir dentes perdidos'),
(9, 'Odontogeriatra', 'Especialista no atendimento odontológico de idosos, com foco nas necessidades específicas de saúde bucal da terceira idade'),
(10, 'Estomatologista', 'Especialista no diagnóstico e tratamento de doenças da boca, como úlceras, lesões e infecções orais'),
(11, 'Cirurgião Dentista Estético', 'Especialista em procedimentos estéticos dentários, como clareamento, facetas e restaurações estéticas'),
(12, 'Higienista Dental', 'Profissional focado na limpeza dos dentes, remoção de tártaro, placas bacterianas e orientações sobre saúde bucal'),
(13, 'Odontologista Forense', 'Especialista que atua na área de perícia odontológica, fornecendo exames e relatórios em casos legais e criminais'),
(14, 'Odontopediatra Preventiva', 'Especialista em prevenção da saúde bucal infantil, com foco em educação e cuidados para evitar problemas dentários futuros'),
(15, 'Protesista sobre Implantes', 'Especialista em criação e adaptação de próteses sobre implantes dentários, para restaurar dentes perdidos com maior funcionalidade e estética'),
(16, 'Odontologista Hospitalar', 'Especialista em odontologia aplicada a pacientes hospitalizados, incluindo cuidados com pacientes com condições médicas graves ou especiais'),
(17, 'Radiologista Odontológico', 'Especialista em diagnóstico por imagem, realizando exames de radiografia, tomografia e outros para diagnóstico de doenças dentárias'),
(18, 'Fisioterapeuta Orofacial', 'Especialista em fisioterapia para o tratamento de disfunções na articulação temporomandibular (ATM) e problemas musculares da face'),
(19, 'Odontologo de Urgência', 'Especialista em atendimentos odontológicos emergenciais, tratando casos como dores fortes, fraturas dentárias e outros problemas súbitos'),
(20, 'Odontogeriatra Preventiva', 'Especialista em cuidados preventivos para a saúde bucal de idosos, com foco na manutenção de dentes naturais e cuidados com próteses');

INSERT INTO medico (nome, email, cpf, telefone, nasc, id_sexo, senha, CRM, cod_especialidade, foto) VALUES
('Dr. João Silva', 'joao.silva@email.com', '12345678901', '11987654321', '1985-04-25', 1, 'senha123', 'CRM123456', 1, NULL),
('Dra. Maria Oliveira', 'maria.oliveira@email.com', '98765432100', '11923456789', '1990-07-15', 2, 'senha456', 'CRM987654', 2, NULL),
('Dr. Pedro Costa', 'pedro.costa@email.com', '11223344556', '11345678901', '1982-01-05', 1, 'senha789', 'CRM654321', 1, NULL),
('Dra. Ana Souza', 'ana.souza@email.com', '22334455667', '11987654322', '1988-09-20', 2, 'senha101', 'CRM213546', 3, NULL),
('Dr. Carlos Pereira', 'carlos.pereira@email.com', '33445566778', '11876543210', '1983-12-11', 1, 'senha102', 'CRM789654', 4, NULL),
('Dra. Fernanda Lima', 'fernanda.lima@email.com', '44556677889', '11987654323', '1992-03-30', 2, 'senha103', 'CRM321654', 2, NULL),
('Dr. Luiz Almeida', 'luiz.almeida@email.com', '55667788990', '11765432109', '1980-10-05', 1, 'senha104', 'CRM456123', 1, NULL),
('Dra. Clara Martins', 'clara.martins@email.com', '66778899001', '11923456780', '1994-06-18', 2, 'senha105', 'CRM789321', 3, NULL),
('Dr. Roberto Alves', 'roberto.alves@email.com', '77889900112', '11654321098', '1987-11-02', 1, 'senha106', 'CRM101112', 4, NULL),
('Dra. Juliana Rocha', 'juliana.rocha@email.com', '88990011223', '11345678902', '1991-02-22', 2, 'senha107', 'CRM654987', 5, NULL);

INSERT INTO medico_tratamento (Id_tratamento, id_medico) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 2),
(7, 3),
(8, 1),
(9, 4),
(10, 5),
(11, 2),
(12, 3),
(13, 1),
(14, 4),
(15, 5),
(16, 2),
(17, 3),
(18, 1),
(19, 4),
(20, 5);