-- phpMyAdmin SQL Dump
-- version 5.2.2deb1+deb13u1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 02-01-2026 a las 18:53:40
-- Versión del servidor: 11.8.3-MariaDB-0+deb13u1 from Debian
-- Versión de PHP: 8.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `acoradoor2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias_contables`
--

CREATE TABLE `categorias_contables` (
  `id_categoria` int(11) NOT NULL,
  `nombre_categoria` varchar(100) NOT NULL,
  `tipo_categoria` enum('ingreso','egreso') NOT NULL,
  `descripcion` text DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias_contables`
--

INSERT INTO `categorias_contables` (`id_categoria`, `nombre_categoria`, `tipo_categoria`, `descripcion`, `activo`) VALUES
(1, 'Ventas', 'ingreso', 'Ingresos por ventas de productos', 1),
(2, 'Servicios', 'ingreso', 'Ingresos por servicios prestados', 1),
(3, 'Compra de Mercancía', 'egreso', 'Gastos por compra de productos', 1),
(4, 'Gastos Administrativos', 'egreso', 'Gastos administrativos diversos', 1),
(5, 'Gastos de Personal', 'egreso', 'Salarios y nóminas', 1),
(6, 'Impuestos', 'egreso', 'Impuestos y tasas', 1),
(7, 'Otros Ingresos', 'ingreso', 'Otros ingresos no clasificados', 1),
(8, 'Otros Gastos', 'egreso', 'Otros gastos no clasificados', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `nombre_cliente` varchar(255) NOT NULL,
  `n_cuenta` varchar(9999) NOT NULL,
  `telefono_cliente` char(30) NOT NULL,
  `telefono_movil` varchar(60) NOT NULL,
  `email_cliente` varchar(64) NOT NULL,
  `direccion_cliente` varchar(255) NOT NULL,
  `pago` varchar(100) NOT NULL,
  `cif` varchar(60) NOT NULL,
  `status_cliente` tinyint(4) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nombre_cliente`, `n_cuenta`, `telefono_cliente`, `telefono_movil`, `email_cliente`, `direccion_cliente`, `pago`, `cif`, `status_cliente`, `date_added`) VALUES
(10, 'TOT FUSTA FUENTES, S.L.', '0', '963770548', '0', 'totfustasl@gmail.com', 'C/CEBRIAN MEZQUITA, 14 BAJO\r\n46007 - VALENCIA-', 'Giro 30 Dias', 'B96755244', 1, '2019-10-23 13:29:07'),
(8, 'FUSCOVA', '0', '961526618', '', 'isidoro@fuscova.com', 'P.I. EL COSCOLLAR   C/ COMARQUES DE LA HORTA Nº 6', 'Giro 60 Dias', '', 1, '2019-10-23 12:12:38'),
(9, 'GINERMA, S.L.', '0', '656974482', '', 'ginerma@gmail.com', 'C/ RIU D\'ALBAIDA, 22\r\n46470 MASSANASSA', 'Giro 30 Dias', '', 1, '2019-10-23 13:22:29'),
(18, 'COMERCIAL DE CARPINTERIA COVALCA', '0', '964521696', '664315155', 'ana@covalca.com', 'AVDA ARCADI GARCIA SANZ, 9\r\n12540 VILLAREAL - CASTELLON', 'Giro 30 Dias', 'B12588471', 1, '2019-10-24 11:54:04'),
(14, 'LA CARPINTERIA Y PORTARMARI, S.L.', '0', '0', '670648455', 'lacarpinteriayportarmari@gmail.com', 'C/MAYOR, 85 BAJO\r\n46920 MISLATA - VALENCIA', 'Pagare 30 Dias', 'B97404057', 1, '2019-10-24 11:36:43'),
(15, 'NAVALON COCINAS, S.L.', '0', '670648455', '627476697', 'navaloncocinas@hotmail.com', 'C/ URUGUAY, 16 BAJO IZQUIERDA\r\n46007 VALENCIA', 'Transferencia', 'B97036651', 1, '2019-10-24 11:38:20'),
(16, 'CONSTRUCCIONES PROTALSO, S.L.', '0', '1', '607187359', 'construccionesprotalso@gmail.com', 'C/ FRANSCISCO TORMO, 17 BAJO\r\n46007 VALENCIA', 'Transferencia', 'B98734484', 1, '2019-10-24 11:41:58'),
(17, 'MANUEL LOZANO PEREZ', '0', '1', '671514992', 'lozano.caro@gamil.com', 'C/MONTEALEGRE, 18 PTA 9\r\n46520 XIRIVELLA - VALENCIA -', 'Transferencia', '22678778L', 1, '2019-10-24 11:42:57'),
(19, 'FAUSTINO HUMANES CARPINTERO CB', '0', '0', '659807430', 'tino@humanes.eu', 'C7 ADEMUZ, 1 BAJO\r\n46100 BURJASSOT - VALENCIA-', 'Giro 30 Dias', 'E98515158', 1, '2019-10-24 11:58:24'),
(20, 'PEDRO ANTONIO NARRO HERNANDEZ', '0', '0', '630767374', 'pedissenycarpinteria@hotmail.com', 'C/ ALGER, 34 PISO 2\r\n12530 CASTELLON', 'Giro 30 Dias', '18944741D', 1, '2019-10-24 12:46:13'),
(21, 'MONTAJES PERIS Y ESTEBAN CB', '0', '0', '616794921', 'montajesperisyesteban@hotmail.es', 'C/ HERNANDEZ LAZARO, 178\r\n46470 ALBAL -VALENCIA-', 'Transferencia', 'E97781694', 0, '2019-10-24 12:46:52'),
(22, 'VAFECA2 S.L.', '0', '0', '659164442', 'info@carpinteriavafeca2.com', 'C/ OLOCAO DEL REY NAVE 2\r\n12005 -CASTELLON DE LA PLANA-', 'Giro 30 Dias', 'B12555439', 1, '2019-10-24 12:52:43'),
(23, 'LORENZO ABRIL SEVILLANO', '0', '0', '660322701', 'carpinteria.lorenzoabril@gmail.com', 'C/ COLON 22 BAJO\r\n46120 ALBORAIA - VALENCIA-', 'Efectivo', '24376429V', 1, '2019-10-24 13:10:13'),
(24, 'WINDOWS 2015 S.L.', '0', '964830668', '607731138', 'portaronja@portaronja.com', 'C/ PIBER, Nº 4 PTA 102\r\n12579 ALCOSSEBRE -CASTELLON DE LA PLANA-', 'Giro 30 Dias', 'B12945663', 1, '2019-10-24 13:14:41'),
(25, 'CARLOS ZARAGOZA  ARENAS', '0', '963920644', '639609546', 'puertaszaragoza@gmail.com', 'C/ GUILLEN DE CASTRO, 129\r\n46008 - VALENCIA -', 'Efectivo', '2409308X', 1, '2019-10-24 13:16:18'),
(26, 'FUSTA MORVEDRE, S.L.', '0', '0', '607905111', 'fustamorvedre@telefonica.net', 'AVDA OJOS NEGROS, 12\r\n46520 GRAO DE SAGUNTO - VALENCIA -', 'Giro 30 Dias', 'B97506257', 1, '2019-10-24 13:18:30'),
(27, 'ANTONIO ROS LOPEZ', '0', '0', '678713141', 'tonocuinesyportes@hotmail.com', 'CAMINO DE LA CEBOLLA, Nº 3\r\n46138 RAFAELBUÑOL - VALENCIA -', 'Efectivo', '19096135V', 1, '2019-10-24 13:20:13'),
(28, 'KREAFUSTA NOFRE, S.L.', '0', '961411186', '665251450', 'kreafusta@kreafusta.com', 'C/ MASSANASA \r\n46138 RAFAELBUÑOL - VALENCIA -', 'Giro 30 Dias', 'B98547227', 1, '2019-10-24 13:22:36'),
(29, 'JAVIER PELAEZ REQUENA', '0', '0', '607455851', 'javierpelaezrequena@gmail.com', 'PARTIDA BRUCAR, P.I. 10\r\n46117 BETERA - VALENCIA -', 'Efectivo', '52138297B', 1, '2019-10-24 13:24:15'),
(30, 'DOGMA SEGURIDAD, S.L.', '0', '0', '615992737', 'tienda.dogmaseguridad@gmail.com', 'C/ REINA VIOLANTE, Nº 2\r\n46015 - VALENCIA -', 'Giro 30 Dias', 'B40505117', 1, '2019-10-24 13:25:44'),
(31, 'EXPOBUZON, S.L.', '0', '0', '676952825', 'admon@expobuzon.com', 'C/ EDUARDO BOSCA, 13\r\n46023 - VALENCIA -', 'Giro 30 Dias', 'B96244678', 1, '2019-10-24 13:28:02'),
(32, 'TOMAS EXOJO LUENGO', '0', '0', '699412915', 'tomas.exojoluengo@gmail.com', 'C/ PINTOR NICOLAU, 2\r\n46022 - VALENCIA -', 'Efectivo', '76217727M', 1, '2019-10-24 13:29:25'),
(33, 'MC CARPINTERIA METALICA, S.L.', '0', '0', '669241695', 'mccarpinteriametalica@gmail.com', 'C/ CATALUÑA, 33 BAJO\r\n46520 GRAO DE SAGUNTO - VALENCIA -', 'Giro 30 Dias', 'B96390281', 1, '2019-10-24 13:30:32'),
(34, 'SALVADOR MARTI ROCA', '0', '0', '639120754', 'puertas@puertasxirivella.com', 'C/ JOAQUIN COSTA, Nº 11 BAJO\r\n46950 XIRIVELLA - VALENCIA -', 'Transferencia', '52680381P', 1, '2019-10-24 13:33:46'),
(35, 'VICENTE MANUEL MAÑO NAVARRO', '0', '963670943', '626833815', 'fusvima@yahoo.es', 'AVDA JESUS MORANTE BORRAS, \r\n46012 - VALENCIA -', 'Efectivo', '22528527G', 1, '2019-10-24 13:38:23'),
(36, 'ANTONIO GARCIA VALCARCEL', '0', '963922898', '687991052', 'a.garciapuertas@hotmail.com', 'C/ GUILLEN DE CASTRO, 61 BAJO\r\n46008 - VALENCIA -', 'Pagare 30 Dias', '25416254N', 1, '2019-10-24 13:40:55'),
(37, 'JUAN MANUEL RAMADA', '0', '0', '625384504', 'fusteriaramadaizquierdo@hotmail.com', 'CASETA DELS PASTOR, SNº\r\n46191 VILLAMARXANT - VALENCIA -', 'Efectivo', '73650851K', 0, '2019-10-24 13:42:53'),
(38, 'DAVID MUÑOZ VALIENTE', '0', '0', '665525593', 'davidmuval@hotmail.es', 'C/ PEDRO CABANES, 53\r\n46019 - VALENCIA -', 'Efectivo', '33454638B', 1, '2019-10-24 13:44:40'),
(39, 'MANUEL SANCHO SILVESTRE', '0', '961520592', '0', 'aadministracion@madersan.com', 'C/ INDUSTRIA, 13\r\n46930 QUART DE POBLET - VALENCIA-', 'Transferencia', 'B96010939', 1, '2019-10-24 13:46:05'),
(40, 'VICENTE CARRASCO PILAN', '0', '0', '637248762', 'info@reformasjuvicar.com', 'C/ SALVADOR ALMENAR, 9\r\n46020 - VALENCIA -', 'Transferencia', '22679112P', 1, '2019-10-24 13:48:21'),
(41, 'JAVIER GONZALO MARCILLA', '0', '0', '606943319', 'acorasegur@yahoo.es', 'C/ MUSICO ANDREU PIQUERES\r\n46900 TORRENTE - VALENCIA -', 'Efectivo', '52747338N', 1, '2019-10-24 13:50:54'),
(42, 'PROYECTOS Y REFORMAS PROMED', '0', '0', '0', 'promed2@hotmail.com', 'CIRCULO DE BELLAS ARTES, 5\r\n46020 - VALENCIA -', 'Transferencia', 'B97060768', 0, '2019-10-24 13:53:34'),
(43, 'JOSE MANSILLA  ALMENDROS', '0', '0', '678447026', 'carpinteriajmansilla@gmail.com', 'C/ UTIEL, 26 BAJO\r\n46020 - VALENCIA -', 'Efectivo', '19815124A', 0, '2019-10-24 13:55:10'),
(44, 'IVSN RIOS LOPEZ', '0', '0', '635614675', 'zacarri@gmail.com', 'C/ SAN PEDRO, 25 BAJO\r\n46500 PUERTO SAGUNTO - VALENCIA -', 'Efectivo', '45796495E', 1, '2019-10-25 09:42:06'),
(45, 'EUGENIO PAÑOS DOMINGO', '0', '963332373', '605900706', 'artesanal@ono.com', 'AVDA REINO DE VALENCIA, 70\r\n46005 - VALENCIA -', 'Giro 30 Dias', '19807783E', 1, '2019-10-25 09:46:29'),
(46, 'CARPINTERIA MECANICA MARCIAL MEDINA, S.L.', '0', '961391443', '0', 'medina_sl@yahoo.es', 'C/ TEROL, 3\r\n46113 MONCADA -VALENCIA-', 'Efectivo', 'B46078218', 1, '2019-10-25 09:46:56'),
(47, 'MIO PARQUET, S.L.', '0', '961511697', '610900936', 'l.guillot@mioparquet.com', 'AVDA DEL AIRE, SNº\r\n46960 ALDAIA -VALENCIA-', 'Transferencia', 'B97894117', 1, '2019-10-25 10:38:47'),
(48, 'CONSTRUCCIONES RUIZ 1980, S.L.', '0', '0', '667476638', 'loliruiz@construccionesruiz.es', 'C/ SALVADOR GINER, 16 BAJO\r\n46970 ALAQUAS - VALENCIA -', 'Transferencia', 'B98745722', 1, '2019-10-25 10:44:50'),
(49, 'DIEGO REYES MOYA', '0', '961505352', '669880788', 'interiorismoreyes.dm@gmail.com', 'CARRETERA DE ALDAIA, 4\r\n46970 ALAQUAS - VALENCIA -\r\n', 'Giro 30 Dias', '73538432A', 1, '2019-10-25 10:46:28'),
(50, 'JUAN MRAS CONESA', '0', '961548954', '635683528', 'alumiras@gmail.com', 'C/ PIO XII, 2\r\n46930 QUART DE POBLET - VALENCIA -', 'Efectivo', '52680676G', 1, '2019-10-25 10:47:43'),
(51, 'IGSFOC COOPERATIVA VALENCIANA S', '0', '0', '606786774', 'jsoriano@igsfoc.es', 'C/ BRAC DEL JARDI, Nº 17 P.I.\r\n46470 MASSANASA - VALENCIA -', 'Transferencia', 'F98438955', 1, '2019-10-25 10:50:29'),
(52, 'JOSE JESUS GIL GONZALEZ', '0', '679468564', '679468564', 'j.gilcarpinteria@gamil.com', 'C/ SAN IDELFONSO, Nº 3\r\n46300 ALDEA DE ESTENAS - VALENCIA -', 'Pagare 30 Dias', '85086567E', 1, '2019-10-25 10:55:16'),
(53, 'DKM 2009 MOBILIARIO, S.L.L', '0', '0', '663912589', 'diana@dkmuebles.es', 'P.I. FUENTE DEL OLMO NAVE, 5\r\n46192 - MONSERRAT - VALENCIA', 'Efectivo', 'B98141641', 1, '2019-10-25 10:57:38'),
(54, 'CARPINTERIA  J. MONTAÑES, S.L.', '0', '0', '605999104', 'jmontanes@carpinteriamontanes.es', 'AVDA HERMANOS BOU, 241\r\n12003 CASTELLON DE LA PLANA', 'Giro 30 Dias', 'B12440731', 1, '2019-10-25 10:59:54'),
(55, 'MUNDICOCINA VALLET', '0', '0', '650847131', 'mundicocina@gmail.com', 'C/ REY DON JAIME, 23\r\n46400 CULLERA - VALENCIA -', 'Transferencia', 'B96715214', 1, '2019-10-25 11:05:06'),
(56, 'ISMAEL CASTAÑO NUÑEZ', '0', '0', '607383821', 'ismaelcastanonunez@hotmail.com', 'C/ CONSTANTI LLOMBART, Nº 3\r\n46470 MASSANASA - VALENCIA -', 'Giro 30 Dias', '73765713K', 1, '2019-10-25 11:07:02'),
(57, 'KIT POR FUSTA, S.L.', '0', '963471279', '662483263', 'info@kpfusta.es', 'AVDA DE DURJASSOT, 62\r\n46009 VALENCIA', 'Efectivo', 'B97612808', 1, '2019-10-25 11:08:24'),
(58, 'FRANSCISCO GONZALEZ CARRASCO', '0', '0', '685164681', 'puertasgonzalez@puertasgonzalez.com', 'CAMINO VIEJO DE XIRIVELLA, 2\r\n46920 MISLATA - VALENCIA -', 'Efectivo', '22626530G', 1, '2019-10-25 11:10:07'),
(59, 'CAMILO RODRIGUEZ, S.L.', '0', '0', '652151131', 'camilorodriguezsl@gmail.com', 'C/ GARCI, 15 BUZON 2522\r\n46119 NAQUERA - VALENCIA -', 'Pagare 30 Dias', 'B96348115', 1, '2019-10-25 11:11:40'),
(60, 'FERRETERIA LATORRE, C.B.', '0', '0', '647193289', 'ferreteria.latorre@gmail.com', 'C/ VIRGEN DEL PILAR, Nº 20\r\n46930 QUART DE POBLET - VALENCIA -', 'Giro 30 Dias', 'E96129614', 1, '2019-10-25 12:14:11'),
(61, 'MONTAJES Y SERVICIOS TU CASA REFORMAS, S.L.', '0', '0', '676498041', 'tucasareformas@gmail.com', 'AVDA VICENTE MORTES ALFONSO\r\n46980 PATERNA  - VALENCIA -', 'Efectivo', 'B97596555', 1, '2019-10-25 12:15:59'),
(62, 'CONSTRUBELL CAMIR, S.L.', '0', '0', '0', 'eccontruccionyreformas@gamil.com', 'C/ MESTRE ELIES, 14 BAJO\r\n46183 L\'ELIANA - VALENCIA -', 'Pagare 30 Dias', 'B98727092', 1, '2019-10-25 12:17:45'),
(63, 'MOBIL CARPINTEROS, S.L.', '0', '0', '657960065', 'mobilcarpinteros@yahoo.es', 'C/ REPUBLICA  DE CHILE, Nº 26\r\n46680 ALGEMESI - VALENCIA -', 'Giro 30 Dias', 'B96285085', 1, '2019-10-25 12:19:22'),
(64, 'BALLEROME, S.L.', '0', '0', '676956748', 'balleromereformas@gmail.com', 'C/ TORRETA DE MIRAMAR, 6\r\n46020 VALENCIA', 'Giro 30 Dias', 'B96491501', 1, '2019-10-25 12:20:39'),
(65, 'JOSE MARTINEZ PEREZ', '0', '0', '626243080', 'info@carpinteriamjp.com', 'C/ CROBISTA CARRERES, Nº 1\r\n46930 QUART DE POBLET - VALENCIA -', 'Giro 30 Dias', '48385267Y', 1, '2019-10-25 12:22:13'),
(66, 'JESUS GUTIERREZ GARCIA', '0', '963900960', '696716059', 'carpinteriaguti@hotmail.com', 'C/ LLIBERTAD, 33 B\r\n46100 BURJASSOT - VALENCIA -', 'Efectivo', '07551308V', 1, '2019-10-25 12:24:33'),
(67, 'EDIFESA OBRAS Y PROYECTOS, S.A.', '0', '0', '679996409', 'martin@edifesa.com', 'C/ SAGUNTO, 182 BAJO\r\n46009 VALENCIA', 'Pagare 90 Dias', 'A46185526', 1, '2019-10-25 12:25:57'),
(68, 'SESMERO RAMOS, S.L.', '0', '0', '609661298', 'sesmero_ramos@hotmail.com', 'C/ BERLIN 198\r\n03009 ALICANTE', 'Efectivo', 'B53248548', 1, '2019-10-25 12:27:53'),
(69, 'TORREJON MUEBLES Y DECORACION, S.L.', '0', '964730128', '626515670', 'torrejonmd@gmail.com', 'P.I. C.E. LA PLANA C/ \r\n12550 ALMAZORA - CASTELLON -', 'Giro 30 Dias', 'B12680385', 1, '2019-10-25 12:29:40'),
(70, 'TABLEROS TECNICOS DE LEVANTE, S.L.', '0', '960501790', '', 'info@tablerostecnicos.es', 'CRTA VILLAREAL-ONDA KM 3\r\n12540 VILLAREAL - CASTELLON DE LA PLANA -', 'Giro 30 Dias', 'B98183841', 1, '2019-10-25 12:31:08'),
(71, 'CEMALU CERRAJEROS, S.L.', '0', '902151304', '', 'siniestros@cemalucerrajeros.com', 'PI EL COSCOLLAR C/COMARQUES DE LA HORTA,9\r\n46960 ALDAIA - VALENCIA -', 'Transferencia', 'B96640362', 1, '2019-10-25 12:33:10'),
(72, 'ALBA BAQUEREO BALLESTEROS', '0', '0', '687406359', 'consultascpa@gmail.com', 'C/ EXPLORADOR ANDRES, 34\r\n46022 VALENCIA', 'Pagare 60 Dias', '26764314L', 1, '2019-10-25 12:34:44'),
(73, 'MAYFER, S.L.', '0', '962541800', '0', 'rosa@mayfer.com', 'AVDA CONTE DEL SERALLO\r\n46250 L\'ALCUDIA - VALENCIA -', 'Transferencia', 'B96369020', 1, '2019-10-25 12:35:33'),
(74, 'DOORME AUTOMATIMOS, S.L.', '0', '963563414', '0', 'instalaciones@zibor.com', 'C/ SANTOS JUSTO Y PASTOR, \r\n46022 - VALENCIA -', 'Pagare 60 Dias', 'B96813050', 1, '2019-10-25 12:40:05'),
(75, 'JOFRASER SERVICIOS INTEGRALES, S.L.', '0', '961533592', '653984034', 'arquitecta@jofraserservicios.es', 'C/ ISLAS CANARIAS, Nº 18 BAJO\r\n46024 VALENCIA', 'Giro 30 Dias', 'B98764103', 1, '2019-10-25 12:41:47'),
(76, 'PRIEVAL MANTENIMIENTO 2014, S.L.', '0', '961533592', '653984034', 'arquitecta@prieval.es', 'C/ ISLAS CANARIAS, Nº 184 BAJO\r\n46024 VALENCIA', 'Giro 30 Dias', 'B98624380', 1, '2019-10-25 12:43:30'),
(77, 'EMILIO VALDES ESCRIBANO', '0', '0', '610812993', 'dentrocasa@hotmail.com', 'C/ MUSICO CABANILLES, Nº 48\r\n46017 VALENCIA', 'Efectivo', '22678921R', 1, '2019-10-25 12:46:11'),
(78, 'PUERTAS AGUILERA, S.L.', '0', '667550101', '667550102', 'info@puertasaguilera.es', 'P.I. FTE DEL JARRO - CRTA PATERNA\r\n46980 PATERNA - VALENCIA -', 'Efectivo', 'B96130885', 0, '2019-10-25 12:51:27'),
(79, 'CARPINTERIA AUDIVERT, S.L.', '0', '961731067', '0', 'info@carpinteriaaudivert.com', 'C/ SUECA, 49\r\n46400 CULLERA  - VALENCIA -', 'Giro 30 Dias', 'B96581137', 0, '2019-10-25 12:51:54'),
(80, 'MONICA MORAL CUEVAS', '0', '0', '620632304', 'lmoreno@naturarmari.com', 'AVDA REYES CATALICOS, 48\r\n46450 BENIFAIO - VALENCIA -', 'Efectivo', '20811715G', 1, '2019-10-25 12:55:11'),
(81, 'JORASAN S.L.', '0', '0', '661459957', 'jorasansl@gmail.com', 'C/ BRASIL, 21 BAJO\r\n46018 VALENCIA', 'Efectivo', 'B97282933', 1, '2019-10-25 12:57:07'),
(82, 'RAFAEL TORTAJADA BALLESTER', '0', '0', '665828063', 'rafatortajada@gmail.com', 'C/ SANT JOSEP, Nº 39 PTA 10\r\n46139 POBLA DE FARNALLS  - VALENCIA -', 'Efectivo', '25386997B', 1, '2019-10-25 13:04:00'),
(83, 'INDUSTRIAS SERRANOSA, S.L.', '0', '0', '640016423', 'info@serranosa.com', 'C/ PUZOL, 6\r\n46500 SAGUNTO - VALENCIA -', 'Giro 30 Dias', 'B46821344', 1, '2019-10-25 13:05:08'),
(84, 'FUSTERIA CHAPA, S.L.', '0', '961440458', '620241688', 'info@fusteriachapa.com', 'C/ ESTE, 6\r\n46530 MASSAMAGRELL -VALENCIA -', 'Efectivo', 'B96260443', 1, '2019-10-25 13:06:29'),
(85, 'SUMINISTROS TRESMADER, S.L.U', '0', '96254657', '649892702', 'javimolina@tresmader.com', 'PI CAMI REIAL C/ARGENTER, SNº\r\n46250 L\'ALCUDIA - VALENCIA -', 'Transferencia', 'B98382203', 1, '2019-10-25 13:08:53'),
(86, 'ANGEL LOPEZ SALMERON', '0', '0', '667278447', 'reformasangel24@hotmail.com', 'C/ CARNIYENA, 26\r\n12540 VILLAREAL - CASTELLON DE LA PLANA -', 'Efectivo', '52799567P', 1, '2019-10-25 13:10:51'),
(87, 'GREGAL INGENIERIA, S.L.', '0', '963518208', '652082124', 'jcasado@gregalingenieria.com', 'PI POYO DE RECA C/MALLORCA\r\n46190 RIBARROJA DEL TURIA - VALENCIA -', 'Transferencia', 'B97514889', 1, '2019-10-25 13:13:27'),
(88, 'CARPINTERIA BENIMAMET, S.L.', '0', '0', '619721576', 'carpinteriabenimametsl@gamil.com', 'C/ SOT DE CHERA, 3 BAJO\r\n46035 BENIMAMET - VALENCIA -', 'Giro 30 Dias', 'B96302039', 1, '2019-10-25 13:30:55'),
(89, 'CARRASCO INTERIORISMO Y DECORACION, S.L.', '0', '0', '610271665', 'carrascointerdec@ono.com', 'C/ LORIGUILLA 4 BAJO\r\n46025 VALENCIA', 'Giro 30 Dias', 'B96548565', 1, '2019-10-25 13:33:13'),
(90, 'HERMAR, S.L.', '0', '962670153', '0', 'hermar@saneamientoshermar.es', 'C/ SIERRA DE JABALAMBRE, 12 \r\n46520 PUERTO DE SAGUNTO - VALENCIA -', 'Giro 30 Dias', 'B46141727', 1, '2019-10-25 13:35:06'),
(91, 'CARPINTERIA METALICA BONMETAL CB', '0', '0', '617466970', 'bonmetal@gmail.com', 'CARRER MITGERA, 1\r\n46560 MASSALFASSAR - VALENCIA -', 'Giro 30 Dias', 'E97958631', 1, '2019-10-25 13:36:27'),
(92, 'CAMPOS DE VUELO OLOCAU CB', '0', '0', '620209781', 'joype@joype.eu', 'VIRGEN DE LOS DESAMPARADOS, SNº\r\n46163 MARINES - VALENCIA -', 'Efectivo', 'E98447600', 1, '2019-10-25 13:37:43'),
(93, 'JOSE LUIS ROJAS CRESPO', '0', '0', '600080006', 'jlrojasc19@gmail.com', 'AVDA DE LA DEMOCRACIA\r\n46600 ALZIRA - VALENCIA -', 'Giro 30 Dias', '20772653L', 1, '2019-10-25 13:39:36'),
(94, 'PUERTAS SEGARRA, S.L.', '0', '964219042', '0', 'puertassegarra@hotmail.com', 'C/ DE HERRERO, 43 BAJO\r\n12005 CASTELLON DE LA PLANA', 'Giro 30 Dias', 'B12365748', 1, '2019-10-25 13:41:12'),
(95, 'EBANISTERIA ENRIQUE SAFONT, S.L.U', '0', '0', '639658306', 'info@ebanisteriasafont.com', 'C/ DE LOS DESAMPARADOS, Nº\r\n12550 ALMAZORA - CASTELLON DE LA PLANA -', 'Giro 30 Dias', 'B12985701', 1, '2019-10-28 09:34:27'),
(96, 'RGH SERVICIOS CARRE LEVANTE, S.L.', '0', '963682637', '687715285', 'proyectosreformasrgh@hotmail.com', 'C/ CIRILO AMOROS, Nº 16 BAJO\r\n46004 - VALENCIA -', 'Transferencia', 'B98876428', 1, '2019-10-28 09:38:09'),
(97, 'CARPINTERIA Y DECORACION ALARCON, S.L.', '0', '0', '633718150', '', 'P.I. LOS VIENTOS C/ XALOU\r\n46119 NAQUERA - VALENCIA -', 'Efectivo', 'B98847205', 1, '2019-10-28 09:40:01'),
(98, 'OSCAR CALVO VILLAMON', '0', '0', '676426317', 'o.c.v.24h@gmail.com', 'C/ RAMON Y CAJAL Nº 6 BAJO\r\n46960 ALDAIA - VALENCIA -', 'Efectivo', '53097163F', 1, '2019-10-28 09:41:18'),
(99, 'PUERTAS PERCIBER, S.L.', '0', '968861535', '', 'pedidos@perciber.com', 'P.I. EL MIRADOR, SNº\r\n30140 SANTOMERA - MURCIA -', 'Transferencia', 'B30375216', 1, '2019-10-28 09:43:42'),
(100, 'FUSTER REUNITS, S.L.', '0', '961410234', '', 'fusters.reunits@hotmail.com', 'CAMINO CEBOLLA, 20\r\n46138 RAFAELBUÑOL - VALENCIA -', 'Efectivo', 'B46224333', 1, '2019-10-28 09:45:05'),
(101, 'TAENGUA, S.L.', '0', '962280165', '', 'taenguasl@hotmail.com', 'C/ ALMAS, 54\r\n46800 XATIVA - VALENCIA -', 'Transferencia', 'B96242201', 1, '2019-10-28 09:47:56'),
(102, 'CLIMENT Y AGUSTI, S.L.', '0', '', '656933602', 'climentyagustin2005@hotmail.com', 'C/ BOTANICO CABANILLES, 42 BAJO\r\n46120 ALBORAYA - VALENCIA -', 'Pagare 30 Dias', 'B96386925', 1, '2019-10-28 09:50:28'),
(103, 'SERGIO ESCRIBANO GARCIA', '0', '', '626234245', 'sergioescribano@live.com', 'CARRERA DE MALILLA, Nº 82\r\n46026 VALENCIA', 'Efectivo', '22587125K', 1, '2019-10-28 09:52:02'),
(104, 'VIJOCAS STILL. S.L.', '0', '', '659525676', 'arturo@vijocastil.com', 'CAMINO VIEJO DEL MAR, SNº\r\n46760 TABERNES DE LA VALLDIGAN - VALENCIA -', 'Pagare 30 Dias', 'B97720221', 1, '2019-10-28 09:53:47'),
(105, 'CRISTINA TAURA ALFONSO', '0', '', '661202354', 'info@tauracocinas.com', 'C/ ESCALANTE, 11\r\n46940 MANISES - VALENCIA -', 'Giro 30 Dias', '52684206S', 1, '2019-10-28 09:55:21'),
(106, 'ALMACENES INCOPLAST INCO, S.L.', '0', '963672158', '', 'julio@incoplast.com', 'C/ POETA MAS Y ROS, 99\r\n46022 VALENCIA', 'Giro 30 Dias', 'B46589263', 1, '2019-10-28 09:57:08'),
(107, 'TURIAVAL SERVICIOS INTEGRALES, S.L.U.', '0', '0', '609686848', 'daniel@turiaval.com', 'C/ JAIME II EL JUSTO 31\r\n46180 BENAGUASSIL - VALENCIA -', 'Giro 30 Dias', 'B98110703', 1, '2019-10-28 09:59:22'),
(108, 'CONSTRUCAMP CAMPILLOS, S.L.', '0', '', '670918888', 'construcampillos@hotmail.com', 'C/ CANAL, 62 PTA 5\r\n46300 UTIEL - VALENCIA -', 'Transferencia', 'B97720114', 1, '2019-10-28 10:46:51'),
(109, 'JOYFRA REPRESENTACIONES, S.L.U.', '0', '', '655586191', 'fcorequena@gmail.com', 'C/ HERNANDEZ LAZARO, Nº 3\r\n46470 ALBAL - VALENCIA -', 'Giro 60 Dias', 'B96764824', 1, '2019-10-28 10:48:41'),
(110, 'MATIAS GIJON GONZALEZ', '0', '0', '653033146', 'magijon24@gmail.com', 'C/ PASAJE 25 DE ABRIL, 3\r\n46970 ALAQUAS - VALENCIA -', 'Efectivo', '05890492P', 1, '2019-10-28 10:50:26'),
(111, 'VIRGEN DE SALES S.C. P.I.V', '', '961701166', '', 'covisa@telefonica.net', 'CALLE DELS FERRERS, 6\r\n46410 SUECA - VALENCIA -', 'Giro 30 Dias', 'F46049318', 1, '2019-10-28 10:52:21'),
(112, 'CARPINTERIA MARTIN-J S.L.', '0', '96263119', '', 'mariajesus@carpinteriamartin-j.com', 'P.I LA FOIA C/ 7 Nº 6\r\n46510 QUARTELL - VALENCIA -', 'Giro 30 Dias', 'B97545115', 1, '2019-10-28 10:53:48'),
(113, 'TALLERS JOYPE, S.L.', '', '962703018', '', 'joype@jpype.eu', 'CRTA LLIRIA-OLOCAU\r\n46169', 'Efectivo', 'B96128046', 1, '2019-10-28 10:54:56'),
(114, 'CARMAPLUS, S.L.', '', '', '', 'carmaplu@carmaplu.com', 'C/ BENICARLO, 16 BAJO\r\n46020 VALENCIA', 'Efectivo', 'B97283840', 1, '2019-10-28 10:57:40'),
(115, 'PROSEVAL DEL MEDITERRANEO, S.L.', '', '', '670322199', 'info@maderexpress.es', 'C/ CONDE DE ALTEA, 55 PTA 8\r\n46005 VALENCIA', 'Giro 30 Dias', 'B98301344', 1, '2019-10-28 10:58:56'),
(116, 'PUERTAS DE LA MARINA, S.L.', '0', '', '654546196', 'info@puertasdelamarina.com', 'CRTA PIQUERAS, 1\r\n16120 VALERA DE ABAJO - CUENCA -', 'Efectivo', 'B16155103', 1, '2019-10-28 11:01:18'),
(117, 'FUSTERIA DOÑATE, S.L.', '', '964665990', '', 'fusteriadonatesl@hotmail.com', 'POLIGONO LA MEZQUITA\r\n12600 VALL D\'UXO - CASTELLON DE LA PLANA -', 'Giro 30 Dias', 'B12644399', 1, '2019-10-28 11:04:59'),
(118, 'CLAUDIO Y MANUEL PROYECTOS, S.L.', '0', '', '622787701', 'ucedadeprados@gmail.com', 'C/ CESAR PUGET RIQUER, 50\r\n07840 SAN EULALIA DES RIU - IBIZA -', 'Transferencia', 'B16547689', 1, '2019-10-28 11:25:08'),
(119, 'JUAN JOSE LATORRE LOPEZ', '0', '', '620964761', 'jjlatorreccarpinteria@gamil.com', 'C/ EJERCITO ESPAÑOL, 9 pta 5\r\n46370 CHIVA - VALENCIA -', 'Pagare 30 Dias', '24345304B', 1, '2019-10-28 11:29:26'),
(120, 'DAVID ALARCON VICENT', '0', '0', '637598911', 'davyalarcon@hotmail.com', 'C/ FRANCISCO CUBELLS, 22\r\n46011 VALENCIA', 'Transferencia', '33460456X', 1, '2019-10-28 11:30:48'),
(121, 'MARACUINES, S.L.', '', '', '626997603', 'maracuines@gmail.com', 'C/ RIBERA BAIXA, SNº\r\n46417 RIOLA - VALENCIA -', 'Giro 30 Dias', 'B96362769', 1, '2019-10-28 11:33:38'),
(122, 'TOMAS NAVARRO RUIZ', '0', '', '626498072', 'info@carpinteriatomasnavarro.com', 'C/ CASTELLON, Nº 45 BAJO\r\n12590 ALMENARA - CASTELLON DE LA PLANA -', 'Giro 30 Dias', '44803639F', 1, '2019-10-28 11:42:16'),
(123, 'PALASI EBANISTES, S.L.', '0', '', '685141583', 'rafapalasi@hotmail.com', 'C/ RIU MILLARES Nº 5\r\n46940 PINATE - VALENCIA -', 'Efectivo', 'B97463178', 1, '2019-10-28 11:46:25'),
(124, 'PABLO LAZARO CARRASCO', '', '', '696494775', 'lazaromantenimientos@gmail.com', 'PLAZA DEL POBLET, 12\r\n46131 BONREPOS I MIRAMBELL - VALENCIA -', 'Efectivo', '33462133P', 1, '2019-10-28 11:48:22'),
(125, 'VICENTE SANCHEZ TORIL', '', '', '636256659', 'torilvins@hotmail.com', 'PLAZA LA CONCORDIA, Nº 3\r\n46900 TORRENTE - VALENCIA -', 'Efectivo', '53358457K', 1, '2019-10-28 11:49:37'),
(126, 'MIGUEL CERVERA MARTI', '0', '', '636291048', 'mcmcervera@hotmail.com', 'C/ CALVARIO, 27\r\n46180 BENAGUASSIL - VALENCIA -', 'Efectivo', '85087199X', 1, '2019-10-28 12:37:59'),
(127, 'CIVINED, S.L.U', '0', '', '649953560', 'jvferrer@grupobertolin.es', 'RONDA GUGLIEMO MARCONI\r\n46980 PATERNA - VALENCIA -', 'Confirming 60 Dias', 'B98212970', 1, '2019-10-28 12:39:20'),
(128, 'GRUPO BERTOLIN S.A.U', '', '', '649953560', 'jvferrer@grupobertolin.es', 'RONDA GUGLEIMO MARCONI\r\n46980 PATERNA - VALENCIA -', 'Confirming 60 Dias', 'A46092128', 1, '2019-10-28 12:40:52'),
(129, 'RUBEN RODRIGUEZ EXPOSITO', '', '', '609636640', 'rubroex@hotmail.com', 'C/ JESUS MORANTE Y BORRAS, \r\n46930 QUART DE POBLET - VALENCIA -', 'Efectivo', '48385223P', 1, '2019-10-28 12:42:28'),
(130, 'CARPINTERIA ARANDIGA. S.L.', '', '', '605679537', 'carpinteriaarandiga@hotmail.com', 'C/ DOCTOR FLEMING, Nº 28\r\n46270 VILLANUEVA DE CASTELLON - VALENCIA -', 'Giro 30 Dias', 'B96258074', 1, '2019-10-28 12:45:34'),
(131, 'P.G.M. CUINES EN KIT, S.L.', '', '961350891', '', 'piedad@cuineskit.com', 'P.I FTE DEL JARRO CRTA PATERNA LA CAÑADA\r\n46980 PATERNA - VALENCIA -', 'Giro 30 Dias', 'B97399729', 1, '2019-10-28 12:47:14'),
(132, 'PROYALPAS, S.L.U.', '', '', '647942616', 'proyalpas@gmail.com', 'C/ GINESTA, Nº 1 PTA 3\r\n46980 PATERNA - VALENCIA -', 'Transferencia', 'B98196991', 1, '2019-10-28 12:49:00'),
(133, 'JOSE MIGUEL MORA BORRAS', '', '', '636566602', 'fustdecora@gmail.com', 'C/ ANDRES MONREAL, 2\r\n46953 ALGAR DEL PALANCIA - CASTELLON -', 'Giro 30 Dias', '44804893L', 1, '2019-10-28 12:51:36'),
(134, 'FERNANDO GONZALEZ GIRON', '', '', '625551001', 'reparafer@gmail.com', 'C/ BUEN AIRE 1 -C\r\n46388 GODELLETA - VALENCIA -', 'Efectivo', '52638675R', 1, '2019-10-28 12:53:24'),
(135, 'ANTIQUE CONSERVACION Y RESTAURACION, S.L.', '', '963874380', '', 'facturacion@grupobertolin.es', 'RONDA GUGLEIMO MARCONI\r\n46980 PATERNA - VALENCIA -', 'Confirming 60 Dias', 'B97956304', 1, '2019-10-28 12:55:03'),
(136, 'FUSHABITAT, S.L.U', '', '', '665006489', 'ifusta@hotmail.com', 'C/ JOAN VICENT MORA, 37\r\n46240 CARLET - VALENCIA-', 'Giro 30 Dias', 'B98578867', 1, '2019-10-28 12:58:39'),
(137, 'PUERTAS ESPECIALES, S.L.', '', '', '685968604', 'info@puertasespeciales.es', 'P.I. FTE DEL JARRO  C/ CIUDAD DE SEVILLA, 86\r\n46988 PATERNA - VALENCIA -', 'Transferencia', 'B98961055', 1, '2019-10-28 13:00:53'),
(138, 'CARPINDEMA, S.L.', '', '964515918', '', 'carpindemasl@hotmail.com', 'PI CARABONA  C/ BRONCE\r\n12530 BURRIANA - CASTELLON DE LA PLANA -', 'Giro 30 Dias', 'B12394342', 1, '2019-10-28 13:02:44'),
(139, 'IBIFOREST, S.L.', '', '', '615271505', '', 'C/ DEL PARE JOSEP MANXAR\r\n07800 IBIZA', 'Transferencia', 'B07155146', 1, '2019-10-28 13:03:52'),
(140, 'IVADO REFORMAS, S.L.', '', '', '661969642', 'ivadoreformas@hotmail.com', 'AVDA CARDENALL BENLLOCH\r\n46021 VAVLENCIA', 'Giro 30 Dias', 'B98780505', 1, '2019-10-28 13:06:24'),
(141, 'SERVICIOS, OBRAS,ESTUDIOS Y REFORMAS, S.L.', '', '', '667728277', 'mfuentes@soerconstruccion.com', 'AVDA PERIS Y VALERO, 138 BAJO\r\n46006 VALENCIA', 'Transferencia', 'B98715279', 1, '2019-10-28 13:08:02'),
(142, 'GRUPO TEXTIL TUTOO TEMPO', '', '', '649919437', 'grupotextiltt@yahoo.es', 'C/ JUAN DE LA CIERVA, 50\r\n28936 MOSTOLES - MADRID -', 'Transferencia', 'B85984706', 1, '2019-10-28 13:09:14'),
(143, 'MIGUEL CASTILLO SABARIEGO', '', '', '630874780', 'fusteriacastillo@yahoo.es', 'C/ JOSE LIZANDRA, Nº 2\r\n46181 BENISANO - VALENCIA -', 'Giro 30 Dias', '22628182T', 1, '2019-10-28 13:11:24'),
(144, 'EDE3 GESTION DE PROYECTOS URBANISTICOS, S.L.', '', '', '660318288', 'tecnico3@ede3.com', 'C/ RASCAÑA, Nº 26 PTA 21\r\n46015  VALENCIA', 'Giro 30 Dias', 'B98351026', 0, '2019-10-28 13:14:27'),
(145, 'INSTALACIONES GENERALES DE LA MADERA, S.L', '', '963331579', '', 'laboutiquedelarmario@gmail.com', 'PLAZA DE HOLANDA, 7\r\n46017 VALENCIA', 'Transferencia', 'B46143772', 1, '2019-10-28 13:15:50'),
(146, 'ANDRES EQUIPAMENT INTEGRAL, S.L.', '', '', '661367952', 'cocinas@andresgns.com', 'AVDA DEL RECREO, 3\r\n46183 L\'ELIANA - VALENCIA -', 'Transferencia', 'B98729411', 1, '2019-10-28 13:17:23'),
(147, 'pPUERTAS PADILLA, S.L.', '', '', '', 't.mojica@ppadilla.es', 'C/ GENERAL MOSCARDO, 4\r\n30330 ALBUJON - MURCIA -', 'Transferencia', 'B30668602', 1, '2019-10-28 13:18:39'),
(148, 'JOSE MIGUEL LINARES CAMPS', '', '', '650749080', 'mlccarpinteros@gmail.com', 'C/ XALOC, 29 PTA 14\r\n46116 MASIAS - VALENCIA -', 'Efectivo', '73771692C', 1, '2019-10-28 13:20:04'),
(149, 'NOU ESPAI DE L\'ELIANA, S.L.', '', '962743129', '', 'enrique@novaliana.com', 'C/ MAYOR, 38\r\n46183 L\'ELIANA', 'Giro 30 Dias', 'B98827470', 1, '2019-10-28 13:23:49'),
(150, 'OSCAR FERRI RAGA', '', '', '630102778', 'oscarferri@gmail.com', 'AVDA RAMBLETA, 67 PTA 15\r\n46470 CATARROJA - VALENCIA -', 'Giro 30 Dias', '52749505V', 1, '2019-10-28 13:26:27'),
(151, 'FUSTERIA ANTONIA SEGURA, S.L.', '', '', '605842657', 'estudio2.0@mueblesdica.es', 'C/ MAESTRO SERRANO, 3\r\n46139 POBLA DE FARNALLS  - VALENCIA -\r\n', 'Giro 30 Dias', 'B96267265', 1, '2019-10-28 13:28:07'),
(152, 'RAUL CORREDOR GONZALEZ', '', '', '627961846', 'raulcorredor35@yahoo.es', 'C/ SAN CRISTOBAL, 10 PTA 10\r\n46960 ALDAIA - VALENCIA -', 'Transferencia', '48388789D', 1, '2019-10-28 13:31:25'),
(153, 'GERARDO VIANA CARRION', '', '', '667632523', 'gerardoviana1@gmail.com', 'C/ DOCTOR FLEMING, 17\r\n02200 CASA DE IBAÑEZ - ALBACETE -', 'Transferencia', '05197743L', 1, '2019-10-28 13:33:56'),
(154, 'JOSE ESPEJO GONZALEZ', '', '', '687687535', 'cocinaslevante@yahoo.es', 'AVDA DOCTOR PESET Y ALEIXANDRE, 60\r\n46025 VALENCIA', 'Efectivo', '22630801C', 1, '2019-10-28 13:36:30'),
(155, 'PEDISSENY, S.L.U', '', '', '630767374', 'pedissenycarpinteria@hotmail.com', 'C/ CAMI FONDO, NAVE 20\r\n12530 BURRIANA - CASTELLON DE LA PLANA -', 'Giro 30 Dias', 'B12863379', 1, '2019-10-28 13:37:54'),
(156, 'FIMADER, S.L.', '', '962301955', '620201224', 'fimader@fimader.com', 'CRTA MADRID-VALECNIA KM 2\r\n46340 REQUENA - VALENCIA -', 'Transferencia', 'B96252325', 1, '2019-10-29 12:12:23'),
(157, 'RAUL CASTELLO PEREZ', '', '', '609627628', 'carpinteriapinotxo@hotmail.es', 'C/ REPUBLICA ARGENTINA, 28\r\n46021 VALENCIA', 'Giro 30 Dias', '19849647A', 1, '2019-10-29 12:13:33'),
(158, 'CARPINTERIA BLAY C.B.', '', '', '676325956', 'carpinteriablay@hotmail.com', 'AVDA REINA DE LOS APOSTOLES\r\n12549 BETXI  - CASTELLON DE LA PLANA -', 'Giro 30 Dias', 'E12266904', 1, '2019-10-29 12:15:09'),
(159, 'ENRIQUE ALMELA GOMEZ', '', '', '628568987', 'ka.boardsoficina@gmail.com', 'PARTIDA SANTA QUIETERIA, 601\r\n12550 ALMAZORA .CASTELON DE LA PLANA-', 'Transferencia', '52796057V', 1, '2019-10-29 12:25:41'),
(160, 'FUSTA DECORA2, S.L.', '', '', '636566602', 'fustadecora@gmail.com', 'P.I. LA VERNITXA C/ C Nº 20\r\n12600 VALL DE UXO - CASTELLON DE LA PLANA -', 'Giro 30 Dias', 'B44516565', 1, '2019-10-29 12:27:51'),
(161, 'APLIMA CARPINTEROS, S.L.', '', '', '622167718', 'aplimacarpinteros@aplima.es', 'C/ REPUBLICA GUINEA ECUATORIAL\r\n46022 VALENCIA', 'Transferencia', 'B40546376', 1, '2019-10-29 12:30:30'),
(162, 'BARTOLOME PARRA CABRERA', '', '', '661814403', 'bartolomeparra@yahoo.es', 'C/ ALCALA GALIANO 6 PTA 3\r\n46520 PUERTO DE SAGUNTO - VALENCIA -', 'Efectivo', '33405707R', 1, '2019-10-29 12:32:07'),
(163, 'CONSTRUCCIONES HERRERO ATIENZAR, S.L.', '', '', '648849203', 'construccion@cohemar.com', 'C/ LOS MOLINOS, 10 BAJO\r\n46988 PATERNA - VALENCIA -', 'Pagare 60 Dias', 'B53773818', 1, '2019-10-29 12:33:40'),
(164, 'TORDERA LLISTERRI, S.L.U', '', '', '608847257', 'borotordera@hotmail.com', 'AVDA PERIS Y VALERO 183\r\n46005 VALENCIA', 'Efectivo', 'B40515959', 1, '2019-10-29 12:40:30'),
(165, 'ANTONIO GIL PORTA', '', '', '635557040', 'capega@hotmail.es', 'C/ BRUGENTE, 13 E\r\n46176 CHELVA - VALENCIA -', 'Efectivo', '20519707T', 1, '2019-10-29 12:42:15'),
(166, 'TOMAS PONCELA BARROSO', '', '', '', '', 'CRTA DE MALILLA, 69 PTA 7\r\n46026 VALENCIA', 'Efectivo', '25406151Y', 1, '2019-10-29 12:43:13'),
(167, 'BEATRIZ CUADRADO DOMINGUEZ', '', '', '628628774', 'diego@cuadom.com', 'AVDA 9 DE OCTUBRE, 76 PTA 2\r\n46520 PUERTO DE SAGUNTO - VALENCIA -', 'Transferencia', '45913388Y', 1, '2019-10-29 12:44:32'),
(168, 'K2 EN LA CUMBRE DE LA DECORACION, S.L.', '', '964550478', '', 'admin@k2decoracion.com', 'AVDA BOQUERAS, 246\r\n12550 ALMASSORA  - CASTEELON DE LA PLANA -', 'Transferencia', 'B12807566', 1, '2019-10-29 12:47:06'),
(169, 'ON TOP RENEWABLES, S.L.', '', '', '636505338', 'sunsi@onrenewables.es', 'C/ INGENIERO MANUEL MAESES\r\n46011 VALENCIA', 'Transferencia', 'B98925324', 1, '2019-10-29 12:50:41'),
(170, 'VIALTERRA INFRAESTRUCTURAS, S.A.', '', '', '686462623', 'rcarrasco@vialterra.com', 'C/ MENORCA Nº 19\r\n46023 VALENCIA\r\n', 'Transferencia', 'A23434970', 1, '2019-10-29 12:52:32'),
(171, 'CONSTRUCCIONES JAIME TAMARIT, S.L.', '', '', '', 'atamaritc@gmail.com', 'C/ 7 NUMERO 30\r\n46980 LA CAÑADA  PATERNA - VALENCIA -', 'Transferencia', 'B46423570', 1, '2019-10-29 12:54:12'),
(172, 'ABRAHAM Y CONSTAN PROMOCIONES, S.L.', '', '', '685834779', 'acprom.oficina@gmail.com', 'AVDA CONSTITUCION, 47\r\n46009 VALENCIA', 'Giro 30 Dias', 'B97802443', 1, '2019-10-29 12:55:42'),
(173, 'JERONIMO HERRERA MARCO', '', '', '653881294', '', 'C/ DAMA DE ELCHE, Nº 5 BAJO\r\n46023 VALENCIA', 'Transferencia', '44515392L', 1, '2019-10-29 12:57:18'),
(174, 'FERMIN VIDAL MERO', '', '', '651828460', 'vidalfusta@hotmail.com', 'C/ PICAPEDRES, 90\r\n46790 XERESA - VALENCIA -', 'Transferencia', '20032837K', 1, '2019-10-29 12:58:39'),
(175, 'RAUL LOPEZ VERGARA', '', '', '637625174', 'info@reformasvergar.com', 'C/ PINTOR SOROLLA, 25\r\n46113 MONCADA - VALENCIA -', 'Transferencia', '52688247P', 1, '2019-10-29 13:00:00'),
(176, 'ROBERTO VILLAR ALEMAN', '', '', '639621668', 'robertovillaraleman@gmail.com', 'C/ BUENOS AIRES, Nº 6\r\n46360 BUÑOL', 'Efectivo', '22643304B', 1, '2019-10-29 13:01:19'),
(177, 'FUSTERIA ANGEL MARTI, S.L.U', '', '961958686', '', 'fusteria@fusteriaangelmarti.es', 'C/ MAS DEL BOMBO, 4 B\r\n46530 PUZOL - VALENCIA  -', 'Giro 30 Dias', 'B98460421', 1, '2019-10-29 13:04:18'),
(178, 'MONDECOR SOLUCIONES, S.L.', '', '', '626477905', 'info@modecorsl.es', 'C/ MOSCU, Nº 15\r\n46185 POBLA DE VALLBONA - VALENCIA -', 'Giro 30 Dias', 'B98313604', 1, '2019-10-29 13:05:31'),
(179, 'REHABILITACION DE EDIFICIOS OBRAXA, S.L.', '', '', '663953430', 'obraxa@gmail.com', 'C/ FONTANARS DELS ALFORINS\r\n46014 VALENCIA', 'Pagare 30 Dias', 'B98596208', 1, '2019-10-29 13:07:05'),
(180, 'SUMINISTRES AL PROFESSIONAL MAESES, S.L.', '', '606327355', '626243164', 'maeses@maeseinteriorismo.es', 'AVDA JAUME I, 38\r\n46714 PALMERA - VALENCIA -', 'Giro 30 Dias', '', 1, '2019-10-29 13:08:28'),
(194, 'DISPAVAL', '4345645e', '3213232', '234567890', 'uyyh@uyuyby', 'gfffdgfddfgd', 'Efectivo', '455678864e', 1, '2019-12-21 23:12:25'),
(193, 'toni', '4554455445a', '963443564', '616845415', 'toni@dispaval.com', 'itiiiuurriur', 'Pagare 60 Dias', '64566754356774f', 1, '2019-12-15 18:45:59'),
(196, 'diana', '', '', '627885611', '', 'Calle Rodriguez de cepeda 22 pta 3', 'Transferencia', '', 1, '2024-01-08 20:07:53'),
(197, 'raul gallur', '53345345345', '', '6666666666', 'gfsdfds@rfsfdsfds', 'gdgfdfgdgdgf', 'Efectivo', '664565tf', 1, '2024-01-13 19:06:29'),
(198, 'OSCAR FELICES', '6546', '56343446', '564634', 'GHRGR@DFGD', 'TRTTTRRRRRRRRRR', 'Efectivo', '465265F', 1, '2024-01-13 19:34:45'),
(199, 'PATRI VALENCIA', '42265546554', '645654654', '43645534', 'GFRGRGREGRE2@RTQRTT', 'RAGRRGGA', 'Efectivo', '6545426654C', 1, '2024-01-13 19:36:08'),
(200, 'PATRI GALLUR', '5635464643456', '967854345', '667445903', 'RGARARA@GFFGAS', 'RWWTRRT', 'Transferencia', '5465656365G', 1, '2024-01-13 19:41:11'),
(201, 'MARIAJO', '64565456433466', '96454524554', '6674562665', 'FGAFGAF@FDSDSD', 'GSFDGARGGRGR', 'Efectivo', '5665655V', 1, '2024-01-13 19:42:16'),
(202, 'jesus linares camps', '', '', '636714586', '', 'C/ colon Nº 51 pta 4 Moncada Valencia', 'Transferencia', '73570356A', 1, '2024-07-11 17:50:11'),
(203, 'ÓSCAR FELICES MARTÍNEZ', '', '', '637089604', '', 'Calle Crevillente nº 4 bajo, Valencia Valencia', 'Transferencia', '29196486X', 1, '2024-07-11 18:07:33'),
(204, 'Alexander Sanchez Obando', '', '', '663006252', '', 'Calle silla N/49 Alaquas Valencia', 'Transferencia', 'X4080114Y', 1, '2024-10-12 07:43:19'),
(205, 'Ivan Martinez Lizandra', '', '', '616274191', '', 'Av archiduque carlos 23 pta 13  46018 Valencia', 'Efectivo', '48410091J', 1, '2025-01-13 19:07:25'),
(206, 'Ivan Felces Martinez', '', '', '', '', 'calle Asturias 51 pta 6 46022 Valencia', 'Efectivo', '29196487B', 1, '2025-01-13 20:04:17'),
(207, 'Sonia del Valle Fernandez Hueso', '', '', '', '', 'calle Juaquin navarro 24 pta 12 46017 Valencia', 'Efectivo', '29196742J', 1, '2025-01-13 20:07:46'),
(208, 'Acoradoor S.L.', '', '', '616845415', 'acoradoor@gmail.com', 'C/ colon 57 bajo , Moncada valencia CP/46113 ', 'Giro 60 Dias', 'B21747126', 1, '2025-05-03 20:27:52'),
(209, 'Trasejar, S.L.', '', '', '', '', 'Avenida de las Cortes Valencianas', 'Transferencia', 'B-97956981', 1, '2025-06-30 16:00:29'),
(219, 'borrar', '345678', '234567890\'', '', 'subetealamoto2009@hotmail.com', 'asdfghjk', 'Confirming 120 Dias', 'f34567890', 1, '2025-08-28 18:37:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentas_contables`
--

CREATE TABLE `cuentas_contables` (
  `id_cuenta` int(11) NOT NULL,
  `codigo_cuenta` varchar(20) NOT NULL,
  `nombre_cuenta` varchar(255) NOT NULL,
  `naturaleza` enum('activo','pasivo','patrimonio','ingreso','gasto') NOT NULL,
  `nivel` int(11) NOT NULL DEFAULT 1,
  `cuenta_padre` int(11) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cuentas_contables`
--

INSERT INTO `cuentas_contables` (`id_cuenta`, `codigo_cuenta`, `nombre_cuenta`, `naturaleza`, `nivel`, `cuenta_padre`, `descripcion`, `activo`) VALUES
(1, '430000', 'Clientes', 'activo', 1, NULL, 'Cuenta de clientes', 1),
(2, '400000', 'Proveedores', 'pasivo', 1, NULL, 'Cuenta de proveedores', 1),
(3, '700000', 'Ventas', 'ingreso', 1, NULL, 'Ventas de productos', 1),
(4, '600000', 'Compras', 'gasto', 1, NULL, 'Compras de mercancía', 1),
(5, '640000', 'Sueldos', 'gasto', 1, NULL, 'Gastos de personal', 1),
(6, '572000', 'Caja', 'activo', 1, NULL, 'Caja y efectivo', 1),
(7, '5455644', 'tres', 'activo', 1, NULL, 'trfrgyg', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_factura`
--

CREATE TABLE `detalle_factura` (
  `id_detalle` int(11) NOT NULL,
  `numero_factura` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_venta` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `detalle_factura`
--

INSERT INTO `detalle_factura` (`id_detalle`, `numero_factura`, `id_producto`, `cantidad`, `precio_venta`) VALUES
(226, 20250001, 273, 1, 550),
(227, 20250002, 278, 1, 550),
(228, 20250003, 236, 1, 120),
(229, 20250003, 273, 1, 550),
(230, 20250004, 236, 1, 150),
(231, 20250004, 276, 1, 550),
(232, 20250005, 287, 1, 75),
(233, 20250005, 236, 1, 150),
(234, 20250005, 264, 1, 550),
(235, 20250006, 236, 1, 120),
(236, 20250006, 277, 1, 50),
(237, 20250006, 281, 1, 550),
(238, 20250007, 236, 1, 150),
(239, 20250007, 273, 1, 550),
(240, 20250008, 236, 1, 150),
(241, 20250008, 273, 1, 550),
(242, 20250009, 238, 1, 300),
(243, 20250009, 288, 1, 75),
(244, 20250009, 285, 1, 550),
(245, 20250009, 238, 1, 300),
(246, 20250009, 288, 1, 75),
(247, 20250009, 285, 1, 530),
(248, 20250009, 238, 1, 300),
(249, 20250009, 288, 1, 75),
(250, 20250009, 278, 1, 520),
(251, 20250010, 236, 1, 150),
(252, 20250010, 264, 1, 550),
(253, 20250011, 273, 3, 555),
(254, 20250011, 274, 3, 150),
(255, 20250011, 288, 3, 70),
(256, 20250012, 273, 1, 550),
(257, 20250013, 236, 1, 150),
(258, 20250013, 278, 1, 550),
(259, 20250014, 236, 1, 150),
(260, 20250014, 273, 1, 550),
(261, 20250011, 289, 1, 0),
(262, 20250015, 236, 1, 150),
(263, 20250015, 264, 1, 550),
(264, 20250016, 236, 1, 150),
(265, 20250016, 277, 1, 70),
(266, 20250016, 278, 1, 550),
(267, 20250017, 236, 1, 120),
(268, 20250017, 264, 1, 550),
(269, 20250018, 236, 1, 120),
(270, 20250018, 275, 1, 550),
(271, 20250019, 236, 1, 150),
(272, 20250019, 264, 1, 550),
(273, 20250020, 236, 1, 150),
(274, 20250020, 275, 1, 550),
(275, 20250021, 236, 1, 120),
(276, 20250021, 273, 1, 550),
(278, 20250022, 3, 1, 0),
(279, 20250022, 3, 1, 0),
(280, 20250022, 3, 1, 0),
(281, 20250022, 3, 1, 0),
(282, 20250022, 36, 1, 0),
(283, 20250022, 36, 1, 0),
(284, 20250022, 3, 1, 0),
(285, 20250022, 3, 1, 0),
(286, 20250023, 3, 1, 0),
(287, 20250024, 3, 1, 0),
(288, 20250025, 3, 1, 0),
(289, 20250026, 3, 1, 0),
(290, 20250027, 3, 1, 0),
(291, 20250028, 3, 1, 0),
(292, 20250029, 3, 1, 0),
(293, 20250030, 27, 1, 0),
(294, 20250030, 29, 1, 0),
(295, 20250030, 27, 1, 0),
(296, 20250030, 28, 1, 0),
(297, 20250030, 29, 1, 0),
(298, 20250030, 27, 1, 0),
(299, 20250030, 29, 1, 0),
(300, 20250030, 27, 1, 0),
(301, 20250030, 28, 1, 0),
(302, 20250030, 29, 1, 0),
(303, 20250030, 27, 1, 0),
(304, 20250030, 27, 1, 0),
(305, 20250030, 3, 1, 0),
(306, 20250030, 27, 1, 0),
(307, 20250030, 29, 1, 0),
(308, 20250030, 3, 1, 0),
(309, 20250030, 27, 1, 0),
(310, 20250030, 27, 1, 0),
(311, 20250030, 29, 1, 0),
(312, 20250030, 3, 1, 0),
(313, 20250030, 27, 1, 0),
(314, 20250030, 28, 1, 0),
(315, 20250030, 28, 1, 0),
(316, 20250030, 27, 1, 0),
(317, 20250030, 29, 1, 0),
(318, 20250030, 3, 1, 0),
(319, 20250030, 27, 1, 0),
(320, 20250030, 27, 1, 0),
(321, 20250030, 28, 1, 0),
(322, 20250030, 28, 1, 0),
(323, 20250030, 27, 1, 0),
(324, 20250030, 29, 1, 0),
(325, 20250030, 3, 1, 0),
(326, 20250030, 27, 1, 0),
(327, 20250030, 28, 1, 0),
(328, 20250030, 27, 1, 0),
(329, 20250030, 28, 1, 0),
(330, 20250030, 28, 1, 0),
(331, 20250030, 27, 1, 0),
(332, 20250030, 29, 1, 0),
(333, 20250030, 3, 1, 0),
(334, 20250030, 27, 1, 0),
(335, 20250030, 28, 1, 0),
(336, 20250030, 27, 1, 0),
(337, 20250030, 28, 1, 0),
(338, 20250030, 27, 1, 0),
(339, 20250030, 28, 1, 0),
(340, 20250030, 28, 1, 0),
(341, 20250030, 27, 1, 0),
(342, 20250030, 29, 1, 0),
(343, 20250030, 3, 1, 0),
(344, 20250030, 27, 1, 0),
(345, 20250030, 3, 1, 0),
(346, 20250030, 3, 1, 0),
(347, 20250030, 3, 1, 0),
(348, 20250030, 29, 1, 0),
(349, 20250030, 3, 1, 0),
(350, 20250030, 3, 1, 0),
(351, 20250030, 28, 1, 0),
(352, 20250030, 29, 1, 0),
(353, 20250030, 28, 1, 0),
(354, 20250030, 27, 1, 0),
(355, 20250030, 29, 1, 0),
(356, 20250030, 29, 1, 0),
(357, 20250030, 27, 1, 0),
(358, 20250030, 3, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_factura_compras`
--

CREATE TABLE `detalle_factura_compras` (
  `id_detalle_compra` int(11) NOT NULL,
  `numero_factura_compra` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_venta` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `detalle_factura_compras`
--

INSERT INTO `detalle_factura_compras` (`id_detalle_compra`, `numero_factura_compra`, `id_producto`, `cantidad`, `precio_venta`) VALUES
(1, 20250001, 3, 1, 550);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `id_factura` int(11) NOT NULL,
  `numero_factura` int(11) NOT NULL,
  `fecha_factura` datetime NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `condiciones` varchar(30) NOT NULL,
  `total_venta` varchar(20) NOT NULL,
  `descuento` varchar(100) NOT NULL,
  `estado_factura` tinyint(1) NOT NULL,
  `ruta_factura` varchar(100) NOT NULL,
  `numero_pedido` varchar(40) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `facturas`
--

INSERT INTO `facturas` (`id_factura`, `numero_factura`, `fecha_factura`, `id_cliente`, `id_vendedor`, `condiciones`, `total_venta`, `descuento`, `estado_factura`, `ruta_factura`, `numero_pedido`) VALUES
(107, 20250001, '2025-04-09 21:37:16', 203, 1, '1', '550.00', '0', 2, '', ''),
(108, 20250002, '2025-05-04 21:39:10', 203, 1, '1', '550.00', '0', 2, '', ''),
(109, 20250003, '2025-05-16 15:29:17', 203, 1, '1', '670.00', '0', 2, '', ''),
(110, 20250004, '2025-05-22 17:30:38', 203, 1, '1', '700.00', '0', 2, '', ''),
(111, 20250005, '2025-05-23 17:34:45', 203, 1, '1', '775.00', '0', 2, '', ''),
(112, 20250006, '2025-05-30 17:36:26', 203, 1, '1', '720.00', '0', 2, '', ''),
(113, 20250007, '2025-06-06 16:22:38', 203, 1, '1', '700.00', '0', 2, '', ''),
(114, 20250008, '2025-06-10 16:24:00', 203, 1, '1', '700.00', '0', 2, '', ''),
(115, 20250009, '2025-06-13 16:32:26', 203, 1, '1', '2,725.00', '0', 2, '', ''),
(116, 20250010, '2025-06-17 16:34:10', 203, 1, '1', '700.00', '0', 2, '', ''),
(117, 20250011, '2025-06-30 16:14:31', 209, 1, '1', '2,325.00', '0', 2, '', ''),
(118, 20250012, '2025-07-01 17:41:19', 203, 1, '1', '550.00', '0', 2, '', ''),
(119, 20250013, '2025-07-01 17:45:14', 203, 1, '1', '700.00', '0', 2, '', ''),
(120, 20250014, '2025-07-02 17:46:49', 203, 1, '1', '700.00', '0', 2, '', ''),
(121, 20250015, '2025-07-07 11:49:58', 203, 1, '1', '700.00', '0', 2, '', ''),
(122, 20250016, '2025-07-11 16:36:31', 203, 1, '3', '770.00', '0', 2, '', ''),
(123, 20250017, '2025-07-14 16:43:07', 203, 1, '3', '670.00', '0', 2, '', ''),
(124, 20250018, '2025-07-18 16:53:44', 203, 1, '3', '670.00', '0', 2, '', ''),
(125, 20250019, '2025-07-21 18:04:56', 203, 1, '1', '700.00', '0', 2, '', ''),
(126, 20250020, '2025-07-22 18:06:24', 203, 1, '1', '700.00', '0', 2, '', ''),
(127, 20250021, '2025-07-24 18:07:35', 203, 1, '1', '670.00', '0', 2, '', ''),
(128, 20250022, '2025-08-28 23:43:22', 219, 2, '1', '0.00', '0', 2, '', ''),
(129, 20250023, '2025-08-28 23:47:26', 219, 2, '1', '0.00', '0', 2, '', ''),
(130, 20250024, '2025-08-29 21:13:53', 219, 2, '1', '0.00', '0', 2, '', ''),
(131, 20250025, '2025-08-29 21:34:59', 219, 1, '1', '0.00', '0', 2, '', ''),
(132, 20250026, '2025-08-29 21:40:02', 219, 1, '1', '0.00', '0', 2, '', ''),
(133, 20250027, '2025-08-29 22:38:07', 219, 2, '1', '0.00', '0', 2, '', ''),
(134, 20250028, '2025-08-29 23:23:58', 219, 2, '1', '0.00', '0', 2, '', ''),
(135, 20250029, '2025-08-29 23:25:50', 219, 2, '1', '0.00', '0', 2, '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas_compras`
--

CREATE TABLE `facturas_compras` (
  `id_factura_compra` int(11) NOT NULL,
  `numero_factura_compra` int(11) NOT NULL,
  `fecha_factura_compra` datetime NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `condiciones` varchar(30) NOT NULL,
  `total_venta` varchar(20) NOT NULL,
  `descuento` varchar(100) NOT NULL,
  `estado_factura` tinyint(1) NOT NULL,
  `ruta_factura` varchar(100) NOT NULL,
  `numero_pedido` varchar(40) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `facturas_compras`
--

INSERT INTO `facturas_compras` (`id_factura_compra`, `numero_factura_compra`, `fecha_factura_compra`, `id_proveedor`, `id_vendedor`, `condiciones`, `total_venta`, `descuento`, `estado_factura`, `ruta_factura`, `numero_pedido`) VALUES
(1, 20250001, '2025-04-09 21:37:16', 1, 1, '1', '550.00', '0', 2, '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos_contables`
--

CREATE TABLE `movimientos_contables` (
  `id_movimiento` int(11) NOT NULL,
  `fecha_movimiento` datetime NOT NULL,
  `concepto` varchar(255) NOT NULL,
  `id_cuenta_debe` int(11) NOT NULL,
  `id_cuenta_haber` int(11) NOT NULL,
  `importe` decimal(15,2) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `id_proveedor` int(11) DEFAULT NULL,
  `id_usuario` int(11) NOT NULL,
  `referencia` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_contabilizacion` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `movimientos_contables`
--

INSERT INTO `movimientos_contables` (`id_movimiento`, `fecha_movimiento`, `concepto`, `id_cuenta_debe`, `id_cuenta_haber`, `importe`, `id_cliente`, `id_proveedor`, `id_usuario`, `referencia`, `descripcion`, `fecha_contabilizacion`) VALUES
(1, '2025-09-28 00:00:00', 'pago', 2, 1, 440.00, NULL, NULL, 7, 'pago', 'ghhfgf', '2025-09-28 22:33:31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id_pedido` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `fecha_pedido` datetime NOT NULL,
  `fecha_entrega` datetime DEFAULT NULL,
  `condiciones` varchar(30) NOT NULL,
  `descuento` varchar(100) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `estado` enum('pendiente','confirmado','en_proceso','entregado','cancelado') NOT NULL DEFAULT 'pendiente',
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id_pedido`, `id_cliente`, `id_vendedor`, `fecha_pedido`, `fecha_entrega`, `condiciones`, `descuento`, `total`, `estado`, `observaciones`) VALUES
(1, 219, 1, '2025-09-07 12:50:05', NULL, 'Efectivo', '0', 500.00, 'pendiente', NULL),
(2, 208, 1, '2025-09-09 21:48:51', NULL, 'Transferencia', '0', 10609.00, 'pendiente', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_detalle`
--

CREATE TABLE `pedido_detalle` (
  `id_detalle` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedido_detalle`
--

INSERT INTO `pedido_detalle` (`id_detalle`, `id_pedido`, `id_producto`, `cantidad`, `precio_unitario`) VALUES
(1, 1, 269, 1, 500.00),
(2, 2, 269, 1, 500.00),
(3, 2, 299, 1, 4567.00),
(4, 2, 299, 1, 4567.00),
(5, 2, 265, 1, 975.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil`
--

CREATE TABLE `perfil` (
  `id_perfil` int(11) NOT NULL,
  `nombre_empresa` varchar(150) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `codigo_postal` varchar(100) NOT NULL,
  `estado` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `email` varchar(64) NOT NULL,
  `cif` varchar(40) NOT NULL,
  `impuesto` int(2) NOT NULL,
  `moneda` varchar(6) NOT NULL,
  `logo_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `perfil`
--

INSERT INTO `perfil` (`id_perfil`, `nombre_empresa`, `direccion`, `ciudad`, `codigo_postal`, `estado`, `telefono`, `email`, `cif`, `impuesto`, `moneda`, `logo_url`) VALUES
(1, 'AcoraDoor S.L.', 'Calle Colon nº 57.', 'Moncada', '46113', 'Valencia', '616845415', 'info@acoradoor.com', 'B21747126', 21, '€', '../images/acoradoor.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presupuestos`
--

CREATE TABLE `presupuestos` (
  `id_presupuesto` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `fecha_presupuesto` datetime NOT NULL,
  `fecha_vencimiento` datetime DEFAULT NULL,
  `condiciones` varchar(30) NOT NULL,
  `descuento` varchar(100) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `estado` enum('pendiente','aceptado','rechazado','vencido') NOT NULL DEFAULT 'pendiente',
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `presupuestos`
--

INSERT INTO `presupuestos` (`id_presupuesto`, `id_cliente`, `id_vendedor`, `fecha_presupuesto`, `fecha_vencimiento`, `condiciones`, `descuento`, `total`, `estado`, `observaciones`) VALUES
(1, 219, 1, '2025-09-10 22:59:04', NULL, 'Transferencia', '0', 9634.00, 'pendiente', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presupuesto_detalle`
--

CREATE TABLE `presupuesto_detalle` (
  `id_detalle` int(11) NOT NULL,
  `id_presupuesto` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `presupuesto_detalle`
--

INSERT INTO `presupuesto_detalle` (`id_detalle`, `id_presupuesto`, `id_producto`, `cantidad`, `precio_unitario`) VALUES
(1, 1, 269, 1, 500.00),
(2, 1, 299, 1, 4567.00),
(3, 1, 299, 1, 4567.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id_producto` int(11) NOT NULL,
  `codigo_producto` char(20) NOT NULL,
  `nombre_producto` char(255) NOT NULL,
  `categoria` varchar(60) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `status_producto` tinyint(4) NOT NULL,
  `date_added` datetime NOT NULL,
  `precio_producto` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id_producto`, `codigo_producto`, `nombre_producto`, `categoria`, `cantidad`, `status_producto`, `date_added`, `precio_producto`) VALUES
(3, 'Rtgff', 'Fffgf', 'puertas', 0, 1, '2019-10-29 13:29:37', 0),
(36, 'AC74204IZ', 'PUERTA ACORAZADA DAS1 740X2040 IZQUIERDA', 'puertas', 0, 1, '2019-12-21 15:22:17', 0),
(27, 'AC70200D', 'PUERTA ACORAZADA DAS 1 700X2000 DERECHA', 'puertas', 0, 1, '2019-12-21 11:24:14', 0),
(28, 'AC70200IZ', 'PUERTA ACORAZADA DAS 1  700X2000 IZQUIERDA', 'puertas', 0, 1, '2019-12-21 11:26:04', 0),
(29, 'AC70204D', 'PUERTA ACORAZADA DAS 1 700X2040 DERECHA', 'puertas', 0, 1, '2019-12-21 15:16:48', 0),
(30, 'AC70204IZ', 'PUERTA ACORAZADA DAS1 700X2040 IZQUIERDA', 'puertas', 0, 1, '2019-12-21 15:17:23', 0),
(31, 'AC70210D', 'PUERTA ACORAZADA DAS1 700X2100 DERECHA', 'puertas', 0, 1, '2019-12-21 15:18:20', 0),
(32, 'AC70210IZ', 'PUERTA ACORAZADA DAS1 700X2100 IZQUIERDA', 'puertas', 0, 1, '2019-12-21 15:19:52', 0),
(33, 'AC74200D', 'PUERTA ACORAZADA DAS 1 740X2000 DERECHA', 'puertas', 0, 1, '2019-12-21 15:20:27', 0),
(34, 'AC74200IZ', 'PUERTA ACORAZADA DAS1 740X2000 IZQUIERDA', 'puertas', 0, 1, '2019-12-21 15:21:04', 0),
(35, 'AC74204D', 'PUERTA ACORAZADA DAS1 740X2040 DERECHA', 'puertas', 0, 1, '2019-12-21 15:21:38', 0),
(37, 'AC74210D', 'PUERTA ACORAZADA DAS1 740X2100 DERECHA', 'puertas', 0, 1, '2019-12-21 15:23:00', 0),
(38, 'AC74210IZ', 'PUERTA ACORAZADA DAS1 740X2100 IZQUIERDA', 'puertas', 0, 1, '2019-12-21 15:23:27', 0),
(39, 'AC80200D', 'PUERTA ACORAZADA DAS1 800X2000 DERECHA', 'puertas', 0, 1, '2019-12-21 15:23:57', 0),
(40, 'AC80200IZ', 'PUERTA ACORAZADA DAS1 800X2000 IZQUIERDA', 'puertas', 0, 1, '2019-12-21 15:24:32', 0),
(41, 'AC80204D', 'PUERTA ACORAZADA DAS1 800X2040 DERECHA', 'puertas', 0, 1, '2019-12-21 15:25:02', 0),
(42, 'AC80204IZ', 'PUERTA ACORAZADA DAS1 800X2040 IZQUIERDA', 'puertas', 0, 1, '2019-12-21 15:25:34', 0),
(43, 'AC80210D', 'PUERTA ACORAZADA DAS1 800X2100 DERECHA', 'puertas', 0, 1, '2019-12-21 15:26:10', 0),
(44, 'AC80210IZ', 'PUERTA ACORAZADA DAS1 800X2100 IZQUIERDA', 'puertas', 0, 1, '2019-12-21 15:26:47', 0),
(45, 'AC85200D', 'PUERTA ACORAZADA DAS1 850X2000 DERECHA', 'puertas', 0, 1, '2019-12-21 15:27:38', 0),
(46, 'AC85200IZ', 'PUERTA ACORAZADA DAS1 850X2000 IZQUIERDA', 'puertas', 0, 1, '2019-12-21 15:28:06', 0),
(47, 'AC85204D', 'PUERTA ACORAZADA DAS1 850X2040 DERECHA', 'puertas', 0, 1, '2019-12-21 15:28:32', 0),
(48, 'AC85204IZ', 'PUERTA ACORAZADA DAS1 850X2040 IZQUIERDA', 'puertas', 0, 1, '2019-12-21 15:29:10', 0),
(49, 'AC85210D', 'PUERTA ACORAZADA DAS1 850X2100 DERECHA', 'puertas', 0, 1, '2019-12-21 15:34:28', 0),
(50, 'AC85210IZ', 'PUERTA ACORAZADA DAS1 850X2100 IZQUIERDA', 'puertas', 0, 1, '2019-12-21 15:34:57', 0),
(51, 'AC90200D', 'PUERTA ACORAZADA DAS1 900X2000 DERECHA', 'puertas', 0, 1, '2019-12-21 15:35:26', 0),
(52, 'AC90200IZ', 'PUERTA ACORAZADA DAS1 900X2100 IZQUIERDA', 'puertas', 0, 1, '2019-12-21 15:36:02', 0),
(53, 'AC90204D', 'PUERTA ACORAZADA DAS1 900X2040 DERECHA', 'puertas', 0, 1, '2019-12-21 15:36:41', 0),
(54, 'AC90204IZ', 'PUERTA ACORAZADA DAS1 900X2040 IZQUIERDA', 'puertas', 0, 1, '2019-12-21 15:37:13', 0),
(55, 'AC90210D', 'PUERTA ACORAZADA DAS1 900X2100 DERECHA', 'puertas', 0, 1, '2019-12-21 15:37:41', 0),
(56, 'AC90210IZ', 'PUERTA ACORAZADA DAS1 900X2100 IZQUIERDA', 'puertas', 0, 1, '2019-12-21 15:38:12', 0),
(57, 'ACB74200D', 'PUERTA ACORAZADAS DAS1 BLANCA 740X2000 DERECHA', 'puertas', 0, 1, '2019-12-21 15:39:03', 0),
(58, 'ACB74200IZ', 'PUERTA ACORAZADA DAS1 BLANCA 740X2000 IZQUIERDA', 'puertas', 0, 1, '2019-12-21 15:39:37', 0),
(59, 'ACB74204D', 'PUERTA ACORAZADA DAS1 BLANCA 740X2040 DERECHA', 'puertas', 0, 1, '2019-12-21 15:40:12', 0),
(60, 'ACB74204IZ', 'PUERTA ACORAZADA DAS1 BLANCA 740X2040 IZQUIERDA', 'puertas', 0, 1, '2019-12-21 15:40:52', 0),
(61, 'ACB74210D', 'PUERTA ACORAZADA DAS1 BLANCA 740X2100 DERECHA', 'puertas', 0, 1, '2019-12-21 15:41:26', 0),
(62, 'ACB74210IZ', 'PUERTA ACORAZADA DAS1 BLANCA 740X2100 IZQUIERDA', 'puertas', 0, 1, '2019-12-21 15:41:55', 0),
(63, 'ACB80200D', 'PUERTA ACORAZADA DAS1 BLANCA 800X2000 DERECHA', 'puertas', 0, 1, '2019-12-21 15:42:25', 0),
(64, 'ACB80200IZ', 'PUERTA ACORAZADA DAS1 BLANCA 800X2000 IZQUIERDA', 'puertas', 0, 1, '2019-12-21 15:42:57', 0),
(65, 'ACB80204D', 'PUERTA ACORAZADA DAS1 BLANCA 800X2040 DERECHA', 'puertas', 0, 1, '2019-12-21 15:43:35', 0),
(66, 'ACB80204IZ', 'PUERTA ACORAZADA DAS1 BLANCA 800X2040 IZQUIERDA', 'puertas', 0, 1, '2019-12-21 15:44:08', 0),
(67, 'ACB80210D', 'PUERTA ACORAZADA DAS1 BLANCA 800X2100 DERECHA', 'puertas', 0, 1, '2019-12-21 15:44:44', 0),
(68, 'ACB80210IZ', 'PUERTA ACORAZADA DAS1 BLANCA 800X2100 IZQUIERDA', 'puertas', 0, 1, '2019-12-21 15:45:25', 0),
(69, 'ACB90200D', 'PUERTA ACORAZADA DAS1 BLANCA 900X2000 DERECHA', 'puertas', 0, 1, '2019-12-21 15:47:12', 0),
(70, 'ACB90200IZ', 'PUERTA ACORAZADA DAS1 BLANCA 900X2000 IZQUIERDA', 'puertas', 0, 1, '2019-12-21 15:47:42', 0),
(71, 'ACB90204D', 'PUERTA ACORAZADA DAS1 BLANCA 900X2040 DERECHA', 'puertas', 0, 1, '2019-12-21 15:48:09', 0),
(72, 'ACB90204IZ', 'PUERTA ACORAZADA DAS1 BLANCA 900X2040 IZQUIERDA', 'puertas', 0, 1, '2019-12-21 15:48:41', 0),
(73, 'ACB90210D', 'PUERTA ACORAZADA DAS1 BLANCA 900X2100 DERECHA', 'puertas', 0, 1, '2019-12-21 15:49:08', 0),
(74, 'ACB90210IZ', 'PUERTA ACORAZADA DAS1 BLANCA 900X2100 IZQUIERDA', 'puertas', 0, 1, '2019-12-21 15:49:42', 0),
(75, 'ACB70200D', 'PUERTA ACORAZADA DAS1 BLANCA 700X2000 DERECHA', 'puertas', 0, 1, '2019-12-21 15:50:24', 0),
(76, 'ACB70200IZ', 'PUERTA ACORAZADA DAS1 BLANCA 700X2000 IZQUIERDA', 'puertas', 0, 1, '2019-12-21 15:51:02', 0),
(77, 'ACB70204D', 'PUERTA ACORAZADA DAS1 BLANCA 700X2040 DERECHA', 'puertas', 0, 1, '2019-12-21 15:51:28', 0),
(78, 'ACB70204IZ', 'PUERTA ACORAZADA DAS1 BLANCA 700X2040 IZQUIERDA', 'puertas', 0, 1, '2019-12-21 15:52:01', 0),
(79, 'ACB70210D', 'PUERTA ACORAZADA DAS1 BLANCA 700X2100 DERECHA', 'puertas', 0, 1, '2019-12-21 15:52:33', 0),
(80, 'ACB70210IZ', 'PUERTA ACORAZADA DAS1 BLANCA 700X2100 IZQUIERDA', 'puertas', 0, 1, '2019-12-21 15:53:04', 0),
(81, 'ACD70204DA', 'PUERTA ACORAZADA DAS1 700X2040 DERECHA CON APERTOR', 'puertas', 0, 1, '2019-12-21 15:53:48', 0),
(82, 'AC70204IZA', 'PUERTA ACORAZADA DAS1 700X2040 IZQUIERDA CON APERTOR', 'puertas', 0, 1, '2019-12-21 15:54:30', 0),
(83, 'ACD80204DA', 'PUERTA ACORAZADA DAS1 800X2040 DERECHA CON APERTOR', 'puertas', 0, 1, '2019-12-21 15:55:04', 0),
(84, 'ACD80204IZA', 'PUERTA ACORAZADA DAS1 800X2040 IZQUIERDA CON APERTOR', 'puertas', 0, 1, '2019-12-21 15:55:43', 0),
(85, 'TSLE', 'TABLERO SAPELY LISO EXTERIOR', 'tableros', 0, 1, '2019-12-21 15:56:22', 0),
(86, 'TSLI', 'TABLERO SAPELY LISO INTERIOR', 'tableros', 0, 1, '2019-12-21 15:56:44', 0),
(87, 'TS1C', 'TABLERO SAPELY 1 CUADRO', 'tableros', 0, 1, '2019-12-21 15:57:05', 0),
(88, 'TS2C', 'TABLERO SAPELY 2 CUADROS', 'tableros', 0, 1, '2019-12-21 15:57:26', 0),
(89, 'TS3C', 'TABLERO SAPELY 3 CUADROS', 'tableros', 0, 1, '2019-12-21 15:57:47', 0),
(90, 'TS4C', 'TABLERO SAPELY 4 CUADROS', 'tableros', 0, 1, '2019-12-21 15:58:11', 0),
(91, 'TS5C', 'TABLERO SAPELY 5 CUADROS', 'tableros', 0, 1, '2019-12-21 15:58:31', 0),
(92, 'TS6C', 'TABLERO SAPELY 6 CUADROS', 'tableros', 0, 1, '2019-12-21 15:58:50', 0),
(93, 'TS7C', 'TABLERO SAPELY 7 CUADROS', 'tableros', 0, 1, '2019-12-21 15:59:12', 0),
(94, 'TS8C', 'TABLERO SAPELY 8 CUADROS', 'tableros', 0, 1, '2019-12-21 15:59:34', 0),
(95, 'TS9C', 'TABLERO SAPELY 9 CUADROS', 'tableros', 0, 1, '2019-12-21 15:59:52', 0),
(96, 'TS10C', 'TABLERO SAPELY 10 CUADROS', 'tableros', 0, 1, '2019-12-21 16:00:11', 0),
(97, 'TS1CD', 'TABLERO SAPELY 1 CUADRO DOBLE', 'tableros', 0, 1, '2019-12-21 16:00:36', 0),
(98, 'TS2CD', 'TABLERO SAPELY 2 CUADROS DOBLES', 'tableros', 0, 1, '2019-12-21 16:00:58', 0),
(99, 'TS3CD', 'TABLERO SAPELY 3 CUADROS DOBLES', 'tableros', 0, 1, '2019-12-21 16:01:32', 0),
(100, 'TS4CD', 'TABLERO SAPELY 4 CUADROS DOBLES', 'tableros', 0, 1, '2019-12-21 16:01:53', 0),
(101, 'TS5CD', 'TABLERO SAPELY 5 CUADROS DOBLES', 'tableros', 0, 1, '2019-12-21 16:02:20', 0),
(102, 'TS6CD', 'TABLERO SAPELY 6 CUADROS DOBLES', 'tableros', 0, 1, '2019-12-21 16:02:43', 0),
(103, 'TS7CD', 'TABLERO SAPELY 7 CUADROS DOBLES', 'tableros', 0, 1, '2019-12-21 16:03:04', 0),
(104, 'TS8CD', 'TABLERO SAPELY 8 CUADROS DOBLES', 'tableros', 0, 1, '2019-12-21 16:03:26', 0),
(105, 'TS9CD', 'TABLERO SAPELY 9 CUADROS DOBLES', 'tableros', 0, 1, '2019-12-21 16:03:58', 0),
(106, 'TS10CD', 'TABLERO SAPELY 10 CUADROS DOBLES', 'tableros', 0, 1, '2019-12-21 16:04:51', 0),
(107, 'TS1CP', 'TABLERO SAPELY 1 CUADRO PLAFON INTERIOR', 'tableros', 0, 1, '2019-12-21 16:05:28', 0),
(108, 'TS4CP', 'TABLERO SAPELY 4 CUADROS PLAFON INTERIOR', 'tableros', 0, 1, '2019-12-21 16:06:19', 0),
(109, 'TS5CP', 'TABLERO SAPELY 5 CUADROS PLAFON INTERIOR', 'tableros', 0, 1, '2019-12-21 16:06:49', 0),
(110, 'TS6CP', 'TABLERO SAPELY 6 CUADROS PLAFON INTERIOR', 'tableros', 0, 1, '2019-12-21 16:07:20', 0),
(111, 'TS7CP', 'TABLERO SAPELY 7 CUADROS PLAFON INTERIOR', 'tableros', 0, 1, '2019-12-21 16:07:51', 0),
(112, 'TS8CP', 'TABLERO SAPELY 8 CUADROS PLAFON INTERIOR', 'tableros', 0, 1, '2019-12-21 16:08:19', 0),
(113, 'TS10CP', 'TABLERO SAPELY 10 CUADROS PLAFON INTERIOR', 'tableros', 0, 1, '2019-12-21 16:08:48', 0),
(114, 'TRLE', 'TABLERO ROBLE LISO EXTERIOR', 'tableros', 0, 1, '2019-12-21 16:09:09', 0),
(115, 'TRLI', 'TABLERO ROBLE LISO INTERIOR', 'tableros', 0, 1, '2019-12-21 16:09:30', 0),
(116, 'TR1C', 'TABLERO ROBLE 1 CUADRO', 'tableros', 0, 1, '2019-12-21 16:09:54', 0),
(117, 'TR2C', 'TABLERO ROBLE 2 CUADROS', 'tableros', 0, 1, '2019-12-21 16:10:14', 0),
(118, 'THLE', 'TABLERO HAYA VAPORIZADA LISA EXTERIOR', 'tableros', 0, 1, '2019-12-21 16:10:53', 0),
(119, 'THLI', 'TABLERO HAYA VAPORIZADA LISA INTERIOR', 'tableros', 0, 1, '2019-12-21 16:11:59', 0),
(120, 'TH2C', 'TABLERO HAYA VAPORIZADA 2 CUADROS', 'tableros', 0, 1, '2019-12-21 16:12:55', 0),
(121, 'TMLE', 'TABLERO MUKALY LISO EXTERIOR', 'tableros', 0, 1, '2019-12-21 16:13:21', 0),
(122, 'TMLI', 'TABLERO MUKALY LISO INTERIOR', 'tableros', 0, 1, '2019-12-21 16:13:41', 0),
(123, 'TM2C', 'TABLERO MUKALY 2 CUADROS', 'tableros', 0, 1, '2019-12-21 16:14:04', 0),
(124, 'TCLE', 'TABLERO CEREZO LISO EXTERIOR', 'tableros', 0, 1, '2019-12-21 16:14:30', 0),
(125, 'TCLI', 'TABLERO CEREZO LISO INTERIOR', 'tableros', 0, 1, '2019-12-21 16:14:52', 0),
(126, 'TC2C', 'TABLERO CEREZO 2 CUADROS', 'tableros', 0, 1, '2019-12-21 16:15:14', 0),
(127, 'TPOLE', 'TABLERO PINO OREGON LISO EXTERIOR', 'tableros', 0, 1, '2019-12-21 16:15:39', 0),
(128, 'TPOLI', 'TABLERO PINO OREGON LISO INTERIOR', 'tableros', 0, 1, '2019-12-21 16:16:00', 0),
(129, 'TPO2C', 'TABLERO PINO OREGON 2 CUADROS', 'tableros', 0, 1, '2019-12-21 16:16:25', 0),
(130, 'TPO4C', 'TABLERO PINO OREGON 4 CUADROS', 'tableros', 0, 1, '2019-12-21 16:16:45', 0),
(131, 'TPO10C', 'TABLERO PINO OREGON 10 CUADROS', 'tableros', 0, 1, '2019-12-21 16:17:06', 0),
(132, 'TCSE', 'TABLERO CONTRAMALLA SAPELY EXTERIOR', 'tableros', 0, 1, '2019-12-21 16:18:40', 0),
(133, 'TCRE', 'TABLERO CONTRAMALLA ROBLE EXTERIOR', 'tableros', 0, 1, '2019-12-21 16:19:04', 0),
(134, 'TCSI', 'TABLERO CONTRAMALLA SAPELY INTERIOR', 'tableros', 0, 1, '2019-12-21 16:19:26', 0),
(135, 'TCRI', 'TABLERO CONTRAMALLA ROBLE INTERIOR', 'tableros', 0, 1, '2019-12-21 16:19:50', 0),
(136, 'TCHE', 'TABLERO CONTRAMALLA HAYA VAPORIZADA EXTERIOR', 'tableros', 0, 1, '2019-12-21 16:20:22', 0),
(137, 'TCHI', 'TABLERO CONTRAMALLA HAYA VAPORIZADA INTERIOR', 'tableros', 0, 1, '2019-12-21 16:20:52', 0),
(138, 'TCCE', 'TABLERO CONTRAMALLA CEREZO EXTERIOR', 'tableros', 0, 1, '2019-12-21 16:21:19', 0),
(139, 'TCCI', 'TABLERO CONTRAMALLA CEREZO INTERIOR', 'tableros', 0, 1, '2019-12-21 16:21:55', 0),
(140, 'THSE', 'TABLERO MODELO H SAPELY EXTERIOR', 'tableros', 0, 1, '2019-12-21 16:22:25', 0),
(141, 'THSI', 'TABLERO MODELO H SAPELY INTERIOR', 'tableros', 0, 1, '2019-12-21 16:22:45', 0),
(142, 'THRE', 'TABLERO MODELO H ROBLE EXTERIOR', 'tableros', 0, 1, '2019-12-21 16:23:08', 0),
(143, 'THRI', 'TABLERO MODELO H ROBLE INTERIOR', 'tableros', 0, 1, '2019-12-21 16:23:29', 0),
(144, 'THHE', 'TABLERO MODELO H HAYA VAPORIZADA EXTERIOR', 'tableros', 0, 1, '2019-12-21 16:23:53', 0),
(145, 'THHI', 'TABLERO MODELO H HAYA VAPORIZADA INTERIOR', 'tableros', 0, 1, '2019-12-21 16:24:15', 0),
(146, 'THCE', 'TABLERO MODELO H CEREZO EXTERIOR', 'tableros', 0, 1, '2019-12-21 16:24:38', 0),
(147, 'THCI', 'TABLERO MODELO H CEREZO INTERIOR', 'tableros', 0, 1, '2019-12-21 16:25:00', 0),
(148, 'TRSE', 'TABLERO RANURADO 4 RAYAS  SAPELY EXTERIOR', 'tableros', 0, 1, '2019-12-21 16:25:52', 0),
(149, 'TRSI', 'TABLERO RANURADO 4 RAYAS SAPELY INTERIOR', 'tableros', 0, 1, '2019-12-21 16:26:17', 0),
(150, 'TRRE', 'TABLERO RANURADO  4 RAYAS ROBLE EXTERIOR', 'tableros', 0, 1, '2019-12-21 16:26:43', 0),
(151, 'TRRI', 'TABLERO RANURADO 4 RAYAS ROBLE INTERIOR', 'tableros', 0, 1, '2019-12-21 16:27:14', 0),
(152, 'TRHE', 'TABLERO RANURADO 4 RAYAS HAYA VAPORIZADA EXTERIOR', 'tableros', 0, 1, '2019-12-21 16:27:47', 0),
(153, 'TRHI', 'TABLERO RANURADO  4 RAYAS HAYA VAPORIZADA INTERIOR', 'tableros', 0, 1, '2019-12-21 16:28:37', 0),
(154, 'TRCE', 'TABLERO RANURADO 4 RAYAS CEREZO EXTERIOR', 'tableros', 0, 1, '2019-12-21 16:30:07', 0),
(155, 'TRCI', 'TABLERO RANURADO 4 RAYAS CEREZO INTERIOR', 'tableros', 0, 1, '2019-12-21 16:30:33', 0),
(156, 'TBLE', 'TABLERO BLANCO LISO EXTERIOR', 'tableros', 0, 1, '2019-12-21 16:30:53', 0),
(157, 'TBLI', 'TABLERO BLANCO LISO INTERIOR', 'tableros', 0, 1, '2019-12-21 16:31:19', 0),
(158, 'TRBE', 'TABLERO  RANURADO 4 RAYAS BLANCO EXTERIOR', 'tableros', 0, 1, '2019-12-21 16:32:11', 0),
(159, 'TRBI', 'TABLERO RANURADO 4 RAYAS BLANCO INTERIOR', 'tableros', 0, 1, '2019-12-21 16:32:39', 0),
(160, 'TRB2HE', 'TABLERO RANURADO BLANCO 2 RAYAS HORIZONTALES EXTERIOR', 'tableros', 0, 1, '2019-12-21 16:33:32', 0),
(161, 'TRB2HI', 'TABLERO RANURADO BLANCO 2 RAYAS HORIZONTALES INTERIOR', 'tableros', 0, 1, '2019-12-21 16:34:09', 0),
(162, 'TRB2VE', 'TABLERO RANURADO BLANCO 2 RAYAS VERTICALES EXTERIOR', 'tableros', 0, 1, '2019-12-21 16:34:47', 0),
(163, 'TRB2VI', 'TABLERO RANURADO BLANCO2 RAYAS VERTICALES INTERIOR', 'tableros', 0, 1, '2019-12-21 16:35:21', 0),
(164, 'TABLE', 'TABLERO ALUMINIO BLANCO LISO EXTERIOR', 'tableros', 0, 1, '2019-12-21 16:35:59', 0),
(165, 'TABRE', 'TABLERO ALUMINIO BLANCO 4 RAYAS EXTERIOR', 'tableros', 0, 1, '2019-12-21 16:36:33', 0),
(166, 'TPVCBLE', 'TABLERO PVC BLANCO LISO EXTERIOR', 'tableros', 0, 1, '2019-12-21 16:37:16', 0),
(167, 'TPVCBRE', 'TABLERO PVC BLANCO 4 RAYAS EXTERIOR', 'tableros', 0, 1, '2019-12-21 16:37:43', 0),
(168, 'TPVCRE', 'TABLERO PVC GOLDEN ORO LISO EXTERIOR', 'tableros', 0, 1, '2019-12-21 16:38:50', 0),
(169, 'TPVCRRE', 'TABLERO PVC ROBLE GOLDEN ORO RANURADO 4 RAYAS EXTERIOR', 'tableros', 0, 1, '2019-12-21 16:39:26', 0),
(170, 'TPVCNE', 'TABLERO PVC NOGAL LISO EXTERIOR', 'tableros', 0, 1, '2019-12-21 16:40:01', 0),
(171, 'TPVCNRE', 'TABLERO PVC NOGAL RANURADO 4 RAYAS EXTERIOR', 'tableros', 0, 1, '2019-12-21 16:40:33', 0),
(172, 'TJS7', 'TAPAJUNTAS MOLDURADO SAPELY 7 CMS', 'molduras', 0, 1, '2019-12-21 16:41:28', 0),
(173, 'TJS8', 'TAPAJUNTAS MOLDURADO SAPELY 8 CMS', 'molduras', 0, 1, '2019-12-21 16:41:52', 0),
(174, 'TJS9', 'TAPAJUNTAS MOLDURADO SAPELY 9 CMS', 'molduras', 0, 1, '2019-12-21 16:42:16', 0),
(175, 'TJR7', 'TAPAJUNTAS MOLDURADO ROBLE 7 CMS', 'molduras', 0, 1, '2019-12-21 16:42:38', 0),
(176, 'TJR8', 'TAPAJUNTAS MOLDURADO ROBLE DE 8 CMS', 'molduras', 0, 1, '2019-12-21 16:43:04', 0),
(177, 'TJR9', 'TAPAJUNTAS MOLDURADO ROBLE DE 9 CMS', 'molduras', 0, 1, '2019-12-21 16:43:29', 0),
(178, 'TJPM7', 'TAPAJUNTAS MOLDURADO PINO MELIS 7 CMS', 'molduras', 0, 1, '2019-12-21 16:43:54', 0),
(179, 'TJPM9', 'TAPAJUNTAS MOLDURADO PINO MELIS 9 CMS', 'molduras', 0, 1, '2019-12-21 16:44:22', 0),
(180, 'TJM7', 'TAPAJUNTAS MOLDURADO MUKALY 7 CMS', 'molduras', 0, 1, '2019-12-21 16:44:52', 0),
(181, 'TJM9', 'TAPAJUNTAS MOLDURADO MUKALY 7CMS', 'molduras', 0, 1, '2019-12-21 16:45:19', 0),
(182, 'TPS7', 'TAPETA LISA SAPELY 7 CMS', 'molduras', 0, 1, '2019-12-21 16:45:44', 0),
(183, 'TPS8', 'TAPETA LISA SAPELY 8 CMS', 'molduras', 0, 1, '2019-12-21 16:46:08', 0),
(184, 'TPS9', 'TAPETA LISA SAPELY 9 CMS', 'molduras', 0, 1, '2019-12-21 16:46:32', 0),
(185, 'TPR7', 'TAPETA LISA ROBLE 7 CMS', 'molduras', 0, 1, '2019-12-21 16:47:38', 0),
(186, 'TPR8', 'TAPETA LISA ROBLE 8 CMS', 'molduras', 0, 1, '2019-12-21 16:48:04', 0),
(187, 'TPR9', 'TAPETA LISA ROBLE 9 CMS', 'molduras', 0, 1, '2019-12-21 16:48:25', 0),
(188, 'TPH7', 'TAPETA LISA HAYA VAPORIZADA 7 CMS', 'molduras', 0, 1, '2019-12-21 16:48:47', 0),
(189, 'TPH8', 'TAPETA LISA HAYA VAPORIZADA 8 CMS', 'molduras', 0, 1, '2019-12-21 16:49:13', 0),
(190, 'TPH9', 'TAPETA LISA HAYA VAPORIZADA 9 CMS', 'molduras', 0, 1, '2019-12-21 16:49:47', 0),
(191, 'TPM7', 'TAPETA LISA MUKALY 7 CMS', 'molduras', 0, 1, '2019-12-21 16:50:09', 0),
(192, 'TPM9', 'TAPETA LISA MUKALY DE 9 CMS', 'molduras', 0, 1, '2019-12-21 16:50:35', 0),
(193, 'TPPM7', 'TAPETA LISA  PINO MELIS 7 CMS', 'molduras', 0, 1, '2019-12-21 16:51:05', 0),
(194, 'TPPM9', 'TAPETA LISA PINO MELIS 9 CMS', 'molduras', 0, 1, '2019-12-21 16:51:26', 0),
(195, 'TPC7', 'TAPETA LISA CEREZO 7 CMS', 'molduras', 0, 1, '2019-12-21 16:51:48', 0),
(196, 'TPC9', 'TAPETA LISA CEREZO 9 CMS', 'molduras', 0, 1, '2019-12-21 16:52:16', 0),
(197, 'TPN7', 'TAPETA LISA NOGAL 7 CMS', 'molduras', 0, 1, '2019-12-21 16:52:36', 0),
(198, 'TPN9', 'TAPETA LISA NOGAL 9 CMS', 'molduras', 0, 1, '2019-12-21 16:52:56', 0),
(199, 'TJN7', 'TAPAJUNTAS  MOLDURADO NOGAL 7 CMS', 'molduras', 0, 1, '2019-12-21 16:53:30', 0),
(200, 'TJN9', 'TAPAJUNTAS MOLDURADO NOGAL 9 CMS', 'molduras', 0, 1, '2019-12-21 16:53:57', 0),
(201, 'TPB7', 'TAPETA LISA BLANCA 7 CMS', 'molduras', 0, 1, '2019-12-21 16:54:20', 0),
(202, 'TPB8', 'TAPETA LISA BLANCA 8 CMS', 'molduras', 0, 1, '2019-12-21 16:54:39', 0),
(203, 'TPB9', 'TAPETA LISA BLANCA 9 CMS', 'molduras', 0, 1, '2019-12-21 16:55:01', 0),
(204, 'TPBPVC6', 'TAPETA LISA PVC BLANCA 6 CMS', 'molduras', 0, 1, '2019-12-21 16:55:39', 0),
(205, 'TPBPVC8', 'TAPETA LISA PVC BLANCA 8 CMS', 'molduras', 0, 1, '2019-12-21 16:56:08', 0),
(206, 'TPRPVC6', 'TAPETA LISA PVC GOLDEN ORO 6CMS', 'molduras', 0, 1, '2019-12-21 16:56:41', 0),
(207, 'TPRPVC8', 'TAPETA LISA PVC ROBLE GOLDEN ORO 8 CMS', 'molduras', 0, 1, '2019-12-21 16:57:23', 0),
(208, 'TPNPVC6', 'TAPETA LISA PVC NOGAL 6 CMS', 'molduras', 0, 1, '2019-12-21 16:58:06', 0),
(209, 'TPNPVC8', 'TAPETA LISA PVC NOGAL 8 CMS', 'molduras', 0, 1, '2019-12-21 16:58:28', 0),
(210, 'TPMLE', 'TABLERO PINO MELIS LISO EXTERIOR', 'tableros', 0, 1, '2019-12-21 16:58:52', 0),
(211, 'TPMLI', 'TABLERO PINO MELIS LISO INTERIOR', 'tableros', 0, 1, '2019-12-21 16:59:25', 0),
(212, 'TPM2C', 'TABLERO PINO MELIS 2 CUADROS', 'tableros', 0, 1, '2019-12-21 17:00:05', 0),
(213, 'TPM4C', 'TABLERO PINO MELIS 4 CUADROS', 'tableros', 0, 1, '2019-12-21 17:00:27', 0),
(214, 'TPM10C', 'TABLERO PINO MELIS 10 CUADROS', 'tableros', 0, 1, '2019-12-21 17:00:48', 0),
(215, 'TNLE', 'TABLERO NOGAL LISO EXTERIOR', 'tableros', 0, 1, '2019-12-21 17:01:10', 0),
(216, 'TNLI', 'TABLERO NOGAL LISO INTERIOR', 'tableros', 0, 1, '2019-12-21 17:01:28', 0),
(217, 'TN2C', 'TABLERO NOGAL 2 CUADROS', 'tableros', 0, 1, '2019-12-21 17:01:46', 0),
(218, 'ACK1009D', 'PUERTA ACORAZADA KIUSO 100 DE GRADO 4 2068X990 HOJA 2006X900 DERECHA', 'puertas', 0, 1, '2019-12-22 11:13:42', 0),
(219, 'ACK1009IZ', 'PUERTA ACORAZADA KIUSO 100 DE GRADO 4 2068X990 HOJA 2006X900 IZQUIERDA', 'puertas', 0, 1, '2019-12-22 11:14:59', 0),
(220, 'ACK1008D', 'PUERTA ACORAZADA KIUSO 100 DE GRADO 4 2068X910 HOJA 2006X820 DERECHA', 'puertas', 0, 1, '2019-12-22 11:15:44', 0),
(221, 'ACK1008IZ', 'PUERTA ACORAZADA KIUSO 100 DE GRADO 4 2068X910 HOJA 2006X820 IZQUIERDA', 'puertas', 0, 1, '2019-12-22 11:16:33', 0),
(222, 'ACKXXI8D', 'PUERTA ACORAZADA KIUSO XXI DE GRADO 4 2083X910 HOJA 2021X820 DERECHA', 'puertas', 0, 1, '2019-12-22 11:17:58', 0),
(223, 'ACKXXI8IZ', 'PUERTA ACORAZADA KIUSO XXI DE GRADO 4 2083X910 HOJA 2021X820 IZQUIERDA', 'puertas', 0, 1, '2019-12-22 11:18:51', 0),
(224, 'HPL', 'HERRAJE PLATA POMO LATERAL', 'herrajes', 0, 1, '2019-12-22 11:20:27', 0),
(225, 'HPC', 'HERRAJE PLATA POMO CENTRAL', 'herrajes', 0, 1, '2019-12-22 11:20:51', 0),
(226, 'HBL', 'HERRAJE BRONCE POMO LATERAL', 'herrajes', 0, 1, '2019-12-22 11:21:16', 0),
(227, 'HBC', 'HERRAJE BRONCE POMO CENTRAL', 'herrajes', 0, 1, '2019-12-22 11:21:39', 0),
(228, 'HMBCL', 'HERRAJE MIXTO BRONCE EXTERIOR  Y PLATA  INTERIOR POMO LATERAL', 'herrajes', 0, 1, '2019-12-22 11:22:28', 0),
(229, 'HMBPC', 'HERRAJE MIXTO BRONCE EXTERIOR PLATA INTERIOR POMO CENTRAL', 'herrajes', 0, 1, '2019-12-22 11:23:07', 0),
(230, 'HOL', 'HERRAJE ORO POMO LATERAL', 'herrajes', 0, 1, '2019-12-22 11:24:26', 0),
(231, 'HOC', 'HERRAJE ORO POMO CENTRAL', 'herrajes', 0, 1, '2019-12-22 11:24:46', 0),
(232, 'HMOPL', 'HERRAJE MIXTO ORO EXTERIOR Y PLATA INTERIOR POMO LATERAL', 'herrajes', 0, 1, '2019-12-22 11:25:23', 0),
(233, 'HMOPC', 'HERRAJE MIXTO ORO EXTERIOR Y PLATA INTERIOR POMO CENTRAL', 'herrajes', 0, 1, '2019-12-22 11:25:58', 0),
(234, 'HMPBL', 'HERRAJE MIXTO PLATA EXTERIOR Y BRONCE INTERIOR POMO LATERAL', 'herrajes', 0, 1, '2019-12-22 11:26:37', 0),
(235, 'HMPBC', 'HERRAJE MIXTO PLATA EXTERIOR BRONCE INTERIOR POMO CENTRAL', 'herrajes', 0, 1, '2019-12-22 11:29:22', 0),
(236, 'MM', 'MONTAJE SOBRE PREMARCO DE MADERA', 'momtaje', 1, 1, '2019-12-22 11:30:00', 130),
(237, 'MCF', 'MONTAJE DE COLGAR Y FORRAR', 'momtaje', 1, 1, '2019-12-22 11:30:21', 130),
(238, 'MCA', 'MONTAJE COMPLETO CON ALBAÑILERIA', 'momtaje', 1, 1, '2019-12-22 11:31:03', 300),
(239, 'BIF', 'BOMBILLO IFAM', 'bombillo', 1, 1, '2019-12-22 11:50:38', 0),
(240, 'BIO', 'BOMBILLO ISEO CON LLAVE DE OBRA', 'bombillo', 1, 1, '2019-12-22 11:51:28', 0),
(241, 'BMC', 'BOMBILLO MOTURA CHAMPIONS PRO', 'bombillo', 1, 1, '2019-12-22 11:52:17', 0),
(242, 'BKM', 'BOMBILLO KABA MATRIX', 'bombillo', 1, 1, '2019-12-22 11:53:10', 0),
(243, 'BDS', 'BOMBILLO DISPAVAL SNAKE', 'bombillo', 1, 1, '2019-12-22 11:55:32', 0),
(244, 'BA', 'BOMBILLO ABUS', 'bombillo', 1, 1, '2019-12-22 11:55:57', 0),
(245, 'BAP4', 'BOMBILLO CISA AP4', 'bombillo', 1, 1, '2019-12-22 11:56:29', 0),
(246, 'ACTP', 'PUERTA ACORAZADA TESA GRADO 4 PREMIUN', 'puertas', 1, 1, '2019-12-22 12:10:30', 0),
(247, 'ACTA', 'PUERTA ACORAZADA TESA GRADO 4 AUTOMATICA', 'puertas', 1, 1, '2019-12-22 12:11:11', 0),
(249, 'BO', 'BOMBILLO OBRA', 'bombillo', 0, 1, '2020-01-20 09:55:37', 0),
(251, 'PIBL', 'PUERTA INTERIOR LACADA BLANCO LISO', 'p_paso', 0, 1, '2020-02-25 16:54:15', 0),
(252, 'AC80217IZ', 'PUERTA ACORAZADA DAS1 800X2170 IZQUIERDA', 'puertas', 0, 1, '2020-04-23 08:03:14', 0),
(264, 'paa', 'puerta acorazada acoradoor 800x2000 iz', 'puertas', 25, 1, '2024-01-06 22:03:39', 500),
(265, 'pta', 'Puerta acorazada asso10  medidas estandar', 'puertas', 1, 1, '2024-01-08 20:09:55', 975),
(266, 'hghg', 'Montaje de puerta acorazada', 'puertas', 1, 1, '2024-01-08 20:15:32', 10),
(267, 'hgjhg', 'FORROS COMPLETOS INTERIOR Y EXTERIOR', 'puertas', 1, 1, '2024-01-08 20:17:26', 10),
(268, 'yyui', 'PUERTA ACORAZADA DIERRE ASSO10 DE MEDIDAS ESTANDAR', 'puertas', 1, 1, '2024-01-08 20:19:52', 975),
(269, 'PTYTT', 'ACORADOOR', 'puertas', 5, 1, '2024-01-13 19:37:41', 500),
(270, 'YHHE', 'ACORADOR 800X2040', 'puertas', 7, 1, '2024-01-13 19:39:22', 500),
(271, '5W4Y', 'ACORADOOR 900X2000', 'puertas', 0, 1, '2024-01-13 19:40:03', 500),
(272, 'ACO0001', 'Puerta AcoraDoor Exposicion', 'puertas', 110, 1, '2024-07-11 17:52:58', 250),
(273, 'ACO0002', 'Puerta Acorazada AcoraDoor 800x2000 D', 'puertas', 110, 1, '2024-07-11 17:57:31', 250),
(274, 'mmoo1', 'Montaje', 'puertas', 10, 1, '2024-07-23 15:41:39', 200),
(275, 'ac000004', 'puerta acorazada acoradoor 740x2000 D', 'puertas', 55, 1, '2024-07-23 15:50:14', 550),
(276, 'ac000005', 'Puerta acorazada AcoraDoor 740x2100 D', 'puertas', 66, 1, '2024-08-01 17:56:47', 550),
(277, 'tra00001', 'Corte a medida', 'puertas', 1, 1, '2024-08-01 18:02:51', 100),
(278, 'ac0006', 'Puerta acorazada acoradoor 740x2000 IZ', 'puertas', 1, 1, '2024-08-01 18:04:02', 100),
(279, 'aco004', 'puerta acorazada acoradoor 800x2040 D', 'puertas', 5, 1, '2024-11-16 18:29:31', 550),
(280, 'paa000065', 'puerta acorazada acoradoor 740x2000 D', 'puertas', 44, 1, '2024-11-30 16:55:40', 550),
(281, 'ac000065', 'puerta acorazada acoradoor 700x2000 D', 'puertas', 44, 1, '2024-11-30 16:57:02', 550),
(282, 'ac000066', 'puerta acorazada acoradoor 740x2040 D', 'puertas', 66, 1, '2025-01-09 19:27:18', 550),
(283, 'aco011', 'puerta acorazada acoradoor 800x2040 D', 'puertas', 55, 1, '2025-02-09 19:58:39', 550),
(284, 'aco015', 'puerta acorazada acoradoor 800x2040 IZ', 'puertas', 55, 1, '2025-02-09 19:59:31', 550),
(285, 'pacad', 'puerta acorazada acoradoor 700x2000 iz', 'puertas', 55, 1, '2025-03-15 07:42:02', 550),
(286, 'ac00045', 'Puerta acorazada AcoraDoor 700x2100 D', 'puertas', 77, 1, '2025-03-15 07:47:27', 550),
(287, 'acoo', 'Pulimento tono', 'puertas', 99, 1, '2025-05-30 17:34:13', 75),
(288, 'g6t65', 'Premarco Puerta Acorazada', 'puertas', 60, 1, '2025-06-19 16:28:59', 75),
(289, 'inpu', 'Operación de Inversión del Sujeto Pasivo de acuerdo al art. 84, apartado uno, número 22 f) de la Ley 37/1992 de IVA', 'puertas', 1, 1, '2025-07-02 16:12:35', 1),
(299, 'borrar', 'dorrar', 'puertas', 6, 1, '2025-08-28 18:38:12', 4567);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id_proveedor` int(11) NOT NULL,
  `nombre_proveedor` varchar(255) NOT NULL,
  `n_cuenta` varchar(9999) NOT NULL,
  `telefono_proveedor` char(30) NOT NULL,
  `telefono_movil` varchar(60) NOT NULL,
  `email_proveedor` varchar(64) NOT NULL,
  `direccion_proveedor` varchar(255) NOT NULL,
  `pago` varchar(100) NOT NULL,
  `cif` varchar(60) NOT NULL,
  `status_proveedor` tinyint(4) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id_proveedor`, `nombre_proveedor`, `n_cuenta`, `telefono_proveedor`, `telefono_movil`, `email_proveedor`, `direccion_proveedor`, `pago`, `cif`, `status_proveedor`, `date_added`) VALUES
(1, 'Proveedor de Ejemplo', '123456789', '961234567', '600123456', 'proveedor@ejemplo.com', 'Calle Ejemplo, 123', 'Transferencia', 'B12345678', 1, '2025-09-15 10:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subcuentas_contables`
--

CREATE TABLE `subcuentas_contables` (
  `id_subcuenta` int(11) NOT NULL,
  `codigo_subcuenta` varchar(30) NOT NULL,
  `nombre_subcuenta` varchar(255) NOT NULL,
  `tipo_subcuenta` enum('cliente','proveedor','centro_coste','proyecto') NOT NULL,
  `referencia_id` int(11) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `subcuentas_contables`
--

INSERT INTO `subcuentas_contables` (`id_subcuenta`, `codigo_subcuenta`, `nombre_subcuenta`, `tipo_subcuenta`, `referencia_id`, `descripcion`, `activo`) VALUES
(1, '4444', 'hgdxds', 'cliente', 172, 'tftedff', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tmp`
--

CREATE TABLE `tmp` (
  `id_tmp` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad_tmp` int(11) NOT NULL,
  `precio_tmp` double(8,2) DEFAULT NULL,
  `session_id` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Volcado de datos para la tabla `tmp`
--

INSERT INTO `tmp` (`id_tmp`, `id_producto`, `cantidad_tmp`, `precio_tmp`, `session_id`) VALUES
(458, 264, 2, 500.00, 'ai85ah07vo555n71ae5pb4lfe3'),
(457, 3, 1, 0.00, 'ai85ah07vo555n71ae5pb4lfe3'),
(454, 57, 1, 0.00, 'v78evombtq9bfa6djonba6gs14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL COMMENT 'auto incrementing user_id of each user, unique index',
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `user_name` varchar(64) NOT NULL COMMENT 'user''s name, unique',
  `user_password_hash` varchar(255) NOT NULL COMMENT 'user''s password in salted and hashed format',
  `user_email` varchar(64) NOT NULL COMMENT 'user''s email, unique',
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci COMMENT='user data';

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`user_id`, `firstname`, `lastname`, `user_name`, `user_password_hash`, `user_email`, `date_added`) VALUES
(1, 'Toni', 'Gallur', 'admin', '$2y$10$MPVHzZ2ZPOWmtUUGCq3RXu31OTB.jo7M9LZ7PmPQYmgETSNn19ejO', 'admin@admin.com', '2016-05-21 15:06:00'),
(2, 'Juan Carlos', 'Clavijo', 'Juancarlos', '$2y$10$DZvKyTOO7HZpYzXsN4e8xOyP7Tg0N1P5HpWUDFVN1lDaeBzNgxXzW', 'juancarlos@dispaval.com', '2019-10-13 17:28:10'),
(3, 'Pablo ', 'Perez Gonzalez', 'Pablo', '$2y$10$371M63nScYXdTURjoT1CpOepVzmHErH4JIrLsOIWmJ71hVq/ThDb.', 'pablo@dispaval.com', '2020-01-12 10:15:32');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `rol` enum('admin','user') DEFAULT 'user',
  `activo` tinyint(1) DEFAULT 1,
  `ultimo_login` datetime DEFAULT NULL,
  `intentos_fallidos` int(11) DEFAULT 0,
  `creado_en` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `password_hash`, `rol`, `activo`, `ultimo_login`, `intentos_fallidos`, `creado_en`, `updated_at`) VALUES
(7, 'toni', '$2y$12$//KjGIhbotME9ljyqtzIxOif2U58wBCsrzxmW72P6atcUKQFE6zgu', 'admin', 1, '2026-01-02 18:40:42', 0, '2025-08-25 23:19:56', '2026-01-02 18:40:42'),
(8, 'usuario', '$2y$12$TtZV6Y3eQABFhtmNz08HL.6Eagay5FpvOQizGdPCxuwTMxqV8YqUC', 'user', 1, NULL, 0, '2025-08-25 23:19:57', '2025-08-25 23:19:57');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias_contables`
--
ALTER TABLE `categorias_contables`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`),
  ADD UNIQUE KEY `codigo_producto` (`nombre_cliente`);

--
-- Indices de la tabla `cuentas_contables`
--
ALTER TABLE `cuentas_contables`
  ADD PRIMARY KEY (`id_cuenta`),
  ADD UNIQUE KEY `codigo_cuenta` (`codigo_cuenta`),
  ADD KEY `cuenta_padre` (`cuenta_padre`);

--
-- Indices de la tabla `detalle_factura`
--
ALTER TABLE `detalle_factura`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `numero_cotizacion` (`numero_factura`,`id_producto`);

--
-- Indices de la tabla `detalle_factura_compras`
--
ALTER TABLE `detalle_factura_compras`
  ADD PRIMARY KEY (`id_detalle_compra`),
  ADD KEY `numero_cotizacion` (`numero_factura_compra`,`id_producto`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`id_factura`),
  ADD UNIQUE KEY `numero_cotizacion` (`numero_factura`);

--
-- Indices de la tabla `facturas_compras`
--
ALTER TABLE `facturas_compras`
  ADD PRIMARY KEY (`id_factura_compra`),
  ADD UNIQUE KEY `numero_cotizacion` (`numero_factura_compra`);

--
-- Indices de la tabla `movimientos_contables`
--
ALTER TABLE `movimientos_contables`
  ADD PRIMARY KEY (`id_movimiento`),
  ADD KEY `id_cuenta_debe` (`id_cuenta_debe`),
  ADD KEY `id_cuenta_haber` (`id_cuenta_haber`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_proveedor` (`id_proveedor`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_vendedor` (`id_vendedor`);

--
-- Indices de la tabla `pedido_detalle`
--
ALTER TABLE `pedido_detalle`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_pedido` (`id_pedido`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`id_perfil`);

--
-- Indices de la tabla `presupuestos`
--
ALTER TABLE `presupuestos`
  ADD PRIMARY KEY (`id_presupuesto`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_vendedor` (`id_vendedor`);

--
-- Indices de la tabla `presupuesto_detalle`
--
ALTER TABLE `presupuesto_detalle`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_presupuesto` (`id_presupuesto`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id_producto`),
  ADD UNIQUE KEY `codigo_producto` (`codigo_producto`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id_proveedor`),
  ADD UNIQUE KEY `nombre_proveedor` (`nombre_proveedor`);

--
-- Indices de la tabla `subcuentas_contables`
--
ALTER TABLE `subcuentas_contables`
  ADD PRIMARY KEY (`id_subcuenta`),
  ADD UNIQUE KEY `codigo_subcuenta` (`codigo_subcuenta`),
  ADD KEY `referencia_id` (`referencia_id`);

--
-- Indices de la tabla `tmp`
--
ALTER TABLE `tmp`
  ADD PRIMARY KEY (`id_tmp`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD KEY `idx_usuario` (`usuario`),
  ADD KEY `idx_rol` (`rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias_contables`
--
ALTER TABLE `categorias_contables`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=220;

--
-- AUTO_INCREMENT de la tabla `cuentas_contables`
--
ALTER TABLE `cuentas_contables`
  MODIFY `id_cuenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `detalle_factura`
--
ALTER TABLE `detalle_factura`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=359;

--
-- AUTO_INCREMENT de la tabla `detalle_factura_compras`
--
ALTER TABLE `detalle_factura_compras`
  MODIFY `id_detalle_compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `id_factura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT de la tabla `facturas_compras`
--
ALTER TABLE `facturas_compras`
  MODIFY `id_factura_compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `movimientos_contables`
--
ALTER TABLE `movimientos_contables`
  MODIFY `id_movimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `pedido_detalle`
--
ALTER TABLE `pedido_detalle`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `perfil`
--
ALTER TABLE `perfil`
  MODIFY `id_perfil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `presupuestos`
--
ALTER TABLE `presupuestos`
  MODIFY `id_presupuesto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `presupuesto_detalle`
--
ALTER TABLE `presupuesto_detalle`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=300;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `subcuentas_contables`
--
ALTER TABLE `subcuentas_contables`
  MODIFY `id_subcuenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tmp`
--
ALTER TABLE `tmp`
  MODIFY `id_tmp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=459;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing user_id of each user, unique index', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cuentas_contables`
--
ALTER TABLE `cuentas_contables`
  ADD CONSTRAINT `cuentas_contables_ibfk_1` FOREIGN KEY (`cuenta_padre`) REFERENCES `cuentas_contables` (`id_cuenta`) ON DELETE SET NULL;

--
-- Filtros para la tabla `movimientos_contables`
--
ALTER TABLE `movimientos_contables`
  ADD CONSTRAINT `movimientos_contables_ibfk_1` FOREIGN KEY (`id_cuenta_debe`) REFERENCES `cuentas_contables` (`id_cuenta`) ON DELETE CASCADE,
  ADD CONSTRAINT `movimientos_contables_ibfk_2` FOREIGN KEY (`id_cuenta_haber`) REFERENCES `cuentas_contables` (`id_cuenta`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
