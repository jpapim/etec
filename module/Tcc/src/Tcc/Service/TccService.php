<?php


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

    // Optendo o tcc pelo id
    public function getTccToArray($id)
    {
        $sql = new Sql($this->getAdapter());

        $select = $sql->select('tcc')
            ->where([
                'tcc.id_tcc= ?' => $id,
            ]);
        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    // faz uma busca baseada na data de  cadastro
    public function getFilterTccPorDataCadastro($dt_cadastro)
    {
        $sql = new Sql($this->getAdapter());

        $select = $sql->select('tcc')
            ->columns(array('dt_cadastro'))
            ->where(['tcc.dt_cadastro LIKE ?' => '%' . $dt_cadastro . '%']);

        return $sql->prepareStatementForSqlObject($select)->execute();
    }

    //faz uma busca baseada na data de Alteração
    public function getFilterTccPorDataAlteracao($dt_alteracao)
    {
        $sql = new Sql($this->getAdapter());

        $select = $sql->select('tcc')
            ->columns(array('dt_alteracao'))
            ->where(['tcc.dt_alteracao LIKE ?' => '%' . $dt_alteracao . '%']);

        return $sql->prepareStatementForSqlObject($select)->execute();
    }

    public function buscaPaginator($pagina = 1, $itensPagina = 5, $ordem = 'id_tcc ASC', $like = null, $itensPaginacao = 10)
    {
        // preparar um select para tabela em ordem
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
            // quantidade de itens na p�gina
            ->setItemCountPerPage((int)$itensPagina)
            ->setPageRange((int)$itensPaginacao);
    }

    //Paginação do Detalhe Concluinte
    public function getTccDetalhePaginator($id_tcc, $filter = NULL, $camposFilter = NULL)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('concluinte')->columns([
            'id_concluinte',
            'id_curso',
            'id_tcc',
            'nm_concluinte',
            'nr_matricula',
        ]);

        $where = [
            'id_tcc' => $id_tcc,
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

        $select->where($where)->order(['id_concluinte DESC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }

    // faz uma busca para combox professor orientador
    public function getFilterProfessorOrientador($id_professor)
    {
        $sql = new Sql($this->getAdapter());

        $select = $sql->select('professor')
            ->columns(array('nm_professor'))
            ->where(['professor.cs_orientador = s'=> $id_professor]);

        return $sql->prepareStatementForSqlObject($select)->execute();
    }

//    /**
//     * Recupera as informações dos Componentes Afetados pelo plano de Mudança
//     *
//     * @param $id_plano_mudanca_detalhe
//     * @param null $filter
//     * @param null $camposFilter
//     * @return \Zend\Paginator\Paginator
//     */
//    public function getComponentesPaginator($id_plano_mudanca_detalhe, $filter = NULL, $camposFilter = NULL)
//    {
//
//        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
//
//        $select = $sql->select('componente_plano_mudanca')->columns([
//            'id_componente_plano_mudanca',
//            'id_plano_mudanca_detalhe',
//            'id_local',
//            'id_componente',
//        ])->join('local', 'local.id_local = componente_plano_mudanca.id_local', [
//            'nm_local'
//        ])->join('componente', 'componente.id_componente = componente_plano_mudanca.id_componente', [
//            'nm_componente'
//        ])->join('tipo_componente', 'tipo_componente.id_tipo_componente = componente.id_tipo_componente', [
//            'nm_tipo_componente'
//        ]);
//
//        $where = [
//            'id_plano_mudanca_detalhe' => $id_plano_mudanca_detalhe,
//        ];
//
//        if (!empty($filter)) {
//
//            foreach ($filter as $key => $value) {
//
//                if ($value) {
//
//                    if (isset($camposFilter[$key]['mascara'])) {
//
//                        eval("\$value = " . $camposFilter[$key]['mascara'] . ";");
//                    }
//
//                    $where[$camposFilter[$key]['filter']] = '%' . $value . '%';
//                }
//            }
//        }
//
//        $select->where($where)->order(['id_componente_plano_mudanca DESC']);
//
//        #xd($select->getSqlString($this->getAdapter()->getPlatform()));
//        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
//    }
//
//    public function getEtapaPlanejamentoPaginator($id_plano_mudanca_detalhe, $filter = NULL, $camposFilter = NULL)
//    {
//
//        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
//
//        $select = $sql->select('etapa_planejamento')->columns([
//            'id_etapa_planejamento',
//            'id_plano_mudanca_detalhe',
//            'id_usuario',
//            'ds_etapa_planejamento',
//            'dt_inicio_previsto',
//            'dt_fim_previsto',
//            'dt_cadastro',
//        ])->join('usuario', 'usuario.id_usuario = etapa_planejamento.id_usuario', [
//            'nm_usuario',
//            'id_torre',
//        ])->join('torre', 'torre.id_torre = usuario.id_torre', [
//            'nm_torre',
//        ]);
//
//        $where = [
//            'id_plano_mudanca_detalhe' => $id_plano_mudanca_detalhe,
//        ];
//
//        if (!empty($filter)) {
//
//            foreach ($filter as $key => $value) {
//
//                if ($value) {
//
//                    if (isset($camposFilter[$key]['mascara'])) {
//
//                        eval("\$value = " . $camposFilter[$key]['mascara'] . ";");
//                    }
//
//                    $where[$camposFilter[$key]['filter']] = '%' . $value . '%';
//                }
//            }
//        }
//
//        $select->where($where)->order(['ds_etapa_planejamento ASC']);
//
//        #xd($select->getSqlString($this->getAdapter()->getPlatform()));
//        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
//    }
//
//    /**
//     * Insere na tabela dos Detalhes do Plano de Mudança o ID inserido no Cabeçalho
//     * @param null $inserted_id Esta variavel vem preenchida com o id inserido em caso de insert e com true ou false se for um update
//     */
//    public function posSave($inserted_id = null)
//    {
//        $planoDetalheService = new \PlanoMudancaDetalhe\Service\PlanoMudancaDetalheService();
//        $dadosPlanoDetalhado = $planoDetalheService->buscar($inserted_id);
//
//        #Só executa esta IF se a operação que chamou este método foi uma inserção
//        if (empty($dadosPlanoDetalhado) && $inserted_id !== true) {
//            $planoDetalheService->setId($inserted_id);
//            $planoDetalheService->salvar(true);
//        }
//    }

}