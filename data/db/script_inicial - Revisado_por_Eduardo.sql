-- MySQL dump 10.13  Distrib 5.6.26, for Win32 (x86)
--
-- Host: localhost    Database: bdetec
-- ------------------------------------------------------
-- Server version	5.6.24

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
-- Temporary view structure for view `acl`
--

DROP TABLE IF EXISTS `acl`;
/*!50001 DROP VIEW IF EXISTS `acl`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `acl` AS SELECT 
 1 AS `id_perfil`,
 1 AS `nm_resource`*/;
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
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `action`
--

LOCK TABLES `action` WRITE;
/*!40000 ALTER TABLE `action` DISABLE KEYS */;
INSERT INTO `action` VALUES (1,'index'),(2,'cadastro'),(3,'gravar'),(4,'excluir'),(5,'upload'),(6,'dados-pessoais'),(7,'atualizar-dados'),(8,'gravar-atualizacao'),(9,'enviar-id'),(10,'ativar-id'),(11,'negar-id'),(12,'alterar-senha'),(13,'salvar-redefinicao-senha'),(14,'index-pagination'),(15,'detalhe-pagination'),(16,'listar-permissoes-acoes'),(17,'autocompleteprofessor'),(18,'cadastro-detalhe'),(19,'adicionar-palavrachavetcc'),(20,'listar-palavrachavetcc'),(21,'excluir-palavrachavetcc-via-tcc'),(22,'adicionar-concluintes'),(23,'listar-concluintes'),(24,'excluir-concluinte-via-tcc'),(25,'download-arquivo'),(26,'pesquisar'),(27,'realizar-pesquisa-tcc'),(28,'detalhes-filtros-pagination'),(29,'realizarinscricoes'),(30,'listar-professores'),(31,'adicionar-professores'),(32,'excluir-membrobanca-via-banca');
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
-- Temporary view structure for view `auth`
--

DROP TABLE IF EXISTS `auth`;
/*!50001 DROP VIEW IF EXISTS `auth`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `auth` AS SELECT 
 1 AS `id_usuario`,
 1 AS `id_perfil`,
 1 AS `em_email`,
 1 AS `pw_senha`,
 1 AS `nm_usuario`,
 1 AS `id_contrato`*/;
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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banca_examinadora`
--

LOCK TABLES `banca_examinadora` WRITE;
/*!40000 ALTER TABLE `banca_examinadora` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `concluinte`
--

LOCK TABLES `concluinte` WRITE;
/*!40000 ALTER TABLE `concluinte` DISABLE KEYS */;
/*!40000 ALTER TABLE `concluinte` ENABLE KEYS */;
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
INSERT INTO `controller` VALUES (1,'usuario-usuario','Usuario','S'),(2,'application-index','Aplicação','N'),(3,'principal-principal','Principal','S'),(4,'perfil-perfil','Perfil','S'),(5,'tipo_tcc-tipotcc','Tipo de TCC','S'),(6,'area_conhecimento-areaconhecimento','Área de Conhecimento','S'),(7,'controller-controller','Controller','S'),(8,'action-action','Actions','S'),(9,'permissao-permissao','Gerenciador de Permissao','S'),(10,'professor-professor','Professores','S'),(11,'curso-curso','Cursos','S'),(12,'banca_examinadora-bancaexaminadora','Banca Examinadora','S'),(13,'palavra_chave-palavrachave','Palavras Chave','S'),(14,'infra-infra','Infraestrutura','S'),(15,'palavra_chave_tcc-palavrachavetcc','Palavra Chave TCC','S'),(16,'concluinte-concluinte','Concluinte (Alunos Formandos)','S'),(17,'tcc-tcc','TCC','S'),(18,'titulacao-titulacao','Titulaçao','S'),(19,'pesquisar-pesquisar','Pesquisar','S');
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `curso`
--

LOCK TABLES `curso` WRITE;
/*!40000 ALTER TABLE `curso` DISABLE KEYS */;
INSERT INTO `curso` VALUES (1,'Bacharel em Sistema de Informação'),(2,'TADS');
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
INSERT INTO `login` VALUES (1,'e10adc3949ba59abbe56e057f20f883e',1,'2014-08-27 21:53:33','2014-08-27 21:53:37',1,1,1,1),(2,'e10adc3949ba59abbe56e057f20f883e',NULL,NULL,'2015-01-30 15:01:11',2,2,1,1),(3,'25d55ad283aa400af464c76d713c07ad',NULL,NULL,'2016-10-22 11:10:28',13,16,2,2);
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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `membros_banca`
--

LOCK TABLES `membros_banca` WRITE;
/*!40000 ALTER TABLE `membros_banca` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `palavra_chave_tcc`
--

LOCK TABLES `palavra_chave_tcc` WRITE;
/*!40000 ALTER TABLE `palavra_chave_tcc` DISABLE KEYS */;
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
INSERT INTO `perfil` VALUES (1,'Administrador'),(2,'Coordernação'),(3,'Secretaría');
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
) ENGINE=InnoDB AUTO_INCREMENT=565 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perfil_controller_action`
--

LOCK TABLES `perfil_controller_action` WRITE;
/*!40000 ALTER TABLE `perfil_controller_action` DISABLE KEYS */;
INSERT INTO `perfil_controller_action` VALUES (1,1,12,1), (2,1,7,1), (3,1,2,1), (4,1,6,1), (5,1,3,1), (6,1,8,1), (7,1,1,1), (8,1,14,1), (9,1,13,1), (10,2,1,1), (11,3,1,1), (12,4,2,1), (13,4,4,1), (14,4,3,1), (15,4,1,1), (16,5,2,1), (17,5,4,1), (18,5,3,1), (19,5,1,1), (20,5,14,1), (21,6,12,1), (22,6,10,1), (23,6,7,1), (24,6,2,1), (25,6,6,1), (26,6,9,1), (27,6,4,1), (28,6,3,1), (29,6,8,1), (30,6,1,1), (31,6,14,1), (32,6,11,1), (33,6,13,1), (34,6,5,1), (35,7,2,1), (36,7,4,1), (37,7,3,1), (38,7,1,1), (39,7,14,1), (40,8,2,1), (41,8,4,1), (42,8,3,1), (43,8,1,1), (44,8,14,1), (45,9,2,1), (46,9,4,1), (47,9,3,1), (48,9,1,1), (49,9,14,1), (50,9,16,1), (51,10,2,1), (52,10,4,1), (53,10,3,1), (54,10,1,1), (55,10,14,1), (56,11,2,1), (57,11,4,1), (58,11,3,1), (59,11,1,1), (60,11,14,1), (61,12,31,1), (62,12,17,1), (63,12,2,1), (64,12,18,1), (65,12,15,1), (66,12,4,1), (67,12,32,1), (68,12,3,1), (69,12,1,1), (70,12,14,1), (71,12,30,1), (72,12,29,1), (73,13,2,1), (74,13,4,1), (75,13,3,1), (76,13,1,1), (77,13,14,1), (78,14,1,1), (79,15,2,1), (80,15,4,1), (81,15,3,1), (82,15,1,1), (83,15,14,1), (84,16,2,1), (85,16,4,1), (86,16,3,1), (87,16,1,1), (88,16,14,1), (89,17,22,1), (90,17,19,1), (91,17,2,1), (92,17,18,1), (93,17,4,1), (94,17,24,1), (95,17,25,1), (96,17,21,1), (97,17,3,1), (98,17,1,1), (99,17,14,1), (100,17,23,1), (101,17,20,1), (102,17,5,1), (103,18,2,1), (104,18,4,1), (105,18,3,1), (106,18,1,1), (107,18,14,1), (108,19,2,1), (109,19,28,1), (110,19,4,1), (111,19,3,1), (112,19,1,1), (113,19,14,1), (114,19,26,1), (115,19,27,1), (116,1,12,2), (117,1,7,2), (118,1,2,2), (119,1,6,2), (120,1,3,2), (121,1,8,2), (122,1,1,2), (123,1,14,2), (124,1,13,2), (125,2,1,2), (126,3,1,2), (127,4,2,2), (128,4,4,2), (129,4,3,2), (130,4,1,2), (131,5,2,2), (132,5,4,2), (133,5,3,2), (134,5,1,2), (135,5,14,2), (136,6,12,2), (137,6,10,2), (138,6,7,2), (139,6,2,2), (140,6,6,2), (141,6,9,2), (142,6,4,2), (143,6,3,2), (144,6,8,2), (145,6,1,2), (146,6,14,2), (147,6,11,2), (148,6,13,2), (149,6,5,2), (150,7,2,2), (151,7,4,2), (152,7,3,2), (153,7,1,2), (154,7,14,2), (155,8,2,2), (156,8,4,2), (157,8,3,2), (158,8,1,2), (159,8,14,2), (160,9,2,2), (161,9,4,2), (162,9,3,2), (163,9,1,2), (164,9,14,2), (165,9,16,2), (166,10,2,2), (167,10,4,2), (168,10,3,2), (169,10,1,2), (170,10,14,2), (171,11,2,2), (172,11,4,2), (173,11,3,2), (174,11,1,2), (175,11,14,2), (176,12,31,2), (177,12,17,2), (178,12,2,2), (179,12,18,2), (180,12,15,2), (181,12,4,2), (182,12,32,2), (183,12,3,2), (184,12,1,2), (185,12,14,2), (186,12,30,2), (187,12,29,2), (188,13,2,2), (189,13,4,2), (190,13,3,2), (191,13,1,2), (192,13,14,2), (193,14,1,2), (194,15,2,2), (195,15,4,2), (196,15,3,2), (197,15,1,2), (198,15,14,2), (199,16,2,2), (200,16,4,2), (201,16,3,2), (202,16,1,2), (203,16,14,2), (204,17,22,2), (205,17,19,2), (206,17,2,2), (207,17,18,2), (208,17,4,2), (209,17,24,2), (210,17,25,2), (211,17,21,2), (212,17,3,2), (213,17,1,2), (214,17,14,2), (215,17,23,2), (216,17,20,2), (217,17,5,2), (218,18,2,2), (219,18,4,2), (220,18,3,2), (221,18,1,2), (222,18,14,2), (223,19,2,2), (224,19,28,2), (225,19,4,2), (226,19,3,2), (227,19,1,2), (228,19,14,2), (229,19,26,2), (230,19,27,2), (231,1,12,3), (232,1,7,3), (233,1,2,3), (234,1,6,3), (235,1,3,3), (236,1,8,3), (237,1,1,3), (238,1,14,3), (239,1,13,3), (240,2,1,3), (241,3,1,3), (242,4,2,3), (243,4,4,3), (244,4,3,3), (245,4,1,3), (246,5,2,3), (247,5,4,3), (248,5,3,3), (249,5,1,3), (250,5,14,3), (251,6,12,3), (252,6,10,3), (253,6,7,3), (254,6,2,3), (255,6,6,3), (256,6,9,3), (257,6,4,3), (258,6,3,3), (259,6,8,3), (260,6,1,3), (261,6,14,3), (262,6,11,3), (263,6,13,3), (264,6,5,3), (265,7,2,3), (266,7,4,3), (267,7,3,3), (268,7,1,3), (269,7,14,3), (270,8,2,3), (271,8,4,3), (272,8,3,3), (273,8,1,3), (274,8,14,3), (275,9,2,3), (276,9,4,3), (277,9,3,3), (278,9,1,3), (279,9,14,3), (280,9,16,3), (281,10,2,3), (282,10,4,3), (283,10,3,3), (284,10,1,3), (285,10,14,3), (286,11,2,3), (287,11,4,3), (288,11,3,3), (289,11,1,3), (290,11,14,3), (291,12,31,3), (292,12,17,3), (293,12,2,3), (294,12,18,3), (295,12,15,3), (296,12,4,3), (297,12,32,3), (298,12,3,3), (299,12,1,3), (300,12,14,3), (301,12,30,3), (302,12,29,3), (303,13,2,3), (304,13,4,3), (305,13,3,3), (306,13,1,3), (307,13,14,3), (308,14,1,3), (309,15,2,3), (310,15,4,3), (311,15,3,3), (312,15,1,3), (313,15,14,3), (314,16,2,3), (315,16,4,3), (316,16,3,3), (317,16,1,3), (318,16,14,3), (319,17,22,3), (320,17,19,3), (321,17,2,3), (322,17,18,3), (323,17,4,3), (324,17,24,3), (325,17,25,3), (326,17,21,3), (327,17,3,3), (328,17,1,3), (329,17,14,3), (330,17,23,3), (331,17,20,3), (332,17,5,3), (333,18,2,3), (334,18,4,3), (335,18,3,3), (336,18,1,3), (337,18,14,3), (338,19,2,3), (339,19,28,3), (340,19,4,3), (341,19,3,3), (342,19,1,3), (343,19,14,3), (344,19,26,3), (345,19,27,3);
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
INSERT INTO `professor` VALUES (1,2,1,'Alysson Vicuña de Oliveira','2016-06-20 18:40:44','N','A'),(2,3,1,'Eduardo Prola Salinas','2016-06-20 18:41:10','S','A'),(3,3,1,'Vanessa Coelho','2016-10-14 18:34:49','N','A'),(4,3,1,'Jorge Targino','2016-10-14 18:35:07','N','A'),(5,2,1,'Fernando Feliu','2016-10-14 18:35:21','S','A'),(6,3,1,'Renato Leao','2016-10-15 13:18:43','S','A');
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
  `dt_alteracao` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tcc`
--

LOCK TABLES `tcc` WRITE;
/*!40000 ALTER TABLE `tcc` DISABLE KEYS */;
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
INSERT INTO `tipo_usuario` VALUES (1,'Administrador'),(2,'Coordernação'),(3,'Secretaría');
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

-- Dump completed on 2016-11-01 11:28:40
