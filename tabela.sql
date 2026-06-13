SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

SET NAMES utf8;

create database databanco;
use databanco;

CREATE TABLE IF NOT EXISTS gerentes (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50),
    endereco VARCHAR(50),
    depto VARCHAR(20),
    datanasc DATETIME,
    foto VARCHAR(20)
) DEFAULT CHARSET=utf8;

INSERT INTO gerentes (nome, endereco, depto, datanasc, foto) VALUES 
('Carlos Silva', 'Rua das Flores, 123', 'TI', '1985-04-15 00:00:00', 'fotogenerica.png'),
('Mariana Oliveira', 'Av. Paulista, 1500', 'RH', '1990-08-22 00:00:00', 'fotogenerica.png'),
('Roberto Costa', 'Rua Sete de Setembro, 45', 'Vendas', '1982-11-03 00:00:00', 'fotogenerica.png'),
('Ana Souza', 'Praça da Liberdade, 99', 'Financeiro', '1988-02-18 00:00:00', 'fotogenerica.png'),
('Fernando Almeida', 'Alameda Santos, 321', 'Marketing', '1993-07-25 00:00:00', 'fotogenerica.png');