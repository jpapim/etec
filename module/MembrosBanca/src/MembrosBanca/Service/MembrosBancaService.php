<?php

namespace MembrosBanca\Service;

use \MembrosBanca\Entity\MembrosBancaEntity as Entity;

class MembrosBancaService extends Entity
{

    public function getBancaExaminadoraToArray($id)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('banca_examinadora')
            ->where([
                'banca_examinadora.id_banca_examinadora = ?' => $id,
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

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

    /**
     * Consulta que retorna o membro_banca tendo como condição o id do professor
     * e o id da banca examinadora
     */
    public function checarSeProfessorEstaInscritoNaBanca($id_professor, $id_banca_examinadora)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        #die($id);
        $select = $sql->select('membros_banca')
            ->where([
                'membros_banca.id_professor = ?' => $id_professor,
                'membros_banca.id_banca_examinadora = ?' => $id_banca_examinadora,
            ]);
        #print_r($sql->prepareStatementForSqlObject($select)->execute());exit;

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    /**
     * Função que altera o campo cs_orientador a partir do valor informado.
     */
    public function alterarCampoCsOrientador($id_banca_examinadora, $cs_orientador)
    {
        $this->preSave();
        $dados = $this->hydrate();
        $where = null;

        if ($id_banca_examinadora) {
            if (!$field = $this->fieldName('id')) {
                $field = $this->fieldName('Id');
            }
            $where = [$field => $id_banca_examinadora];
        }

        $dados['cs_orientador'] = $cs_orientador;

        $result = $this->getTable()->salvar($dados, $where);
        if (is_string($result)) {
            $this->setId($result);
        }
        $this->posSave();
        return $result;
    }
}