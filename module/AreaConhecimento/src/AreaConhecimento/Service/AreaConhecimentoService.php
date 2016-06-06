<?php

namespace AreaConhecimento\Service;

use \AreaConhecimento\Entity\AreaConhecimentoEntity as Entity;

class AreaConhecimentoService extends Entity{

    public function getAreaConhecimentoToArray($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        #die($id);
        $select = $sql->select('area_conhecimento')
            ->where([
                'area_conhecimento.id_area_conhecimento = ?' => $id,
            ]);
        #print_r($sql->prepareStatementForSqlObject($select)->execute());exit;

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

}