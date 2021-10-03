<?php

defined('BASEPATH') OR exit('Ação não permitida');

class Sistema extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->ion_auth->logged_in()) {
            $this->session->set_flashdata('info', 'Sua sessão expirou!');
            redirect('login');
        }
    }

    public function index() {

         if (!$this->ion_auth->is_admin()) {
            $this->session->set_flashdata('info', 'Acesso negado');
            redirect('/');
        }
        
        $data = array(
            'titulo' => 'Editar informações do sistema',
            
            'scripts' => array(
                'vendor/mask/jquery.mask.min.js',
                'vendor/mask/app.js'
            ),
            
            'sistema' => $this->core_model->get_by_id('sistema', array('sistema_id' => 1))
        );

        $this->form_validation->set_rules('sistema_razao_social', 'Razão social', 'required|min_length[10]|max_length[145]');
        $this->form_validation->set_rules('sistema_nome_fantasia', 'Nome fantasia', 'required|min_length[10]|max_length[145]');
        $this->form_validation->set_rules('sistema_cnpj', '', 'required|exact_length[18]'); //18 caracteres
        $this->form_validation->set_rules('sistema_ie', '', 'required|max_length[25]');
        $this->form_validation->set_rules('sistema_telefone_fixo', '', 'required|max_length[25]');
        $this->form_validation->set_rules('sistema_telefone_movel', '', 'required|max_length[25]');
        $this->form_validation->set_rules('sistema_email', '', 'required|valid_email|max_length[100]');
        $this->form_validation->set_rules('sistema_site_url', 'URL do site', 'required|valid_url|max_length[100]');
        $this->form_validation->set_rules('sistema_cep', 'CEP', 'required|exact_length[9]');
        $this->form_validation->set_rules('sistema_endereco', 'Endereço', 'required|max_length[145]');
        $this->form_validation->set_rules('sistema_numero', 'Número', 'max_length[25]');
        $this->form_validation->set_rules('sistema_cidade', 'Cidade', 'required|max_length[45]');
        $this->form_validation->set_rules('sistema_estado', 'UF', 'required|exact_length[2]');
        $this->form_validation->set_rules('sistema_txt_ordem_servico', 'Texto da ordem de serviço e venda', 'max_length[500]');

        if ($this->form_validation->run()) {

            /*
             * [sistema_razao_social] => GRUPO7 Systems S.A
              [sistema_nome_fantasia] => Sistema G7 OS
              [sistema_cnpj] => 04.182.944/0001-88
              [sistema_ie] => 487.547.065.850
              [sistema_telefone_fixo] => 11 - 7177-1771
              [sistema_telefone_movel] => 11 - 91711-7117
              [sistema_site_url] => http://localhost/ordem/home
              [sistema_email] => contato@grupo7systems.com
              [sistema_endereco] => Rua dos Devs
              [sistema_numero] => 1337
              [sistema_cidade] => São Paulo
              [sistema_estado] => SP
              [sistema_cep] => 804290000
              [sistema_txt_ordem_servico] =>
             */

            $data = elements(
                    array(
                        'sistema_razao_social',
                        'sistema_nome_fantasia',
                        'sistema_cnpj',
                        'sistema_ie',
                        'sistema_telefone_fixo',
                        'sistema_telefone_movel',
                        'sistema_site_url',
                        'sistema_email',
                        'sistema_endereco',
                        'sistema_numero',
                        'sistema_cidade',
                        'sistema_estado',
                        'sistema_cep',
                        'sistema_txt_ordem_servico',
                    ), $this->input->post()
            );
            
            $data = html_escape($data); //
            
            $this->core_model->update('sistema', $data, array('sistema_id' => 1));
            
            redirect('sistema');
            
        } else {

            //Erro de validação

            $this->load->view('layout/header', $data);
            $this->load->view('sistema/index');
            $this->load->view('layout/footer');
        }
    }

}
