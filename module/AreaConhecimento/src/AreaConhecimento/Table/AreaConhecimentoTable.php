<?php

namespace AreaConhecimento\Table;

use Estrutura\Table\AbstractEstruturaTable;

class AreaConhecimentoTable extends AbstractEstruturaTable{

    public $table = 'area_conhecimento';
    public $campos = [
        'id_area_conhecimento'=>'id', 
        'nm_area_conhecimento'=>'nm_area_conhecimento',
    ];

}