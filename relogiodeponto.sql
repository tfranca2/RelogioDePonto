-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tempo de Geração: 
-- Versão do Servidor: 5.5.27
-- Versão do PHP: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `relogiodeponto`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `empresa`
--

CREATE TABLE IF NOT EXISTS `empresa` (
  `id_empresa` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `razaoSocial` varchar(255) NOT NULL,
  `nomeFantasia` varchar(255) NOT NULL,
  `CNPJ` varchar(255) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `telefone` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `site` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_empresa`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `empresa`
--

INSERT INTO `empresa` (`id_empresa`, `razaoSocial`, `nomeFantasia`, `CNPJ`, `endereco`, `telefone`, `email`, `site`) VALUES
(1, 'COMPANHIA BRASILEIRA DE BEBIDAS PREMIUM', 'CBBP', '009.325.874/001-93', 'RODOVIA CE 040 S/Nº KM 43,7 CENTRO, PINDORETAMA', '(85) 3375 1239', 'contato@cbbp.com.br', 'www.cbbp.com.br');

-- --------------------------------------------------------

--
-- Estrutura da tabela `faltas`
--

CREATE TABLE IF NOT EXISTS `faltas` (
  `id_falta` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Funcionario_id_Funcionario` int(11) NOT NULL,
  `data` date NOT NULL,
  `justificativa` varchar(255) NOT NULL,
  PRIMARY KEY (`id_falta`),
  KEY `funcionario` (`Funcionario_id_Funcionario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `feriados`
--

CREATE TABLE IF NOT EXISTS `feriados` (
  `id_Feriado` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) NOT NULL,
  `dia` int(10) unsigned NOT NULL,
  `mes` int(10) unsigned NOT NULL,
  `ano` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_Feriado`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Extraindo dados da tabela `feriados`
--

INSERT INTO `feriados` (`id_Feriado`, `descricao`, `dia`, `mes`, `ano`) VALUES
(1, 'CONFRATERNIZACAO UNIVERSAL', 1, 1, NULL),
(2, 'TIRADENTES', 21, 4, NULL),
(3, 'INDEPENDENCIA DO BRASIL', 7, 9, NULL),
(4, 'PADROEIRA DO BRASIL', 12, 10, NULL),
(5, 'FINADOS', 2, 11, NULL),
(6, 'PROCLAMACAO DA REPUBLICA', 15, 11, NULL),
(7, 'NATAL', 25, 12, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcao`
--

CREATE TABLE IF NOT EXISTS `funcao` (
  `id_funcao` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Horario_id_horario` int(10) unsigned NOT NULL,
  `descricao` varchar(255) NOT NULL,
  PRIMARY KEY (`id_funcao`),
  KEY `horario` (`Horario_id_horario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Extraindo dados da tabela `funcao`
--

INSERT INTO `funcao` (`id_funcao`, `Horario_id_horario`, `descricao`) VALUES
(1, 2, 'AUXILIAR DE PRODUCAO'),
(2, 2, 'OPERADOR DE UTILIDADES'),
(3, 2, 'JARDINEIRO'),
(4, 2, 'OPERADOR DE PRODUCAO'),
(5, 2, 'AUXILIAR MECANICO'),
(6, 2, 'MECANICO'),
(7, 2, 'ANALISTA DE QUALIDADE'),
(8, 2, 'COORDENADOR DE MANUTENCAO'),
(9, 2, 'AUXILIAR DE ARMAZENAGEM'),
(10, 2, 'PEDREIRO'),
(11, 2, 'AUXILIAR DE SERVICOS GERAIS'),
(12, 2, 'VISORISTA'),
(13, 2, 'PORTEIRO'),
(14, 1, 'GERENTE INDUSTRIAL'),
(15, 3, 'PROMOTOR DE MARKETING'),
(16, 1, 'ALMOXARIFE'),
(17, 1, 'ASSISTENTE ADIMINISTRATIVO FIANCEIRO'),
(18, 1, 'ANALISTA ADIMINISTRATIVO FIANCEIRO'),
(19, 1, 'MESTRE CERVEJEIRO'),
(20, 1, 'CAIXA'),
(21, 1, 'TECNICO DE T.I.');

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionario`
--

CREATE TABLE IF NOT EXISTS `funcionario` (
  `id_Funcionario` int(11) NOT NULL AUTO_INCREMENT,
  `Funcao_id_funcao` int(10) unsigned NOT NULL,
  `Relogio_id_relogio` int(10) unsigned NOT NULL,
  `matricula` int(10) unsigned NOT NULL,
  `dataDeAdmissao` date NOT NULL,
  `pis` varchar(255) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `cpf` varchar(255) NOT NULL,
  `rg` varchar(255) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `telefone` varchar(255) DEFAULT NULL,
  `observacoes` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_Funcionario`),
  KEY `relogio` (`Relogio_id_relogio`),
  KEY `funcao` (`Funcao_id_funcao`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Extraindo dados da tabela `funcionario`
--

INSERT INTO `funcionario` (`id_Funcionario`, `Funcao_id_funcao`, `Relogio_id_relogio`, `matricula`, `dataDeAdmissao`, `pis`, `nome`, `cpf`, `rg`, `endereco`, `telefone`, `observacoes`) VALUES
(1, 20, 2, 0, '0000-00-00', '', 'GLEIDSTONE FERREIRA DA SILVA', '', '', '', NULL, NULL),
(2, 3, 1, 0, '0000-00-00', '', 'JURACY JERONIMO DE ASSIS', '', '', '', NULL, NULL),
(3, 19, 1, 0, '0000-00-00', '', 'FRANCISCO ROBLES VALVERDE', '', '', '', NULL, NULL),
(4, 7, 1, 0, '0000-00-00', '', 'NAGELA CRISTINA COSTA ARAUJO', '', '', '', NULL, NULL),
(5, 17, 2, 0, '0000-00-00', '', 'ANDREA MAGDA LIMA MARCAL', '', '', '', NULL, NULL),
(6, 16, 1, 0, '0000-00-00', '', 'ERMINIO JARDIM DE LIMA', '', '', '', NULL, NULL),
(7, 8, 1, 0, '0000-00-00', '', 'MARCOS ANTONIO HARTER MOURA', '', '', '', NULL, NULL),
(8, 11, 1, 0, '0000-00-00', '', 'ALBANIZA PRAXEDES DA COSTA', '', '', '', NULL, NULL),
(9, 4, 1, 0, '0000-00-00', '', 'JORGE LUIS DE ARAGÃO', '', '', '', NULL, NULL),
(10, 7, 1, 0, '0000-00-00', '', 'VANEZA ELIANE DE OLIVEIRA', '', '', '', NULL, NULL),
(11, 11, 2, 0, '0000-00-00', '', 'MARIA IVONETE FERREIRA DA SILVA', '', '', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `horario`
--

CREATE TABLE IF NOT EXISTS `horario` (
  `id_horario` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) NOT NULL,
  PRIMARY KEY (`id_horario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `horario`
--

INSERT INTO `horario` (`id_horario`, `descricao`) VALUES
(1, 'ADMINISTRATIVO'),
(2, 'FABRIL'),
(3, 'COMERCIAL');

-- --------------------------------------------------------

--
-- Estrutura da tabela `jornada`
--

CREATE TABLE IF NOT EXISTS `jornada` (
  `id_diaSemana` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Horario_id_horario` int(10) unsigned NOT NULL,
  `diaSemana` varchar(255) NOT NULL,
  `entrada` varchar(255) NOT NULL,
  `almoco` varchar(255) DEFAULT NULL,
  `retorno` varchar(255) DEFAULT NULL,
  `saida` varchar(255) NOT NULL,
  PRIMARY KEY (`id_diaSemana`),
  KEY `horario` (`Horario_id_horario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Extraindo dados da tabela `jornada`
--

INSERT INTO `jornada` (`id_diaSemana`, `Horario_id_horario`, `diaSemana`, `entrada`, `almoco`, `retorno`, `saida`) VALUES
(1, 1, 'SEGUNDA', '08:00', NULL, NULL, '18:00'),
(2, 1, 'TERCA', '08:00', NULL, NULL, '18:00'),
(3, 1, 'QUARTA', '08:00', NULL, NULL, '18:00'),
(4, 1, 'QUINTA', '08:00', NULL, NULL, '18:00'),
(5, 1, 'SEXTA', '08:00', NULL, NULL, '17:00'),
(6, 2, 'SEGUNDA', '08:00', NULL, NULL, '18:00'),
(7, 2, 'TERCA', '08:00', NULL, NULL, '18:00'),
(8, 2, 'QUARTA', '08:00', NULL, NULL, '18:00'),
(9, 2, 'QUINTA', '08:00', NULL, NULL, '18:00'),
(10, 2, 'SEXTA', '08:00', NULL, NULL, '17:00'),
(11, 3, 'SEGUNDA', '08:00', NULL, NULL, '18:00'),
(12, 3, 'TERCA', '08:00', NULL, NULL, '18:00'),
(13, 3, 'QUARTA', '08:00', NULL, NULL, '18:00'),
(14, 3, 'QUINTA', '08:00', NULL, NULL, '18:00'),
(15, 3, 'SEXTA', '08:00', NULL, NULL, '18:00'),
(16, 3, 'SABADO', '08:00', NULL, NULL, '17:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pontos`
--

CREATE TABLE IF NOT EXISTS `pontos` (
  `id_ponto` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dataEhora` datetime NOT NULL,
  `Funcionario_id_Funcionario` int(11) NOT NULL,
  `observacoes` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_ponto`),
  KEY `funcionario` (`Funcionario_id_Funcionario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `relogio`
--

CREATE TABLE IF NOT EXISTS `relogio` (
  `id_relogio` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) NOT NULL,
  PRIMARY KEY (`id_relogio`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `relogio`
--

INSERT INTO `relogio` (`id_relogio`, `descricao`) VALUES
(1, 'RELOGIO_PRODUCAO'),
(2, 'RELOGIO_ADMINISTRATIVO');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
