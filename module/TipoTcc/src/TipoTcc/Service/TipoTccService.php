<?php

namespace TipoTcc\Service;

use \TipoTcc\Entity\TipoTccEntity as Entity;

class TipoTccService extends Entity{

    public function getTipoTccToArray($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        #die($id);
        $select = $sql->select('tipo_tcc')
            ->where([
                'tipo_tcc.id_tipo_tcc = ?' => $id,
            ]);
        #print_r($sql->prepareStatementForSqlObject($select)->execute());exit;

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

}