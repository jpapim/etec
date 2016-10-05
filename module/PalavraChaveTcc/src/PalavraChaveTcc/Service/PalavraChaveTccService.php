<?php

namespace PalavraChaveTcc\Service;

use \PalavraChaveTcc\Entity\PalavraChaveTccEntity as Entity;

class PalavraChaveTccService extends Entity
{

    public function getPalavrasChaveTccPaginator($filter = NULL, $camposFilter = NULL)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('palavra_chave_tcc')->columns([
            'id_palavra_chave_tcc',
        ])
            ->join('tcc', 'tcc.id_tcc = palavra_chave_tcc.id_tcc', ['tx_titulo_tcc'])
            ->join('palavra_chave', 'palavra_chave.id_palavra_chave = palavra_chave_tcc.id_palavra_chave', ['nm_palavra_chave']);

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

        $select->where($where)->order(['id_palavra_chave_tcc DESC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }


}