<?php

namespace PalavraChaveTcc\Table;

use Estrutura\Table\AbstractEstruturaTable;

class PalavraChaveTccTable extends AbstractEstruturaTable
{
    public $table = 'palavra_chave_tcc';
    public $campos = [
        'id_palavra_chave_tcc' => 'id',
        'id_tcc' => 'id_tcc',
        'id_palavra_chave' => 'id_palavra_chave',
    ];

}