<?php
session_start();
include "../model/Conexao.php";
$conexao = new Conexao();
$sql = "select primeiroacesso from pessoa where codpessoa = {$_SESSION["codpessoa"]}  ";
$pessoap = $conexao->comandoArray($sql);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>South Sistemas | Dashboard</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="/visao/recursos/css/instalador.css">
        <link rel="stylesheet" href="/visao/recursos/css/sweet-alert.min.css">
        <link rel="stylesheet" href="/visao/recursos/css/popup.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. --> 
        <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
        <!-- Morris chart -->
        <link rel="stylesheet" href="plugins/morris/morris.css">
        <!-- jvectormap -->
        <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
        <!-- Date Picker -->
        <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker-bs3.css">
        <!-- bootstrap wysihtml5 - text editor -->
        <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="http://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="http://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script type="text/javascript" src="http://www.gstatic.com/charts/loader.js"></script>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">

            <?php
                include "header.php";
                include ("menu.php");
            ?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Dashboard
                        <small>Painel de controle</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Dashboard</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <?php
                                    if ($_SESSION["codnivel"] != 19) {
                                        $and = " and funcionario.codfuncionario = {$_SESSION['codpessoa']}";
                                    }
                                    $sql = "select count(1) as qtd
                                        from agenda 
                                        left join pessoa as cliente on cliente.codpessoa = agenda.codpessoa and cliente.codempresa = agenda.codempresa
                                        left join pessoa as funcionario on funcionario.codpessoa = agenda.codfuncionario
                                        left join statuspessoa as status on status.codstatus = cliente.codstatus  
                                        where agenda.codempresa = '{$_SESSION['codempresa']}' and funcionario.status <> 'i'
                                        $and    
                                        and dtagenda >= '" . date('Y-m-d') . " 00:00:01' and dtagenda <= '" . date('Y-m-d') . " 23:59:01'    
                                        and cliente.codstatus <> '1'  and agenda.atendido = 'n' order by agenda.dtagenda asc";
                                    $qtdAgenda = $conexao->comandoArray($sql);
                                    if (isset($qtdAgenda["qtd"]) && $qtdAgenda["qtd"] != NULL && $qtdAgenda["qtd"] > 0) {
                                        echo '<h3>', $qtdAgenda["qtd"], '</h3>';
                                    } else {
                                        echo '<h3>0</h3>';
                                    }
                                    echo '<p>Quantidade retornos</p>';
                                    ?>                                         
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="Cliente.php?callcenter=true&agendamentos=true" class="small-box-footer">Mais informações <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <?php
                                    if ($_SESSION["codnivel"] != 19) {
                                        $and = " and codfuncionario = {$_SESSION['codpessoa']}";
                                    }
                                    $sql = "select sum(valor) as valor from baixa 
                                    where codempresa = '{$_SESSION["codempresa"]}' 
                                    and dtcadastro >= '" . date("Y-m-") . "01' and dtcadastro <= '" . date("Y-m-") . "31'    
                                    {$and}";
                                    $valorBaixaMes = $conexao->comandoArray($sql);
                                    if (isset($valorBaixaMes["valor"]) && $valorBaixaMes["valor"] != NULL && $valorBaixaMes["valor"] > 0) {
                                        echo '<h3><sup style="font-size: 20px">R$ </sup>', number_format($valorBaixaMes["valor"], 2, ",", "."), '</h3>';
                                    } else {
                                        echo '<h3><sup style="font-size: 20px">R$ </sup>0,00</h3>';
                                    }
                                    echo '<p>Produção mês</p>';
                                    ?>                                    
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="Baixa.php?procurar=1" class="small-box-footer">Mais informações <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <?php
                                    echo '<h3> R$ ', number_format(calculaMetaFuncionario(), 2, ',', '.'), '</h3>';
                                    echo '<p>Meta do dia</p>';
                                    ?>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="Pessoa.php?procurar=1" class="small-box-footer">Mais informações <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3>
                                        <?php
                                        $res = medalhaFuncionario();
                                        if ($res != NULL && $res != "") {
                                            echo $res . "º";
                                        } else {
                                            echo "Veja";
                                        }
                                        ?>
                                    </h3>
                                    <p>Ranking Funcionários</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="Ranking.php" class="small-box-footer">Mais informações <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div><!-- ./col -->
                    </div><!-- /.row -->
                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <section class="col-lg-7 connectedSortable">
                            <!-- Custom tabs (Charts with tabs)-->
                            <div class="nav-tabs-custom">
                                <!-- Tabs within a box -->
                                <ul class="nav nav-tabs pull-right">
                                    <li><a href="#grafico_mes" data-toggle="tab">Mês X Meta</a></li>
                                    <li class="active"><a href="#sales-chart" data-toggle="tab">Dia X Meta</a></li>
                                    <li class="pull-left header"><i class="fa fa-inbox"></i> Produção X Meta</li>
                                </ul>
                                <div class="tab-content no-padding">
                                    <!-- Morris chart - Sales -->
                                    <div class="chart tab-pane" id="grafico_mes" style="width: 100%;height: 300px;"></div>
                                    <div class="chart tab-pane active" id="sales-chart" style="height: 300px;"></div>
                                </div>
                            </div><!-- /.nav-tabs-custom -->

                            <!-- Chat box -->
                            <div class="box box-success">
                                <div class="box-header">
                                    <i class="fa fa-comments-o"></i>
                                    <h3 class="box-title">Chat</h3>
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <!--<button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="" data-widget="chat-pane-toggle" data-original-title="Contacts"><i class="fa fa-comments"></i></button>-->
                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="box-body chat" id="chat-box">
                                    <?php
                                    $sql = "select 
                                        chat.*, pessoa.nome as enviador, pessoa.imagem as imagem_enviador, 
                                        DATE_FORMAT(chat.dtcadastro, '%d/%m/%Y %H:%i') as dtcadastro2,
                                        acesso.dtsaida
                                    from  chat 
                                    inner join pessoa on pessoa.codpessoa = chat.codpessoa1 
                                    inner join acesso on acesso.codpessoa = chat.codpessoa2 and acesso.codempresa = chat.codempresa
                                    where chat.codempresa = '{$_SESSION["codempresa"]}' 
                                    and   chat.codpessoa2 = '{$_SESSION["codpessoa"]}'
                                    and   acesso.codacesso = (select codacesso from acesso where codempresa = {$_SESSION["codempresa"]} and codpessoa = {$_SESSION["codpessoa"]} order by codacesso desc limit 1)    
                                    order by chat.dtcadastro desc";
                                    $reschat = $conexao->comando($sql);
                                    $qtdchat = $conexao->qtdResultado($reschat);
                                    if ($qtdchat > 0) {
                                        while ($chat = $conexao->resultadoArray($reschat)) {
                                            if ($chat["dtsaida"] == '0000-00-00 00:00:00') {
                                                $classe_chat = 'online';
                                            } else {
                                                $classe_chat = 'offline';
                                            }
                                            ?>
                                            <!-- chat item -->
                                            <div class="item">
                                                <?php if (isset($chat["imagem_enviador"]) && $chat["imagem_enviador"] != NULL && trim($chat["imagem_enviador"]) != "" && file_exists('/arquivos/' . $chat["imagem_enviador"])) { ?>
                                                    <img src="/arquivos/<?= $chat["imagem_enviador"] ?>" alt="user image" class="<?= $classe_chat ?>">
                                                <?php } else { ?>
                                                    <img src="/visao/recursos/img/sem_imagem.png" alt="user image" class="<?= $classe_chat ?>">
                                                <?php } ?>
                                                <p class="message" codpessoa="<?= $chat["codpessoa1"] ?>">
                                                    <a href="#" class="name">
                                                        <small class="text-muted pull-right"><i class="fa fa-clock-o"></i><?= $chat["dtcadastro2"] ?></small>
                                                        <?= $chat["enviador"] ?>
                                                    </a>
                                                    <?= $chat["texto"] ?>
                                                </p>
                                            </div><!-- /.item -->
                                            <?php
                                        }
                                    }
                                    ?>

                                </div><!-- /.chat -->
                                <div class="box-footer">
                                    <div class="input-group">
                                        <input type='hidden' name="name" id="name" value="<?=$_SESSION["nome"]?>"/>
                                        <input class="form-control" id="message" name="message" placeholder="Digite mensagem...">
                                        <div class="input-group-btn">
                                            <button class="btn btn-success" id="send-btn"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /.box (chat box) -->

                            <!-- TO DO List -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title">Agendamentos do dia (CallCenter)</h3>
                                    <!--                                    <div class="box-tools pull-right">
                                                                            <ul class="pagination pagination-sm inline">
                                                                                <li><a href="#">&laquo;</a></li>
                                                                                <li><a href="#">1</a></li>
                                                                                <li><a href="#">2</a></li>
                                                                                <li><a href="#">3</a></li>
                                                                                <li><a href="#">&raquo;</a></li>
                                                                            </ul>
                                                                        </div>-->
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <ul class="todo-list">
                                        <?php
                                        
                                        if ($_SESSION["codnivel"] == '16') {
                                            $and = " and codfuncionario = {$_SESSION["codpessoa"]}";
                                        }
                                        $sql = "select agenda.codagenda, cliente.nome, DATE_FORMAT(dtagenda, '%d/%m/%Y') as dtagenda2, cliente.codpessoa 
                                            from agenda 
                                            inner join pessoa as cliente on cliente.codpessoa = agenda.codpessoa and cliente.codempresa = agenda.codempresa
                                            left join pessoa as funcionario on funcionario.codpessoa = agenda.codfuncionario
                                            left join statuspessoa as status on status.codstatus = cliente.codstatus  
                                            where agenda.codempresa = '{$_SESSION['codempresa']}' and funcionario.status <> 'i'
                                            and agenda.codstatus not in (1,2,6,8,13)    
                                            and dtagenda >= '" . date('Y-m-d') . " 00:00:00' and dtagenda <= '" . date('Y-m-d') . " 23:59:01'    
                                            and cliente.codstatus <> '1' and cliente.codcategoria = '6' and agenda.atendido = 'n' {$and} order by agenda.codagenda desc limit 10";
                                            
                                        $resagenda = $conexao->comando($sql);
                                        $qtdagenda = $conexao->qtdResultado($resagenda);
                                        if ($qtdagenda > 0) {
                                            while ($agenda = $conexao->resultadoArray($resagenda)) {
                                                ?>
                                                <li>
                                                    <!-- drag handle -->
                                                    <span class="handle">
                                                        <i class="fa fa-ellipsis-v"></i>
                                                        <i class="fa fa-ellipsis-v"></i>
                                                    </span>
                                                    <!-- checkbox -->
                                                    <input type="checkbox" value="" name="">
                                                    <!-- todo text -->
                                                    <span class="text">
                                                        <a title="Agendamento de callcenter para <?= $agenda["nome"] ?>" href="/Cliente.php?callcenter=true&codpessoa=<?= $agenda["codpessoa"] ?>">
                                                            <?= $agenda["nome"] ?>
                                                        </a>
                                                    </span>
                                                    <!-- Emphasis label -->
                                                    <?php if (date("Y-m-d") == $agenda["dtagenda"]) { ?>
                                                        <small class="label label-danger"><i class="fa fa-clock-o"></i><?= $agenda["dtagenda2"] ?></small>
                                                    <?php } else { ?>
                                                        <small class="label label-default"><i class="fa fa-clock-o"></i><?= $agenda["dtagenda2"] ?></small>
                                                    <?php } ?>
                                                    <!-- General tools such as edit or delete-->
                                                    <div class="tools">
                                                        <i class="fa fa-edit" title="Edite a data do agendamento"></i>
                                                        <i class="fa fa-trash-o" title="Exclua o agendamento" onclick="excluir2Agenda(<?= $agenda["codagenda"] ?>)"></i>
                                                    </div>
                                                </li>
                                                <?php
                                            }
                                        }
                                        ?>

                                    </ul>
                                </div><!-- /.box-body -->
                                <div class="box-footer clearfix no-border">
                                    <button class="btn btn-default pull-right"><i class="fa fa-plus"></i> Adicionar</button>
                                </div>
                            </div><!-- /.box -->

                            <!-- quick email widget -->
                            <div class="box box-info">
                                <div class="box-header">
                                    <i class="fa fa-envelope"></i>
                                    <h3 class="box-title">Consulta Viper</h3>
                                    <!-- tools box -->
                                    <div class="pull-right box-tools">
                                        <button class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                                    </div><!-- /. tools -->
                                </div>
                                <div class="box-body">
                                    <form action="#" method="post">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="cpf" id="cpf" placeholder="Digite CPF">
                                        </div>
                                        <div class="form-group">
                                            <input type='text' class="form-control" name="beneficio" id="beneficio" placeholder="Digite Beneficio">
                                        </div>
                                    </form>
                                </div>
                                <div class="box-footer clearfix">
                                    <button class="pull-right btn btn-default" id="sendEmail" onclick="javascript: consultaCpfBeneficio()">Consultar <i class="fa fa-arrow-circle-right"></i></button>
                                </div>
                            </div>

                        </section><!-- /.Left col -->
                        <section class="col-lg-5 connectedSortable">
                            <div class="box box-solid bg-teal-gradient">
                                <div class="box-header">
                                    <i class="fa fa-th"></i>
                                    <h3 class="box-title">Comunicados</h3>
                                    <?php
                                    $rescomunicado = $conexao->comando('select DATE_FORMAT(dtcadastro, "%d/%m/%Y") as dtcadastro2, nome, codcomunicado, arquivo from comunicado where codempresa = ' . $_SESSION["codempresa"]);
                                    $qtdcomunicado = $conexao->qtdResultado($rescomunicado);
                                    if ($qtdcomunicado > 0) {
                                        echo '<ul>';
                                        while ($comunicado = $conexao->resultadoArray($rescomunicado)) {
                                            echo '<li><a target="_blank" href="/arquivos/', $comunicado["arquivo"], '">', $comunicado["dtcadastro2"], ' - ', $comunicado["nome"], '</a></li>';
                                        }
                                        echo '</ul>';
                                    }
                                    ?>
                                    <div class="box-tools pull-right">
                                        <button class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button class="btn bg-teal btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="box-body border-radius-none">
                                    <div class="chart" id="line-chart" style="height: 250px;"></div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </section><!-- right col -->
                        <section class="col-lg-5 connectedSortable">
                            <div class="box box-solid bg-teal-gradient">
                                <div class="box-header">
                                    <i class="fa fa-th"></i>
                                    <h3 class="box-title">Roteiros</h3>
                                    <?php
                                    $reslink = $conexao->comando('select banco.nome, banco.codbanco from banco where codbanco in(select codbanco from manual)');
                                    $qtdlink = $conexao->qtdResultado($reslink);
                                    if ($qtdlink > 0) {
                                        echo '<ul>';
                                        while ($link = $conexao->resultadoArray($reslink)) {
                                            echo '<li>';
                                            echo $link["nome"];
                                            $reslink2 = $conexao->comando('select DATE_FORMAT(dtcadastro, "%d/%m/%Y") as dtcadastro2, nome, arquivo from manual 
                                                where codbanco = ' . $link["codbanco"] . ' and codempresa = ' . $_SESSION["codempresa"]);
                                            $qtdlink2 = $conexao->qtdResultado($reslink2);
                                            if ($qtdlink2 > 0) {
                                                echo '<ul>';
                                                while ($link2 = $conexao->resultadoArray($reslink2)) {
                                                    echo '<li><a target="_blank" href="/arquivos/', $link2["arquivo"], '">', $link2["dtcadastro2"], ' - ', $link2["nome"], '</a></li>';
                                                }
                                                echo '</ul>';
                                            }
                                            echo '</li>';
                                        }
                                        echo '</ul>';
                                    }
                                    ?>                                    
                                    <div class="box-tools pull-right">
                                        <button class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button class="btn bg-teal btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="box-body border-radius-none">
                                    <div class="chart" id="line-chart" style="height: 250px;"></div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </section><!-- right col -->
                        <section class="col-lg-5 connectedSortable">
                            <div class="box box-solid bg-teal-gradient">
                                <div class="box-header">
                                    <i class="fa fa-th"></i>
                                    <h3 class="box-title">Links</h3>
                                    <?php
                                    $sql = 'select DATE_FORMAT(dtcadastro, "%d/%m/%Y") as dtcadastro2, nome, link from link where codempresa = ' . $_SESSION["codempresa"] . ' order by nome';
                                    $reslink = $conexao->comando($sql);
                                    $qtdlink = $conexao->qtdResultado($reslink);
                                    if ($qtdlink > 0) {
                                        echo '<ul>';
                                        while ($link = $conexao->resultadoArray($reslink)) {
                                            echo '<li><a target="_blank" href="', $link["link"], '">', $link["dtcadastro2"], ' - ', $link["nome"], '</a></li>';
                                        }
                                        echo '</ul>';
                                    }
                                    ?>                                     
                                    <div class="box-tools pull-right">
                                        <button class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button class="btn bg-teal btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="box-body border-radius-none">
                                    <div class="chart" id="line-chart" style="height: 250px;"></div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </section><!-- right col -->
                    </div><!-- /.row (main row) -->

                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->
            <?php include "footer.php"; ?>

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Create the tabs -->
                <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
                    <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
                    <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <!-- Home tab content -->
                    <div class="tab-pane" id="control-sidebar-home-tab">
                        <h3 class="control-sidebar-heading">Atividades recentes</h3>
                        <ul class="control-sidebar-menu">
                            <li>
                                <a href="javascript::;">
                                    <i class="menu-icon fa fa-birthday-cake bg-red"></i>
                                    <div class="menu-info">
                                        <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>
                                        <p>Will be 23 on April 24th</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript::;">
                                    <i class="menu-icon fa fa-user bg-yellow"></i>
                                    <div class="menu-info">
                                        <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>
                                        <p>New phone +1(800)555-1234</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript::;">
                                    <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>
                                    <div class="menu-info">
                                        <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>
                                        <p>nora@example.com</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript::;">
                                    <i class="menu-icon fa fa-file-code-o bg-green"></i>
                                    <div class="menu-info">
                                        <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>
                                        <p>Execution time 5 seconds</p>
                                    </div>
                                </a>
                            </li>
                        </ul><!-- /.control-sidebar-menu -->

                        <h3 class="control-sidebar-heading">Tasks Progress</h3>
                        <ul class="control-sidebar-menu">
                            <li>
                                <a href="javascript::;">
                                    <h4 class="control-sidebar-subheading">
                                        Custom Template Design
                                        <span class="label label-danger pull-right">70%</span>
                                    </h4>
                                    <div class="progress progress-xxs">
                                        <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript::;">
                                    <h4 class="control-sidebar-subheading">
                                        Update Resume
                                        <span class="label label-success pull-right">95%</span>
                                    </h4>
                                    <div class="progress progress-xxs">
                                        <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript::;">
                                    <h4 class="control-sidebar-subheading">
                                        Laravel Integration
                                        <span class="label label-warning pull-right">50%</span>
                                    </h4>
                                    <div class="progress progress-xxs">
                                        <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript::;">
                                    <h4 class="control-sidebar-subheading">
                                        Back End Framework
                                        <span class="label label-primary pull-right">68%</span>
                                    </h4>
                                    <div class="progress progress-xxs">
                                        <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                                    </div>
                                </a>
                            </li>
                        </ul><!-- /.control-sidebar-menu -->

                    </div><!-- /.tab-pane -->
                    <!-- Stats tab content -->
                    <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div><!-- /.tab-pane -->
                    <!-- Settings tab content -->
                    <div class="tab-pane" id="control-sidebar-settings-tab">
                        <form method="post">
                            <h3 class="control-sidebar-heading">General Settings</h3>
                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Report panel usage
                                    <input type="checkbox" class="pull-right" checked>
                                </label>
                                <p>
                                    Some information about this general settings option
                                </p>
                            </div><!-- /.form-group -->

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Allow mail redirect
                                    <input type="checkbox" class="pull-right" checked>
                                </label>
                                <p>
                                    Other sets of options are available
                                </p>
                            </div><!-- /.form-group -->

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Expose author name in posts
                                    <input type="checkbox" class="pull-right" checked>
                                </label>
                                <p>
                                    Allow the user to show his name in blog posts
                                </p>
                            </div><!-- /.form-group -->

                            <h3 class="control-sidebar-heading">Chat Configurações</h3>

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Ficar ativo no chat
                                    <input type="checkbox" class="pull-right" checked>
                                </label>
                            </div><!-- /.form-group -->

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Desativar notificações
                                    <input type="checkbox" class="pull-right">
                                </label>
                            </div><!-- /.form-group -->

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Apagar histórico do chat
                                    <a href="javascript::;" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
                                </label>
                            </div><!-- /.form-group -->
                        </form>
                    </div><!-- /.tab-pane -->
                </div>
            </aside><!-- /.control-sidebar -->
            <!-- Add the sidebar's background. This div must be placed
                 immediately after the control sidebar -->
            <div class="control-sidebar-bg"></div>
        </div><!-- ./wrapper -->

        <!-- jQuery 2.1.4 -->
        <script type="text/javascript" src="/visao/recursos/js/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="/visao/recursos/js/jquery.form.js"></script>
        <script src="/visao/recursos/js/instalador.js?<?=date("Ymdhis")?>"></script>

        <!-- jQuery UI 1.11.4 -->
        <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script> 

        <script src="/visao/recursos/js/tinybox.min.js"></script>
        <?php        
        if($pessoap["primeiroacesso"] === "s"){
                    ?>
            <script>
                function abreInstalador(){
                    TINY.box.show({url: '../visao/instalador/instalador1.php',width: 800, height: 400, opacity: 20, topsplit: 3});
                }
                abreInstalador();
            </script>

                    <?php
                }        
        ?>

        <script src="/visao/recursos/js/sweet-alert.min.js"></script>
        <script src="/visao/recursos/js/ajax/BeneficioCliente.js"></script>
        <script src="/visao/recursos/js/ajax/Agenda.js"></script>
        <script src="/visao/recursos/js/ajax/Comunicado.js"></script>
        <script src="/visao/recursos/js/chat.js"></script>
        <script src="dist/js/pages/dashboard.js?<?= date("YmdHis") ?>"></script>
        <script src="/visao/recursos/js/Geral.js"></script>
        
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
                                        $.widget.bridge('uibutton', $.ui.button);
        </script>
        <!-- Bootstrap 3.3.5 -->
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <!-- Morris.js charts -->
        <script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="plugins/morris/morris.min.js"></script>
        <!-- Sparkline -->
        <script src="plugins/sparkline/jquery.sparkline.min.js"></script>
        <!-- jvectormap -->
        <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
        <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
        <!-- jQuery Knob Chart -->
        <script src="plugins/knob/jquery.knob.js"></script>
        <!-- daterangepicker -->
        <script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
        <script src="plugins/daterangepicker/daterangepicker.js"></script>
        <!-- datepicker -->
        <script src="plugins/datepicker/bootstrap-datepicker.js"></script>
        <script src="plugins/datepicker/locales/bootstrap-datepicker.pt-BR.js"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
        <!-- Slimscroll -->
        <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <!-- FastClick -->
        <script src="plugins/fastclick/fastclick.min.js"></script>
        <!-- AdminLTE App -->
        <script src="dist/js/app.min.js"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->

        <!-- AdminLTE for demo purposes -->
        <script src="dist/js/demo.js"></script>

    </body>
</html>
<?php

function medalhaFuncionario() {
    global $conexao;
    $jaRecebeu = FALSE;
    $mes = date("m");
    $and = " and b2.dtcadastro >= '" . date("Y") . '-' . $mes . "-01'";
    $and .= " and b2.dtcadastro <= '" . date("Y") . '-' . $mes . "-30'";
    $sql = "select distinct pessoa.codpessoa, pessoa.codempresa, pessoa.nome, pessoa.imagem,
        (select sum(b1.valor) as valor from baixa as b1 where b1.codempresa = b2.codempresa and b1.codfuncionario = b2.codfuncionario and b1.dtcadastro = b2.dtcadastro) as total_produzido    
        from baixa as b2
        inner join pessoa on pessoa.codpessoa = b2.codfuncionario
        inner join empresa on empresa.codempresa = b2.codempresa
        where 1 = 1
        {$and} order by b2.valor desc";
    $res = $conexao->comando($sql);
    $qtd = $conexao->qtdResultado($res);
    $ranking = array();
    if ($qtd > 0) {
        $linhaIteracao = 0;
        while ($baixa = $conexao->resultadoArray($res)) {
            $sql = "select sum(b2.valor) as valor from baixa as b2 where b2.codfuncionario = '{$baixa["codpessoa"]}' {$and}";
            $total = $conexao->comandoArray($sql);
            $ranking[$linhaIteracao]["codempresa"] = $baixa["codempresa"];
            $ranking[$linhaIteracao]["nome"] = $baixa["nome"];
            $ranking[$linhaIteracao]["codfuncionario"] = $baixa["codpessoa"];
            $ranking[$linhaIteracao]["valor"] = $total["valor"];
            $ranking[$linhaIteracao]["imagem"] = $baixa["imagem"];
            $linhaIteracao++;
        }
    } else {
        echo '';
    }

    usort($ranking, "cmpValor");
    if ($ranking[0]["codfuncionario"] == $_SESSION['codpessoa']) {
        return 1;
    } elseif ($ranking[1]["codfuncionario"] == $_SESSION['codpessoa']) {
        return 2;
    } elseif ($ranking[2]["codfuncionario"] == $_SESSION['codpessoa']) {
        return 3;
    } elseif ($ranking[3]["codfuncionario"] == $_SESSION['codpessoa']) {
        return 4;
    } elseif ($ranking[4]["codfuncionario"] == $_SESSION['codpessoa']) {
        return 5;
    }
}

function cmpValor($a, $b) {
    if ($a["valor"] == $b["valor"]) {
        return 0;
    }
    return ($a["valor"] > $b["valor"]) ? -1 : 1;
}

function calculaMetaFuncionario() {
    global $conexao;
    /*     * pegando o valor total da meta do funcionário */
    if ($_SESSION["codnivel"] != 19) {
        $and = " and codfuncionario = {$_SESSION['codpessoa']}";
    }
    $sql = "select sum(valor) as valor from metafuncionario where codempresa = '{$_SESSION['codempresa']}' 
    and dtcadastro >= '" . date("Y-m-") . "01 00:00:00'    
    and dtcadastro <= '" . date("Y-m-") . "30 23:59:59'  {$and}          
    order by codmeta desc";

    $metaFuncionario = $conexao->comandoArray($sql);
    $diasUteis = 0;

    if (isset($metaFuncionario) && $metaFuncionario["valor"] != NULL && $metaFuncionario["valor"] != "") {

        /*         * somatório valor total vendido */
        $ontem = date('Y-m-d', strtotime("-1 days"));
        $baixaTotal = $conexao->comandoArray("select sum(valor) as valor from baixa 
        where codempresa = '{$_SESSION['codempresa']}' 
        and dtcadastro >= '" . date("Y-m-") . "01'    
        and dtcadastro <= '" . $ontem . " 23:59:59'    
        {$and}");

        $ultimo_dia = date("t", mktime(0, 0, 0, date("m"), '01', date("Y")));
        $dia_mes = date("Y-m-");
        $semana = array(
            'Sun' => 'domingo',
            'Mon' => 'segunda',
            'Tue' => 'terca',
            'Wed' => 'quarta',
            'Thu' => 'quinta',
            'Fri' => 'sexta',
            'Sat' => 'sabado'
        );
        for ($i = date("d"); $i <= $ultimo_dia; $i++) {
            if ($i < 10) {
                $dia_mes2 = "0" . $i;
            } else {
                $dia_mes2 = $i;
            }
            $data_selec = $dia_mes . $dia_mes2;
            $sql = "select * from dia where data = '{$data_selec}' and codempresa = '{$_SESSION['codempresa']}'";
            $dia_feriado = $conexao->comandoArray($sql);
            if (isset($dia_feriado) && $dia_feriado["data"] != NULL && $dia_feriado["data"] != "") {
                continue; //tira os feriados
            }

            $dia_semana = date("D", strtotime($data_selec));
//            $sql = "select * from horariofilial where codempresa = '{$_SESSION['codempresa']}' and dia = '{$semana[$dia_semana]}'";
//            $horarioFilial = $conexao->comandoArray($sql);
//            if (isset($horarioFilial["codhorario"]) && $horarioFilial["codhorario"] != NULL && $horarioFilial["codhorario"] != "") {
//                $diasUteis++;
//            }
            if ($semana[$dia_semana] == "segunda" || $semana[$dia_semana] == "terca" || $semana[$dia_semana] == "quarta" || $semana[$dia_semana] == "quinta" || $semana[$dia_semana] == "sexta") {
                $diasUteis++;
            }
        }

        if ($diasUteis == 0) {
            $resultadoFinal = 0;
        } elseif (isset($baixaTotal["valor"]) && $baixaTotal["valor"] != NULL && $baixaTotal["valor"] > 0) {
            $resultadoFinal = ($metaFuncionario["valor"] - $baixaTotal["valor"]) / $diasUteis;
        } else {
            $resultadoFinal = $metaFuncionario["valor"] / $diasUteis;
        }
    }
    return $resultadoFinal;
}
?>