<?php
include '../../model/Conexao.php';
$conexao = new Conexao();
?>
<html>
    <head>
        <?php include 'head.php'; ?>
        <title>Atualizar informações empresa</title>
    </head>
    <body>
        <div id="corpo">
            <div id="header">
                <h1>Atualizar informações empresa</h1>
                <img src="http://southnegocios.com/visao/recursos/img/170xNxlogo.png.pagespeed.ic.cUe1AI1RmP.png">
            </div>
            <div id="meio">
                <div class="row">
                    <form name="fempresa" id="fempresa" method="post">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="estadocivil">Tel. Fixo</label>
                                <input type='text' class="form-control inteiro" name="telefone" id="telefone" placeholder="Digite telefone fixo" value='' onkeypress="validarInteiro('telefone')">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="estadocivil">Celular</label>
                                <input type='text' class="form-control" name="celular" id="celular" placeholder="Digite celular" value='' onkeypress="validarInteiro('celular')">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input type="email" class="form-control" name='email' id="email" placeholder="Digite e-mail" value=''>
                            </div>
                        </div>                        
                        <div class="col-md-12">
                            <input type="button" name="btCadastraRoteiro" class="btn btn-primary" value="Salvar" onclick="atualizarEmpresa();">                        
                        </div>                         
                    </form>

                </div>
            </div> 

            <div id="rodape">
                <input type="button" value="Próximo" class="botao_rodape" onclick="pulaPagina(4)">
                <input type='button' value='Voltar' class='botao_rodape' onclick="pulaPagina(2)">
            </div>                   
        </div>
    </body>
<?php include './javascriptFinal.php'; ?>
</html>

