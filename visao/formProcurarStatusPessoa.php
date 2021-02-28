<form id="fpconta" action="../control/ProcurarContaRelatorio.php" target="_blank" role="form" class="form-horizontal form-groups-bordered" method="POST" onsubmit="return false;">
    <input type="hidden" name="movimentacao" id="movimentacao"  value="<?php if (isset($conta["movimentacao"])) {
    echo $conta["movimentacao"];
} else {
    echo $_GET["movimentacao"];
} ?>"/>                       
    <table class="tabela_formulario">
        <input type="hidden" name="master" id="master" value="<?=$_GET["master"]?>"/>
        <input type="hidden" name="html" id="html" value=""/>
        <input type="hidden" name="nome_pagina" id="nome_pagina" value="Relatório de Contas"/>
        <input type="hidden" name="tipo" id="tipo" value="pdf"/>
        <tr>
            <td style="width: 80px;">Nome</td>
            <td colspan="8"><input style="width: 580px;" type="text" name="nome" size="50" maxlength="250" placeholder="Digite nome aqui" value=""></td>
        </tr>
        <tr>
            <td style="width: 80px;">Dt. Inicio</td>
            <td style="width: 100px;"><input style="width: 200px;" type="text" class="data" name="data" value="<?php if(isset($_GET["data1"])){echo $_GET["data1"];}?>"/></td>
            <td style="width: 80px;">Dt. Fim</td>
            <td style="width: 100px;"><input style="width: 222px;" type="text" class="data" name="data2" value="<?php if(isset($_GET["data2"])){echo $_GET["data2"];}?>"/></td>
        </tr>
        <?php if(isset($_GET["master"]) && $_GET["master"] == true && $_SESSION["codnivel"] == 1){?>
        <tr>
            <td>Filial</td>
            <td>
                <select name="codempresa" id="filial2">
                    <?php
                    $resempresa = $conexao->comando("select codempresa, razao from empresa where codempresa <> '{$_SESSION['codempresa']}' order by razao");
                    $qtdempresa = $conexao->qtdResultado($resempresa);
                    if($qtdempresa > 0){
                        echo '<option value="">--Selecione--</option>';
                        while($empresa = $conexao->resultadoArray($resempresa)){
                            echo '<option value="',$empresa["codempresa"],'">',$empresa["razao"],'</option>';
                        }
                    }else{
                        echo '<option value="">--Nada encontrado--</option>';
                    }
                    ?>
                </select>
            </td>
            <td>Movimentação</td>
            <td>
                <select name="movimentacao" id="movimentacao">
                    <option value="">--Selecione--</option>
                    <option value="R">Receita</option>
                    <option value="D">Despesa</option>
                </select>
            </td>
        </tr>
        <?php }?>         
        <tr>
            <td>Tipo</td>
            <td>
                <select style="width: 205px;" name="codtipo" id="codtipo2" title="Escolha aqui o tipo de sua conta">
                    <?php
                    $restipo = $conexao->comando("select * from tipoconta where codempresa = '{$_SESSION['codempresa']}' order by nome");
                    $qtdtipo = $conexao->qtdResultado($restipo);
                    if ($qtdtipo > 0) {
                        echo '<option value="">--Selecione--</option>';
                        while ($tipo = $conexao->resultadoArray($restipo)) {
                            echo '<option value="', $tipo["codtipo"], '">', $tipo["nome"], '</option>';
                        }
                    } else {
                        echo '<option value="">Nada encontrado</option>';
                    }
                    ?>
                </select>                 
            </td>
            <td>Valor</td>
            <td>
                <input style="width: 222px" type="text" name="valor" id="valor" class="real" maxlength="6"/>
            </td>
        </tr>
        <tr>
            <td>Status</td>
            <td>
                <select style="width: 205px;" name="codstatus" id="codstatus">
                    <?php
                    $resstatus = $conexao->comando("select * from statusconta order by nome");
                    $qtdstatus = $conexao->qtdResultado($resstatus);
                    if($qtdstatus){
                        echo '<option value="">--Selecione--</option>';
                        while($status = $conexao->resultadoArray($resstatus)){
                            if(isset($_GET["codstatus"]) && $_GET["codstatus"] == $status["codstatus"]){
                                echo '<option selected value="',$status["codstatus"],'">',$status["nome"],'</option>';
                            }else{
                                echo '<option value="',$status["codstatus"],'">',$status["nome"],'</option>';
                            }
                        }
                    }else{
                        echo '<option value="">--Nada encontrado--</option>';
                    }
                    ?>
                </select>
            </td>
            <td>Ordem</td>
            <td>
                <select name="ordem" id="ordem">
                    <option value="1">Código</option>
                    <option value="2">Nome</option>
                </select>
            </td>
        </tr>
       
    </table>
    <button onclick="procurarConta(false)">Procurar</button>
    <?php
    if(isset($nivelp["gerapdf"]) && $nivelp["gerapdf"] == 1){
        echo '<button onclick="abreRelatorioConta()">Gera PDF</button> ';
    }
    if(isset($nivelp["geraexcel"]) && $nivelp["geraexcel"] == 1){
        echo '<button onclick="abreRelatorio2Conta()">Gera Excel</button>';
    }
    ?>
</form>
<?php include("./carregando.php");?>
<div id="listagem"></div>

<form action="Excel.php" method="post" target="_blank" id="fpconta2" name="fpconta2">
    <input type="hidden" name="nome_pagina" id="nome_pagina" value="Relatório de Contas"/>
    <input type="hidden" name="html" id="html2" value=""/>
</form>