<?php

namespace PalavraChave\Table;

use Estrutura\Table\AbstractEstruturaTable;

class PalavraChaveTable extends AbstractEstruturaTable{

    public $table = 'palavra_chave';
    public $campos = [
        'id_palavra_chave'=>'id', 
        'nm_palavra_chave'=>'nm_palavra_chave',
    ];

}