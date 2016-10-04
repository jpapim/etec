<?php

namespace PalavraChave\Service;

use \PalavraChave\Entity\PalavraChaveEntity as Entity;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\Reflection;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class PalavraChaveService extends Entity
{

    public function getPalavraChaveToArray($id)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('palavra_chave')
            ->where([
                'palavra_chave.id_palavra_chave = ?' => $id,
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    public function getIdPalavraChavePorNomeToArray($nm_palavra_chave)
    {

        $arNomePalavraChave = explode('(', $nm_palavra_chave);
        $nm_palavra_chave = $arNomePalavraChave[0];

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $filter = new \Zend\Filter\StringTrim();
        $select = $sql->select('palavra_chave')
            ->columns(array('nm_palavra_chave'))
            ->where([
                'palavra_chave.nm_palavra_chave = ?' => $filter->filter($nm_palavra_chave),
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    public function getPalavrasChaveTccPaginator($filter = NULL, $camposFilter = NULL) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('palavra_chave_tcc')->columns([
            'id_palavra_chave_tcc',
            'tx_titulo_tcc',
            'nm_palavra_chave',
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

        $select->where($where)->order(['id_palavra_chave_tcc DESC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }

    public function fetchPaginator($pagina = 1, $itensPagina = 5, $ordem = 'nm_palavra_chave ASC', $like = null, $itensPaginacao = 5)
    {
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/
        // preparar um select para tabela contato com uma ordem
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('palavra_chave')->order($ordem);

        if (isset($like)) {
            $select
                ->where
                ->like('id_palavra_chave', "%{$like}%")
                ->or
                ->like('nm_palavra_chave', "%{$like}%")
                #->or
                #->like('telefone_principal', "%{$like}%")
                #->or
                #->like('data_criacao', "%{$like}%")
            ;
        }

        // criar um objeto com a estrutura desejada para armazenar valores
        $resultSet = new HydratingResultSet(new Reflection(), new \PalavraChave\Entity\PalavraChaveEntity());

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
            // quantidade de itens na p�gina
            ->setItemCountPerPage((int)$itensPagina)
            ->setPageRange((int)$itensPaginacao);
    }

    public function getPalavraChavesPaginator($filter = NULL, $camposFilter = NULL)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('palavra_chave')->columns([
            'id_palavra_chave',
            'nm_palavra_chave',
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

        $select->where($where)->order(['nm_palavra_chave DESC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }

}
