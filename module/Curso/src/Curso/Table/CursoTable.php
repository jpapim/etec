<?php

namespace Curso\Table;

use Estrutura\Table\AbstractEstruturaTable;

class CursoTable extends AbstractEstruturaTable{

    public $table = 'curso';
    public $campos = [
        'id_curso'=>'id', 
        'nm_curso'=>'nm_curso',
    ];

}