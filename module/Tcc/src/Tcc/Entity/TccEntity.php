<?php

namespace Tcc\Entity;

use Estrutura\Service\AbstractEstruturaService;

class TccEntity extends AbstractEstruturaService{

    protected $id;
    protected $id_usuario_cadastro;
    protected $id_usuario_alteracao;
    protected $id_banca_examinadora;
    protected $id_area_conhecimento;
    protected $id_tipo_tcc;
    protected $id_professor_orientador;
    protected $tx_titulo_tcc;
    protected $tx_resumo;
    protected $dt_cadastro;
    protected $dt_alteracao;
    protected $nr_nota_final;

}