

<?php $this->load->view('layout/sidebar'); ?>



<!-- Main Content -->
<div id="content">

    <?php $this->load->view('layout/navbar'); ?>

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url('clientes') ?>">Clientes</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo $titulo ?></li>
            </ol>
        </nav>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">

            <div class="card-body">

                <form class="user" method="POST" name="form_edit">

                    <fieldset class="mt-4 border p-2">

                        <legend class="font-small"><i class="fas fa-user-tie"></i>&nbsp;Dados pessoais</legend>

                        <div class="form-group row">

                            <div class="col-md-5 mb-3">
                                <label>Nome</label>
                                <input type="text" class="form-control form-control-user" name="cliente_nome" placeholder="Nome do cliente" value="<?php echo $cliente->cliente_nome ?>">
                                <?php echo form_error('cliente_nome', '<small class="form-text text-danger">', '</small>') ?>
                            </div>

                            <div class="col-md-5">
                                <label>Sobrenome</label>
                                <input type="text" class="form-control form-control-user" name="cliente_sobrenome" placeholder="Sobrenome do cliente" value="<?php echo $cliente->cliente_sobrenome ?>">
                                <?php echo form_error('cliente_sobrenome', '<small class="form-text text-danger">', '</small>') ?>
                            </div>

                            <div class="col-md-2">
                                <label>Data de nascimento</label>
                                <input type="date" class="form-control form-control-user" name="cliente_data_nascimento" value="<?php echo $cliente->cliente_data_nascimento ?>">
                                <?php echo form_error('cliente_data_nascimento', '<small class="form-text text-danger">', '</small>') ?>
                            </div>  

                        </div>

                        <div class="form-group row">

                            <div class="col-md-3 mb-3">
                                <label>CPF ou CNPJ</label>
                                <input type="text" class="form-control form-control-user cnpj" name="cliente_cpf_cnpj" placeholder="CPF ou CNPJ" value="<?php echo $cliente->cliente_cpf_cnpj ?>">
                                <?php echo form_error('cliente_cpf_cnpj', '<small class="form-text text-danger">', '</small>') ?>
                            </div>

                            <div class="col-md-3">
                                <label>RG ou I.E</label>
                                <input type="text" class="form-control form-control-user" name="cliente_rg_ie" placeholder="RG ou I.E" value="<?php echo $cliente->cliente_rg_ie ?>">
                                <?php echo form_error('cliente_rg_ie', '<small class="form-text text-danger">', '</small>') ?>
                            </div>

                            <div class="col-md-6">
                                <label>E-mail</label>
                                <input type="email" class="form-control form-control-user" name="cliente_email" placeholder="E-mail do cliente" value="<?php echo $cliente->cliente_email ?>">
                                <?php echo form_error('cliente_email', '<small class="form-text text-danger">', '</small>') ?>
                            </div>

                        </div>

                        <div class="form-group row">

                            <div class="col-md-6 mb-3">
                                <label>Telefone fixo</label>
                                <input type="text" class="form-control form-control-user sp_celphones" name="cliente_telefone" placeholder="Telefone fixo" value="<?php echo $cliente->cliente_telefone ?>">
                                <?php echo form_error('cliente_telefone', '<small class="form-text text-danger">', '</small>') ?>
                            </div>

                            <div class="col-md-6">
                                <label>Telefone celular</label>
                                <input type="text" class="form-control form-control-user sp_celphones" name="cliente_celular" placeholder="Celular do cliente" value="<?php echo $cliente->cliente_celular ?>">
                                <?php echo form_error('cliente_celular', '<small class="form-text text-danger">', '</small>') ?>
                            </div>

                        </div>

                    </fieldset> 

                    <fieldset class="mt-4 border p-2">

                        <legend class="font-small"><i class="fas fa-map-marker-alt"></i>&nbsp;Dados de endereço</legend>

                        <div class="form-group row">

                            <div class="col-md-6 mb-3">
                                <label>Endereço</label>
                                <input type="text" class="form-control form-control-user" name="cliente_endereco" placeholder="Endereço" value="<?php echo $cliente->cliente_endereco ?>">
                                <?php echo form_error('cliente_endereco', '<small class="form-text text-danger">', '</small>') ?>
                            </div>

                            <div class="col-md-2">
                                <label>Número</label>
                                <input type="text" class="form-control form-control-user" name="cliente_numero_endereco" placeholder="Número" value="<?php echo $cliente->cliente_numero_endereco ?>">
                                <?php echo form_error('cliente_numero_endereco', '<small class="form-text text-danger">', '</small>') ?>
                            </div>

                            <div class="col-md-4">
                                <label>Complemento</label>
                                <input type="text" class="form-control form-control-user" name="cliente_complemento" placeholder="Complemento" value="<?php echo $cliente->cliente_complemento ?>">
                                <?php echo form_error('cliente_complemento', '<small class="form-text text-danger">', '</small>') ?>
                            </div>

                        </div>

                        <div class="form-group row">

                            <div class="col-md-4 mb-3">
                                <label>Bairro</label>
                                <input type="text" class="form-control form-control-user" name="cliente_bairro" placeholder="Bairro" value="<?php echo $cliente->cliente_bairro ?>">
                                <?php echo form_error('cliente_bairro', '<small class="form-text text-danger">', '</small>') ?>
                            </div>

                            <div class="col-md-2">
                                <label>CEP</label>
                                <input type="text" class="form-control form-control-user cep" name="cliente_cep" placeholder="CEP" value="<?php echo $cliente->cliente_cep ?>">
                                <?php echo form_error('cliente_cep', '<small class="form-text text-danger">', '</small>') ?>
                            </div>

                            <div class="col-md-5">
                                <label>Cidade</label>
                                <input type="text" class="form-control form-control-user" name="cliente_cidade" placeholder="Cidade" value="<?php echo $cliente->cliente_cidade ?>">
                                <?php echo form_error('cliente_cidade', '<small class="form-text text-danger">', '</small>') ?>
                            </div>

                            <div class="col-md-1">
                                <label>UF</label>
                                <input type="text" class="form-control form-control-user uf" name="cliente_estado" placeholder="Endereço" value="<?php echo $cliente->cliente_estado ?>">
                                <?php echo form_error('cliente_estado', '<small class="form-text text-danger">', '</small>') ?>
                            </div>

                        </div>

                    </fieldset>   

                    <fieldset class="mt-4 border p-2">

                        <legend class="font-small"><i class="fas fa-tools"></i>&nbsp;Configurações</legend>

                        <div class="form-group row">

                            <div class="col-md-4">
                                <label>Cliente ativo</label>
                                <select class="form-control" name="cliente_ativo">
                                    <option value="0" <?php echo ($cliente->cliente_ativo == 0 ? 'selected' : ''); ?> >Não</option>
                                    <option value="1" <?php echo ($cliente->cliente_ativo == 1 ? 'selected' : ''); ?> >Não</option>
                                </select>                                                               
                            </div>

                            <div class="col-md-8">
                                <label>Observações</label>
                                <textarea class="form-control form-control-user" name="cliente_obs" placeholder="Observações"><?php echo $cliente->cliente_obs ?></textarea>        
                                <?php echo form_error('cliente_obs', '<small class="form-text text-danger">', '</small>') ?>
                            </div>

                        </div>

                    </fieldset>

                    <div class="form-group row">

                        <input type="hidden" mame="cliente_tipo" value="<?php echo $cliente->cliente_tipo ?>"/>
                        <input type="hidden" mame="cliente_id" value="<?php echo $cliente->cliente_id ?>"/>
                        
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
                    <a title="Voltar" href="<?php echo base_url('clientes') ?>" class="btn btn-success btn-sm ml-2">Voltar</i></a>
                </form>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

