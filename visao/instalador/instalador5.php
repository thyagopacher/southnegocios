<?php
include '../../model/Conexao.php';
$conexao = new Conexao();
?>
<html>
    <head>
        <?php include 'head.php';?>
        <title>Cadastre links</title>
    </head>
    <body>
        <div id="corpo">
            <div id="header">
                <h1>Cadastro de links úteis</h1>
                <img src="http://southnegocios.com/visao/recursos/img/170xNxlogo.png.pagespeed.ic.cUe1AI1RmP.png">
            </div>
            <div id="meio">
                <div class="row">
                    <form name="flink" id="flink" method="post">
                        <div class="col-md-12">
                            <label for="banco" >Nome</label>
                            <input type="text" name="nome" id="nome" class="form-control" placeholder="Digite o nome">         
                        </div>                    
                        <div class="col-md-12">
                            <label for="banco" >Link</label>
                            <input type="url" name="link" id="link" class="form-control" placeholder="Digite o site">         
                        </div>  
                        <div class="col-md-12">
                            <input type="button" name="btInserirLink" class="btn btn-primary" value="Cadastrar" onclick="inserirLink()">                        
                        </div>                         
                    </form>
                </div>
                <div style="margin: 0;" class="row">
                    <div id="listagemLink" class="col-md-12" style="height: 140px;overflow: auto;">
                        
                    </div>
                </div>
            </div> 

            <div id="rodape">
                <input type="button" value="Próximo" class="botao_rodape" onclick="pulaPagina(6)">
                <input type='button' value='Voltar' class='botao_rodape' onclick="pulaPagina(4)">
            </div>                   
        </div>
    </body>
    <?php include './javascriptFinal.php';?>
    <script type="text/javascript" src="../recursos/js/jquery.form.min.js"></script>
</html>

