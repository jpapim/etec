<?php

namespace AreaConhecimento\Service;

use \AreaConhecimento\Entity\AreaConhecimentoEntity as Entity;
use AreaConhecimento\Table\AreaConhecimentoTable;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\Reflection;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class AreaConhecimentoService extends Entity {

    public function getAreaConhecimentoToArray($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('area_conhecimento')
                ->where([
            'area_conhecimento.id_area_conhecimento = ?' => $id,
        ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    public function getIdAreaConhecimentoPorNomeToArray($nm_area_conhecimento) {

        $arNomeAreaConhecimento = explode('(', $nm_area_conhecimento);
        $nm_area_conhecimento = $arNomeAreaConhecimento[0];

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $filter = new \Zend\Filter\StringTrim();
        $select = $sql->select('area_conhecimento')
                ->columns(array('nm_area_conhecimento'))
                ->where([
            'area_conhecimento.nm_area_conhecimento = ?' => $filter->filter($nm_area_conhecimento),
        ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    public function fetchPaginator($pagina = 1, $itensPagina = 5, $ordem = 'nm_area_conhecimento ASC', $like = null, $itensPaginacao = 5) {
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/
        // preparar um select para tabela contato com uma ordem
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('area_conhecimento')->order($ordem);

        if (isset($like)) {
            $select
                    ->where
                    ->like('id_area_conhecimento', "%{$like}%")
                    ->or
                    ->like('nm_area_conhecimento', "%{$like}%")
            #->or
            #->like('telefone_principal', "%{$like}%")
            #->or
            #->like('data_criacao', "%{$like}%")
            ;
        }

        // criar um objeto com a estrutura desejada para armazenar valores
        $resultSet = new HydratingResultSet(new Reflection(), new \AreaConhecimento\Entity\AreaConhecimentoEntity());

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
        // resultado da pagina��o
        return (new Paginator($paginatorAdapter))
                        // pagina a ser buscada
                        ->setCurrentPageNumber((int) $pagina)
                        // quantidade de itens na p�gina
                        ->setItemCountPerPage((int) $itensPagina)
                        ->setPageRange((int) $itensPaginacao);
    }

    public function getAreaConhecimentosPaginator($filter = NULL, $camposFilter = NULL) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('area_conhecimento')->columns([
                    'id_area_conhecimento',
                    'nm_area_conhecimento',
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

        $select->where($where)->order(['id_area_conhecimento DESC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }

    public function getFiltrarAreaConhecimentoPorNomeToArray($nm_area_conhecimento) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('area_conhecimento')
            ->columns(array('id_area_conhecimento', 'nm_area_conhecimento'))
            ->where([
                "area_conhecimento.nm_area_conhecimento LIKE ?" => '%' . $nm_area_conhecimento . '%',
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute();
    }

}
