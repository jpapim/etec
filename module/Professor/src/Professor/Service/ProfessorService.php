<?php

namespace Professor\Service;

use \Professor\Entity\ProfessorEntity as Entity;

class ProfessorService extends Entity
{

    public function getProfessorToArray($id)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('professor')
            ->where([
                'professor.id_professor = ?' => $id,
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    public function getProfessoresPaginator($filter = NULL, $camposFilter = NULL)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('professor')->columns([
            'id_professor',
            'nm_professor',
            'cs_orientador',
            'cs_ativo',
        ])
            ->join('titulacao', 'titulacao.id_titulacao = professor.id_titulacao', [
                'nm_titulacao'
            ]);

        $where = [
        ];

        if (!empty($filter)) {

            foreach ($filter as $key => $value) {

                if ($value) {

                    if (isset($camposFilter[$key]['mascara'])) {

                        eval("\$value = " . $camposFilter[$key]['mascara'] . ";");

                    }

                    /*
                    * Tratamento para buscas no campo Orientador
                    */
                    if ($key == 2) {
                        if (strcasecmp($value, "sim") == 0) {
                            $value = 'S';
                        } else if (strcasecmp($value, "não") == 0 ||
                            strcasecmp($value, "nao") == 0 ||
                            strcasecmp($value, "nÃo") == 0
                        ) {
                            $value = 'N';
                        }
                    }

                    /*
                    * Tratamento para buscas no campo Situação
                    */
                    if ($key == 3) {
                        if (strcasecmp($value, "ativo") == 0) {
                            $value = 'A';
                        } else if (strcasecmp($value, "inativo") == 0) {
                            $value = 'I';
                        }
                    }

                    $where[$camposFilter[$key]['filter']] = '%' . $value . '%';

                }
            }
        }

        $select->where($where)->order(['id_professor DESC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }

    public function getFiltrarProfessorPorNomeToArray($nm_professor)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('professor')
            ->columns(array('nm_professor', 'cs_orientador'))#Colunas a retornar. Basta Omitir que ele traz todas as colunas
            ->where([
                "professor.nm_professor LIKE ?" => '%' . $nm_professor . '%',
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute();
    }

    public function getIdProfessorPorNomeToArray($nm_professor)
    {

        $arNomeProfessor = explode('(', $nm_professor);
        $nm_professor = $arNomeProfessor[0];

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $filter = new \Zend\Filter\StringTrim();
        $select = $sql->select('professor')
            ->columns(array('id_professor', 'nm_professor', 'cs_orientador'))
            ->where([
                'professor.nm_professor = ?' => $filter->filter($nm_professor),
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    /**
     * Método Responsavel por retornar Apenas os professores Orientadores
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function retornaOrientadores()
    {
        $colecaoProfessor = $this->select(['cs_orientador'=> 'S', 'cs_ativo'=> 'A']);
        return $colecaoProfessor;
    }
    /**
     * Método Responsavel por retornar Apenas os professores Ativos
     * @return \Zend\Db\ResultSet\ResultSet
     */

    public function retornaProfessoresAtivo()
    {
        $colecaoProfessor = $this->select(['cs_ativo'=> 'A']);
        return $colecaoProfessor;
    }
}
