<?php
/**
 * Created by PhpStorm.
 * User: EduFerr
 * Date: 19/09/2016
 * Time: 16:18
 */

namespace Pesquisar\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class PesquisarForm extends AbstractForm
{

    public function __construct($options = [])
    {
        parent::__construct('tccformpesquisa');

        $this->inputFilter = new InputFilter();

        $objForm = new FormObject('tccformpesquisa', $this, $this->inputFilter);

        $objForm->date("dt_inicio")->required(false)->label("Início Periodo");
        $objForm->date("dt_final")->required(false)->label("Final da Periodo");
        $objForm->combo("id_tipo_tcc",'\TipoTcc\Service\TipoTccService', 'id', 'nm_tipo_tcc')->required(false)->label("Tipo de Trabalho");
        $objForm->combo("id_area_conhecimento", '\AreaConhecimento\Service\AreaConhecimentoService', 'id', 'nm_area_conhecimento')->required(false)->label("Área de Conhecimento");
        $objForm->combo("id_professor_orientador",'\Professor\Service\ProfessorService', 'id','nm_Professor', 'retornaOrientadores')->required(false)->label("Orientador");
        $objForm->text("tx_titulo_tcc")->required(false)->label("Título do TCC");

        $objForm->combo("id_curso", '\Curso\Service\CursoService', 'id', 'nm_curso')->required(false)->label("Curso");
        $objForm->text("nm_concluinte")->required(false)->label("Nome do Aluno");
        $objForm->text("tx_palavra_chave")->required(false)->label("Palavra Chave");
        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }

}