
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>South Sistemas | Ranking Funcionários</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="/sistema/bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="/sistema/dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="/visao/recursos/css/jquery-ui.min.css">
        <link rel="stylesheet" href="/visao/recursos/css/sweet-alert.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="/sistema/dist/css/skins/_all-skins.min.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
<?php
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('America/Sao_Paulo');
session_start();
include "../model/Conexao.php";
$conexao = new Conexao(); 
$sql = "select nivelpagina.*, pagina.nome as pagina, modulo.nome as modulo, pagina.link as pagina_link 
            from nivelpagina 
            inner join pagina on pagina.codpagina = nivelpagina.codpagina    
            inner join modulo on modulo.codmodulo = pagina.codmodulo
            where nivelpagina.codnivel = '{$_SESSION["codnivel"]}' {$andNivelPagina}";
$nivelp = $conexao->comandoArray($sql);
if (isset($_GET["codpessoa"]) && $_GET["codpessoa"] != NULL && trim($_GET["codpessoa"]) != "") {
    $pessoap = $conexao->comandoArray("select * from pessoa where codpessoa = '{$_GET["codpessoa"]}' and codempresa = '{$_SESSION['codempresa']}'");
    $action = "../control/AtualizarPessoa.php";
} else {
    $action = "../control/InserirCliente.php";
}
?>
            <?php include "header.php"; ?>
            <?php include "menu.php"; ?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>Ranking de Vendas</h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#"><?= $nivelp["modulo"] ?></a></li>
                        <li class="active"><?= $nivelp["pagina"] ?></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div id="tabs">
                        <ul>
                            <li><a href="#tabs-1">Procurar</a></li>
                        </ul>   
                        <div id="tabs-1">
                            <?php include("formProcurarRanking.php"); ?>
                        </div>
                        <span style="float: right; color: grey;width: 100%;text-align: right;">@ South Negócios</span>                            
                    </div>
                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->
            <?php include "footer.php"?>

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
                        <h3 class="control-sidebar-heading">Recent Activity</h3>
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

                            <h3 class="control-sidebar-heading">Chat Settings</h3>

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Show me as online
                                    <input type="checkbox" class="pull-right" checked>
                                </label>
                            </div><!-- /.form-group -->

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Turn off notifications
                                    <input type="checkbox" class="pull-right">
                                </label>
                            </div><!-- /.form-group -->

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Delete chat history
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

        <script type="text/javascript" src="/visao/recursos/js/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="/visao/recursos/js/jquery-ui.min.js"></script> 
        <script type="text/javascript" src="/visao/recursos/js/jquery.form.js"></script>
        <script type="text/javascript" src="../visao/recursos/js/ajax/Ranking.js"></script>
        <script type="text/javascript" src="/visao/recursos/js/jquery.maskedinput.min.js"></script>
        <!-- Bootstrap 3.3.5 -->
        <script src="/sistema/bootstrap/js/bootstrap.min.js"></script>
        <!-- FastClick -->
        <script src="/sistema/plugins/fastclick/fastclick.min.js"></script>
        <!-- AdminLTE App -->
        <script src="/sistema/dist/js/app.min.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="/sistema/dist/js/demo.js"></script>

        <script type="text/javascript" src="../visao/recursos/js/Geral.js"></script>
        <script type="text/javascript" src="../visao/recursos/js/sweet-alert.min.js"></script>
        <?php if(isset($_GET['procurar']) && $_GET['procurar'] != NULL && $_GET['procurar'] == "1"){?>
        <script>
            $("#tabs").tabs({
                active: 1
            });
            procurarPessoa2(true);
        </script>        
        <?php } ?>       
    </body>
</html>
