<?php

namespace MembrosBanca\Service;

use \MembrosBanca\Entity\MembrosBancaEntity as Entity;

class MembrosBancaService extends Entity
{

    public function getMembrosBancaPaginator($filter = NULL, $camposFilter = NULL)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('membros_banca')->columns([
            'id_membro_banca',
        ])
            ->join('banca_examinadora', 'banca_examinadora.id_banca_examinadora = membros_banca.id_banca_examinadora', ['dt_banca'])
            ->join('professor', 'professor.id_professor = membros_banca.id_professor', ['nm_professor', 'cs_orientador']);

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

        $select->where($where)->order(['id_membro_banca DESC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }


}