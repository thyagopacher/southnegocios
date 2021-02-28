<form id="ftabelap" method="POST" onsubmit="return false;">
    <input type="hidden" name="codtabelap" id="codtabelap"  value="<?php if(isset($tabelap["codtabelap"])){echo $tabelap["codtabelap"];}else{ echo "";}?>"/>                            
<table class="tabela_formulario">
    <tr>
        <td>De</td>
        <td>
            <input type="number" min="0" max="999" name="prazode" id="prazode" value="<?php if(isset($tabelap["prazode"])){echo $tabelap["prazode"];}else{ echo "";}?>"/>
        </td>
        <td>Até</td>
        <td><input type="number" min="0" max="999" name="prazoate" id="prazoate" value="<?php if(isset($tabelap["prazoate"])){echo $tabelap["prazoate"];}else{ echo "";}?>"/></td>
    </tr>
    <tr>
        <td>Tabela</td>
        <td>
            <select style="width: 220px;" name="codtabela" id="codtabela">
                <?php
                $resBanco = $conexao->comando("select * from tabela where nome <> '' order by nome");
                $qtdBanco = $conexao->qtdResultado($resBanco);
                if($qtdBanco > 0){
                    echo '<option value="">--Selecione--</option>';
                    while($tabela = $conexao->resultadoArray($resBanco)){
                        echo '<option value="',$tabela["codtabela"],'">',$tabela["nome"],'</option>';
                    }
                }else{
                    echo '<option value="">--Nada encontrado--</option>';
                }
                ?>
            </select>
        </td>
        <td>Comissão</td>
        <td><input type="text" class="real" name="comissao" id="comissao" value="<?php if(isset($tabelap["comissao"])){echo $tabelap["comissao"];}else{ echo "";}?>"/></td>
    </tr>
</table>
        <?php
            if($nivelp["inserir"] == 1){
                echo '<input type="button" style="" name="submit" value="Cadastrar" id="btInserirTabelap" onclick="inserirTabelaPrazo();"/>';
            }            
            if($nivelp["atualizar"] == 1){
                echo '<input style="margin-left: 5px; display: none" type="button" name="submit" id="btAtualizarTabelap" value="Atualizar" onclick="atualizarTabelaPrazo();"/>';
            }
            if($nivelp["excluir"] == 1){
                echo '<button style="margin-left: 5px;display: none" id="btExcluirTabelap" onclick="excluirTabelaPrazo()">Excluir</button>';
            }
            echo '<button style="margin-left: 5px;" id="btnovoTabelap" onclick="btNovoTabelaPrazo()">Novo</button>';
        ?>
</form>

<div class="progress">
    <div class="bar"></div>
    <div class="percent">0%</div>
</div>
<div id="status"></div>
