<form id="fclassificado" autocomplete="on" action="<?=$action?>" method="POST">
    <input type="hidden" name="ehMorador" id="ehMorador" value="<?php if(isset($ehMorador) && $ehMorador == true){echo "s";}?>"/>
    <input type="hidden" name="codclassificado" id="codclassificado"  value="<?php if(isset($classificado["codclassificado"])){echo $classificado["codclassificado"];}else { echo "";} ?>"/>                       
    <table class="tabela_formulario">

    <tr>
        <td>Título</td>
        <td colspan="3"><input type="text" style="width: 693px;" name="titulo" id="titulo" size="50" maxlength="25" value="<?php if(isset($classificado["titulo"])){echo $classificado["titulo"];}else { echo "";} ?>"/></td>
    </tr>
    <tr>
        <td>Arquivo</td>
        <td colspan="3">
            <input type="file" name="arquivo"/>
            <div id="imagemCarregada">
            <?php
            if(isset($classificado["arquivo"]) && $classificado["arquivo"] != NULL && $classificado["arquivo"] != ""){
                echo '<img width="150" src="../arquivos/',$classificado["arquivo"],'" alt="Imagem do classificado de condominio"/>';
            }
            ?>
            </div>
        </td>
    </tr>
    <tr>
        <td>Valor</td>
        <td colspan="3"><input type="text" style='width: 208px;' name="valor" id="valor" class="real" size="18" required value="<?php if (isset($classificado["valor"])) {echo number_format($classificado["valor"], 2, ",", "");}?>" title="valor do classificado" placeholder="valor da classificado"/></td>
    </tr>
    <?php if($ehMorador){?>
        <tr>
            <td>Bloco</td>
            <td style="width: 356px;">
                <select style="width: 212px;" name="bloco" id="pbloco">
                    <?php 
                    $sql      = "select distinct bloco from pessoa where codempresa = '{$_SESSION['codempresa']}' and status = 'a' and bloco <> '' and apartamento <> '' order by bloco";
                    $resbloco = $conexao->comando($sql);
                    $qtdbloco = $conexao->qtdResultado($resbloco);
                    if($qtdbloco > 0){
                        echo "<option value=''>--Selecione--</option>";
                        while($bloco = $conexao->resultadoArray($resbloco)){
                            echo '<option>',$bloco["bloco"],'</option>';
                        }
                    }else{
                        echo "<option value=''>--Nada encontrado--</option>";
                    }
                    ?>
                </select> 
            </td>
            <td>Apartamento</td>
            <td>
                <select style="width: 205px;" name="apartamento" id="papartamento">
                    <?php 
                    $sql            = "select distinct apartamento from pessoa where codempresa = '{$_SESSION['codempresa']}' and status = 'a' and apartamento <> '' and bloco <> '' order by apartamento";
                    $resapartamento = $conexao->comando($sql);
                    $qtdapartamento = $conexao->qtdResultado($resapartamento);
                    if($qtdapartamento > 0){
                        echo "<option value=''>--Selecione--</option>";
                        while($apartamento = $conexao->resultadoArray($resapartamento)){
                            echo '<option>',$apartamento["apartamento"],'</option>';
                        }
                    }else{
                        echo "<option value=''>--Nada encontrado--</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Morador</td>
            <td colspan="3">
                <select style="width: 212px;" name="codmorador" id="pcodmorador">
                    <option value="">--Selecione--</option>
                    <?php
                    $respessoa = $conexao->comando("select codpessoa, nome from pessoa where codempresa = '{$_SESSION['codempresa']}' and status = 'a' and bloco <> '' and apartamento <> ''");
                    $qtdpessoa = $conexao->qtdResultado($respessoa);
                    if($qtdpessoa > 0){
                        while($pessoa = $conexao->resultadoArray($respessoa)){
                            echo '<option value="',$pessoa["codpessoa"],'">',$pessoa["nome"],'</option>';
                        }
                    }else{
                        echo '<option value="">--Selecione--</option>';
                    }
                    ?>
                </select>                  
            </td>
        </tr>    
    <?php }?>
    <tr> 
        <td>Texto</td>
        <td colspan="3"><textarea name="texto" id="texto" class="texto" cols="50" rows="10"><?php if(isset($classificado["texto"])){echo $classificado["texto"];}else { echo "";} ?></textarea></td>
    </tr>
    <?php if(!isset($ehMorador) || $ehMorador != true){?>
    <tr>
        <td>Fornecedor</td>
        <td>
            <select name='codfornecedor' id='codfornecedor' required>
            <?php
            $sql = "select * from empresa where codramo <> '7' order by razao";
            $resfornecedor = $conexao->comando($sql);
            $qtdfornecedor = $conexao->qtdResultado($resfornecedor);
            if($qtdfornecedor > 0){
                echo '<option value="">--Selecione--</option>';
                while($fornecedor = $conexao->resultadoArray($resfornecedor)){
                    if(isset($classificado["codfornecedor"]) && $classificado["codfornecedor"] == $fornecedor["codempresa"]){
                        echo '<option selected value="',$fornecedor["codempresa"],'">',$fornecedor["razao"],'</option>';
                    }else{
                        echo '<option value="',$fornecedor["codempresa"],'">',$fornecedor["razao"],'</option>';
                    }
                }
            }else{
                echo '<option value="">--Nada encontrado--</option>';
            }
            ?>
            </select>    
        </td>
    </tr> 
    <tr>
        <td>Anunc. em</td>
        <td>
            <div style="height: 130px;overflow-y: auto;" id="condominios">
            <?php
            $res = $conexao->comando("select codempresa, razao from empresa where codramo = '7' order by razao");
            $qtd = $conexao->qtdResultado($res);
            if($qtd > 0){
                echo '<ul>';
                echo '<li><input type="checkbox" name="bt_marcar_todos" id="bt_marcar_todos"/>Marcar/Desmarcar todos</li>';
                while($condominio = $conexao->resultadoArray($res)){
                    $checkCondominio = "";
                    if(isset($_GET["codclassificado"]) && $_GET["codclassificado"] != NULL && $_GET["codclassificado"] != ""){
                        $sql = "select * from condominioclassificado as cc where cc.codcondominio = '{$condominio["codempresa"]}' and cc.codclassificado = '{$_GET["codclassificado"]}'";
                        $cc = $conexao->comandoArray($sql);
                        if(isset($cc) && $cc["codclassificado"] != NULL && $cc["codclassificado"] != ""){
                            $checkCondominio = "checked";
                        }
                    }
                    echo '<li><input ',$checkCondominio,' class="ch_condominio" type="checkbox" name="condominio[]" value="',$condominio["codempresa"],'"/>', $condominio["razao"], '</li>';
                }
                echo '</ul>';
            }else{
                echo '<ul><li>--Nada encontrado--</li></ul>';
            }
            ?>
            </div>
        </td>
    </tr>
    <?php }?>    
    </table>
    <?php 
    if (!isset($classificado["codclassificado"])) {    
        if($nivelp["inserir"] == 1){
            echo '<input type="submit" name="submit" value="Cadastrar"/>';
        }
    } elseif (isset($classificado["codclassificado"])) {
        if($nivelp["atualizar"] == 1){
            echo '<input type="submit" name="submit" value="Atualizar"/>';
        }
        if($nivelp["excluir"] == 1){
            echo '<button style="margin-left: 10px" onclick="excluir()">Excluir</button>';
        }
        echo '<button style="margin-left: 10px" onclick="btNovo()">Novo</button>';
    } 
    ?>
</form>