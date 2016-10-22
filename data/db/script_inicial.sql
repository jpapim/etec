-- MySQL dump 10.16  Distrib 10.1.9-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: bdetec
-- ------------------------------------------------------
-- Server version	10.1.9-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `bdetec`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `bdetec` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `bdetec`;

--
-- Temporary table structure for view `acl`
--

DROP TABLE IF EXISTS `acl`;
/*!50001 DROP VIEW IF EXISTS `acl`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `acl` (
  `id_perfil` tinyint NOT NULL,
  `nm_resource` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `action`
--

DROP TABLE IF EXISTS `action`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `action` (
  `id_action` int(11) NOT NULL AUTO_INCREMENT,
  `nm_action` varchar(200) DEFAULT NULL COMMENT '{"label":"Ação"}',
  PRIMARY KEY (`id_action`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `action`
--

LOCK TABLES `action` WRITE;
/*!40000 ALTER TABLE `action` DISABLE KEYS */;
INSERT INTO `action` VALUES (1,'index'),(6,'cadastro'),(7,'gravar'),(8,'excluir'),(9,'upload'),(14,'dados-pessoais'),(15,'atualizar-dados'),(17,'gravar-atualizacao'),(27,'enviar-id'),(30,'ativar-id'),(35,'negar-id'),(36,'alterar-senha'),(37,'salvar-redefinicao-senha'),(51,'index-pagination'),(52,'cadastroperiodoletivodetalhe'),(53,'detalhe-pagination'),(54,'adicionarperiodoletivodetalhe'),(55,'excluirvialistagemperiodoletivo'),(56,'listar-permissoes-acoes'),(58,'autocompleteprofessor'),(59,'gerar-relatorio-pdf'),(60,'cadastro-detalhe'),(61,'adicionar-palavrachavetcc'),(62,'listar-palavrachavetcc'),(63,'excluir-palavrachavetcc-via-tcc'),(64,'adicionar-concluintes'),(65,'listar-concluintes'),(66,'excluir-concluinte-via-tcc'),(67,'download-arquivo'),(68,'pesquisar');
/*!40000 ALTER TABLE `action` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `area_conhecimento`
--

DROP TABLE IF EXISTS `area_conhecimento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `area_conhecimento` (
  `id_area_conhecimento` smallint(6) NOT NULL AUTO_INCREMENT,
  `nm_area_conhecimento` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_area_conhecimento`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `area_conhecimento`
--

LOCK TABLES `area_conhecimento` WRITE;
/*!40000 ALTER TABLE `area_conhecimento` DISABLE KEYS */;
INSERT INTO `area_conhecimento` VALUES (1,'Engenharia de Software'),(2,'Segurança da Informação'),(3,'Teste de Software'),(4,'Banco de Dados');
/*!40000 ALTER TABLE `area_conhecimento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `auth`
--

DROP TABLE IF EXISTS `auth`;
/*!50001 DROP VIEW IF EXISTS `auth`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `auth` (
  `id_usuario` tinyint NOT NULL,
  `id_perfil` tinyint NOT NULL,
  `em_email` tinyint NOT NULL,
  `pw_senha` tinyint NOT NULL,
  `nm_usuario` tinyint NOT NULL,
  `id_contrato` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `banca_examinadora`
--

DROP TABLE IF EXISTS `banca_examinadora`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `banca_examinadora` (
  `id_banca_examinadora` int(11) NOT NULL AUTO_INCREMENT,
  `dt_banca` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_banca_examinadora`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banca_examinadora`
--

LOCK TABLES `banca_examinadora` WRITE;
/*!40000 ALTER TABLE `banca_examinadora` DISABLE KEYS */;
INSERT INTO `banca_examinadora` VALUES (1,'2016-07-22 03:00:00'),(2,'2016-10-14 03:00:00'),(3,'2016-10-15 03:00:00'),(4,'2016-10-19 02:00:00');
/*!40000 ALTER TABLE `banca_examinadora` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `concluinte`
--

DROP TABLE IF EXISTS `concluinte`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `concluinte` (
  `id_concluinte` int(11) NOT NULL AUTO_INCREMENT,
  `id_curso` int(11) DEFAULT NULL,
  `nm_concluinte` varchar(50) DEFAULT NULL,
  `nr_matricula` varchar(20) DEFAULT NULL,
  `id_tcc` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_concluinte`),
  KEY `FK_concluinte_curso` (`id_curso`),
  KEY `fk_tcc_concluinte_idx` (`id_tcc`),
  CONSTRAINT `FK_concluinte_curso` FOREIGN KEY (`id_curso`) REFERENCES `curso` (`id_curso`),
  CONSTRAINT `fk_tcc_concluinte` FOREIGN KEY (`id_tcc`) REFERENCES `tcc` (`id_tcc`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `concluinte`
--

LOCK TABLES `concluinte` WRITE;
/*!40000 ALTER TABLE `concluinte` DISABLE KEYS */;
INSERT INTO `concluinte` VALUES (1,1,'Eduardo ','545485',2),(2,1,'Elias Jose','2332',1),(3,1,'jdvsvydjww','fefefe',4),(4,1,'fgegefgief','efefe',4);
/*!40000 ALTER TABLE `concluinte` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `config`
--

DROP TABLE IF EXISTS `config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `config` (
  `idconfigs` int(11) NOT NULL AUTO_INCREMENT,
  `nm_config` varchar(200) DEFAULT NULL COMMENT '{"label":"Nome da Configuração"}',
  `nm_valor` varchar(200) DEFAULT NULL COMMENT '{"label":"Valor"}',
  PRIMARY KEY (`idconfigs`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `config`
--

LOCK TABLES `config` WRITE;
/*!40000 ALTER TABLE `config` DISABLE KEYS */;
INSERT INTO `config` VALUES (1,'valor_por','99.00'),(2,'valor_de','119.00'),(3,'agencia','0643'),(4,'op','013'),(5,'conta_corrente','782.632-8'),(6,'favorecido','Alysson Vicuña de Oliveira'),(7,'situacao_pagamento_pendente','1'),(8,'situacao_pagamento_atraso','3'),(9,'situacao_pagamento_pago','2'),(10,'situacao_ativo','1'),(11,'situacao_inativo','2'),(12,'tipo_pagamento_mensalidade','1'),(13,'tipo_usuario_administrador','1'),(14,'tipo_usuario_aluno','2'),(15,'situacao_usuario_ativo','1'),(16,'situacao_usuario_inativo','2'),(17,'situacao_usuario_congelado','3'),(19,'perfil_administrador','1'),(20,'perfil_aluno','3'),(21,'qtd_niveis','3'),(22,'qtd_por_nivel','5'),(23,'tipo_telefone_residencial','1'),(24,'tipo_telefone_comercial','2'),(25,'tipo_telefone_celular','3'),(26,'telefone_admin','6191123250'),(27,'email_admin','alyssontkd@gmail.com'),(28,'nome_admin','Alysson Vicuña de Oliveira'),(29,'telefone_cel_admin','61991123250'),(30,'tipo_pagamento_bonus','2'),(32,'tipo_pagamento_saque','3'),(33,'limite_minimo_saque','300'),(34,'situacao_usuario_atrasado','4'),(35,'situacao_empresa_contrato_ativo','1'),(36,'situacao_empresa_contrato_inativo','2'),(37,'situacao_empresa_contrato_congelado','3'),(38,'situacao_empresa_contrato_regusado','4'),(39,'situacao_solicitacao_empresa_recusado','3'),(40,'situacao_solicitacao_empresa_aprovado','2'),(41,'situacao_solicitacao_empresa_pendente','1'),(42,'codigo_video_apresentacao','UsSSUglRMAw'),(43,'link_conferencia','login.hotconference.net.br/conference'),(44,'cnpj','08.988.564/0001-30'),(45,'razao_social','MC DE SA LIMA EPP'),(46,'endereco','SIA TR 05 LT 05 35 SL 211 ED. IMPORT CENTER GUARA DISTRITO FEDERAL'),(47,'exibir_no_combo','S'),(48,'nao_exibir_no_combo','N'),(49,'masculino','1'),(50,'feminino','2'),(51,'perfil_professor','2');
/*!40000 ALTER TABLE `config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `controller`
--

DROP TABLE IF EXISTS `controller`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `controller` (
  `id_controller` int(11) NOT NULL AUTO_INCREMENT,
  `nm_controller` varchar(400) DEFAULT NULL COMMENT '{"label":"Controller"}',
  `nm_modulo` varchar(50) DEFAULT NULL,
  `cs_exibir_combo` char(1) DEFAULT 'S',
  PRIMARY KEY (`id_controller`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `controller`
--

LOCK TABLES `controller` WRITE;
/*!40000 ALTER TABLE `controller` DISABLE KEYS */;
INSERT INTO `controller` VALUES (3,'usuario-usuario','Usuario','S'),(4,'application-index','Aplicação','N'),(9,'PhpBoletoZf2\\Controller\\Itau','Boleto do Itau','N'),(11,'principal-principal','Principal','S'),(12,'perfil-perfil','Perfil','S'),(23,'tipo_tcc-tipotcc','Tipo de TCC','S'),(24,'area_conhecimento-areaconhecimento','Área de Conhecimento','S'),(25,'controller-controller','Controller','S'),(26,'action-action','Actions','S'),(27,'periodo_letivo-periodoletivo','Periodo Letivo','S'),(28,'detalhe_periodo_letivo','Detalhe Periodo Letivo (Encontros)','S'),(29,'permissao-permissao','Gerenciador de Permissao','S'),(30,'professor-professor','Professores','S'),(31,'curso-curso','Cursos','S'),(32,'banca_examinadora-bancaexaminadora','Banca Examinadora','S'),(36,'palavra_chave-palavrachave','Palavras Chave','S'),(37,'infra-infra','Infraestrutura','S'),(38,'palavra_chave_tcc-palavrachavetcc','Palavra Chave TCC','S'),(39,'concluinte-concluinte','Concluinte (Alunos Formandos)','S'),(40,'tcc-tcc','TCC','S'),(41,'titulacao-titulacao','Titulaçao','S'),(42,'pesquisar-pesquisar','Pesquisar','S');
/*!40000 ALTER TABLE `controller` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `curso`
--

DROP TABLE IF EXISTS `curso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `curso` (
  `id_curso` int(11) NOT NULL AUTO_INCREMENT,
  `nm_curso` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_curso`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `curso`
--

LOCK TABLES `curso` WRITE;
/*!40000 ALTER TABLE `curso` DISABLE KEYS */;
INSERT INTO `curso` VALUES (1,'Bacharel em Sistema de Informação');
/*!40000 ALTER TABLE `curso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `email`
--

DROP TABLE IF EXISTS `email`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `email` (
  `id_email` int(11) NOT NULL AUTO_INCREMENT,
  `em_email` varchar(200) DEFAULT NULL COMMENT '{"label":"E-mail"}',
  `id_situacao` int(11) NOT NULL,
  PRIMARY KEY (`id_email`),
  KEY `ix_emails_situacao` (`id_situacao`),
  CONSTRAINT `FK_Reference_32` FOREIGN KEY (`id_situacao`) REFERENCES `situacao` (`id_situacao`),
  CONSTRAINT `fk_emails_situacao` FOREIGN KEY (`id_situacao`) REFERENCES `situacao` (`id_situacao`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `email`
--

LOCK TABLES `email` WRITE;
/*!40000 ALTER TABLE `email` DISABLE KEYS */;
INSERT INTO `email` VALUES (1,'administrador@gmail.com',1),(2,'alyssontkd@gmail.com',1),(16,'vanessa.coelho@projecao.br',1);
/*!40000 ALTER TABLE `email` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `esqueci_senha`
--

DROP TABLE IF EXISTS `esqueci_senha`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `esqueci_senha` (
  `id_esqueci_senha` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `tx_identificacao` varchar(60) DEFAULT NULL,
  `id_situacao` int(11) DEFAULT NULL,
  `dt_solicitacao` datetime DEFAULT NULL,
  `dt_alteracao` datetime NOT NULL,
  PRIMARY KEY (`id_esqueci_senha`),
  KEY `ix_esqueci_senha_usuarios` (`id_usuario`),
  KEY `ix_esqueci_senha_situacoes` (`id_situacao`),
  CONSTRAINT `FK_Reference_23` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`),
  CONSTRAINT `FK_Reference_40` FOREIGN KEY (`id_situacao`) REFERENCES `situacao` (`id_situacao`),
  CONSTRAINT `fk_esqueci_senha_situacoes1` FOREIGN KEY (`id_situacao`) REFERENCES `situacao` (`id_situacao`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_esqueci_senha_usuarios1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `esqueci_senha`
--

LOCK TABLES `esqueci_senha` WRITE;
/*!40000 ALTER TABLE `esqueci_senha` DISABLE KEYS */;
INSERT INTO `esqueci_senha` VALUES (1,1,'9cbf6bab3c6b428fafd6ebd7965df386',1,'2015-07-25 09:35:13','0000-00-00 00:00:00'),(2,2,'1e4bf63079dd38bff6fd2bcc65bcca4f',1,'2015-07-25 09:57:15','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `esqueci_senha` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login`
--

DROP TABLE IF EXISTS `login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login` (
  `id_Login` int(11) NOT NULL AUTO_INCREMENT,
  `pw_senha` varchar(40) DEFAULT NULL COMMENT '{"label":"Senha"}',
  `nr_tentativas` int(11) DEFAULT NULL COMMENT '{"label":"Tentativas"}',
  `dt_visita` datetime DEFAULT NULL COMMENT '{"label":"Data da última visita"}',
  `dt_registro` datetime DEFAULT NULL COMMENT '{"label":"Data de Registro"}',
  `id_usuario` int(11) NOT NULL,
  `id_email` int(11) NOT NULL,
  `id_situacao` int(11) NOT NULL,
  `id_perfil` int(11) NOT NULL,
  PRIMARY KEY (`id_Login`),
  KEY `ix_Login_emails` (`id_email`),
  KEY `ix_Login_situacao` (`id_situacao`),
  KEY `FK_Reference_26` (`id_perfil`),
  KEY `fk_Login_usuarios` (`id_usuario`),
  CONSTRAINT `FK_Reference_26` FOREIGN KEY (`id_perfil`) REFERENCES `perfil` (`id_perfil`),
  CONSTRAINT `FK_Reference_31` FOREIGN KEY (`id_situacao`) REFERENCES `situacao` (`id_situacao`),
  CONSTRAINT `fk_Login_emails` FOREIGN KEY (`id_email`) REFERENCES `email` (`id_email`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Login_situacao` FOREIGN KEY (`id_situacao`) REFERENCES `situacao` (`id_situacao`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Login_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login`
--

LOCK TABLES `login` WRITE;
/*!40000 ALTER TABLE `login` DISABLE KEYS */;
INSERT INTO `login` VALUES (1,'e10adc3949ba59abbe56e057f20f883e',1,'2014-08-27 21:53:33','2014-08-27 21:53:37',1,1,1,1),(2,'e10adc3949ba59abbe56e057f20f883e',NULL,NULL,'2015-01-30 15:01:11',2,2,1,1),(12,'25d55ad283aa400af464c76d713c07ad',NULL,NULL,'2016-10-22 11:10:28',13,16,2,2);
/*!40000 ALTER TABLE `login` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `membros_banca`
--

DROP TABLE IF EXISTS `membros_banca`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `membros_banca` (
  `id_membro_banca` int(11) NOT NULL AUTO_INCREMENT,
  `id_banca_examinadora` int(11) DEFAULT NULL,
  `id_professor` smallint(6) DEFAULT NULL,
  `cs_orientador` char(1) DEFAULT 'N',
  PRIMARY KEY (`id_membro_banca`),
  KEY `FK_Reference_97` (`id_banca_examinadora`),
  KEY `FK_Reference_98` (`id_professor`),
  CONSTRAINT `FK_Reference_97` FOREIGN KEY (`id_banca_examinadora`) REFERENCES `banca_examinadora` (`id_banca_examinadora`),
  CONSTRAINT `FK_Reference_98` FOREIGN KEY (`id_professor`) REFERENCES `professor` (`id_professor`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `membros_banca`
--

LOCK TABLES `membros_banca` WRITE;
/*!40000 ALTER TABLE `membros_banca` DISABLE KEYS */;
INSERT INTO `membros_banca` VALUES (1,1,1,'N'),(2,1,2,'S'),(3,2,1,'N'),(4,2,2,'S'),(5,3,1,'N'),(6,3,2,'S'),(7,3,5,'S'),(8,4,1,'N'),(9,4,2,'S'),(10,4,3,'N');
/*!40000 ALTER TABLE `membros_banca` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `palavra_chave`
--

DROP TABLE IF EXISTS `palavra_chave`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `palavra_chave` (
  `id_palavra_chave` bigint(20) NOT NULL AUTO_INCREMENT,
  `nm_palavra_chave` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id_palavra_chave`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `palavra_chave`
--

LOCK TABLES `palavra_chave` WRITE;
/*!40000 ALTER TABLE `palavra_chave` DISABLE KEYS */;
INSERT INTO `palavra_chave` VALUES (1,'Arduino'),(2,'Android'),(3,'IOS');
/*!40000 ALTER TABLE `palavra_chave` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `palavra_chave_tcc`
--

DROP TABLE IF EXISTS `palavra_chave_tcc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `palavra_chave_tcc` (
  `id_palavra_chave_tcc` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_tcc` bigint(20) DEFAULT NULL,
  `id_palavra_chave` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_palavra_chave_tcc`),
  KEY `FK_Reference_100` (`id_tcc`),
  KEY `FK_Reference_101` (`id_palavra_chave`),
  CONSTRAINT `FK_Reference_100` FOREIGN KEY (`id_tcc`) REFERENCES `tcc` (`id_tcc`),
  CONSTRAINT `FK_Reference_101` FOREIGN KEY (`id_palavra_chave`) REFERENCES `palavra_chave` (`id_palavra_chave`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `palavra_chave_tcc`
--

LOCK TABLES `palavra_chave_tcc` WRITE;
/*!40000 ALTER TABLE `palavra_chave_tcc` DISABLE KEYS */;
INSERT INTO `palavra_chave_tcc` VALUES (1,2,1),(2,2,2),(3,1,3),(4,1,1),(5,4,1),(6,4,2);
/*!40000 ALTER TABLE `palavra_chave_tcc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `perfil`
--

DROP TABLE IF EXISTS `perfil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `perfil` (
  `id_perfil` int(11) NOT NULL AUTO_INCREMENT COMMENT '{"label":"Id Perfil"}',
  `nm_perfil` varchar(100) NOT NULL COMMENT '{''label'':"Perfil"}',
  PRIMARY KEY (`id_perfil`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perfil`
--

LOCK TABLES `perfil` WRITE;
/*!40000 ALTER TABLE `perfil` DISABLE KEYS */;
INSERT INTO `perfil` VALUES (1,'Administrador'),(2,'Professor'),(3,'Aluno'),(4,'Auxiliar');
/*!40000 ALTER TABLE `perfil` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `perfil_controller_action`
--

DROP TABLE IF EXISTS `perfil_controller_action`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `perfil_controller_action` (
  `id_perfil_controller_action` int(11) NOT NULL AUTO_INCREMENT,
  `id_controller` int(11) NOT NULL,
  `id_action` int(11) NOT NULL,
  `id_perfil` int(11) NOT NULL,
  PRIMARY KEY (`id_perfil_controller_action`),
  KEY `ix_perfil_controller_action_controller` (`id_controller`),
  KEY `ix_perfil_controller_action_action` (`id_action`),
  KEY `ix_perfil_controller_action_perfil` (`id_perfil`),
  CONSTRAINT `fk_perfil_controller_action_action` FOREIGN KEY (`id_action`) REFERENCES `action` (`id_action`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_perfil_controller_action_controller` FOREIGN KEY (`id_controller`) REFERENCES `controller` (`id_controller`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_perfil_controller_action_perfil` FOREIGN KEY (`id_perfil`) REFERENCES `perfil` (`id_perfil`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=485 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perfil_controller_action`
--

LOCK TABLES `perfil_controller_action` WRITE;
/*!40000 ALTER TABLE `perfil_controller_action` DISABLE KEYS */;
INSERT INTO `perfil_controller_action` VALUES (3,3,1,1),(4,4,1,1),(20,3,7,1),(24,3,14,1),(27,3,17,1),(32,3,1,2),(33,4,1,2),(49,3,7,2),(53,3,14,2),(59,3,15,2),(62,3,15,1),(81,3,36,1),(82,3,36,2),(83,3,37,1),(84,3,37,2),(86,3,17,2),(87,9,1,1),(88,9,1,2),(89,3,6,1),(93,11,1,1),(95,12,1,1),(96,12,6,1),(97,12,7,1),(164,23,1,1),(169,23,6,1),(170,23,7,1),(171,23,8,1),(172,23,9,1),(177,23,14,1),(178,23,15,1),(180,23,17,1),(190,23,27,1),(193,23,30,1),(198,23,35,1),(199,23,36,1),(200,23,37,1),(214,23,51,1),(215,24,1,1),(220,24,6,1),(221,24,7,1),(222,24,8,1),(223,24,9,1),(228,24,14,1),(229,24,15,1),(231,24,17,1),(241,24,27,1),(244,24,30,1),(249,24,35,1),(250,24,36,1),(251,24,37,1),(265,24,51,1),(266,3,51,1),(267,3,51,2),(268,23,1,1),(269,23,6,1),(270,23,7,1),(271,23,8,1),(272,23,51,1),(273,25,1,1),(274,25,6,1),(275,25,7,1),(276,25,8,1),(277,25,51,1),(278,26,1,1),(279,26,6,1),(280,26,7,1),(281,26,8,1),(282,26,51,1),(283,27,1,1),(284,27,6,1),(285,27,7,1),(286,27,8,1),(287,27,51,1),(288,27,52,1),(289,27,53,1),(290,27,54,1),(291,28,55,1),(313,29,1,1),(315,29,6,1),(316,29,7,1),(317,29,8,1),(318,29,51,1),(319,29,56,1),(351,31,1,1),(352,31,6,1),(353,31,7,1),(354,31,8,1),(355,31,51,1),(384,36,1,1),(385,36,6,1),(386,36,7,1),(387,36,8,1),(388,36,51,1),(389,37,1,1),(390,11,1,2),(391,11,1,3),(392,11,1,4),(393,32,1,1),(394,32,6,1),(395,32,7,1),(396,32,8,1),(398,32,51,1),(399,32,53,1),(400,32,58,1),(401,38,1,1),(402,38,6,1),(403,38,7,1),(404,38,8,1),(405,38,9,1),(406,38,51,1),(407,39,1,1),(408,39,6,1),(409,39,7,1),(410,39,8,1),(411,39,51,1),(418,30,1,1),(419,30,6,1),(420,30,7,1),(421,30,8,1),(422,30,51,1),(423,30,58,1),(424,30,59,1),(438,40,1,1),(439,40,6,1),(440,40,7,1),(441,40,8,1),(442,40,9,1),(443,40,51,1),(444,40,60,1),(445,40,61,1),(446,40,62,1),(447,40,63,1),(448,40,64,1),(449,40,65,1),(450,40,66,1),(451,40,67,1),(452,41,1,1),(453,41,6,1),(454,41,7,1),(455,41,8,1),(456,41,51,1),(457,41,1,2),(458,41,6,2),(459,41,7,2),(460,41,8,2),(461,41,9,2),(462,41,51,2),(473,42,1,1),(474,42,6,1),(475,42,7,1),(476,42,8,1),(477,42,51,1),(478,42,68,1),(479,42,1,2),(480,42,6,2),(481,42,7,2),(482,42,8,2),(483,42,51,2),(484,42,68,2);
/*!40000 ALTER TABLE `perfil_controller_action` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `professor`
--

DROP TABLE IF EXISTS `professor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `professor` (
  `id_professor` smallint(6) NOT NULL AUTO_INCREMENT,
  `id_titulacao` smallint(6) DEFAULT NULL,
  `id_usuario_cadastro` int(11) DEFAULT NULL,
  `nm_professor` varchar(50) DEFAULT NULL,
  `dt_cadastro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cs_orientador` char(1) DEFAULT NULL,
  `cs_ativo` char(1) DEFAULT NULL,
  PRIMARY KEY (`id_professor`),
  KEY `FK_Reference_90` (`id_titulacao`),
  KEY `FK_Reference_91` (`id_usuario_cadastro`),
  CONSTRAINT `FK_Reference_90` FOREIGN KEY (`id_titulacao`) REFERENCES `titulacao` (`id_titulacao`),
  CONSTRAINT `FK_Reference_91` FOREIGN KEY (`id_usuario_cadastro`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `professor`
--

LOCK TABLES `professor` WRITE;
/*!40000 ALTER TABLE `professor` DISABLE KEYS */;
INSERT INTO `professor` VALUES (1,2,1,'Alysson Vicuña de Oliveira','2016-06-20 18:40:44','N','A'),(2,3,1,'Eduardo Prola Salinas','2016-06-20 18:41:10','S','A'),(3,3,1,'Vanessa Coelho','2016-10-14 18:34:49','N','A'),(4,3,1,'Jorge Targino','2016-10-14 18:35:07','N','A'),(5,2,1,'Fernando Feliu','2016-10-14 18:35:21','S','A'),(6,3,1,'Renato Leao','2016-10-15 13:18:43','S','I');
/*!40000 ALTER TABLE `professor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sexo`
--

DROP TABLE IF EXISTS `sexo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sexo` (
  `id_sexo` int(11) NOT NULL AUTO_INCREMENT,
  `nm_sexo` varchar(45) NOT NULL COMMENT '{"label":"Sexo"}',
  PRIMARY KEY (`id_sexo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sexo`
--

LOCK TABLES `sexo` WRITE;
/*!40000 ALTER TABLE `sexo` DISABLE KEYS */;
INSERT INTO `sexo` VALUES (1,'Masculino'),(2,'Feminino');
/*!40000 ALTER TABLE `sexo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `situacao`
--

DROP TABLE IF EXISTS `situacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `situacao` (
  `id_situacao` int(11) NOT NULL AUTO_INCREMENT,
  `nm_situacao` varchar(100) DEFAULT NULL COMMENT '{"label":"Situação"}',
  PRIMARY KEY (`id_situacao`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `situacao`
--

LOCK TABLES `situacao` WRITE;
/*!40000 ALTER TABLE `situacao` DISABLE KEYS */;
INSERT INTO `situacao` VALUES (1,'Ativo'),(2,'Inativo');
/*!40000 ALTER TABLE `situacao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `situacao_usuario`
--

DROP TABLE IF EXISTS `situacao_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `situacao_usuario` (
  `id_situacao_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nm_situacao_usuario` varchar(100) DEFAULT NULL COMMENT '{"label":"Situação usuário"}',
  PRIMARY KEY (`id_situacao_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `situacao_usuario`
--

LOCK TABLES `situacao_usuario` WRITE;
/*!40000 ALTER TABLE `situacao_usuario` DISABLE KEYS */;
INSERT INTO `situacao_usuario` VALUES (1,'Ativo'),(2,'Inativo'),(3,'Congelado'),(4,'Atrasado');
/*!40000 ALTER TABLE `situacao_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tcc`
--

DROP TABLE IF EXISTS `tcc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tcc` (
  `id_tcc` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_usuario_cadastro` int(11) DEFAULT NULL,
  `id_usuario_alteracao` int(11) DEFAULT NULL,
  `id_banca_examinadora` int(11) DEFAULT NULL,
  `id_area_conhecimento` smallint(6) DEFAULT NULL,
  `id_tipo_tcc` smallint(6) DEFAULT NULL,
  `id_professor_orientador` smallint(6) DEFAULT NULL,
  `tx_titulo_tcc` varchar(150) DEFAULT NULL,
  `tx_resumo` text,
  `dt_cadastro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dt_alteracao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `nr_nota_final` decimal(4,2) DEFAULT NULL,
  `ar_arquivo` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id_tcc`),
  KEY `FK_Reference_103` (`id_professor_orientador`),
  KEY `FK_Reference_93` (`id_usuario_cadastro`),
  KEY `FK_Reference_94` (`id_usuario_alteracao`),
  KEY `FK_Reference_95` (`id_banca_examinadora`),
  KEY `FK_Reference_96` (`id_area_conhecimento`),
  KEY `FK_Reference_99` (`id_tipo_tcc`),
  CONSTRAINT `FK_Reference_103` FOREIGN KEY (`id_professor_orientador`) REFERENCES `professor` (`id_professor`),
  CONSTRAINT `FK_Reference_93` FOREIGN KEY (`id_usuario_cadastro`) REFERENCES `usuario` (`id_usuario`),
  CONSTRAINT `FK_Reference_94` FOREIGN KEY (`id_usuario_alteracao`) REFERENCES `usuario` (`id_usuario`),
  CONSTRAINT `FK_Reference_95` FOREIGN KEY (`id_banca_examinadora`) REFERENCES `banca_examinadora` (`id_banca_examinadora`),
  CONSTRAINT `FK_Reference_96` FOREIGN KEY (`id_area_conhecimento`) REFERENCES `area_conhecimento` (`id_area_conhecimento`),
  CONSTRAINT `FK_Reference_99` FOREIGN KEY (`id_tipo_tcc`) REFERENCES `tipo_tcc` (`id_tipo_tcc`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tcc`
--

LOCK TABLES `tcc` WRITE;
/*!40000 ALTER TABLE `tcc` DISABLE KEYS */;
INSERT INTO `tcc` VALUES (1,1,1,1,2,1,5,'Teste','aqaqaq','2016-10-14 19:42:31','2016-10-16 20:16:20',10.00,NULL),(2,1,1,2,1,3,2,'Teste do Salinas','deded','2016-10-14 19:45:49','2016-10-16 20:16:20',99.99,NULL),(3,1,1,1,2,3,5,'Teste de Arquivo','swswswsw','2016-10-15 15:01:42','2016-10-16 20:16:20',99.99,NULL),(4,1,1,1,2,2,2,'rgrgrg','fbfvbfbfbfbfb','2016-10-19 00:03:56','2016-10-19 00:03:56',3.00,'Alysson Vicuña de Oliveira Curriculum Vitae - Gerencial_5806b86ccfed0.pdf');
/*!40000 ALTER TABLE `tcc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `telefone`
--

DROP TABLE IF EXISTS `telefone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `telefone` (
  `id_telefone` int(11) NOT NULL AUTO_INCREMENT,
  `nr_ddd_telefone` varchar(3) DEFAULT NULL COMMENT '{"label":"ddd"}',
  `nr_telefone` varchar(20) DEFAULT NULL COMMENT '{"label":"Telefone"}',
  `id_tipo_telefone` int(11) NOT NULL,
  `id_situacao` int(11) NOT NULL,
  PRIMARY KEY (`id_telefone`),
  KEY `ix_telefones_situacao` (`id_situacao`),
  KEY `fk_telefones_tipo_telefone1` (`id_tipo_telefone`),
  CONSTRAINT `fk_telefones_situacao` FOREIGN KEY (`id_situacao`) REFERENCES `situacao` (`id_situacao`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_telefones_tipo_telefone1` FOREIGN KEY (`id_tipo_telefone`) REFERENCES `tipo_telefone` (`id_tipo_telefone`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `telefone`
--

LOCK TABLES `telefone` WRITE;
/*!40000 ALTER TABLE `telefone` DISABLE KEYS */;
INSERT INTO `telefone` VALUES (1,'12','34567890',1,1),(2,'61','91613193',1,1),(17,'43','44554444',1,1);
/*!40000 ALTER TABLE `telefone` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_tcc`
--

DROP TABLE IF EXISTS `tipo_tcc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_tcc` (
  `id_tipo_tcc` smallint(6) NOT NULL AUTO_INCREMENT,
  `nm_tipo_tcc` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_tipo_tcc`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_tcc`
--

LOCK TABLES `tipo_tcc` WRITE;
/*!40000 ALTER TABLE `tipo_tcc` DISABLE KEYS */;
INSERT INTO `tipo_tcc` VALUES (1,'Projeto Completo'),(2,'Artigo Cienctífico'),(3,'Monografia');
/*!40000 ALTER TABLE `tipo_tcc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_telefone`
--

DROP TABLE IF EXISTS `tipo_telefone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_telefone` (
  `id_tipo_telefone` int(11) NOT NULL AUTO_INCREMENT,
  `nm_tipo_telefone` varchar(100) DEFAULT NULL COMMENT '{"label":"Tipo telefone"}',
  PRIMARY KEY (`id_tipo_telefone`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_telefone`
--

LOCK TABLES `tipo_telefone` WRITE;
/*!40000 ALTER TABLE `tipo_telefone` DISABLE KEYS */;
INSERT INTO `tipo_telefone` VALUES (1,'Residencial'),(2,'Comercial'),(3,'Celular');
/*!40000 ALTER TABLE `tipo_telefone` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_usuario`
--

DROP TABLE IF EXISTS `tipo_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_usuario` (
  `id_tipo_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nm_tipo_usuario` varchar(100) DEFAULT NULL COMMENT '{"label":"Tipo usuário"}',
  PRIMARY KEY (`id_tipo_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_usuario`
--

LOCK TABLES `tipo_usuario` WRITE;
/*!40000 ALTER TABLE `tipo_usuario` DISABLE KEYS */;
INSERT INTO `tipo_usuario` VALUES (1,'Administrador'),(2,'Professor'),(3,'Aluno');
/*!40000 ALTER TABLE `tipo_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `titulacao`
--

DROP TABLE IF EXISTS `titulacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `titulacao` (
  `id_titulacao` smallint(6) NOT NULL AUTO_INCREMENT,
  `nm_titulacao` varchar(35) DEFAULT NULL,
  PRIMARY KEY (`id_titulacao`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `titulacao`
--

LOCK TABLES `titulacao` WRITE;
/*!40000 ALTER TABLE `titulacao` DISABLE KEYS */;
INSERT INTO `titulacao` VALUES (1,'Doutor(a)'),(2,'Especialista'),(3,'Mestre');
/*!40000 ALTER TABLE `titulacao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nm_usuario` varchar(250) NOT NULL COMMENT '{"label":"Usuário"}',
  `nm_funcao` varchar(200) DEFAULT NULL COMMENT '{"label":"Profissão"}',
  `id_sexo` int(11) DEFAULT NULL,
  `id_perfil` int(11) DEFAULT NULL,
  `id_situacao_usuario` int(11) NOT NULL,
  `id_email` int(11) DEFAULT NULL,
  `id_telefone` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  KEY `ix_usuarios_sexo` (`id_sexo`),
  KEY `ix_usuarios_situacao_usuario` (`id_situacao_usuario`),
  KEY `ix_usuarios_emails` (`id_email`),
  KEY `ix_usuarios_telefones` (`id_telefone`),
  KEY `ix_usuarios_perfil` (`id_perfil`),
  CONSTRAINT `fk_usuarios_emails` FOREIGN KEY (`id_email`) REFERENCES `email` (`id_email`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuarios_perfil` FOREIGN KEY (`id_perfil`) REFERENCES `perfil` (`id_perfil`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuarios_sexo` FOREIGN KEY (`id_sexo`) REFERENCES `sexo` (`id_sexo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuarios_situacao_usuario` FOREIGN KEY (`id_situacao_usuario`) REFERENCES `situacao_usuario` (`id_situacao_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuarios_telefones` FOREIGN KEY (`id_telefone`) REFERENCES `telefone` (`id_telefone`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'Admin','Administrador',1,1,1,1,1),(2,'Alysson Vicuna de Oliveira',NULL,NULL,1,1,2,2),(13,'Vanessa Coelho','Coordenadora de Curso',2,2,1,16,17);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Current Database: `bdetec`
--

USE `bdetec`;

--
-- Final view structure for view `acl`
--

/*!50001 DROP TABLE IF EXISTS `acl`*/;
/*!50001 DROP VIEW IF EXISTS `acl`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `acl` AS (select `perfil_controller_action`.`id_perfil` AS `id_perfil`,concat(`controller`.`nm_controller`,'/',`action`.`nm_action`) AS `nm_resource` from ((`perfil_controller_action` join `controller` on((`controller`.`id_controller` = `perfil_controller_action`.`id_controller`))) join `action` on((`action`.`id_action` = `perfil_controller_action`.`id_action`)))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `auth`
--

/*!50001 DROP TABLE IF EXISTS `auth`*/;
/*!50001 DROP VIEW IF EXISTS `auth`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `auth` AS (select `login`.`id_usuario` AS `id_usuario`,`perfil`.`id_perfil` AS `id_perfil`,`email`.`em_email` AS `em_email`,`login`.`pw_senha` AS `pw_senha`,`usuario`.`nm_usuario` AS `nm_usuario`,1 AS `id_contrato` from (((`usuario` join `login` on((`login`.`id_usuario` = `usuario`.`id_usuario`))) join `email` on((`email`.`id_email` = `login`.`id_email`))) join `perfil` on((`perfil`.`id_perfil` = `login`.`id_perfil`)))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-10-22 13:36:07
