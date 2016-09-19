<?php
/**
 * Created by PhpStorm.
 * User: EduTFerr
 * Date: 19/09/2016
 * Time: 16:17
 */

namespace Tcc\Service;

use Tcc\Entity\TccEntity as Entity;
use Zend\Db\Sql\Sql;
use \Zend\Paginator\Paginator;
use \Zend\Paginator\Adapter\DbSelect;

class TccService extends Entity
{
    public function getTccPaginator($filter = NULL, $camposFilter = NULL)
    {

        $sql = new Sql($this->getAdapter());

        $select = $sql->select('tcc')->columns([
            'id_tcc',
            'id_usuario_cadastro',
            'id_usuario_alteracao',
            'tx_titulo_tcc',
            'tx_resumo',
            'dt_cadastro',
            'dt_alteracao',
            'nr_nota_final',
        ])
            // Buscando dados das Fks
            ->join('banca_examinadora', 'banca_examinadora.id_banca_examinadora = tcc.id_banca_examinadora', ['dt_banca'])
            ->join('area_conhecimento', 'area_conhecimento.id_area_conhecimento = tcc.id_area_conhecimento', ['nm_area_conhecimento'])
            ->join('tipo_tcc', 'tipo_tcc.id_tipo_tcc = tcc.id_tipo_tcc', ['nm_tipo_tcc'])
            ->join('professor', 'professor.id_professor = tcc.id_professor_orientador', ['nm_professor']);

        $where = [
        ];

        if (!empty($filter)) {
            foreach ($filter as $key => $value) {
                if ($value) {
                    if (isset($camposFilter[$key]['mascara'])) {
                        eval("\$value = " . $camposFilter[$key]['mascara'] . ";");
                    }
                    $where[$camposFilter[$key]['filter']] = '%' . $value . '%';
                }
            }
        }
        $select->where($where)->order(['dt_cadastro  DESC']);
        return new Paginator(new DbSelect($select, $this->getAdapter()));
    }



}