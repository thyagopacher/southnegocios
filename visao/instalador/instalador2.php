<?php
include '../../model/Conexao.php';
$conexao = new Conexao();
?>
<html>
    <head>
        <?php include 'head.php'; ?>
        <title>Importe seus clientes</title>
    </head>
    <body>
        <div id="corpo">
            <div id="header">
                <h1>Importar Clientes</h1>
                <img src="http://southnegocios.com/visao/recursos/img/170xNxlogo.png.pagespeed.ic.cUe1AI1RmP.png">
            </div>
            <div id="meio">
                <div class="row">
                    <form target="_blank" name="fimportacaoClienteInstalador" id="fimportacaoClienteInstalador" action="../../control/Importacao.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="retorno_especial" id="retorno_especial" value="s"/>
                        <div class="col-md-6">
                            <label for="plano" >Nome carteira</label>
                            <input type="text" name="nome" class="form-control" placeholder="Digite nome da carteira">                        
                        </div>        
                        <div class="col-md-12">
                            <label for="plano" >Arquivo</label>
                            <input type="file" name="arquivo" id="arquivo" title="selecione arquivo para importar" class="form-control" >      
                            <img style="width: 30px;" src="http://southnegocios.com/visao/recursos/img/download.png"><a class="linkPlanilhaCliente" href="/arquivos/layout_de_importacao_29_06_2015.xls" target="_blank">Download planilha padrão</a>
                            <br>*Dependendo do número de linhas da planilha essa ação pode ser demorada, recomenda-se até 500 linhas para começar.
                        </div>   
                        <div class="col-md-6">
                            <input type="button" name="btImportaCliente" class="btn btn-primary" value="Importar" onclick="importarClientes();">                        
                        </div>                        
                    </form>
                </div>
            </div> 
            <div id="rodape">
                <input type="button" value="Próximo" class = "botao_rodape" onclick="pulaPagina(3)">
                <input type='button' value='Voltar' class="botao_rodape" onclick="pulaPagina(1)">
            </div>                   
        </div>
    </body>
    <?php // include './javascriptFinal.php'; ?>
    <!-- <script type="text/javascript" src="../recursos/js/jquery.form.min.js"></script> -->
</html>

