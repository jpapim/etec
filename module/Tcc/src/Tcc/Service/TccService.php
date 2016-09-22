<?php
/**
 * Created by PhpStorm.
 * User: IGOR
 * Date: 30/06/2016
 * Time: 21:59
 */

namespace Tcc\Service;

use Tcc\Entity\TccEntity as Entity;
use Zend\Db\Sql\Sql;
use \Zend\Paginator\Paginator;
use \Zend\Paginator\Adapter\DbSelect;

class TccService extends Entity {

    public function getTccToArray($id)
    {
        $sql = new Sql($this->getAdapter());

        $select = $sql->select('tcc')
            ->where([
                'tcc.id_tcc= ?' => $id,
            ]);
        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    public function buscarTcc($params)
    {
        $resultSet = null;
        if (isset($params['id_tcc']) && $params['id_tcc']) {
            $resultSet = $this->select(['tcc.id_tcc = ?'
            => $params['id_tcc']]);
        }
        return $resultSet;
    }

    public function getFilterTccPorNome($tx_titulo_tcc)
    {
        $sql = new Sql($this->getAdapter());

        $select = $sql->select('tcc')
            ->columns(array('tx_titulo_tcc'))
            ->where(['tcc.tx_titulo_tcc LIKE ?' => '%' . $tx_titulo_tcc . '%']);

        return $sql->prepareStatementForSqlObject($select)->execute();
    }

    public function buscaPaginator($pagina = 1, $itensPagina = 5, $ordem = 'tx_titulo_tcc ASC', $like = null, $itensPaginacao = 10)
    {
        $sql = new Sql($this->getAdapter());
        $select = $sql->select('tcc')->order($ordem);

        if (isset($like)) {
            $select
                ->where
                ->like('id_tcc', "%{$like}%");
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
        // resultado da pagina��o
        return (new Paginator($paginatorAdapter))
            // pagina a ser buscada
            ->setCurrentPageNumber((int)$pagina)
            // quantidade de itens na página
            ->setItemCountPerPage((int)$itensPagina)
            ->setPageRange((int)$itensPaginacao);
    }

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
        $select->where($where)->order(['id_tcc DESC']);

        return new Paginator(new DbSelect($select, $this->getAdapter()));
    }

    public function getDetalhePaginator($id_tcc, $filter = NULL, $camposFilter = NULL)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('concluinte')->columns([
            'id_concluinte',
            'nm_concluinte',
            'nr_matricula',
        ]);
//            ->join('curso', 'curso.id_curso = concluinte.id_curso', ['nm_curso'])
//            ->join('tcc', 'tcc.id_tcc = concluinte.id_tcc', ['tx_titulo_tcc']);

        $where = [
            'id_tcc'=>$id_tcc,
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

        $select->where($where)->order(['nm_concluinte DESC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }



} 