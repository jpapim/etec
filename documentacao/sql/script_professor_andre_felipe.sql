/* ADICIONANDO O MÓDULO */
INSERT controller (nm_controller) VALUES ('professor-professor');

/* INSERINDO TITULAÇÕES */
INSERT titulacao (nm_titulacao) VALUES ('Doutor(a)'), ('Especialista'), ('Mestre');

/* DEFININDO PERMISSÕES PARA O MÓDULO */
INSERT perfil_controller_action (id_controller, id_action, id_perfil) 
	VALUES ((SELECT id_controller FROM controller WHERE nm_controller LIKE 'professor-professor'), 6, 1); /* CADASTRO */ 
    
INSERT perfil_controller_action (id_controller, id_action, id_perfil)
  VALUES ((SELECT id_controller FROM controller WHERE nm_controller LIKE 'professor-professor'), 7, 1); /* GRAVAR */
  
INSERT perfil_controller_action (id_controller, id_action, id_perfil)
  VALUES ((SELECT id_controller FROM controller WHERE nm_controller LIKE 'professor-professor'), 51, 1); /* INDEX-PAGINATION */
  
INSERT perfil_controller_action (id_controller, id_action, id_perfil)
  VALUES ((SELECT id_controller FROM controller WHERE nm_controller LIKE 'professor-professor'), 1, 1); /* INDEX */
  
INSERT perfil_controller_action (id_controller, id_action, id_perfil)
  VALUES ((SELECT id_controller FROM controller WHERE nm_controller LIKE 'professor-professor'), 8, 1); /* EXCLUIR */
