<?php

namespace BancaExaminadora\Table;


use Estrutura\Table\AbstractEstruturaTable;

class BancaExaminadoraTable extends AbstractEstruturaTable{

        public $table='banca_examinadora';
        public $campos= [
            'id_banca_examinadora'=>'id',
            'dt_banca'=>'dt_banca',
        ];

} 