<form id="ftabela" autocomplete="on" role="form" action="<?=$action?>" autocomplete="off" class="form-horizontal form-groups-bordered" method="POST">
    <input type="hidden" name="codtabela" id="codtabela"  value="<?php if(isset($tabela["codtabela"])){echo $tabela["codtabela"];}else{ echo "";}?>"/>                            
<table class="tabela_formulario">
    <tr>
        <td>Tabela</td>
        <td colspan="4"><input type="text" style="width: 600px;" name="nome" value="<?php if(isset($tabela["nome"])){echo $tabela["nome"];}?>"/></td>     
    </tr>
    <tr>
        <td>Código</td>
        <td style="width: 30px;">
            <input type="text" name="codbanco1" id="codbanco1" value=""/>
        </td>
        <td style="width: 10px;">Banco</td>
        <td style="width: 30px;">
            <select style="width: 150px;" name="codbanco" id="codbanco" required>
                <?php
                $resBanco = $conexao->comando("select * from banco where nome <> '' order by nome");
                $qtdBanco = $conexao->qtdResultado($resBanco);
                if($qtdBanco > 0){
                    echo '<option value="">--Selecione--</option>';
                    while($banco = $conexao->resultadoArray($resBanco)){
                        if(isset($tabela["codbanco"]) && $tabela["codbanco"] != NULL && $tabela["codbanco"] == $banco["codbanco"]){
                            echo '<option numero="',$banco["numbanco"],'" selected value="',$banco["codbanco"],'">',$banco["nome"],'</option>';
                        }else{
                            echo '<option numero="',$banco["numbanco"],'" value="',$banco["codbanco"],'">',$banco["nome"],'</option>';
                        }
                    }
                }else{
                    echo '<option value="">--Nada encontrado--</option>';
                }
                ?>
            </select>
        </td>
        <td style="width: 10px;">Convênio</td>
        <td style="margin-left: -90px;">
            <select name="codconvenio" id="codconvenio" required>
                <?php
                $resBanco = $conexao->comando("select * from convenio where nome <> '' order by nome");
                $qtdBanco = $conexao->qtdResultado($resBanco);
                if($qtdBanco > 0){
                    echo '<option value="">--Selecione--</option>';
                    while($convenio = $conexao->resultadoArray($resBanco)){
                        if(isset($tabela["codconvenio"]) && $tabela["codconvenio"] != NULL && $tabela["codconvenio"] == $convenio["codconvenio"]){
                            echo '<option selected value="',$convenio["codconvenio"],'">',$convenio["nome"],'</option>';
                        }else{
                            echo '<option value="',$convenio["codconvenio"],'">',$convenio["nome"],'</option>';
                        }
                    }
                }else{
                    echo '<option value="">--Nada encontrado--</option>';
                }
                ?>
            </select>
        </td>    
    </tr>
</table>
    <h4>Tabela X Prazo X Comissão</h4>
    <div id="tabela_prazo_comissao">
        <?php
        $sql = "select * from tabelaprazo where codtabela <> '' and codtabela <> '0' and codtabela = '{$tabela["codtabela"]}'";
        $restabelap = $conexao->comando($sql);
        $qtdtabelap = $conexao->qtdResultado($restabelap);
        if($qtdtabelap > 0){
            $linhaTabelaPrazo = 0;
            while($tabelap = $conexao->resultadoArray($restabelap)){
        ?>
                <div style="margin-top: 10px;" id="tabela_prazo_comissao<?=$linhaTabelaPrazo?>">
                    <table>
                        <tr>
                            <td style="width: 100px;">DT. INICIO <input style="width: 80px" type="date" name="dtinicio[]" id="dtinicio<?=$linhaTabelaPrazo?>" value="<?php if(isset($tabelap["dtinicio"])){echo $tabelap["dtinicio"];}else{ echo "";}?>"/></td>
                            <td style="width: 100px;">DT. FIM <input style="width: 80px" type="date" name="dtfim[]" id="dtfim<?=$linhaTabelaPrazo?>" value="<?php if(isset($tabelap["dtfim"])){echo $tabelap["dtfim"];}else{ echo "";}?>"/></td> 
                            <td style="width: 100px;">DE <input style="width: 80px" type="number" min="0" max="999" name="prazode[]" id="prazode<?=$linhaTabelaPrazo?>" value="<?php if(isset($tabelap["prazode"])){echo $tabelap["prazode"];}else{ echo "";}?>"/></td>
                            <td style="width: 100px;">ATÉ <input style="width: 80px" type="number" min="0" max="999" name="prazoate[]" id="prazoate<?=$linhaTabelaPrazo?>" value="<?php if(isset($tabelap["prazoate"])){echo $tabelap["prazoate"];}else{ echo "";}?>"/></td>
                            <td style="width: 100px;">COMISSÃO <input style="width: 80px" type="text" class="real" name="comissao[]" id="comissao<?=$linhaTabelaPrazo?>" value="<?php if(isset($tabelap["comissao"])){echo number_format($tabelap["comissao"], 2, ",", "");}else{ echo "";}?>"/></td>
                            <td style="width: 25px;"><a href="javascript: adicionarLinhaTabelaPrazo(<?=$linhaTabelaPrazo?>);" id="botao_adicionar_tabela_prazo<?=$linhaTabelaPrazo?>" class="botao" title="Adicionar nova linha">+</a></td>
                            <td style="width: 25px;"><a href="javascript: removerLinhaTabelaPrazo(<?=$linhaTabelaPrazo?>)" class="botao" title="Retirar linha">-</a></td>                            
                        </tr>
                        <tr>
                            <td style="width: 100px;">PARCEIRO<input style="width: 80px" type="text" name="parceiro[]" id="parceiro<?=$linhaTabelaPrazo?>" class="real" value="<?php if(isset($tabelap["parceiro"])){echo number_format($tabelap["parceiro"], 2, ",", "");}else{ echo "";}?>"/></td>
                            <td style="width: 100px;">BONUS<input style="width: 80px" type="text" name="bonus[]" id="bonus<?=$linhaTabelaPrazo?>" class="real" value="<?php if(isset($tabelap["bonus"])){echo number_format($tabelap["bonus"], 2, ",", "");}else{ echo "";}?>"/></td>
                            <td style="width: 100px;">SUPERVISOR<input style="width: 80px" type="text" name="supervisor[]" id="supervisor<?=$linhaTabelaPrazo?>" class="real" value="<?php if(isset($tabelap["supervisor"])){echo number_format($tabelap["supervisor"], 2, ",", "");}else{ echo "";}?>"/></td>
                            <td style="width: 100px;">VENDEDOR<input style="width: 80px" type="text" name="vendedor[]" id="vendedor<?=$linhaTabelaPrazo?>" class="real" value="<?php if(isset($tabelap["vendedor"])){echo number_format($tabelap["vendedor"], 2, ",", "");}else{ echo "";}?>"/></td>                               
                            <td style="width: 100px;">PESO<input style="width: 80px" type="text" name="peso[]" id="peso<?=$linhaTabelaPrazo?>" class="real" value="<?php if(isset($tabelap["peso"])){echo number_format($tabelap["peso"], 2, ",", "");}else{ echo "";}?>"/></td>                               
                        </tr>
                    </table>
                </div>
        <?php 
            $linhaTabelaPrazo++;
                }
            }else{
                echo '<div id="tabela_prazo_comissao0">';
                echo '<table>';
                echo '<tr>';
                echo '<td style="width: 100px;">DT. INICIO <input style="width: 80px" type="date" name="dtinicio[]" id="dtinicio0" value=""/></td>';
                echo '<td style="width: 100px;">DT. FIM <input style="width: 80px" type="date" name="dtfim[]" id="dtfim0" value=""/></td>';                
                echo '<td style="width: 100px;">DE <input style="width: 80px" type="number" min="0" max="999" name="prazode[]" id="prazode0" value=""/></td>';
                echo '<td style="width: 100px;">ATÉ <input style="width: 80px" type="number" min="0" max="999" name="prazoate[]" id="prazoate0" value=""/></td>';
                echo '<td style="width: 100px;">COMISSÃO <input style="width: 80px" type="text" class="real" name="comissao[]" id="comissao0" value=""/></td>';
                echo '<td style="width: 25px;"><a href="javascript: adicionarLinhaTabelaPrazo(0);" id="botao_adicionar_tabela_prazo0" class="botao" title="Adicionar nova linha">+</a></td>';
                echo '<td style="width: 25px;"><a href="javascript: removerLinhaTabelaPrazo(0)" class="botao" title="Retirar linha">-</a></td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td style="width: 100px;">PARCEIRO<input style="width: 80px" type="text" name="parceiro[]" id="parceiro0" class="real" value=""/></td>';
                echo '<td style="width: 100px;">BONUS<input style="width: 80px" type="text" name="bonus[]" id="bonus0" class="real" value=""/></td>';
                echo '<td style="width: 100px;">SUPERVISOR<input style="width: 80px" type="text" name="supervisor[]" id="supervisor0" class="real" value=""/></td>';
                echo '<td style="width: 100px;">VENDEDOR<input style="width: 80px" type="text" name="vendedor[]" id="vendedor0" class="real" value=""/></td>';
                echo '<td style="width: 100px;">PESO<input style="width: 80px" type="text" name="peso[]" id="peso0" class="real" value=""/></td>';
                echo '</tr>';
                echo '</table>';
                echo '</div>';
            }
            echo '</div>';
        
        echo '<br>';
        if (!isset($tabela["codtabela"])) {
            if($nivelp["inserir"] == 1){
                echo '<input type="submit" name="submit" value="Cadastrar"/>';
            }
        } elseif (isset($tabela["codtabela"])) {
            if($nivelp["atualizar"] == 1){
                echo '<input style="margin-left: 5px;" type="submit" name="submit" value="Atualizar"/>';
            }
            if($nivelp["excluir"] == 1){
                echo '<button style="margin-left: 5px;" onclick="excluirTabela()">Excluir</button>';
            }
            echo '<button style="margin-left: 5px;" onclick="btNovoTabela()">Novo</button>';
        } 
        ?>
</form>

<div class="progress">
    <div class="bar"></div>
    <div class="percent">0%</div>
</div>
<div id="status"></div>
