create database chamados 

use chamados 

CREATE TABLE Clientes (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    Nome VARCHAR(100) NOT NULL,
    Email VARCHAR(100) NOT NULL UNIQUE,
    Telefone VARCHAR(15)
);

-- Criação da Tabela Colaboradores
CREATE TABLE Colaboradores (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    Nome VARCHAR(100) NOT NULL,
    Email VARCHAR(100) NOT NULL UNIQUE,
    Telefone VARCHAR(15)
);

-- Criação da Tabela Chamados
CREATE TABLE Chamados (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    ID_Cliente INT NOT NULL,
    Descricao TEXT NOT NULL,
    Criticidade ENUM('baixa', 'média', 'alta') NOT NULL,
    Status ENUM('aberto', 'em andamento', 'resolvido') DEFAULT 'aberto',
    Data_Abertura TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ID_Colaborador INT NULL,
    FOREIGN KEY (ID_Cliente) REFERENCES Clientes(ID) ON DELETE CASCADE,
    FOREIGN KEY (ID_Colaborador) REFERENCES Colaboradores(ID) ON DELETE SET NULL
);

-- Consulta para inserir dados iniciais
INSERT INTO Clientes (Nome, Email, Telefone) VALUES
('Cliente A', 'clienteA@exemplo.com', '123456789'),
('Cliente B', 'clienteB@exemplo.com', '987654321');

INSERT INTO Colaboradores (Nome, Email, Telefone) VALUES
('Colaborador X', 'colaboradorX@empresa.com', '555123456'),
('Colaborador Y', 'colaboradorY@empresa.com', '555987654');


INSERT INTO Chamados (ID_Cliente, Descricao, Criticidade, ID_Colaborador) VALUES
(1, 'Problema no sistema de login', 'alta', 1),
(2, 'Erro ao gerar relatório', 'média', 2),
(1, 'Solicitação de suporte geral', 'baixa', NULL);

-- Exemplo de consulta para visualizar chamados por status
SELECT Chamados.ID, Clientes.Nome AS Cliente, Colaboradores.Nome AS Colaborador,
       Chamados.Descricao, Chamados.Criticidade, Chamados.Status, Chamados.Data_Abertura
FROM Chamados
LEFT JOIN Clientes ON Chamados.ID_Cliente = Clientes.ID
LEFT JOIN Colaboradores ON Chamados.ID_Colaborador = Colaboradores.ID
WHERE Chamados.Status = 'aberto';


SELECT * FROM Chamados WHERE Criticidade = 'alta';

