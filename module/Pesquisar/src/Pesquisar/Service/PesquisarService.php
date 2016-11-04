<?php

/**
 * Created by PhpStorm.
 * User: EduFerr
 * Date: 05/10/2016
 * Time: 17:04
 */

namespace Pesquisar\Service;

use Estrutura\Service\AbstractEstruturaService;
use Zend\Db\Sql\Sql;

class PesquisarService extends AbstractEstruturaService
{

    public function pesquisarTcc($where = NULL)
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
            'ar_arquivo',
        ])
            // Buscando dados das Fks
            ->join('banca_examinadora', 'banca_examinadora.id_banca_examinadora = tcc.id_banca_examinadora', ['dt_banca'])
            ->join('area_conhecimento', 'area_conhecimento.id_area_conhecimento = tcc.id_area_conhecimento', ['nm_area_conhecimento'])
            ->join('tipo_tcc', 'tipo_tcc.id_tipo_tcc = tcc.id_tipo_tcc', ['nm_tipo_tcc'])
            ->join('professor', 'professor.id_professor = tcc.id_professor_orientador', ['nm_professor']);

        $where = [
            'banca_examinadora.dt_banca' => '2016-10-14 00:00:00',
            #'banca_examinadora.dt_banca' => '2016-10-14 00:00:00',
            #'banca_examinadora.dt_banca' => '2016-10-14 00:00:00',
            #'banca_examinadora.dt_banca' => '2016-10-14 00:00:00',
            #'banca_examinadora.dt_banca' => '2016-10-14 00:00:00',
            #'banca_examinadora.dt_banca' => '2016-10-14 00:00:00',
        ];

        $select->where($where)->order(['id_tcc DESC']);

        #xd($select->getSqlString($this->getAdapter()->getPlatform()));
        #return $sql->prepareStatementForSqlObject($select)->execute();
        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }

    public function getDetalhesFiltrosPaginator($arrFiltro, $filter = NULL, $camposFilter = NULL)
    {
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('tcc')->columns([
            'id_tcc',
            'id_usuario_cadastro',
            'id_usuario_alteracao',
            'tx_titulo_tcc',
            'tx_resumo',
            'dt_cadastro',
            'dt_alteracao',
            'nr_nota_final',
            'ar_arquivo',
        ])
            // Buscando dados das Fks
            ->join('banca_examinadora', 'banca_examinadora.id_banca_examinadora = tcc.id_banca_examinadora', ['dt_banca'])
            ->join('area_conhecimento', 'area_conhecimento.id_area_conhecimento = tcc.id_area_conhecimento', ['nm_area_conhecimento'])
            ->join('tipo_tcc', 'tipo_tcc.id_tipo_tcc = tcc.id_tipo_tcc', ['nm_tipo_tcc'])
            ->join('professor', 'professor.id_professor = tcc.id_professor_orientador', ['nm_professor']);


        $whereBruto = [];
        if (isset($arrFiltro['dt_inicio']) && $arrFiltro['dt_inicio']) {
            $whereBruto['dt_banca >= ?'] = \Estrutura\Helpers\Data::converterDataBrazil2BancoMySQL($arrFiltro['dt_inicio']);
        }
        if (isset($arrFiltro['dt_final']) && $arrFiltro['dt_final']) {
            $whereBruto['dt_banca <= ?'] = \Estrutura\Helpers\Data::converterDataBrazil2BancoMySQL($arrFiltro['dt_final']);
        }
        if (isset($arrFiltro['id_tipo_tcc']) && $arrFiltro['id_tipo_tcc']) {
            $whereBruto['tcc.id_tipo_tcc = ?'] =  $arrFiltro['id_tipo_tcc'];
        }
        if (isset($arrFiltro['id_area_conhecimento']) && $arrFiltro['id_area_conhecimento']) {
            $whereBruto['tcc.id_area_conhecimento = ?'] = $arrFiltro['id_area_conhecimento'];
        }
        if (isset($arrFiltro['id_professor_orientador']) && $arrFiltro['id_professor_orientador']) {
            $whereBruto['id_professor_orientador = ?'] = $arrFiltro['id_professor_orientador'];
        }
        if (isset($arrFiltro['tx_titulo_tcc']) && $arrFiltro['tx_titulo_tcc']) {
            $whereBruto['UPPER(tx_titulo_tcc) LIKE UPPER(?)'] = '%' . $arrFiltro['tx_titulo_tcc'] . '%';
        }
        if (isset($arrFiltro['id_curso']) && $arrFiltro['id_curso']) {
            $select->join('concluinte', 'concluinte.id_tcc = tcc.id_tcc', ['nm_concluinte']);
            $select->join('curso', 'curso.id_curso = concluinte.id_curso', ['nm_curso']);
            $whereBruto['curso.id_curso = ?'] = $arrFiltro['id_curso'];
        }
        if (isset($arrFiltro['nm_concluinte']) && $arrFiltro['nm_concluinte']) {
            $select->join('concluinte', 'concluinte.id_tcc = tcc.id_tcc', ['nm_concluinte']);
            $whereBruto['UPPER(nm_concluinte) LIKE UPPER(?)'] = '%' . $arrFiltro['nm_concluinte'] . '%';
        }
        if (isset($arrFiltro['tx_palavra_chave']) && $arrFiltro['tx_palavra_chave']) {
            $select->join('palavra_chave_tcc', 'palavra_chave_tcc.id_tcc = tcc.id_tcc', ['id_palavra_chave']);
            $select->join('palavra_chave', 'palavra_chave.id_palavra_chave = palavra_chave_tcc.id_palavra_chave', ['nm_palavra_chave']);
            $whereBruto['UPPER(nm_palavra_chave) LIKE UPPER(?)'] = '%' . $arrFiltro['tx_palavra_chave'] . '%';
        }

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

        $select->quantifier('DISTINCT');
        $select->where($whereBruto)->order(['dt_cadastro DESC']);

        #xd($select->getSqlString($this->getAdapter()->getPlatform()));
        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }
}