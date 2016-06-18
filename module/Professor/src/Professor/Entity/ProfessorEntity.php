<?php

namespace Professor\Entity;

use Estrutura\Service\AbstractEstruturaService;

class ProfessorEntity extends AbstractEstruturaService{

	protected $id;
	protected $id_titulacao;
	protected $id_usuario;
	protected $nm_professor;
	protected $dt_cadastro;
	protected $cs_orientador;
	protected $cs_ativo;

}
