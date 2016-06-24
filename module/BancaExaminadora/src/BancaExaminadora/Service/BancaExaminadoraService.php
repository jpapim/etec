<?php

namespace BancaExaminadora\Service;

use \BancaExaminadora\Entity\BancaExaminadoraEntity as Entity;

class BancaExaminadoraService extends Entity{


  	/**
  	 * Busca das bancas
  	 *
  	 * @param unknown $filter
  	 * @param unknown $camposFilter
  	 * @return \Zend\Paginator\Paginator
  	 */
  	public function getBancaExaminadoraPaginator($filter = NULL, $camposFilter = NULL) {

  		$sql = new \Zend\Db\Sql\Sql($this->getAdapter());

  		$select = $sql->select('banca_examinadora')->columns([
  				'id_banca_examinadora',
  				'dt_banca'
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
  					* Tratamento para buscas por data
  					*/
            if ($key == 0){ // filtro data
    					$where[$camposFilter[$key]['filter']] = $value;
    				} else {
    					$where[$camposFilter[$key]['filter']] = '%' . $value . '%';
    				}
  				}
  			}
  		}

      // Ordenando de forma decrescente
  		$select->where($where)->order(['dt_banca DESC']);

  		return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
  	}
}
