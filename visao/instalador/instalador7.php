<?php
include '../../model/Conexao.php';
$conexao = new Conexao();
?>
<html>
    <head>
        <?php include 'head.php';?>
        <title>Configurações gerais</title>
    </head>
    <body>
        <div id="corpo">
            <div id="header">
                <h1>Instalar</h1>
                <img src="http://southnegocios.com/visao/recursos/img/170xNxlogo.png.pagespeed.ic.cUe1AI1RmP.png">
            </div>
            <div id="meio">
                <div class="row">
                    <form id="fconfiguracao" name="fconfiguracao" method="post">
                        <input type="hidden" name="codconfiguracao" id="codconfiguracao" value="<?= $configuracao["codconfiguracao"] ?>"/>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nome">Login SMS</label>
                                <input type="text" class="form-control" name="loginSMS" id="loginSMS" value="<?php if (isset($configuracao["loginSMS"])) {echo $configuracao["loginSMS"];} ?>"/>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="sexo">Senha SMS</label>
                                <input type="text" class="form-control" name="senhaSMS" id="senhaSMS" value="<?php if (isset($configuracao["senhaSMS"])) {echo $configuracao["senhaSMS"];} ?>"/>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="sexo">Msg. Inicio</label>
                                <input type="text" class="form-control" name="msg_inicio" id="msg_inicio" value="<?php if (isset($configuracao["msg_inicio"])) {echo $configuracao["msg_inicio"];} ?>"/>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="sexo">Login Viper(WS)</label>
                                <input type="text" class="form-control" name="loginViper" id="loginViper" value="<?php if (isset($configuracao["loginViper"])) {echo $configuracao["loginViper"];} ?>"/>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="sexo">Usuário MultiBR(WS)</label>
                                <input type="text" class="form-control" name="usuarioMultiBR" id="usuarioMultiBR" value="<?php if (isset($configuracao["usuarioMultiBR"])) {echo $configuracao["usuarioMultiBR"];} ?>"/>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="sexo">Senha MultiBR(WS)</label>
                                <input type="text" class="form-control" name="senhaMultiBR" id="senhaMultiBR" value="<?php if (isset($configuracao["senhaMultiBR"])) {echo $configuracao["senhaMultiBR"];} ?>"/>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="sexo">Key MultiBR(WS)</label>
                                <input type="text" class="form-control" name="keyMultiBR" id="keyMultiBR" value="<?php if (isset($configuracao["keyMultiBR"])) {echo $configuracao["keyMultiBR"];} ?>"/>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="sexo">Consulta de</label>
                                <select class="form-control" name="consultade" id="consultade" onchange="validaConsultade()">
                                    <option value="0" <?php if (isset($configuracao["consultade"]) && $configuracao["consultade"] == '0') {echo 'selected';} ?>>VIPER</option>
                                    <option value="1" <?php if (isset($configuracao["consultade"]) && $configuracao["consultade"] == '1') {echo 'selected';} ?>>MultiBR</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="button" name="submit" value="Salvar" class="btn btn-primary" onclick="salvarConfiguracao()"/>
                            </div>                                        
                        </div>
                    </form>
                </div>
                
            </div> 

            <div id="rodape">
 
                <input type ="button" value="Fechar" class="botao_rodape" onclick="fecharJanela()">
                <input type='button' value='Voltar' class='botao_rodape' onclick="pulaPagina(6)">
            </div>                   
        </div>
    </body>
    <?php include './javascriptFinal.php';?>
</html>

