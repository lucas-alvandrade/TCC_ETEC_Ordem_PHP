

<?php $this->load->view('layout/sidebar'); ?>



<!-- Main Content -->
<div id="content">

    <?php $this->load->view('layout/navbar'); ?>

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url('os'); ?>">Ordens de Serviços</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo $titulo; ?></li>
            </ol>
        </nav>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">

            <div class="card-body">

                <form class="user" method="POST" name="form_msg">                   

                    <fieldset class="mt-4 border p-2">

                        <legend class="font-small"><i class="fas fa-tags"></i>&nbsp;Dados da mensagem</legend>

                        <div class="form-group row">

                            <div class="col-md-3 mb-3">
                                <label>WhatsApp</label>
                                <input type="text" class="form-control form-control-user" name="phone">
                                <?php echo form_error('categoria_nome', '<small class="form-text text-danger">', '</small>'); ?>
                            </div>

                            <div class="col-md-9">
                                <label>Mensagem</label>
                                <textarea class="form-control form-control-user" name="msg" style="min-height: 100px!important" ></textarea>                                                                     
                            </div>

                        </div>

                    </fieldset>
                    <br>
                    <button type="submit" class="btn btn-success btn-sm">Enviar</button>
                    <a title="Voltar" href="<?php echo base_url($this->router->fetch_class()); ?>" class="btn btn-primary btn-sm ml-2">Voltar</i></a>
                </form>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

