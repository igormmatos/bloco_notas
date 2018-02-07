CREATE DATABASE bd_nota;

USE bd_nota;


CREATE TABLE usuarios_nota(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    email VARCHAR(150) NOT NULL,
    senha CHAR(8) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE notas(
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  titulo VARCHAR(150) NOT NULL,
  status VARCHAR(7) DEFAULT 'active',
  descricao LONGTEXT,
  prioridade CHAR(1) DEFAULT 0,
  data_adicao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  data_entrega DATE NOT NULL,
  user_id INT UNSIGNED NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (user_id) REFERENCES usuarios_nota(id)
);

INSERT INTO `notas` VALUES
(null, 'Ver vÃ­deos', 'success', '<p>V&iacute;deos se encontram no DRIVE</p>\r\n', '0', '2018-01-18 14:12:39', '2018-01-19', 1),
(null, 'Adicionar notificaÃ§Ãµes', 'active', '<p>Quando estiver pr&oacute;ximo a data&nbsp;</p>\r\n', '1', '2018-01-18 14:15:52', '2000-04-23', 1),
(null, 'DÃºvidas sobre - VÃ­deos sobre o BTX', 'success', '<ol>\r\n	<li>O que seria essa conta, que aparece para ser selecionada? Ex.: &quot;<em>brtck</em>&quot;\r\n	<ol>\r\n		<li>Qual a diferen&ccedil;a de <em>CONTA</em> e <em>LOGIN CONTA</em></li>\r\n		<li>Porque &eacute; sempre necess&aacute;rio digitar o <em>LOGIN CONTA</em></li>\r\n	</ol>\r\n	</li>\r\n	<li><strong>Cadastros/ Motoristas - Ajudantes:&nbsp;</strong>\r\n	<ol>\r\n		<li>Para que serve&nbsp;o campo <em>Identifica&ccedil;&atilde;o?</em></li>\r\n	</ol>\r\n	</li>\r\n	<li>O que &eacute; <em>Intelig&ecirc;ncia Embarcada?</em></li>\r\n	<li>Qual o significado dos eventos (<strong>Opera&ccedil;&atilde;o/Grid Opera&ccedil;&otilde;es</strong>)?</li>\r\n</ol>\r\n', '0', '2018-01-18 17:13:55', '2018-01-18', 1),
(null, 'Pegar com HÃ©lcio bugs do sistema..', 'active', '<p>Fazer junto ao h&eacute;lcio uma lista contendo todos os bugs frequentes do BTX, e suas respectivas formas de solu&ccedil;&atilde;o.</p>\r\n', '1', '2018-01-19 17:38:21', '2018-01-19', 1);
