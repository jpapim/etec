<?php
/**
 * Created by PhpStorm.
 * User: EduFerr
 * Date: 19/09/2016
 * Time: 16:17
 */
namespace Pesquisar\Table;

use Estrutura\Table\AbstractEstruturaTable;

class PesquisarTable extends AbstractEstruturaTable
{

    public $table = 'tcc';
    public $campos = [
        'id_tcc' => 'id',
        'id_usuario_cadastro' => 'id_usuario_cadastro',
        'id_usuario_alteracao' => 'id_usuario_alteracao',
        'id_banca_examinadora' => 'id_banca_examinadora',
        'id_area_conhecimento' => 'id_area_conhecimento',
        'id_tipo_tcc' => 'id_tipo_tcc',
        'id_professor_orientador' => 'id_professor_orientador',
        'tx_titulo_tcc' => 'tx_titulo_tcc',
        'tx_resumo' => 'tx_resumo',
        'dt_cadastro' => 'dt_cadastro',
        'dt_alteracao' => 'dt_alteracao',
        'nr_nota_final' => 'nr_nota_final',
            'ar_arquivo' => 'ar_arquivo',
    ];


}