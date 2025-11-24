/*
SQLyog Professional v13.1.1 (64 bit)
MySQL - 5.1.41 : Database - GESCOT
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`GESCOT` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `GESCOT`;

/*Table structure for table `cab_capacitacion` */

DROP TABLE IF EXISTS `cab_capacitacion`;

CREATE TABLE `cab_capacitacion` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `cip` varchar(20) DEFAULT NULL,
  `fec_reg` datetime DEFAULT NULL,
  `usu_reg` char(10) DEFAULT NULL,
  `tp_incidencia` varchar(50) DEFAULT NULL,
  `motivo_incidencia` varchar(5) DEFAULT NULL,
  `fec_ini_inc` datetime DEFAULT NULL,
  `fec_fin_inc` datetime DEFAULT NULL,
  `obs_incidencia` text,
  `nro_participantes` int(2) DEFAULT '0',
  `cod_incidencia` varchar(50) DEFAULT NULL,
  `ejecuto` varchar(1) DEFAULT '',
  `tiempo` time DEFAULT NULL,
  `modo` varchar(10) DEFAULT NULL,
  `c_doid` varchar(50) DEFAULT NULL,
  `dni` varchar(30) DEFAULT NULL,
  `dias` int(2) DEFAULT '0',
  `sub_tipo` varchar(20) DEFAULT NULL,
  `tema` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `NewIndex1` (`cip`),
  KEY `NewIndex2` (`dni`)
) ENGINE=MyISAM AUTO_INCREMENT=104048 DEFAULT CHARSET=utf8;

/*Table structure for table `cab_incidencia` */

DROP TABLE IF EXISTS `cab_incidencia`;

CREATE TABLE `cab_incidencia` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `cip` varchar(20) DEFAULT NULL,
  `fec_reg` datetime DEFAULT NULL,
  `usu_reg` char(10) DEFAULT NULL,
  `tp_incidencia` varchar(50) DEFAULT NULL,
  `motivo_incidencia` varchar(5) DEFAULT NULL,
  `fec_ini_inc` datetime DEFAULT NULL,
  `fec_fin_inc` datetime DEFAULT NULL,
  `obs_incidencia` varchar(100) DEFAULT NULL,
  `nro_participantes` int(2) DEFAULT '0',
  `cod_incidencia` varchar(50) DEFAULT NULL,
  `ejecuto` varchar(1) DEFAULT '',
  `tiempo` time DEFAULT NULL,
  `tt_min` varchar(10) DEFAULT NULL,
  `modo` varchar(10) DEFAULT NULL,
  `estado_inc` varchar(10) DEFAULT NULL,
  `c_doid` varchar(50) DEFAULT NULL,
  `dni` varchar(30) DEFAULT NULL,
  `dias` varchar(10) DEFAULT NULL,
  `fec_mov_est` datetime DEFAULT NULL,
  `usu_mov_est` varchar(10) DEFAULT NULL,
  `fec_rechazo` datetime DEFAULT NULL,
  `usu_rechazo` varchar(10) DEFAULT NULL,
  `mot_rechazo` varchar(50) DEFAULT NULL,
  `fec_cancelado` datetime DEFAULT NULL,
  `usu_cancelado` varchar(10) DEFAULT NULL,
  `mot_cancelado` varchar(50) DEFAULT NULL,
  `fec_aprobado` datetime DEFAULT NULL,
  `usu_aprobado` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `NewIndex1` (`cip`),
  KEY `NewIndex2` (`dni`),
  KEY `NewIndex3` (`obs_incidencia`),
  KEY `cod_incidencia` (`cod_incidencia`)
) ENGINE=MyISAM AUTO_INCREMENT=574169 DEFAULT CHARSET=utf8;

/*Table structure for table `cargos_rrhh` */

DROP TABLE IF EXISTS `cargos_rrhh`;

CREATE TABLE `cargos_rrhh` (
  `Cargo` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `categoria` varchar(100) CHARACTER SET latin1 DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `config_usuarios` */

DROP TABLE IF EXISTS `config_usuarios`;

CREATE TABLE `config_usuarios` (
  `idUser` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `Usuario` varchar(50) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `idsess` varchar(100) NOT NULL,
  `OrdenServAte` varchar(250) NOT NULL,
  `EstadoUser` char(1) NOT NULL DEFAULT 'A',
  `f_ultimo_in` datetime DEFAULT NULL,
  `passwd` varchar(100) NOT NULL,
  `Accesos` varchar(50) NOT NULL,
  `Supervision` varchar(100) NOT NULL,
  `Perfil` varchar(100) NOT NULL,
  `Perfil_acc` varchar(50) NOT NULL,
  `VoIP` varchar(20) NOT NULL,
  `CodPage` text NOT NULL,
  `Carnet` varchar(20) NOT NULL,
  `AccesoFO_NAP` char(1) NOT NULL DEFAULT 'N',
  `flagConformidad` char(1) NOT NULL DEFAULT 'N',
  `disp_mapa_calor` smallint(1) NOT NULL DEFAULT '0',
  `disp_czonal` varchar(50) NOT NULL,
  `codMotivosTratTecnicas` text NOT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `obs` varchar(255) NOT NULL,
  `TraTecZonal` varchar(255) NOT NULL,
  `fecha_desactivacion` datetime DEFAULT NULL,
  `dni` char(8) NOT NULL,
  `NroCel` varchar(12) NOT NULL,
  `f_ultimaConsulta` datetime NOT NULL,
  `TOA` char(1) NOT NULL DEFAULT 'N',
  `codMotTratTecDes` varchar(255) NOT NULL,
  `LimProv` char(1) NOT NULL,
  `gescot` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`Usuario`),
  UNIQUE KEY `IsUser` (`idUser`)
) ENGINE=MyISAM AUTO_INCREMENT=49386 DEFAULT CHARSET=latin1;

/*Table structure for table `cot_area` */

DROP TABLE IF EXISTS `cot_area`;

CREATE TABLE `cot_area` (
  `id_area` int(1) NOT NULL AUTO_INCREMENT,
  `nom_area` varchar(150) CHARACTER SET latin1 DEFAULT NULL,
  `responsable` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id_area`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Table structure for table `cot_grupo` */

DROP TABLE IF EXISTS `cot_grupo`;

CREATE TABLE `cot_grupo` (
  `c_grupo` int(1) NOT NULL AUTO_INCREMENT,
  `grupo` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`c_grupo`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Table structure for table `data_reniec` */

DROP TABLE IF EXISTS `data_reniec`;

CREATE TABLE `data_reniec` (
  `dni` varchar(100) DEFAULT NULL,
  `colum_2` varchar(100) DEFAULT NULL,
  `colum_3` varchar(100) DEFAULT NULL,
  `colum_4` varchar(100) DEFAULT NULL,
  `sexo` varchar(100) DEFAULT NULL,
  `fec_nac` varchar(100) DEFAULT NULL,
  `colum_7` varchar(100) DEFAULT NULL,
  `colum_8` varchar(100) DEFAULT NULL,
  `colum_9` varchar(100) DEFAULT NULL,
  `colum_10` varchar(100) DEFAULT NULL,
  `colum_11` varchar(100) DEFAULT NULL,
  `colum_12` varchar(100) DEFAULT NULL,
  `colum_13` varchar(100) DEFAULT NULL,
  `fec_nac_` date DEFAULT NULL,
  KEY `NewIndex1` (`dni`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `det_incidencia` */

DROP TABLE IF EXISTS `det_incidencia`;

CREATE TABLE `det_incidencia` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `cod_incidencia` varchar(100) DEFAULT NULL,
  `usu_mov` varchar(10) DEFAULT NULL,
  `fec_mov` datetime DEFAULT NULL,
  `modo` varchar(10) DEFAULT NULL,
  `fec_ini` datetime DEFAULT NULL,
  `fec_fin` datetime DEFAULT NULL,
  `tiempo` time DEFAULT NULL,
  `dias` int(2) DEFAULT NULL,
  `obs` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=48963 DEFAULT CHARSET=utf8;

/*Table structure for table `historico_cambio_horarios` */

DROP TABLE IF EXISTS `historico_cambio_horarios`;

CREATE TABLE `historico_cambio_horarios` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `gestor` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `hor_ant` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `hor_nuevo` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `iduser` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fec_mov` datetime DEFAULT NULL,
  `obs` text COLLATE utf8_spanish_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Table structure for table `historico_usuarios_maestra` */

DROP TABLE IF EXISTS `historico_usuarios_maestra`;

CREATE TABLE `historico_usuarios_maestra` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `dni` varchar(50) NOT NULL,
  `dato` char(50) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `aplicativo` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `tipo_mov` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `fec_mov` datetime NOT NULL,
  `fec_ini` date NOT NULL,
  `fec_fin` date NOT NULL,
  `usu_mov` varchar(30) NOT NULL DEFAULT '',
  `obs_mov` text NOT NULL,
  `est` varchar(50) NOT NULL DEFAULT '',
  `apli_` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `perfil` char(50) CHARACTER SET utf8 NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=48847 DEFAULT CHARSET=latin1;

/*Table structure for table `horario_cot_anual` */

DROP TABLE IF EXISTS `horario_cot_anual`;

CREATE TABLE `horario_cot_anual` (
  `Mes` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `CIP` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `NCOMPLETO` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `FECHA_INICIO` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `COD_HORARIO` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `FECHA_FIN` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `Detalle_horario` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `grupo` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `Lider_Directo` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `Comentario` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `dni` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `maestra` varchar(10) DEFAULT NULL,
  `n_fecha_inicio` date DEFAULT NULL,
  `n_fecha_fin` date DEFAULT NULL,
  `est` varchar(10) DEFAULT NULL,
  `f_carga` datetime DEFAULT NULL,
  `xmes` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `horario_cot_mes` */

DROP TABLE IF EXISTS `horario_cot_mes`;

CREATE TABLE `horario_cot_mes` (
  `Mes` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `CIP` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `NCOMPLETO` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `FECHA_INICIO` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `COD_HORARIO` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `FECHA_FIN` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `Detalle_horario` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `Area` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `Lider_Directo` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `Comentario` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `dni` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `maestra` varchar(10) DEFAULT NULL,
  `n_fecha_inicio` date DEFAULT NULL,
  `n_fecha_fin` date DEFAULT NULL,
  `est` varchar(10) DEFAULT NULL,
  `f_carga` datetime DEFAULT NULL,
  KEY `CIP` (`CIP`),
  KEY `dni` (`dni`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `horarios_cot` */

DROP TABLE IF EXISTS `horarios_cot`;

CREATE TABLE `horarios_cot` (
  `Mes` varchar(100) DEFAULT NULL,
  `CIP` varchar(100) DEFAULT NULL,
  `NCOMPLETO` varchar(100) DEFAULT NULL,
  `FECHA_INICIO` varchar(100) DEFAULT NULL,
  `COD_HORARIO` varchar(100) DEFAULT NULL,
  `FECHA_FIN` varchar(100) DEFAULT NULL,
  `Detalle_horario` varchar(100) DEFAULT NULL,
  `Area` varchar(100) DEFAULT NULL,
  `Lider_Directo` varchar(100) DEFAULT NULL,
  `Comentario` varchar(100) DEFAULT NULL,
  `dni` varchar(50) DEFAULT NULL,
  `n_fecha_inicio` date DEFAULT NULL,
  `n_fecha_fin` date DEFAULT NULL,
  `est` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `horarios_gestores_cot` */

DROP TABLE IF EXISTS `horarios_gestores_cot`;

CREATE TABLE `horarios_gestores_cot` (
  `dni` varchar(20) CHARACTER SET latin1 NOT NULL,
  `cip` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `ncompleto` varchar(200) CHARACTER SET latin1 DEFAULT NULL,
  `supervisor` varchar(350) DEFAULT NULL,
  `cargo` varchar(100) DEFAULT '',
  `cod_horario` char(15) NOT NULL DEFAULT '',
  `desc_horario` varchar(300) DEFAULT '',
  `dias_horario` varchar(100) DEFAULT NULL,
  `hor_ini` varchar(50) DEFAULT NULL,
  `hor_fin` varchar(50) DEFAULT NULL,
  `vacaciones` varchar(10) DEFAULT '',
  `f_carga` datetime DEFAULT NULL,
  KEY `NewIndex1` (`dni`),
  KEY `cip` (`cip`),
  KEY `cod_horario` (`cod_horario`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `horarios_manuales` */

DROP TABLE IF EXISTS `horarios_manuales`;

CREATE TABLE `horarios_manuales` (
  `cip` varchar(50) DEFAULT NULL,
  `dni` varchar(50) DEFAULT NULL,
  `ncompleto` varchar(350) DEFAULT NULL,
  `c_horario` varchar(50) DEFAULT NULL,
  `d_horario` varchar(200) DEFAULT NULL,
  `enc` varchar(20) DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `horarios_rrhh` */

DROP TABLE IF EXISTS `horarios_rrhh`;

CREATE TABLE `horarios_rrhh` (
  `cod_horario` varchar(10) DEFAULT NULL,
  `descripcion_1` varchar(200) DEFAULT NULL,
  `descripcion_2` varbinary(200) DEFAULT NULL,
  `tipo_horario` varchar(100) DEFAULT NULL,
  `categoria` varchar(100) DEFAULT NULL,
  `F1` varchar(50) DEFAULT NULL,
  `F2` varchar(50) DEFAULT NULL,
  `xdias` varchar(30) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `lista_capacitacion` */

DROP TABLE IF EXISTS `lista_capacitacion`;

CREATE TABLE `lista_capacitacion` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `cod_incidencia` varchar(100) DEFAULT NULL,
  `cip_gestor` varchar(50) DEFAULT NULL,
  `dni` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `NewIndex1` (`cod_incidencia`),
  KEY `NewIndex2` (`dni`),
  KEY `NewIndex3` (`cip_gestor`)
) ENGINE=MyISAM AUTO_INCREMENT=75931 DEFAULT CHARSET=utf8;

/*Table structure for table `lista_gestores` */

DROP TABLE IF EXISTS `lista_gestores`;

CREATE TABLE `lista_gestores` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `cod_incidencia` varchar(100) DEFAULT NULL,
  `cip_gestor` varchar(50) DEFAULT NULL,
  `dni` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `NewIndex1` (`cod_incidencia`),
  KEY `NewIndex2` (`dni`),
  KEY `NewIndex3` (`cip_gestor`)
) ENGINE=MyISAM AUTO_INCREMENT=22203 DEFAULT CHARSET=utf8;

/*Table structure for table `maestra_cot_act` */

DROP TABLE IF EXISTS `maestra_cot_act`;

CREATE TABLE `maestra_cot_act` (
  `CAMPO1` int(100) NOT NULL AUTO_INCREMENT,
  `CAMPO2` varchar(100) DEFAULT NULL,
  `dni` varchar(100) DEFAULT NULL,
  `cip` varchar(100) DEFAULT NULL,
  `CAMPO5` varchar(100) DEFAULT NULL,
  `CAMPO6` varchar(100) DEFAULT NULL,
  `CAMPO7` varchar(100) DEFAULT NULL,
  `CAMPO8` varchar(100) DEFAULT NULL,
  `CAMPO9` varchar(100) DEFAULT NULL,
  `CAMPO10` varchar(100) DEFAULT NULL,
  `CAMPO11` varchar(100) DEFAULT NULL,
  `CAMPO12` varchar(100) DEFAULT NULL,
  `CAMPO13` varchar(100) DEFAULT NULL,
  `CAMPO14` varchar(100) DEFAULT NULL,
  `CAMPO15` varchar(100) DEFAULT NULL,
  `CAMPO16` varchar(100) DEFAULT NULL,
  `CAMPO17` varchar(100) DEFAULT NULL,
  `CAMPO18` varchar(100) DEFAULT NULL,
  `CAMPO19` varchar(100) DEFAULT NULL,
  `CAMPO20` varchar(100) DEFAULT NULL,
  `CAMPO21` varchar(100) DEFAULT NULL,
  `CAMPO22` varchar(100) DEFAULT NULL,
  `CAMPO23` varchar(100) DEFAULT NULL,
  `CAMPO24` varchar(100) DEFAULT NULL,
  `CAMPO25` varchar(100) DEFAULT NULL,
  `CAMPO26` varchar(100) DEFAULT NULL,
  `CAMPO27` varchar(100) DEFAULT NULL,
  `CAMPO28` varchar(100) DEFAULT NULL,
  `CAMPO29` varchar(100) DEFAULT NULL,
  `CAMPO30` varchar(100) DEFAULT NULL,
  `CAMPO31` varchar(100) DEFAULT NULL,
  `CAMPO32` varchar(100) DEFAULT NULL,
  `CAMPO33` varchar(100) DEFAULT NULL,
  `CAMPO34` varchar(100) DEFAULT NULL,
  `CAMPO35` varchar(100) DEFAULT NULL,
  `CAMPO36` varchar(100) DEFAULT NULL,
  `CAMPO37` varchar(100) DEFAULT NULL,
  `CAMPO38` varchar(100) DEFAULT NULL,
  `CAMPO39` varchar(100) DEFAULT NULL,
  `CAMPO40` varchar(100) DEFAULT NULL,
  `CAMPO41` varchar(100) DEFAULT NULL,
  `CAMPO42` varchar(100) DEFAULT NULL,
  `CAMPO43` varchar(100) DEFAULT NULL,
  `CAMPO44` varchar(100) DEFAULT NULL,
  `CAMPO45` varchar(100) DEFAULT NULL,
  `CAMPO46` varchar(100) DEFAULT NULL,
  `CAMPO47` varchar(100) DEFAULT NULL,
  `CAMPO48` varchar(100) DEFAULT NULL,
  `CAMPO49` varchar(100) DEFAULT NULL,
  `CAMPO50` varchar(100) DEFAULT NULL,
  `CAMPO51` varchar(100) DEFAULT NULL,
  `CAMPO52` varchar(100) DEFAULT NULL,
  `CAMPO53` varchar(100) DEFAULT NULL,
  `CAMPO54` varchar(100) DEFAULT NULL,
  `CAMPO55` varchar(100) DEFAULT NULL,
  `CAMPO56` varchar(100) DEFAULT NULL,
  `CAMPO57` varchar(100) DEFAULT NULL,
  `CAMPO58` varchar(100) DEFAULT NULL,
  `CAMPO59` varchar(100) DEFAULT NULL,
  `CAMPO60` varchar(100) DEFAULT NULL,
  `CAMPO61` varchar(100) DEFAULT NULL,
  `CAMPO62` varchar(100) DEFAULT NULL,
  `CAMPO63` varchar(100) DEFAULT NULL,
  `CAMPO64` varchar(100) DEFAULT NULL,
  `CAMPO65` varchar(100) DEFAULT NULL,
  `CAMPO66` varchar(100) DEFAULT NULL,
  `CAMPO67` varchar(100) DEFAULT NULL,
  `CAMPO68` varchar(100) DEFAULT NULL,
  `CAMPO69` varchar(100) DEFAULT NULL,
  `ENC_CAB` varchar(100) DEFAULT '',
  `ENC_DET` varchar(100) DEFAULT '',
  KEY `NewIndex1` (`dni`),
  KEY `NewIndex2` (`ENC_CAB`),
  KEY `NewIndex3` (`ENC_DET`),
  KEY `CAMPO1` (`CAMPO1`)
) ENGINE=MyISAM AUTO_INCREMENT=1631 DEFAULT CHARSET=latin1;

/*Table structure for table `movimiento_contactos` */

DROP TABLE IF EXISTS `movimiento_contactos`;

CREATE TABLE `movimiento_contactos` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `proceso` varchar(50) DEFAULT NULL,
  `usu_mov` varchar(10) DEFAULT NULL,
  `fec_mov` datetime DEFAULT NULL,
  `obs` text,
  `pc_sis` varchar(100) DEFAULT NULL,
  `pc_asig` varchar(100) DEFAULT NULL,
  `dato` varchar(50) DEFAULT NULL,
  `usu_psi` varchar(50) DEFAULT NULL,
  `usu_ase` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `NewIndex1` (`usu_mov`),
  KEY `NewIndex2` (`fec_mov`),
  KEY `NewIndex3` (`pc_asig`)
) ENGINE=MyISAM AUTO_INCREMENT=21447926 DEFAULT CHARSET=utf8;

/*Table structure for table `movimiento_contactos_acu` */

DROP TABLE IF EXISTS `movimiento_contactos_acu`;

CREATE TABLE `movimiento_contactos_acu` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `proceso` varchar(50) DEFAULT NULL,
  `usu_mov` varchar(10) DEFAULT NULL,
  `fec_mov` datetime DEFAULT NULL,
  `obs` text,
  `pc` varchar(100) DEFAULT NULL,
  `dato` varchar(50) DEFAULT NULL,
  `usu_psi` varchar(50) DEFAULT NULL,
  `usu_ase` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `NewIndex1` (`usu_mov`)
) ENGINE=MyISAM AUTO_INCREMENT=241394 DEFAULT CHARSET=utf8;

/*Table structure for table `movimiento_contactos_mal` */

DROP TABLE IF EXISTS `movimiento_contactos_mal`;

CREATE TABLE `movimiento_contactos_mal` (
  `id` int(6) NOT NULL DEFAULT '0',
  `proceso` varchar(50) DEFAULT NULL,
  `usu_mov` varchar(10) DEFAULT NULL,
  `fec_mov` datetime DEFAULT NULL,
  `obs` text,
  `pc` varchar(100) DEFAULT NULL,
  `dato` varchar(50) DEFAULT NULL,
  `usu_psi` varchar(50) DEFAULT NULL,
  `usu_ase` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `movimiento_incidencias` */

DROP TABLE IF EXISTS `movimiento_incidencias`;

CREATE TABLE `movimiento_incidencias` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `estado` varchar(50) DEFAULT NULL,
  `usu_mov` varchar(10) DEFAULT NULL,
  `fec_mov` datetime DEFAULT NULL,
  `obs` text,
  `pc` varchar(100) DEFAULT NULL,
  `dato` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=574169 DEFAULT CHARSET=utf8;

/*Table structure for table `movimiento_mantenimientos` */

DROP TABLE IF EXISTS `movimiento_mantenimientos`;

CREATE TABLE `movimiento_mantenimientos` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `proceso` varchar(50) DEFAULT NULL,
  `usu_mov` varchar(10) DEFAULT NULL,
  `fec_mov` datetime DEFAULT NULL,
  `obs` text,
  `pc_sis` varchar(100) DEFAULT NULL,
  `pc_asig` varchar(100) DEFAULT NULL,
  `dato` varchar(50) DEFAULT NULL,
  `usu_psi` varchar(50) DEFAULT NULL,
  `usu_ase` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `NewIndex1` (`usu_mov`),
  KEY `NewIndex2` (`fec_mov`),
  KEY `NewIndex3` (`pc_asig`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `movimiento_usuarios` */

DROP TABLE IF EXISTS `movimiento_usuarios`;

CREATE TABLE `movimiento_usuarios` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `proceso` varchar(50) DEFAULT NULL,
  `usu_mov` varchar(10) DEFAULT NULL,
  `fec_mov` datetime DEFAULT NULL,
  `obs` text,
  `pc` varchar(100) DEFAULT NULL,
  `dato` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=77057 DEFAULT CHARSET=utf8;

/*Table structure for table `movimientos_maestra` */

DROP TABLE IF EXISTS `movimientos_maestra`;

CREATE TABLE `movimientos_maestra` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `dni` varchar(50) NOT NULL,
  `dato` char(50) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `aplicativo` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `tipo_mov` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `fec_mov` datetime NOT NULL,
  `fec_ini` date NOT NULL,
  `fec_fin` date NOT NULL,
  `usu_mov` varchar(30) NOT NULL DEFAULT '',
  `obs_mov` text NOT NULL,
  `est` varchar(50) NOT NULL DEFAULT '',
  `apli_` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `perfil` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `NewIndex1` (`dni`),
  KEY `NewIndex2` (`dato`),
  KEY `NewIndex3` (`aplicativo`)
) ENGINE=MyISAM AUTO_INCREMENT=226140 DEFAULT CHARSET=latin1;

/*Table structure for table `movimientos_tiempos` */

DROP TABLE IF EXISTS `movimientos_tiempos`;

CREATE TABLE `movimientos_tiempos` (
  `tipo` char(1) NOT NULL,
  `tiempo` varchar(2) NOT NULL,
  `fec_ini` date NOT NULL,
  `fec_fin` date NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `programacion_extra` */

DROP TABLE IF EXISTS `programacion_extra`;

CREATE TABLE `programacion_extra` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `dni` varchar(20) DEFAULT NULL,
  `fec_reg` datetime DEFAULT NULL,
  `usu_reg` char(10) DEFAULT NULL,
  `tp_incidencia` varchar(50) DEFAULT NULL,
  `motivo_incidencia` varchar(5) DEFAULT NULL,
  `fec_ini_inc` datetime DEFAULT NULL,
  `fec_fin_inc` datetime DEFAULT NULL,
  `obs_incidencia` text,
  `ejecuto` varchar(1) DEFAULT '',
  `tiempo` time DEFAULT NULL,
  `factor` varchar(10) DEFAULT NULL,
  `modo` varchar(10) DEFAULT NULL,
  `est_prog` varchar(20) DEFAULT NULL,
  `tiempo_sf` time DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `NewIndex1` (`dni`)
) ENGINE=MyISAM AUTO_INCREMENT=204 DEFAULT CHARSET=utf8;

/*Table structure for table `reporte_incidencia_cot` */

DROP TABLE IF EXISTS `reporte_incidencia_cot`;

CREATE TABLE `reporte_incidencia_cot` (
  `id` int(11) NOT NULL DEFAULT '0',
  `cip` varchar(20) DEFAULT NULL,
  `cod_horario` char(10) NOT NULL,
  `horario` char(200) NOT NULL,
  `F1` varchar(50) DEFAULT NULL,
  `F2` varchar(50) DEFAULT NULL,
  `fec_reg` datetime DEFAULT NULL,
  `usu_reg` char(10) DEFAULT NULL,
  `tp_incidencia` varchar(50) DEFAULT NULL,
  `motivo_incidencia` varchar(200) DEFAULT NULL,
  `fec_ini_inc` datetime DEFAULT NULL,
  `fec_fin_inc` datetime DEFAULT NULL,
  `obs_incidencia` varchar(300) DEFAULT NULL,
  `nro_participantes` int(11) DEFAULT NULL,
  `cod_incidencia` varchar(50) DEFAULT NULL,
  `ejecuto` varchar(1) DEFAULT NULL,
  `tiempo` time DEFAULT NULL,
  `modo` varchar(10) DEFAULT NULL,
  `c_doid` varchar(50) DEFAULT NULL,
  `dni` varchar(30) DEFAULT NULL,
  `dias` int(11) DEFAULT NULL,
  `xmes` varchar(7) DEFAULT NULL,
  `cargo` varchar(100) DEFAULT NULL,
  `ESTADO_REP` varchar(50) DEFAULT NULL,
  `SUPERVISOR` varchar(300) DEFAULT NULL,
  `NCOMPLETO` varchar(350) DEFAULT NULL,
  KEY `NewIndex1` (`cip`),
  KEY `NewIndex2` (`dni`),
  KEY `NewIndex3` (`cod_horario`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `res_rrhh` */

DROP TABLE IF EXISTS `res_rrhh`;

CREATE TABLE `res_rrhh` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `cip` varchar(100) DEFAULT NULL,
  `dni` varchar(100) DEFAULT NULL,
  `Nombre` varchar(100) DEFAULT NULL,
  `Lider` varchar(100) DEFAULT NULL,
  `Localidad` varchar(100) DEFAULT NULL,
  `Local` varchar(100) DEFAULT NULL,
  `Cargo` varchar(100) DEFAULT NULL,
  `Categoria` varchar(100) DEFAULT NULL,
  `VP` varchar(100) DEFAULT NULL,
  `DIRECCION` varchar(100) DEFAULT NULL,
  `GERENCIA` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `NewIndex1` (`dni`),
  KEY `NewIndex2` (`cip`)
) ENGINE=MyISAM AUTO_INCREMENT=671 DEFAULT CHARSET=latin1;

/*Table structure for table `tb_actividades` */

DROP TABLE IF EXISTS `tb_actividades`;

CREATE TABLE `tb_actividades` (
  `ID_ACTIVIDADES` int(11) NOT NULL AUTO_INCREMENT,
  `ACTIVIDADES` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`ID_ACTIVIDADES`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Table structure for table `tb_aplicativos` */

DROP TABLE IF EXISTS `tb_aplicativos`;

CREATE TABLE `tb_aplicativos` (
  `c_aplicativo` int(1) NOT NULL AUTO_INCREMENT,
  `aplicativo` varchar(150) DEFAULT NULL,
  `estado` varchar(10) DEFAULT NULL,
  `f_act` datetime DEFAULT NULL,
  `usuario` varchar(10) DEFAULT NULL,
  `orden` int(1) DEFAULT NULL,
  `link` text,
  `web` varchar(10) DEFAULT '',
  PRIMARY KEY (`c_aplicativo`)
) ENGINE=MyISAM AUTO_INCREMENT=82 DEFAULT CHARSET=utf8;

/*Table structure for table `tb_cargos` */

DROP TABLE IF EXISTS `tb_cargos`;

CREATE TABLE `tb_cargos` (
  `cod_cargo` varchar(10) NOT NULL,
  `cargo` varchar(2) NOT NULL,
  `desc_cargo` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`cod_cargo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `tb_cargos_cot` */

DROP TABLE IF EXISTS `tb_cargos_cot`;

CREATE TABLE `tb_cargos_cot` (
  `cod_cargo` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `nom` char(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `tb_contactos_actual` */

DROP TABLE IF EXISTS `tb_contactos_actual`;

CREATE TABLE `tb_contactos_actual` (
  `item` int(1) NOT NULL AUTO_INCREMENT,
  `pedido` varchar(50) DEFAULT NULL,
  `campo1` varchar(100) DEFAULT NULL,
  `campo2` char(100) NOT NULL,
  `campo3` varchar(100) NOT NULL,
  `campo4` varchar(200) DEFAULT NULL,
  `campo5` varchar(200) DEFAULT NULL,
  `campo6` varchar(200) DEFAULT NULL,
  `campo7` varchar(400) DEFAULT NULL,
  `campo8` varchar(100) DEFAULT NULL,
  `campo9` text,
  `campo10` date DEFAULT NULL,
  `campo11` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`item`,`campo2`,`campo3`),
  KEY `NewIndex2` (`campo2`),
  KEY `NewIndex1` (`campo3`),
  KEY `NewIndex3` (`campo4`),
  KEY `NewIndex5` (`campo10`),
  KEY `NewIndex6` (`campo11`),
  KEY `NewIndex4` (`pedido`)
) ENGINE=MyISAM AUTO_INCREMENT=4320859 DEFAULT CHARSET=latin1;

/*Table structure for table `tb_contactos_cot` */

DROP TABLE IF EXISTS `tb_contactos_cot`;

CREATE TABLE `tb_contactos_cot` (
  `item` int(1) NOT NULL AUTO_INCREMENT,
  `campo1` varchar(100) DEFAULT NULL,
  `campo2` char(100) DEFAULT NULL,
  `campo3` varchar(100) DEFAULT NULL,
  `campo4` varchar(100) DEFAULT NULL,
  `campo5` varchar(100) DEFAULT NULL,
  `campo6` varchar(200) DEFAULT NULL,
  `campo7` varchar(100) DEFAULT NULL,
  `campo8` varchar(350) DEFAULT NULL,
  `campo9` text,
  `fec_mov` datetime DEFAULT NULL,
  `usu_mov` varchar(10) DEFAULT NULL,
  `pc_mov` varchar(30) DEFAULT NULL,
  `tipo` varchar(50) DEFAULT '',
  PRIMARY KEY (`item`),
  KEY `NewIndex2` (`campo2`),
  KEY `NewIndex1` (`campo3`),
  KEY `NewIndex3` (`campo4`)
) ENGINE=MyISAM AUTO_INCREMENT=20628942 DEFAULT CHARSET=latin1;

/*Table structure for table `tb_dist` */

DROP TABLE IF EXISTS `tb_dist`;

CREATE TABLE `tb_dist` (
  `cod` varchar(5) NOT NULL,
  `dpto` varchar(100) DEFAULT NULL,
  `prov` varchar(100) DEFAULT NULL,
  `dis` varchar(100) DEFAULT NULL,
  `c_dist` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`cod`)
) ENGINE=MyISAM AUTO_INCREMENT=388 DEFAULT CHARSET=utf8;

/*Table structure for table `tb_dni` */

DROP TABLE IF EXISTS `tb_dni`;

CREATE TABLE `tb_dni` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `dni` varchar(10) DEFAULT NULL,
  `nombres` varchar(255) DEFAULT NULL,
  `apellido_paterno` varchar(255) DEFAULT NULL,
  `apellido_materno` varchar(255) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT '0000-00-00',
  `sexo` varchar(1) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT '0000-00-00 00:00:00',
  `usuario_registro` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dni` (`dni`)
) ENGINE=InnoDB AUTO_INCREMENT=3730 DEFAULT CHARSET=utf8;

/*Table structure for table `tb_dpto` */

DROP TABLE IF EXISTS `tb_dpto`;

CREATE TABLE `tb_dpto` (
  `COD` varchar(2) DEFAULT NULL,
  `DPTO` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `tb_estados_incidencia` */

DROP TABLE IF EXISTS `tb_estados_incidencia`;

CREATE TABLE `tb_estados_incidencia` (
  `cod_estado` varchar(2) DEFAULT NULL,
  `estado` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `tb_horarios` */

DROP TABLE IF EXISTS `tb_horarios`;

CREATE TABLE `tb_horarios` (
  `cod_horario` varchar(50) NOT NULL,
  `periodo` varchar(200) DEFAULT NULL,
  `tiempo` varchar(50) DEFAULT NULL,
  `tipo` varchar(100) DEFAULT NULL,
  `categoria` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`cod_horario`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `tb_locales` */

DROP TABLE IF EXISTS `tb_locales`;

CREATE TABLE `tb_locales` (
  `cod_local` varchar(20) DEFAULT NULL,
  `nom_local` varchar(100) DEFAULT NULL,
  `dire_local` varchar(200) DEFAULT NULL,
  `prov` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `tb_log` */

DROP TABLE IF EXISTS `tb_log`;

CREATE TABLE `tb_log` (
  `proc` varchar(200) DEFAULT NULL,
  `proceso` varchar(350) DEFAULT NULL,
  `fec_ini` datetime DEFAULT NULL,
  `fec_fin` datetime DEFAULT NULL,
  `usu_reg` varchar(10) DEFAULT NULL,
  `obs` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `tb_motivos_incidencia` */

DROP TABLE IF EXISTS `tb_motivos_incidencia`;

CREATE TABLE `tb_motivos_incidencia` (
  `cod_mot_inc` varchar(10) DEFAULT NULL,
  `nom_mot_inc` varchar(300) DEFAULT NULL,
  `tp_inc` varchar(100) DEFAULT NULL,
  `est` varchar(1) DEFAULT NULL,
  `grupo` varchar(30) DEFAULT NULL,
  `estado_tp_inc` varchar(1) DEFAULT '0',
  KEY `cod_mot_inc` (`cod_mot_inc`),
  KEY `tp_inc` (`tp_inc`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `tb_perfil` */

DROP TABLE IF EXISTS `tb_perfil`;

CREATE TABLE `tb_perfil` (
  `id` int(1) DEFAULT NULL,
  `perfil` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `tb_soportes_cot` */

DROP TABLE IF EXISTS `tb_soportes_cot`;

CREATE TABLE `tb_soportes_cot` (
  `iduser` int(11) NOT NULL DEFAULT '0',
  `dni` varchar(20) CHARACTER SET latin1 NOT NULL,
  `ncompleto` varchar(200) CHARACTER SET latin1 DEFAULT NULL,
  `c_supervisor` varchar(200) CHARACTER SET latin1 DEFAULT '',
  `nom_supervisor` varchar(300) DEFAULT NULL,
  `estado` varchar(1) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `tb_tecnicos` */

DROP TABLE IF EXISTS `tb_tecnicos`;

CREATE TABLE `tb_tecnicos` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `carnet` varchar(30) DEFAULT NULL,
  `dni` varchar(30) DEFAULT NULL,
  `ncompleto` varchar(350) DEFAULT NULL,
  `celular` varchar(20) DEFAULT NULL,
  `rpm` varchar(20) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `estado` varchar(30) DEFAULT NULL,
  `fec_ingreso` varchar(20) DEFAULT NULL,
  `brevete` varchar(30) DEFAULT NULL,
  `placa` varchar(30) DEFAULT NULL,
  `modelo` varchar(50) DEFAULT NULL,
  `ubicacion` varchar(50) DEFAULT NULL,
  `servicio` varchar(50) DEFAULT NULL,
  `contrata` varchar(100) DEFAULT NULL,
  `scontrata` varchar(100) DEFAULT NULL,
  `obs` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Table structure for table `tb_usuarios` */

DROP TABLE IF EXISTS `tb_usuarios`;

CREATE TABLE `tb_usuarios` (
  `iduser` int(11) NOT NULL AUTO_INCREMENT,
  `ncompleto` varchar(200) DEFAULT NULL,
  `dni` varchar(20) NOT NULL,
  `cip` varchar(20) DEFAULT NULL,
  `user_pc` varchar(50) DEFAULT NULL,
  `login` varchar(50) DEFAULT NULL,
  `pass` varchar(50) DEFAULT NULL,
  `perfil` varchar(10) DEFAULT NULL,
  `idsess` varchar(100) DEFAULT NULL,
  `estado` varchar(30) DEFAULT NULL,
  `conectado` int(1) DEFAULT NULL,
  `numingreso` int(1) DEFAULT '0',
  `n_area` varchar(100) DEFAULT NULL,
  `grupo` varchar(150) DEFAULT NULL,
  `sgrupo` varchar(100) DEFAULT NULL,
  `opc` varchar(10) DEFAULT NULL,
  `usu_gestel` varchar(50) DEFAULT NULL,
  `correo_personal` varchar(100) DEFAULT NULL,
  `correo_w` varchar(100) DEFAULT '',
  `celular1` varchar(30) DEFAULT '',
  `celular2` varchar(30) DEFAULT '',
  `anexo` varchar(30) DEFAULT '',
  `local` varchar(30) DEFAULT '',
  `c_supervisor` varchar(200) DEFAULT '',
  `c_monitor` varchar(200) DEFAULT '',
  `pc` varchar(50) DEFAULT NULL,
  `monitor` varchar(50) DEFAULT NULL,
  `piso` varchar(20) DEFAULT NULL,
  `fec_nacimiento` varchar(20) DEFAULT NULL,
  `c_emergencia` text,
  `fec_reg` date DEFAULT NULL,
  `ape_pat` varchar(200) DEFAULT NULL,
  `ape_mat` varchar(200) DEFAULT NULL,
  `nombres` varchar(200) DEFAULT NULL,
  `hor` varchar(5) DEFAULT NULL,
  `fec_ing_cot` varchar(30) DEFAULT '',
  `fec_fin_cot` varchar(30) DEFAULT '',
  `ola` varchar(10) DEFAULT NULL,
  `fec_baja` varchar(20) DEFAULT NULL,
  `motivo_baja` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`iduser`,`dni`),
  KEY `NewIndex1` (`login`),
  KEY `NewIndex2` (`dni`),
  KEY `NewIndex3` (`cip`),
  KEY `NewIndex4` (`pc`)
) ENGINE=MyISAM AUTO_INCREMENT=4341 DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
