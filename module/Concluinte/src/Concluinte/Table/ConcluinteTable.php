<?php

namespace Concluinte\Table;

use Estrutura\Table\AbstractEstruturaTable;

class ConcluinteTable extends AbstractEstruturaTable
{

    public $table = 'concluinte';
    public $campos = [
        'id_concluinte' => 'id',
        'id_curso' => 'id_curso',
        'id_tcc' => 'id_tcc',
        'nm_concluinte' => 'nm_concluinte',
        'nr_matricula' => 'nr_matricula',
    ];

}