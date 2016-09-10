<?php

return array(
    'modules' => array(
        'Application',
        'Auth',
        'Estrutura', //Tem que vir antes dos demais módulos
        'Banco',
        'Principal',
        'Email',
        'Usuario',
        'Perfil',
        'EsqueciSenha',
        'Controller',
        'Action',
        'Config',
        'Gerador',
        'Cidade',
        'Estado',
        'Sexo',
        'EstadoCivil',
        'TipoUsuario',
        'SituacaoUsuario',
        'Endereco',
        'CompactAsset',
        'EdpSuperluminal',
        'Login',
        'Situacao',
        'Telefone',
        'TipoTelefone',
        'Permissao',
		'TipoTcc',
		'AreaConhecimento',
        'PalavraChave',
        'Curso',
        'Tcc',
        'PeriodoLetivo',
        'DetalhePeriodoLetivo',
        'Professor',
        'Titulacao',
        'PerfilControllerAction',
        'BancaExaminadora',
        'MembrosBanca',
        'Concluinte',
        'Infra',
        'PalavraChaveTcc',
    ),
    'module_listener_options' => array(
        'module_paths' => array(
            './module',
            './vendor',
        ),
        'config_glob_paths' => array(
            'config/autoload/{,*.}{global,' . APPLICATION_ENV . '}.php'
        ),
    )
);
