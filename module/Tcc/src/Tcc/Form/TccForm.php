<?php
/**
 * Created by PhpStorm.
 * User: EduFerr
 * Date: 19/09/2016
 * Time: 16:18
 */

namespace Tcc\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class TccForm extends AbstractForm
{

    public function __construct($options = [])
    {
        parent::__construct('tccform');

        $this->inputFilter = new InputFilter();

        $objForm = new FormObject('tccform', $this, $this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->hidden("id_usuario_cadastro")->required(false)->label("Usuario que cadastrou");
        $objForm->hidden("id_usuario_alteracao")->required(false)->label("Usuario que alterou");

        $objForm->combo("id_banca_examinadora",'\BancaExaminadora\Service\BancaExaminadoraService', 'id', 'dt_banca')->required(true)->label("Data da Banca");
        $objForm->combo("id_tipo_tcc",'\TipoTcc\Service\TipoTccService', 'id', 'nm_tipo_tcc')->required(true)->label("Tipo de TCC");
        $objForm->combo("id_area_conhecimento", '\AreaConhecimento\Service\AreaConhecimentoService', 'id', 'nm_area_conhecimento')->required(true)->label("Ãrea de Conhecimento");

        $objForm->combo("id_professor_orientador",'\Professor\Service\ProfessorService', 'id', 'nm_Professor')->required(true)->label("Nome do Professor Orientador");

        $objForm->text("tx_titulo_tcc")->required(true)->label("Título do TCC");
        $objForm->textarea("tx_resumo")->required(true)->label("Resumo");
        $objForm->text("nr_nota_final")->required(true)->label("Nota");
        #$objForm->file("tx_caminho_arquivo")->required(false)->label("Caminho do arquivo");



        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }

}