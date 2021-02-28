<?php

include '../../model/Conexao.php';
$conexao = new Conexao();

?>
<html>
    <head>
        <?php include 'head.php'; ?>
        <title>Escolha o plano</title>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">

        <div id="corpo">
            <div id="header">
                <h1>Bem vindo ao sistema South.</h1>
                <img src="http://southnegocios.com/visao/recursos/img/170xNxlogo.png.pagespeed.ic.cUe1AI1RmP.png">
            </div>
            <div id="meio">
                <div class="row">
                    <form name="fplano" id="fplano" method="post">
                        <div class="col-md-12">
                            <label for="plano">Selecione Plano:</label>
                            <select class="form-control" id="codplano" name="codplano" title="clique aqui e selecione seu plano">
                                <?php
                                $resultado = $conexao->comando('select * from plano order by nome');
                                $qtdres = $conexao->qtdResultado($resultado);
                                if ($qtdres > 0) {
                                    echo '<option value="">--Selecione--</option>';
                                    while ($resultado = $conexao->resultadoArray($resultado)) {
                                        echo '<option value="', $resultado["codplano"], '">', $resultado["nome"], '</option>';
                                    }
                                } else {
                                    echo '<option value="">--Nada encontrado--</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <input type="button" name="btSalvarPlano" class="btn btn-primary" value="Salvar" onclick="atualizarPlano()">                        
                        </div>   
                    </form>
                </div>


            </div> 

            <div id="rodape">
                <input type="button" value="Próximo" class="botao_rodape" onclick="pulaPagina(2)">
                <input type="button" value="Fechar" class="botao_rodape" onclick="fecharJanela()">
            </div>                   
        </div>                


    </body>
    <?php //include './javascriptFinal.php'; ?>
</html>

