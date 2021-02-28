<?php
include '../../model/Conexao.php';
$conexao = new Conexao();
?>
<html>
    <head>
        <?php include 'head.php'; ?>
        <title>SMS padrão</title>
    </head>
    <body>
        <div id="corpo">
            <div id="header">
                <h1>SMS Padrão</h1>
                <img src="http://southnegocios.com/visao/recursos/img/170xNxlogo.png.pagespeed.ic.cUe1AI1RmP.png">
            </div>
            <div id="meio">
                <div id="sms">
                    <div class="row">
                        <form name="fsmspadrao" id="fsmspadrao" method="post">
                            <div class="col-md-12">
                                <label for="nome">Nome</label>
                                <input type="text" name="nome" id="nome" maxlength="250" class="form-control" placeholder="Digite o nome">
                            </div>
                            <div class="col-md-12">
                                <label for="nome">Mensagem</label>
                                <textarea rows="4" cols="50" name="texto" class="form-control" placeholder="Digite aqui a mensagem do sms"></textarea>
                            </div>
                            <div class="col-md-12">
                                <input type="button" class="btn btn-primary" value="Salvar" onclick="inserirSmsPadrao()">
                            </div>                            
                        </form>
                        
                    </div>
                    <div style="margin: 0;" class="row">
                         <div id="listagemSmsPadrao" class="col-md-12" style="height: 95px;overflow: auto;">
                             
                         </div>
                    </div>
                </div>

            </div> 

            <div id="rodape">
                <input type="button" value="Próximo" class="botao_rodape" onclick="pulaPagina(5)">
                <input type='button' value='Voltar' class='botao_rodape' onclick="pulaPagina(3)">
            </div>                   
        </div>
    </body>
    <?php include './javascriptFinal.php'; ?>
</html>

