<?php
include '../../model/Conexao.php';
$conexao = new Conexao();
?>
<html>
    <head>
        <?php include 'head.php'; ?>
        <title>Cadastre manuais</title>
    </head>
    <body>
        <div id="corpo">
            <div id="header">
                <h1>Cadastre manuais</h1>
                <img src="http://southnegocios.com/visao/recursos/img/170xNxlogo.png.pagespeed.ic.cUe1AI1RmP.png">
            </div>
            <div id="meio">
                <div class="row">
                    <form target="_blank" name="fManual" id="fManual" action="../../control/InserirManual.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="retorno_especial" id="retorno_especial" value="s"/>

                        <div class="col-md-6">
                            <label for="nome">Código Banco</label>
                            <input type='text' class="form-control" name="codbanco1" id="codbanco1" value="">
                        </div>

                        <div class="col-md-6">
                            <label for="statusPessoa">Banco</label>
                            <select class="form-control" name="codbanco" id="codbanco" title="Escolha aqui o banco para o manual" required>
                                <?php
                                $resbanco = $conexao->comando("select * from banco where nome <> '' order by nome");
                                $qtdbanco = $conexao->qtdResultado($resbanco);
                                if ($qtdbanco > 0) {
                                    echo '<option value="">--Selecione--</option>';
                                    while ($banco = $conexao->resultadoArray($resbanco)) {
                                        echo '<option value="', $banco["codbanco"], '">', $banco["nome"], '</option>';
                                    }
                                } else {
                                    echo '<option value="">--Nada encontrado--</option>';
                                }
                                ?>
                            </select>
                        </div>                        
                        <div class="col-md-6">
                            <label for="banco" >Nome</label>
                            <input type="text" name="nome" class="form-control" id="nome" placeholder="Digite o nome" required>         
                        </div>   
                        <div class="col-md-12">
                            <label for="banco" >Arquivo</label>
                            <input type="file" name="arquivo" class="form-control" required>         
                        </div>  
                        <div class="col-md-6">
                            <input type="submit" name="btImportaCliente" class="btn btn-primary" value="Cadastrar">                        
                        </div>                         
                    </form>
                </div>
            </div> 

            <div id="rodape">
                <input type="button" value="Próximo" class="botao_rodape" onclick="pulaPagina(7)">
                <input type='button' value='Voltar' class='botao_rodape' onclick="pulaPagina(5)">
            </div>                   
        </div>
    </body>
    <?php include './javascriptFinal.php'; ?>
    <script type="text/javascript" src="../recursos/js/jquery.form.min.js"></script>
</html>

