

<?php $this->load->view('layout/sidebar'); ?>



<!-- Main Content -->
<div id="content">

    <?php $this->load->view('layout/navbar'); ?>

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <!--<h1 class="h3 mb-4 text-gray-800">Home</h1>-->

        <?php if ($message = $this->session->flashdata('success')): ?>

            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong><i class="fas fa-check-circle"></i>&nbsp;&nbsp;<?php echo $message; ?></strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>

        <?php endif; ?>

        <?php if ($message = $this->session->flashdata('info')): ?>

            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-warning alert-dismissible fade show text-gray-900" role="alert">
                        <strong><i class="fas fa-exclamation-triangle"></i>&nbsp;&nbsp;<?php echo $message; ?></strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>

        <?php endif; ?>

        <?php if ($this->ion_auth->is_admin()): ?>
            <!-- Content Row -->
            <div class="row">

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Total de O.S em Aberto</div>                                   
                                    <div class="h5 mb-0 font-weight-bold text-success"><?php echo $total_ordem_servicos->quantidade_ordens_servicos ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-tools fa-3x text-success"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total de Serviços</div>
                                    <div class="h5 mb-0 font-weight-bold text-primary"><?php echo 'R$&nbsp;' . $soma_ordem_servicos->ordem_servico_valor_total; ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-shopping-basket fa-3x text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total a Pagar
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <div class="h5 mb-0 mr-3 font-weight-bold text-danger"><?php echo 'R$&nbsp;' . $total_pagar->conta_pagar_valor; ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-money-check-alt fa-3x text-danger"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total a Receber
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <div class="h5 mb-0 mr-3 font-weight-bold text-warning"><?php echo 'R$&nbsp;' . ($total_receber->conta_receber_valor == NULL ? '0,00' : $total_receber->conta_receber_valor); ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-hand-holding-usd fa-3x text-warning"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-lg-6 mb-4">

                <!-- Illustrations -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-success">Ordens em Aberto</h6>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 13rem;"
                                 src="<?php echo base_url('/public/img/undraw_bug_fixing_oc7a.svg') ?>" alt="...">
                        </div>   
                        <div class="table-responsive">                            
                            <table class="table table-striped table-borderless">
                                <thead>
                                    <tr>
                                        <th>Cliente</th>
                                        <th class="text-center">Data de entrada</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($ordens_em_aberto as $ordem): ?>
                                        <tr>
                                            <td><?php echo $ordem->cliente_nome_completo ?></td>
                                            <td class="text-center"><?php echo formata_data_banco_com_hora($ordem->ordem_servico_data_emissao) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>                           
                    </div>
                </div>                               
            </div>

            <div class="col-lg-6 mb-4">

                <!-- Illustrations -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">TOP 3 Serviços mais vendidos</h6>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 15rem;"
                                 src="<?php echo base_url('/public/img/undraw_Maintenance_re_59vn.svg') ?>" alt="...">
                        </div> 
                        <div class="table-responsive">                            
                            <table class="table table-striped table-borderless">
                                <thead>
                                    <tr>
                                        <th>Nome do Serviço</th>
                                        <th class="text-center">Vendidos</th>
                                    </tr>
                                </thead>             
                                <tbody>
                                    <?php foreach ($servicos_mais_vendidos as $servico): ?>
                                        <tr>
                                            <td><?php echo$servico->servico_nome ?></td>
                                            <td class="text-center"><?php echo$servico->quantidade_vendidos ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>                           
                            </table>
                        </div>           
                    </div>                    
                </div>                               
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

