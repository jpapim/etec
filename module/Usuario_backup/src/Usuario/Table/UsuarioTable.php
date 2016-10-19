<?php

namespace Usuario\Table;

use Estrutura\Table\AbstractEstruturaTable;

class UsuarioTable extends AbstractEstruturaTable{

    public $table = 'usuario';
    public $campos = [
        'id_usuario'=>'id', 
        'nm_usuario'=>'nm_usuario', 
        'nm_nacionalidade'=>'nm_nacionalidade',
        'id_sexo'=>'id_sexo', 
        'id_tipo_usuario'=>'id_tipo_usuario',
        'id_situacao_usuario'=>'id_situacao_usuario', 

        

    ];

}