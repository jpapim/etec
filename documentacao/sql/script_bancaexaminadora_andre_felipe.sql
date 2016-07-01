/* ADICIONANDO O MÓDULO */
INSERT controller (nm_controller) VALUES ('banca_examinadora-bancaexaminadora');


/* DEFININDO PERMISSÕES PARA O MÓDULO */
INSERT perfil_controller_action (id_controller, id_action, id_perfil)
	VALUES ((SELECT id_controller FROM controller WHERE nm_controller LIKE 'banca_examinadora-bancaexaminadora'), 6, 1); /* CADASTRO */

INSERT perfil_controller_action (id_controller, id_action, id_perfil)
  VALUES ((SELECT id_controller FROM controller WHERE nm_controller LIKE 'banca_examinadora-bancaexaminadora'), 7, 1); /* GRAVAR */

INSERT perfil_controller_action (id_controller, id_action, id_perfil)
  VALUES ((SELECT id_controller FROM controller WHERE nm_controller LIKE 'banca_examinadora-bancaexaminadora'), 51, 1); /* INDEX-PAGINATION */

INSERT perfil_controller_action (id_controller, id_action, id_perfil)
  VALUES ((SELECT id_controller FROM controller WHERE nm_controller LIKE 'banca_examinadora-bancaexaminadora'), 1, 1); /* INDEX */

INSERT perfil_controller_action (id_controller, id_action, id_perfil)
  VALUES ((SELECT id_controller FROM controller WHERE nm_controller LIKE 'banca_examinadora-bancaexaminadora'), 8, 1); /* EXCLUIR */

INSERT perfil_controller_action (id_controller, id_action, id_perfil)
  VALUES ((SELECT id_controller FROM controller WHERE nm_controller LIKE 'banca_examinadora-bancaexaminadora'), 49, 1); /* REALIZAR INSCRIÇÕES */
	  
