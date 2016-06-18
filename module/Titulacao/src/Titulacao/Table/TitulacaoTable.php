<?php

namespace Titulacao\Table;

use Estrutura\Table\AbstractEstruturaTable;

class TitulacaoTable extends AbstractEstruturaTable {
	public $table = 'titulacao';
	public $campos = [ 
			'id_titulacao' => 'id',
			'nm_titulacao' => 'nm_titulacao' 
	];
}