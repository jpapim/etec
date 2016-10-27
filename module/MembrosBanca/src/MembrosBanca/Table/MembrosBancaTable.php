<?php

namespace MembrosBanca\Table;

use Estrutura\Table\AbstractEstruturaTable;

class MembrosBancaTable extends AbstractEstruturaTable
{
    public $table = 'membros_banca';
    public $campos = [
        'id_membro_banca' => 'id',
        'id_banca_examinadora' => 'id_banca_examinadora',
        'id_professor' => 'id_professor',
        'cs_orientador' => 'cs_orientador',
    ];

}