/* ADICIONANDO O MÓDULO */
INSERT controller (nm_controller) VALUES ('concluinte-concluinte');

/* DEFININDO PERMISSÕES PARA O MÓDULO */
INSERT perfil_controller_action (id_controller, id_action, id_perfil) 
	VALUES ((SELECT id_controller FROM controller WHERE nm_controller LIKE 'concluinte-concluinte'), 6, 1); /* CADASTRO */ 
    
INSERT perfil_controller_action (id_controller, id_action, id_perfil)
  VALUES ((SELECT id_controller FROM controller WHERE nm_controller LIKE 'concluinte-concluinte'), 7, 1); /* GRAVAR */
  
INSERT perfil_controller_action (id_controller, id_action, id_perfil)
  VALUES ((SELECT id_controller FROM controller WHERE nm_controller LIKE 'concluinte-concluinte'), 51, 1); /* INDEX-PAGINATION */
  
INSERT perfil_controller_action (id_controller, id_action, id_perfil)
  VALUES ((SELECT id_controller FROM controller WHERE nm_controller LIKE 'concluinte-concluinte'), 1, 1); /* INDEX */
  
INSERT perfil_controller_action (id_controller, id_action, id_perfil)
  VALUES ((SELECT id_controller FROM controller WHERE nm_controller LIKE 'concluinte-concluinte'), 8, 1); /* EXCLUIR */
