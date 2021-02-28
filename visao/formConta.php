<form action="<?=$action?>" id="fconta" role="form" autocomplete="on" method="post">
    <table class="tabela_formulario">
        <input type="hidden" name="codconta" id="codconta"  value="<?php if (isset($conta["codconta"])) {echo $conta["codconta"];}?>"/>                       
        <input type="hidden" name="codstatus" id="codstatus"  value="<?php if (isset($conta["codstatus"]) && $conta["codstatus"] > 0) {echo $conta["codstatus"];}else{echo "2";}?>"/>     
        <?php if(!isset($_GET["master"])){?>
        <input type="hidden" name="movimentacao" id="movimentacao"  value="<?php if (isset($conta["movimentacao"])) {echo $conta["movimentacao"];} else { echo $_GET["movimentacao"];}?>"/> 
        <?php }?>
        <?php if(isset($_GET["master"]) && $_GET["master"] == true && $_SESSION["codnivel"] == 1){?>
        <tr>
            <td>Filial</td>
            <td>
                <select name="codfilial" id="filial">
                    <?php
                    $resempresa = $conexao->comando("select codempresa, razao from empresa where codempresa <> '{$_SESSION['codempresa']}' order by razao");
                    $qtdempresa = $conexao->qtdResultado($resempresa);
                    if($qtdempresa > 0){
                        echo '<option value="">--Selecione--</option>';
                        while($empresa = $conexao->resultadoArray($resempresa)){
                            if(isset($conta["codempresa"]) && $conta["codempresa"] != NULL && $conta["codempresa"] == $empresa["codempresa"]){
                                echo '<option selected value="',$empresa["codempresa"],'">',$empresa["razao"],'</option>';
                            }else{
                                echo '<option value="',$empresa["codempresa"],'">',$empresa["razao"],'</option>';
                            }
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
                    <option value="R" <?php if(isset($conta["movimentacao"]) && $conta["movimentacao"] == "R"){echo "selected";}?>>Receita</option>
                    <option value="D" <?php if(isset($conta["movimentacao"]) && $conta["movimentacao"] == "D"){echo "selected";}?>>Despesa</option>
                </select>
            </td>
        </tr>
        <?php }?>        
        <tr>
            <td style="width: 50px;">Nome</td>
            <td colspan="3">
                <input style="width: 590px;" type="text" list="contas" required name="nome" id="nome" size="50" maxlength="50" placeholder="Digite seu nome aqui" value="<?php if (isset($conta["nome"])) {echo $conta["nome"];}?>"/>
                <datalist id="contas">
                    <?php
                    $resnome = $conexao->comando("select distinct nome from conta where codempresa = '{$_SESSION['codempresa']}'");
                    $qtdnome = $conexao->qtdResultado($resnome);
                    if ($qtdnome > 0) {
                        while ($nome = $conexao->resultadoArray($resnome)) {
                            echo '<option>', $nome["nome"], '</option>';
                        }
                    }
                    ?>
                </datalist>                
            </td>
        </tr>
        <tr>
            <td style="width: 50px;">Valor</td>
            <td style="width: 40px;">
                <input type="text" class="meio_input real" name="valor" id="valor" size="18" maxlength="9" required value="<?php if (isset($conta["valor"])) {echo number_format($conta["valor"], 2, ",", "");}?>" title="valor da conta" placeholder="valor da conta"/>
            </td>
            <td style="width: 155px;">Tipo</td>
            <td>
                <select style="width: 170px;" name="codtipo" id="codtipo" required title="Escolha aqui o tipo de sua conta">
                    <?php
                    if(isset($conta["codempresa"]) && isset($_GET["master"]) && $_GET["master"] == "true"){
                        $and = " and codempresa = '{$conta["codempresa"]}'";
                    }else{
                        $and = " and codempresa = '{$_SESSION['codempresa']}'";
                    }
                    $sql = "select * from tipoconta where 1 = 1 {$and} order by nome";
                    $restipo = $conexao->comando($sql);
                    $qtdtipo = $conexao->qtdResultado($restipo);
                    if ($qtdtipo > 0) {
                        echo '<option value="">--Selecione--</option>';
                        while ($tipo = $conexao->resultadoArray($restipo)) {
                            if (isset($conta["codtipo"]) && $conta["codtipo"] == $tipo["codtipo"]) {
                                echo '<option selected value="', $tipo["codtipo"], '">', $tipo["nome"], '</option>';
                            } else {
                                echo '<option value="', $tipo["codtipo"], '">', $tipo["nome"], '</option>';
                            }
                        }
                    } else {
                        echo '<option value="">Nada encontrado</option>';
                    }
                    ?>
                </select> 
            </td>
        </tr>
        <tr>
            <td style="width: 50px;">Vencimento</td>
            <td>
                <input style="width:220px;" type="text" required name="data" id="data" class="data" value="<?php if (isset($conta["data"])) {echo implode("/",array_reverse(explode("-",$conta["data"])));} else {echo date('d/m/Y');}?>"/>
            </td>
            <td>Dt. Pagamento</td>
            <td>
                <input style="width:165px;" type="text" name="dtpagamento" id="dtpagamento" class="data" value="<?php if (isset($conta["dtpagamento"]) && $conta["dtpagamento"] != NULL && $conta["dtpagamento2"] != "00/00/0000") {echo implode("/",array_reverse(explode("-",$conta["dtpagamento2"])));}?>"/>
            </td>       
        </tr>
        <tr>
            <td>Arquivo</td>
            <td colspan="3">
                <input type="file" multiple name="arquivo[]" id="arquivo"/>
                <a class="botao" href="javascript: abreTiraFotoConta(<?=$conta["codconta"]?>);">Foto da webcam</a>
                <?php
                if(isset($conta["arquivo"]) && $conta["arquivo"] != NULL && $conta["arquivo"] != ""
                    && (strstr($conta["arquivo"], '.png') || strstr($conta["arquivo"], '.jpg') || strstr($conta["arquivo"], '.jpeg'))){
                    echo '<a id="link_imagem" target="_blank" href="../arquivos/',$conta["arquivo"],'"><img width="150" src="../arquivos/',$conta["arquivo"],'" alt="Imagem da conta"/></a>';
                    
                }
                ?>
            </td>
        </tr>
        <?php if(isset($conta["codconta"]) && $conta["codconta"] != NULL && $conta["codconta"] != ""){?>
        <tr>
            <td>Arquivos anteriores</td>
            <td>
<?php
            $sql = "select * from arquivoconta where codconta = '{$conta["codconta"]}'";
            $resarquivo = $conexao->comando($sql);
            $qtdarquivo = $conexao->qtdResultado($resarquivo);
            if($qtdarquivo > 0){
                $linhaArquivo = 1;
                echo '<ul>';
                while($arquivo = $conexao->resultadoArray($resarquivo)){
                    echo '<li style="list-style-type: initial;">';
                    echo '<a target="_blank" href="../arquivos/',$arquivo["link"],'" title="Clique aqui para baixar arquivo">Arquivo ',$linhaArquivo,'</a>';
                    echo '<a title="Clique aqui para excluir arquivo da conta" href="javascript: excluir2ArquivoConta(',$arquivo["codarquivo"],')"><img width="20" src="/visao/recursos/img/excluir.png" alt="Excluir img da conta"/></a>';
                    echo '</li>';
                    $linhaArquivo++;
                }
                echo '</ul>';
            }
?>                
            </td>
        </tr>
        <?php }?>
        <tr>
            <td>Observação</td>
            <td colspan="3">
                <textarea style="margin: 0px; height: 110px; width: 590px;" name="observacao" id="observacao"><?php if(isset($conta["observacao"])){echo $conta["observacao"];}?></textarea>
            </td>
        </tr>
    </table>
        <?php
        
        if (!isset($conta["codconta"])) {
            if ($nivelp["inserir"] == 1) {
                echo '<input type="submit" name="submit" value="Cadastrar"/>';
            }
        } elseif (isset($conta["codconta"])) {
            if ($nivelp["atualizar"] == 1) {
                echo '<input type="submit" name="submit" value="Atualizar"/>';
            }
            if ($nivelp["excluir"] == 1) {
                echo '<button style="margin-left: 10px;" onclick="excluirConta()">Excluir</button>';
            }
            echo '<button style="margin-left: 10px;" onclick="btNovoConta()">Novo</button>';
        }
        ?>    
</form>