<?php

namespace Professor\Table;

use Estrutura\Table\AbstractEstruturaTable;

class ProfessorTable extends AbstractEstruturaTable
{
    public $table = 'professor';
    public $campos = [
        'id_professor' => 'id',
        'id_titulacao' => 'id_titulacao',
        'id_usuario_cadastro' => 'id_usuario',
        'nm_professor' => 'nm_professor',
        'dt_cadastro' => 'dt_cadastro',
        'cs_orientador' => 'cs_orientador',
        'cs_ativo' => 'cs_ativo'
    ];

}