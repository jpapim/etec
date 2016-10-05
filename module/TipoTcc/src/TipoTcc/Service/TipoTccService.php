<?php

namespace TipoTcc\Service;

use \TipoTcc\Entity\TipoTccEntity as Entity;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\Reflection;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class TipoTccService extends Entity {

    public function getTipoTccToArray($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('tipo_tcc')
                ->where([
            'tipo_tcc.id_tipo_tcc = ?' => $id,
        ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    public function getIdTipoTccPorNomeToArray($nm_tipo_tcc) {

        $arNomeTipoTcc = explode('(', $nm_tipo_tcc);
        $nm_tipo_tcc = $arNomeTipoTcc[0];

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $filter = new \Zend\Filter\StringTrim();
        $select = $sql->select('tipo_tcc')
                ->columns(array('nm_tipo_tcc'))
                ->where([
            'tipo_tcc.nm_tipo_tcc = ?' => $filter->filter($nm_tipo_tcc),
        ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    public function fetchPaginator($pagina = 1, $itensPagina = 5, $ordem = 'nm_tipo_tcc ASC', $like = null, $itensPaginacao = 5) {
        // preparar um select para tabela contato com uma ordem
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('tipo_tcc')->order($ordem);

        if (isset($like)) {
            $select
                    ->where
                    ->like('id_tipo_tcc', "%{$like}%")
                    ->or
                    ->like('nm_tipo_tcc', "%{$like}%")
            ;
        }

        // criar um objeto com a estrutura desejada para armazenar valores
        $resultSet = new HydratingResultSet(new Reflection(), new \TipoTcc\Entity\TipoTccEntity());

        // criar um objeto adapter paginator
        $paginatorAdapter = new DbSelect(
                // nosso objeto select
                $select,
                // nosso adapter da tabela
                $this->getAdapter(),
                // nosso objeto base para ser populado
                $resultSet
        );

        # var_dump($paginatorAdapter);
        #die;
        // resultado da paginação
        return (new Paginator($paginatorAdapter))
                        // pagina a ser buscada
                        ->setCurrentPageNumber((int) $pagina)
                        // quantidade de itens na p�gina
                        ->setItemCountPerPage((int) $itensPagina)
                        ->setPageRange((int) $itensPaginacao);
    }

    public function getTipoTccsPaginator($filter = NULL, $camposFilter = NULL) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('tipo_tcc')->columns([
                    'id_tipo_tcc',
                    'nm_tipo_tcc',
        ]);

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

        $select->where($where)->order(['id_tipo_tcc DESC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }

}
