/* ADICIONANDO O MÓDULO */
INSERT controller (nm_controller) VALUES ('membros_banca-membrosbanca');


/* DEFININDO PERMISSÕES PARA O MÓDULO */
INSERT perfil_controller_action (id_controller, id_action, id_perfil)
	VALUES ((SELECT id_controller FROM controller WHERE nm_controller LIKE 'membros_banca-membrosbanca'), 44, 1); /* EXCLUIR VIA ACADEMIA*/
	  
