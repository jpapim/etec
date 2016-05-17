<?php

namespace Evento\Service;

use \Evento\Entity\EventoEntity as Entity;

class EventoService extends Entity{

    public function getEventoToArray($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('eventos')
            ->where([
                'eventos.id_evento = ?' => $id,
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    public function fetchAllEventosAtivosToArray() {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        #die($id);
        $select = $sql->select('eventos')
            ->where([
                'eventos.bo_inativo = ?' => false,
            ]);

        $result = $sql->prepareStatementForSqlObject($select)->execute();
        $resultSet = new \Zend\Db\ResultSet\ResultSet();
        $resultSet->initialize($result);
        $arrayResultado = $resultSet->toArray();
        return $arrayResultado;
    }

    public function fetchAllEventosAtivos() {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        #die($id);
        $select = $sql->select('eventos')
            ->where([
                'eventos.bo_inativo = ?' => false,
            ]);

        $result = $sql->prepareStatementForSqlObject($select)->execute();
        $resultSet = new \Zend\Db\ResultSet\ResultSet();

        return $resultSet->initialize($result);
    }
    
    /**
     * Localizar itens por paginaï¿½ï¿½o
     *
     * @param type $pagina
     * @param type $itensPagina
     * @param type $ordem
     * @param type $like
     * @param type $itensPaginacao
     * @return type Paginator
     */
    public function fetchPaginator($pagina = 1, $itensPagina = 5, $ordem = 'nm_evento ASC', $like = null, $itensPaginacao = 5) {
    	// preparar um select para tabela contato com uma ordem
    	$sql = new \Zend\Db\Sql\Sql($this->getAdapter());
    	$select = $sql->select('eventos')->order($ordem);
    
    	if (isset($like)) {
    		$select
    		->where
    		->like('id_evento', "%{$like}%")
    		->or
    		->like('nm_evento', "%{$like}%")
    		;
    	}
    
    	// criar um objeto com a estrutura desejada para armazenar valores
    	$resultSet = new HydratingResultSet(new Reflection(), new \Evento\Entity\EventoEntity());
    
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
    	// resultado da paginaï¿½ï¿½o
    	return (new Paginator($paginatorAdapter))
    	// pagina a ser buscada
    	->setCurrentPageNumber((int) $pagina)
    	// quantidade de itens na pï¿½gina
    	->setItemCountPerPage((int) $itensPagina)
    	->setPageRange((int) $itensPaginacao);
    }
    
    /** 
     * @param type $dtInicio
     * @param type $dtFim
     * @return type
     */
    public function getEventosPaginator($filter = NULL, $camposFilter = NULL) {
    
    	$sql = new \Zend\Db\Sql\Sql($this->getAdapter());
    
    	$select = $sql->select('eventos')->columns([
    			'id_evento',
    			'id_regra_luta',
    			'nm_evento',
    			'dt_evento',
    			'vl_inscricao_colorida',
    			'vl_inscricao_preta'
    	])
    	->join('cidade', 'cidade.id_cidade = eventos.id_cidade', [
    			'nm_cidade'
    	])
    	->join('estado', 'estado.id_estado = cidade.id_estado', [
    			'sg_estado'
    	])
    	->join('regras_lutas', 'regras_lutas.id_regra_luta = eventos.id_regra_luta', [
    			'nm_regra_luta'
    	]);
    
    	$where = [
    	];
    
    	if (!empty($filter)) {
    
    		foreach ($filter as $key => $value) {

    			if ($value) {

    				if (isset($camposFilter[$key]['mascara'])) {
    
    					eval("\$value = " . $camposFilter[$key]['mascara'] . ";");
    				}
    
    				// a busca por data deverá ser diferente das demais consultas
    				if ($key == 3){ // filtro data
    					$where[$camposFilter[$key]['filter']] = $value;
    				} else {
    					$where[$camposFilter[$key]['filter']] = '%' . $value . '%';
    				}
    			}
    		}
    	}
    
    	$select->where($where)->order(['nm_evento DESC']);
    
    	return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }
}



