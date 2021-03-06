<?php

defined('BASEPATH') OR exit('Ação não permitida');

class Ordem_servicos extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->ion_auth->logged_in()) {
            $this->session->set_flashdata('info', 'Sua sessão expirou!');
            redirect('login');
        }

        $this->load->model('ordem_servicos_model');
    }

    public function index() {

        $data = array(
            'titulo' => 'Ordem de serviços cadastradas',
            'styles' => array(
                'vendor/datatables/dataTables.bootstrap4.min.css',
            ),
            'scripts' => array(
                'vendor/datatables/jquery.dataTables.min.js',
                'vendor/datatables/dataTables.bootstrap4.min.js',
                'vendor/datatables/app.js',
            ),
            'ordens_servicos' => $this->ordem_servicos_model->get_all(),
        );

//        echo '<pre>';
//        print_r($data['ordens_servicos']);
//        exit();

        $this->load->view('layout/header', $data);
        $this->load->view('ordem_servicos/index');
        $this->load->view('layout/footer');
    }

    public function add() {

        $this->form_validation->set_rules('ordem_servico_cliente_id', '', 'required');
        $this->form_validation->set_rules('ordem_servico_equipamento', 'Marca', 'required|min_length[2]|max_length[80]');
        $this->form_validation->set_rules('ordem_servico_marca_equipamento', 'Marca', 'required|min_length[2]|max_length[80]');
        $this->form_validation->set_rules('ordem_servico_modelo_equipamento', 'Modelo', 'required|min_length[2]|max_length[80]');
        $this->form_validation->set_rules('ordem_servico_acessorios', 'Acessórios', 'required|max_length[300]');
        $this->form_validation->set_rules('ordem_servico_defeito', 'Defeito', 'required|max_length[700]');

        if ($this->form_validation->run()) {

            $ordem_servico_valor_total = str_replace('R$', "", trim($this->input->post('ordem_servico_valor_total')));

            $data = elements(
                    array(
                        'ordem_servico_cliente_id',
                        'ordem_servico_status',
                        'ordem_servico_equipamento',
                        'ordem_servico_marca_equipamento',
                        'ordem_servico_modelo_equipamento',
                        'ordem_servico_defeito',
                        'ordem_servico_acessorios',
                        'ordem_servico_obs',
                        'ordem_servico_valor_desconto',
                        'ordem_servico_valor_total',
                    ), $this->input->post()
            );

            $data['ordem_servico_valor_total'] = trim(preg_replace('/\$/', '', $ordem_servico_valor_total));

            $data = html_escape($data);

            $this->core_model->insert('ordens_servicos', $data, TRUE);

            //Recuperar id

            $id_ordem_servico = $this->session->userdata('last_id');

            $servico_id = $this->input->post('servico_id');
            $servico_quantidade = $this->input->post('servico_quantidade');
            $servico_desconto = str_replace('%', '', $this->input->post('servico_desconto'));

            $servico_preco = str_replace('R$', '', $this->input->post('servico_preco'));
            $servico_item_total = str_replace('R$', '', $this->input->post('servico_item_total'));

            $servico_preco = str_replace(',', '', $servico_preco);
            $servico_item_total = str_replace(',', '', $servico_item_total);

            $qty_servico = count($servico_id);

            $ordem_servico_id = $this->input->post('ordem_servico_id');

            for ($i = 0; $i < $qty_servico; $i++) {

                $data = array(
                    'ordem_ts_id_ordem_servico' => $id_ordem_servico,
                    'ordem_ts_id_servico' => $servico_id[$i],
                    'ordem_ts_quantidade' => $servico_quantidade[$i],
                    'ordem_ts_valor_unitario' => $servico_preco[$i],
                    'ordem_ts_valor_desconto' => $servico_desconto[$i],
                    'ordem_ts_valor_total' => $servico_item_total[$i],
                );

                $data = html_escape($data);

                $this->core_model->insert('ordem_tem_servicos', $data);
            }

            redirect('os/imprimir/' . $id_ordem_servico);
        } else {

            $data = array(
                'titulo' => 'Cadastrar ordem de serviço',
                'styles' => array(
                    'vendor/select2/select2.min.css',
                    'vendor/autocomplete/jquery-ui.css',
                    'vendor/autocomplete/estilo.css',
                ),
                'scripts' => array(
                    'vendor/autocomplete/jquery-migrate.js',
                    'vendor/calcx/jquery-calx-sample-2.2.8.min.js',
                    'vendor/calcx/os.js',
                    'vendor/select2/select2.min.js',
                    'vendor/select2/app.js',
                    'vendor/sweetalert2/sweetalert2.js',
                    'vendor/autocomplete/jquery-ui.js',
                ),
                'clientes' => $this->core_model->get_all('clientes', array('cliente_ativo' => 1)),
            );

            $this->load->view('layout/header', $data);
            $this->load->view('ordem_servicos/add');
            $this->load->view('layout/footer');
        }
    }

    public function edit($ordem_servico_id = NULL) {

        if (!$ordem_servico_id || !$this->core_model->get_by_id('ordens_servicos', array('ordem_servico_id' => $ordem_servico_id))) {
            $this->session->set_flashdata('error', 'Ordem de serviço não encontrada');
            redirect('os');
        } else {

            $this->form_validation->set_rules('ordem_servico_cliente_id', '', 'required');

            $ordem_servico_status = $this->input->post('ordem_servico_status');

            if ($ordem_servico_status == 1) {
                $this->form_validation->set_rules('ordem_servico_forma_pagamento_id', '', 'required');
            }

            $this->form_validation->set_rules('ordem_servico_equipamento', 'Marca', 'required|min_length[2]|max_length[80]');
            $this->form_validation->set_rules('ordem_servico_marca_equipamento', 'Marca', 'required|min_length[2]|max_length[80]');
            $this->form_validation->set_rules('ordem_servico_modelo_equipamento', 'Modelo', 'required|min_length[2]|max_length[80]');
            $this->form_validation->set_rules('ordem_servico_acessorios', 'Acessórios', 'required|max_length[300]');
            $this->form_validation->set_rules('ordem_servico_defeito', 'Defeito', 'required|max_length[700]');

            if ($this->form_validation->run()) {

                $ordem_servico_valor_total = str_replace('R$', "", trim($this->input->post('ordem_servico_valor_total')));

                $data = elements(
                        array(
                            'ordem_servico_cliente_id',
                            'ordem_servico_forma_pagamento_id',
                            'ordem_servico_status',
                            'ordem_servico_equipamento',
                            'ordem_servico_marca_equipamento',
                            'ordem_servico_modelo_equipamento',
                            'ordem_servico_defeito',
                            'ordem_servico_acessorios',
                            'ordem_servico_obs',
                            'ordem_servico_valor_desconto',
                            'ordem_servico_valor_total',
                        ), $this->input->post()
                );

                if ($ordem_servico_status == 0) {
                    unset($data['ordem_servico_forma_pagamento_id']);
                }

                $data['ordem_servico_valor_total'] = trim(preg_replace('/\$/', '', $ordem_servico_valor_total));

                $data = html_escape($data);

                $this->core_model->update('ordens_servicos', $data, array('ordem_servico_id' => $ordem_servico_id));

                /* Deletando de ordem_tem_servicos os servicos antigos da ordem editada */
                $this->ordem_servicos_model->delete_old_services($ordem_servico_id);

                $servico_id = $this->input->post('servico_id');
                $servico_quantidade = $this->input->post('servico_quantidade');
                $servico_desconto = str_replace('%', '', $this->input->post('servico_desconto'));

                $servico_preco = str_replace('R$', '', $this->input->post('servico_preco'));
                $servico_item_total = str_replace('R$', '', $this->input->post('servico_item_total'));

                $servico_preco = str_replace(',', '', $servico_preco);
                $servico_item_total = str_replace(',', '', $servico_item_total);

                $qty_servico = count($servico_id);

                $ordem_servico_id = $this->input->post('ordem_servico_id');

                for ($i = 0; $i < $qty_servico; $i++) {

                    $data = array(
                        'ordem_ts_id_ordem_servico' => $ordem_servico_id,
                        'ordem_ts_id_servico' => $servico_id[$i],
                        'ordem_ts_quantidade' => $servico_quantidade[$i],
                        'ordem_ts_valor_unitario' => $servico_preco[$i],
                        'ordem_ts_valor_desconto' => $servico_desconto[$i],
                        'ordem_ts_valor_total' => $servico_item_total[$i],
                    );

                    $data = html_escape($data);

                    $this->core_model->insert('ordem_tem_servicos', $data);
                }

                redirect('os/imprimir/' . $ordem_servico_id);
            } else {

                $data = array(
                    'titulo' => 'Atualizar ordem de serviço',
                    'styles' => array(
                        'vendor/select2/select2.min.css',
                        'vendor/autocomplete/jquery-ui.css',
                        'vendor/autocomplete/estilo.css',
                    ),
                    'scripts' => array(
                        'vendor/autocomplete/jquery-migrate.js',
                        'vendor/calcx/jquery-calx-sample-2.2.8.min.js',
                        'vendor/calcx/os.js',
                        'vendor/select2/select2.min.js',
                        'vendor/select2/app.js',
                        'vendor/sweetalert2/sweetalert2.js',
                        'vendor/autocomplete/jquery-ui.js',
                    ),
                    'clientes' => $this->core_model->get_all('clientes', array('cliente_ativo' => 1)),
                    'formas_pagamentos' => $this->core_model->get_all('formas_pagamentos', array('forma_pagamento_ativa' => 1)),
                    'os_tem_servicos' => $this->ordem_servicos_model->get_all_servicos_by_ordem($ordem_servico_id),
                );

                $ordem_servico = $data['ordem_servico'] = $this->ordem_servicos_model->get_by_id($ordem_servico_id);

//                echo '<pre>';
//                print_r($ordem_servico);
//                exit();

                $this->load->view('layout/header', $data);
                $this->load->view('ordem_servicos/edit');
                $this->load->view('layout/footer');
            }
        }
    }

    public function del($ordem_servico_id = NULL) {

        if (!$ordem_servico_id || !$this->core_model->get_by_id('ordens_servicos', array('ordem_servico_id' => $ordem_servico_id))) {
            $this->session->set_flashdata('error', 'Ordem de serviço não encontrada');
            redirect('os');
        }

        if ($this->core_model->get_by_id('ordens_servicos', array('ordem_servico_id' => $ordem_servico_id, 'ordem_servico_status' => 0))) {
            $this->session->set_flashdata('error', 'Não é possível excluir uma ordem de serviço Em aberto');
            redirect('os');
        }

        $this->core_model->delete('ordens_servicos', array('ordem_servico_id' => $ordem_servico_id));
        redirect('os');
    }

    public function imprimir($ordem_servico_id = NULL) {

        if (!$ordem_servico_id || !$this->core_model->get_by_id('ordens_servicos', array('ordem_servico_id' => $ordem_servico_id))) {
            $this->session->set_flashdata('error', 'Ordem de serviço não encontrada');
            redirect('os');
        } else {

            $data = array(
                'titulo' => 'Escolha uma opção',
                'ordem_servico' => $this->core_model->get_by_id('ordens_servicos', array('ordem_servico_id' => $ordem_servico_id)),
            );

            $this->load->view('layout/header', $data);
            $this->load->view('ordem_servicos/imprimir');
            $this->load->view('layout/footer');
        }
    }

    public function pdf($ordem_servico_id = NULL) {

        if (!$ordem_servico_id || !$this->core_model->get_by_id('ordens_servicos', array('ordem_servico_id' => $ordem_servico_id))) {
            $this->session->set_flashdata('error', 'Ordem de serviço não encontrada');
            redirect('os');
        } else {

            $empresa = $this->core_model->get_by_id('sistema', array('sistema_id' => 1));

            $ordem_servico = $this->ordem_servicos_model->get_by_id($ordem_servico_id);

            //Inicio do HTML

            $file_name = 'O.S&nbsp;' . $ordem_servico->ordem_servico_id;

            $html = '<html>';

            $html .= '<head>';

            $html .= '<title>' . $empresa->sistema_nome_fantasia . ' | Impressão de Ordem de Serviço</title>';

            $html .= '</head>';

            $html .= '<body style="font-size: 14px">';

            $html .= '<h4 align="center">
                    ' . $empresa->sistema_razao_social . '<br/>
                    ' . 'CNPJ: ' . $empresa->sistema_cnpj . '<br/>
                    ' . $empresa->sistema_endereco . ',&nbsp;' . $empresa->sistema_numero . '<br/>
                    ' . 'CEP: ' . $empresa->sistema_cep . ',&nbsp;' . $empresa->sistema_cidade . '-' . $empresa->sistema_estado . '<br/>
                    ' . 'Telefone: ' . $empresa->sistema_telefone_fixo . '<br/>
                    ' . 'E-mail: ' . $empresa->sistema_email . '<br/>
                    </h4>';

            $html .= '<hr>';

            //Dados do cliente

            $html .= '<p align="right" style="font-size: 12px">O.S Nº&nbsp;' . $ordem_servico->ordem_servico_id . '</p>';

            $html .= '<p>'
                    . '<strong>Cliente: </strong>' . $ordem_servico->cliente_nome_completo . '<br/>'
                    . '<strong>CPF: </strong>' . $ordem_servico->cliente_cpf_cnpj . '<br/>'
                    . '<strong>Celular: </strong>' . $ordem_servico->cliente_celular . '<br/>'
                    . '<strong>Data de emissão: </strong>' . formata_data_banco_com_hora($ordem_servico->ordem_servico_data_emissao) . '<br/>'
                    . '<strong>Forma de pagamento: </strong>' . ($ordem_servico->ordem_servico_status == 1 ? $ordem_servico->forma_pagamento : 'Em aberto') . '<br/>'
                    . '</p>';

            $html .= '<hr>';

            //Dados da ordem


            $html .= '<table width="100%" border: solid #ddd 1px>';

            $html .= '<tr>';

            $html .= '<th>Serviço</th>';
            $html .= '<th>Quantidade</th>';
            $html .= '<th>Valor unitário</th>';
            $html .= '<th>Desconto</th>';
            $html .= '<th>Valor total</th>';

            $html .= '</tr>';

            $ordem_servico_id = $ordem_servico->ordem_servico_id;

            $servicos_ordem = $this->ordem_servicos_model->get_all_servicos($ordem_servico_id);

//            echo '<pre>';
//            print_r($servicos_ordem);
//            exit();

            $valor_final_os = $this->ordem_servicos_model->get_valor_final_os($ordem_servico_id);

//            echo '<pre>';
//            print_r($valor_final_os);
//            exit();

            foreach ($servicos_ordem as $servico):

                $html .= '<tr>';
                $html .= '<td>' . $servico->servico_nome . '</td>';
                $html .= '<td>' . $servico->ordem_ts_quantidade . '</td>';
                $html .= '<td>' . 'R$&nbsp;' . $servico->ordem_ts_valor_unitario . '</td>';
                $html .= '<td>' . $servico->ordem_ts_valor_desconto . '%&nbsp;' . '</td>';
                $html .= '<td>' . 'R$&nbsp;' . $servico->ordem_ts_valor_total . '</td>';
                $html .= '</tr>';

            endforeach;

            $html .= '<th colspan="3">';

            $html .= '<td style="border-top: solid #ddd 1px"><strong>Valor final</strong></td>';
            $html .= '<td style="border-top: solid #ddd 1px">' . 'R$&nbsp;' . $valor_final_os->os_valor_total . '</td>';

            $html .= '</th>';

            $html .= '</table>';

            $html .= '</body>';

            $html .= '</html>';

//            echo '<pre>';
//            print_r($html);
//            exit();
            // False-> abre PDF no navegador
            // True-> faz o download

            $this->pdf->createPDF($html, $file_name, false);
        }
    }

    public function whats() {

        $this->form_validation->set_rules('phone', '', 'trim|required');
        $this->form_validation->set_rules('msg', '', 'trim|required');

        if ($this->form_validation->run()) {

            $whatsapp = $this->input->post('phone');
            $apimsg = $this->input->post('msg');

            //dispara a mensagem da API
            $url = 'https://whatsapp-api-assistec.herokuapp.com/send-message';
            $data = array('number' => '55' . $whatsapp, 'message' => $apimsg);

            // use key 'http' even if you send the request to https://...
            $options = array(
                'http' => array(
                    'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method' => 'POST',
                    'content' => http_build_query($data)
                )
            );
            $context = stream_context_create($options);
            $result = file_get_contents($url, false, $context);
            if ($result === FALSE) { /* Handle error */
            }
            var_dump($result);

            redirect('os');
        } else {

            $data = array(
                'titulo' => 'Enviar WhatsApp',               
            );

//            echo '<pre>';
//            print_r($data['categoria']);
//            exit();

            $this->load->view('layout/header', $data);
            $this->load->view('ordem_servicos/whats');
            $this->load->view('layout/footer');
        }
     
    }

}
