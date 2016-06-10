<?php

namespace TipoTcc\Table;

use Estrutura\Table\AbstractEstruturaTable;

class TipoTccTable extends AbstractEstruturaTable{

    public $table = 'tipo_tcc';
    public $campos = [
        'id_tipo_tcc'=>'id', 
        'nm_tipo_tcc'=>'nm_tipo_tcc',
    ];

}