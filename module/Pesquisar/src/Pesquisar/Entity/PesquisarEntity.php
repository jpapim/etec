<?php
/**
 * Created by PhpStorm.
 * User: EduFerr
 * Date: 19/09/2016
 * Time: 16:18
 */
namespace Pesquisar\Entity;

use Estrutura\Service\AbstractEstruturaService;

class PesquisarEntity extends AbstractEstruturaService{

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
        protected $ar_arquivo;

}