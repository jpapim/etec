<?php

namespace BancaExaminadora\Service;

use BancaExaminadora\Entity\BancaExaminadoraEntity as Entity;
use Zend\Db\Sql\Sql;
use \Zend\Paginator\Paginator;
use \Zend\Paginator\Adapter\DbSelect;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\Reflection;


class BancaExaminadoraService extends Entity
{

    // Obtendo a Banca pelo id
    public function getBancaExaminadoraToArray($id)
    {
        $sql = new Sql($this->getAdapter());

        $select = $sql->select('banca_examinadora')
            ->where([
                'banca_examinadora.id_banca_examinadora= ?' => $id,
            ]);
        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    // Buscar a Banca de acordo com os parametros passados
    public function buscarBancaExaminadora($params)
    {
        $resultSet = null;
        if (isset($params['id_banca_examinadora']) && $params['id_banca_examinadora']) {
            $resultSet = $this->select(['banca_examinadora.id_banca_examinadora = ?'
            => $params['id_banca_examinadora']]);
        }
        return $resultSet;
    }

    //faz uma busca baseada na data
    public function getFilterBancaPorData($dt_banca)
    {
        $sql = new Sql($this->getAdapter());

        $select = $sql->select('banca_examinadora')
            ->columns(array('dt_banca'))
            ->where(['banca_examinadora.dt_banca LIKE ?' => '%' . $dt_banca . '%']);

        return $sql->prepareStatementForSqlObject($select)->execute();
    }

    public function buscaPaginator($pagina = 1, $itensPagina = 5, $ordem = 'dt_banca ASC', $like = null, $itensPaginacao = 10)
    {
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/
        // preparar um select para tabela contato com uma ordem
        $sql = new Sql($this->getAdapter());
        $select = $sql->select('banca_examinadora')->order($ordem);

        if (isset($like)) {
            $select
                ->where
                ->like('id_banca_examinadora', "%{$like}%");
        }

        // criar um objeto com a estrutura desejada para armazenar valores
        $resultSet = new HydratingResultSet(new Reflection(), new Entity());

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
            ->setCurrentPageNumber((int)$pagina)
            // quantidade de itens na página
            ->setItemCountPerPage((int)$itensPagina)
            ->setPageRange((int)$itensPaginacao);
    }

    public function getBancaExaminadoraPaginator($filter = NULL, $camposFilter = NULL) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('banca_examinadora')->columns([
            'id_banca_examinadora',
            'dt_banca',
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

        $select->where($where)->order(['id_banca_examinadora DESC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }


    public function getProfessorPaginator($id_banca_examinadora, $filter = NULL, $camposFilter = NULL)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('membros_banca')->columns([
            'id_membro_banca',
            'id_banca_Examinadora',
            'cs_orientador',

        ])->join('professor', 'professor.id_professor = membros_banca.id_professor', ['nm_professor']);

        $where = [
            'id_banca_examinadora' => $id_banca_examinadora,
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

        $select->where($where)->order(['cs_orientador DESC']);
        #xd($select->getSqlString($this->getAdapter()->getPlatform()));
        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }




}