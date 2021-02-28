<form id="fPtabela" action="../control/ProcurarTabelaRelatorio.php" target="_blank" role="form" class="form-horizontal form-groups-bordered" method="POST" onsubmit="return false;">                       
    <table class="tabela_formulario">
        <input type="hidden" name="html" id="html" value=""/>
        <input type="hidden" name="tipo" id="tipo" value="pdf"/>
        <input type="hidden" name="nome_pagina" id="nome_pagina" value="Relatório de Tabelas e perdidos"/>
        <tr>
            <td>Nome</td>
            <td colspan="8"><input style="width: 588px;" type="text" name="descricao" size="50" maxlength="250" placeholder="Digite descrição aqui" value=""></td>
        </tr>
        <tr>
            <td>Dt. Inicio</td>
            <td style="width: 300px;"><input type="date" name="data1"/></td>
            <td>Dt. Fim</td>
            <td><input type="date" name="data2"/></td>
        </tr>
        <tr>
            <td>Prazo de</td>
            <td style="width: 300px;"><input class="inteiro" type="text" name="prazode" id="prazode"/></td>
            <td>Prazo até</td>
            <td><input class="inteiro" type="text" name="prazoate" id="prazoate"/></td>
        </tr>
        <tr>
            <td>Cod. Banco</td>
            <td><input type="text" name="numbanco" id="numbanco"/></td>
            <td>Banco</td>
            <td>
                <select name="codbanco" id="codbancoProcurar">
                    <?php
                    $resbanco = $conexao->comando("select * from banco where nome <> '' order by nome");
                    $qtdbanco = $conexao->qtdResultado($resbanco);
                    if($qtdbanco > 0){
                        echo '<option value="">--Selecione--</option>';
                        while($banco = $conexao->resultadoArray($resbanco)){
                            echo '<option value="',$banco["numbanco"],'">',$banco["nome"],'</option>';
                        }
                    }else{
                        echo '<option value="">--Nada encontrado--</option>';
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Nivel</td>
            <td>
                <select name="codnivel" id="codnivel" <?php if($_SESSION["codnivel"] == 1){echo "title='Escolha aqui um nivel para verificar quais tabelas ele tem selecionadas'";}?>>
                    <?php
                        $resnivel = $conexao->comando("select * from nivel where codempresa = '{$_SESSION['codempresa']}'");
                        $qtdnivel = $conexao->qtdResultado($resnivel);
                        if($qtdnivel > 0){
                            echo '<option value="">--Selecione--</option>';
                            while($nivel = $conexao->resultadoArray($resnivel)){
                                echo '<option value="',$nivel["codnivel"],'">',$nivel["nome"],'</option>';
                            }
                        }else{
                            echo '<option value="">--Nada encontrado--</option>';
                        }
                    ?>                    
                </select>
            </td>
        </tr>
    </table>
    <button onclick="procurarTabela(false)">Procurar</button>
    <button onclick="abreRelatorioTabela()">Gera PDF</button>
    <button onclick="abreRelatorio2Tabela()">Gera Excel</button>
</form>
<?php if($_SESSION["codnivel"] == 1){?>
<form name="formAcaoMassa" id="formAcaoMassa" style="display: none" onsubmit="return false;">
    <h3 style="text-decoration: underline">Ações em massa</h3>
    <table class="tabela_formulario">
        <tr>
            <td>Perfil</td>
            <td>
                <select name="perfil" id="perfilTabela">
                    <?php
                        $resnivel = $conexao->comando("select * from nivel where codempresa = '{$_SESSION['codempresa']}'");
                        $qtdnivel = $conexao->qtdResultado($resnivel);
                        if($qtdnivel > 0){
                            echo '<option value="">--Selecione--</option>';
                            while($nivel = $conexao->resultadoArray($resnivel)){
                                echo '<option value="',$nivel["codnivel"],'">',$nivel["nome"],'</option>';
                            }
                        }else{
                            echo '<option value="">--Nada encontrado--</option>';
                        }
                    ?>
                </select>
            </td>
            <td><button id="btDeixarVisivelTabela">Deixar visivel</button></td>
        </tr>
        <tr>
            <td><input type="checkbox" id="tabela_selecao_tudo"/>Marcar/Desmarcar tudo</td>
        </tr>
    </table>
</form>
<?php }?>
<?php include("./carregando.php");?>
<form id="ftabelaNivel">
    <input type="hidden" name="codnivel" id="codnivelTabela"/>
    <div id="listagemTabela"></div>
</form>
