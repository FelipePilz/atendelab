CREATE
DATABASE IF NOT EXISTS atendelab
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;
USE
atendelab;

CREATE TABLE `usuarios`
(
    `id`            int PRIMARY KEY AUTO_INCREMENT,
    `nome`          varchar(100)        NOT NULL,
    `email`         varchar(100) UNIQUE NOT NULL,
    `senha`         varchar(255)        NOT NULL,
    `perfil`        enum('admin','aluno', 'atendente') DEFAULT 'atendente',
    `status`        enum('ativo','inativo') DEFAULT 'ativo',
    `criado_em`     timestamp DEFAULT CURRENT_TIMESTAMP,
    `atualizado_em` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `pessoas`
(
    `id`            int PRIMARY KEY AUTO_INCREMENT,
    `nome`          varchar(150) NOT NULL,
    `documento`     varchar(30)  NOT NULL UNIQUE,
    `telefone`      varchar(20),
    `email`         varchar(150) NOT NULL,
    `curso`         varchar(120),
    `periodo`       varchar(20),
    `observacoes`   TEXT,
    `status`        ENUM('ativo', 'inativo') DEFAULT 'ativo',
    `criado_em`     timestamp DEFAULT CURRENT_TIMESTAMP,
    `atualizado_em` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tipos_atendimentos`
(
    `id`            int PRIMARY KEY AUTO_INCREMENT,
    `nome`          varchar(100) NOT NULL,
    `descricao`     TEXT         NOT NULL,
    `status`        ENUM('ativo', 'inativo') DEFAULT 'ativo',
    `criado_em`     timestamp DEFAULT CURRENT_TIMESTAMP,
    `atualizado_em` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `atendimentos`
(
    `id`                  int PRIMARY KEY AUTO_INCREMENT,
    `pessoa_id`           int  NOT NULL,
    `tipo_atendimento_id` int  NOT NULL,
    `usuario_id`          int  NOT NULL,
    `descricao`           TEXT NOT NULL,
    `status`              ENUM('aberto', 'em_andamento', 'concluido') DEFAULT 'aberto',
    `data_atendimento`    DATE NOT NULL,
    `horario_atendimento` TIME NOT NULL,
    `observacao_final`    TEXT,
    `criado_em`           timestamp DEFAULT current_timestamp(),
    `atualizado_em`       timestamp DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    CONSTRAINT `fk_atendimentos_pessoa` FOREIGN KEY (`pessoa_id`) REFERENCES `pessoas` (`id`),
    CONSTRAINT `fk_atendimentos_tipo` FOREIGN KEY (`tipo_atendimento_id`) REFERENCES `tipos_atendimentos` (`id`),
    CONSTRAINT `fk_atendimentos_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO usuarios (nome, email, senha, perfil, status)
VALUES ('Administrador',
        'admin@atendelab.com',
        '$2a$12$mwyBKjosbJCT.527IDPSheJXO3kS.2DbLERU2nQLWc4k3ODO9FHfa',
        'admin',
        'ativo');

INSERT INTO tipos_atendimentos (nome, descricao, status)
VALUES ('Dúvida academica', 'Dúvidas sobre disciplinas, conteúdos e atividades.', 'ativo'),
       ('Orientação de atividade', 'Orientações sobre trabalhos, TCC e projetos.', 'ativo'),
       ('Suporte técnico', 'Problemas com sistemas, equipamentos e acesso.', 'ativo'),
       ('Matrícula e documentação', 'Solicitações de matrícula, declarações e históricos.', 'ativo'),
       ('Acesso ao laboratório', 'Liberação de uso e agendamento de laboratórios', 'ativo');

INSERT INTO pessoas (nome, documento, telefone, email, curso, periodo, status)
VALUES ('João da Silva', '123.456.789-00', '(47) 99999-0001', 'joão.silva@exemplo.com', 'Engenharia de Software', '5º',
        'ativo'),
       ('Ana Carolina', '987.654.321-00', '(47) 99999-0002', 'ana.carolina@exemplo.com', 'Sistemas de Informação', '7º',
        'ativo');