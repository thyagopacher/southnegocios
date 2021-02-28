<form id="fcorrespondencia" role="form" autocomplete="off" class="form-horizorrespondencial form-groups-bordered" method="get" onsubmit="return false;">
    <input type="hidden" name="codcorrespondencia" id="codcorrespondencia"  value="<?php if(isset($correspondencia["codcorrespondencia"])){echo $correspondencia["codcorrespondencia"];}else { echo "";} ?>"/>                       
    <table class="tabela_formulario">
    <tr>
        <td>Tipo</td>
        <td>
            <select style="width: 150px;" name="codtipo" id="codtipo" required>
                <?php
                $sql = "select * from tipocorrespondencia where codempresa = '{$_SESSION['codempresa']}' order by nome";
                $res = $conexao->comando($sql);
                $qtd = $conexao->qtdResultado($res);
                if($qtd > 0){
                    echo '<option value="">--Selecione--</option>';
                    while($tipo = $conexao->resultadoArray($res)){
                        if(isset($correspondencia["codtipo"]) && $correspondencia["codtipo"] == $tipo["codtipo"]){
                            echo '<option selected value="',$tipo["codtipo"],'">',$tipo["nome"],'</option>';
                        }else{
                            echo '<option value="',$tipo["codtipo"],'">',$tipo["nome"],'</option>';
                        }
                    }
                }else{
                    echo '<option value="">Nada encontrado</option>';
                }
                ?>
            </select>
        </td> 
        <td style="width: 50px;">Data</td>
        <td><input style="width: 150px;margin-right: 20px;" max="<?=date('Y-m-d')?>"  type="date" name="data" id="data" class="data" required value="<?php if(isset($correspondencia["data"])){echo $correspondencia["data"];}else { echo date('Y-m-d');} ?>" title="Digite aqui data" placeholder="Digite aqui data"/></td>        
    </tr>
    <tr>
        <td>Remetente</td>
        <td colspan="3"><input type="text" style="width: 516px" list="remetentes" name="remetente" id="remetente" required size="50" maxlength="100" value="<?php if(isset($correspondencia["remetente"])){echo $correspondencia["remetente"];}else { echo "";} ?>"/></td>
        <datalist id="remetentes">
            <?php
            $resremetente = $conexao->comando("select distinct remetente from correspondencia where codempresa = '{$_SESSION['codempresa']}' order by remetente");
            $qtdremetente = $conexao->qtdResultado($resremetente);
            if($qtdremetente > 0){
                while($remetente = $conexao->resultadoArray($resremetente)){
                    echo '<option>',$remetente["remetente"],'</option>';
                }
            }
            ?>
        </datalist>
    </tr>
    <tr>
        <td>Bloco</td>
        <td>
            <select style="width: 150px;" name="bloco" id="bloco" class="campo_pequeno_select" required>
                <?php 
                $resbloco = $conexao->comando("select distinct bloco from pessoa where codempresa = '{$_SESSION['codempresa']}' and status = 'a' and bloco <> '' order by bloco");
                $qtdbloco = $conexao->qtdResultado($resbloco);
                if($qtdbloco > 0){
                    echo "<option value=''>--Selecione--</option>";
                    while($bloco = $conexao->resultadoArray($resbloco)){
                        if(isset($correspondencia["bloco"]) && $correspondencia["bloco"] == $bloco["bloco"]){
                            echo '<option selected>',$bloco["bloco"],'</option>';
                        }else{
                            echo '<option>',$bloco["bloco"],'</option>';
                        }
                    }
                }else{
                    echo "<option value=''>--Nada encontrado--</option>";
                }
                ?>
            </select> 
        </td>        
        <td style="width: 50px;">Apartamento</td>
        <td>
            <select style="width: 155px;" title="" name="apartamento" id="apartamento" class="campo_pequeno_select" required>
                <?php 
                $resapartamento = $conexao->comando("select distinct apartamento from pessoa where codempresa = '{$_SESSION['codempresa']}' and morador = 's' and apartamento <> '' and bloco <> '' order by apartamento");
                $qtdapartamento = $conexao->qtdResultado($resapartamento);
                if($qtdapartamento > 0){
                    echo "<option value=''>--Selecione--</option>";
                    while($apartamento = $conexao->resultadoArray($resapartamento)){
                        if(isset($correspondencia["apartamento"]) && $correspondencia["apartamento"] == $apartamento["apartamento"]){
                            echo '<option selected>',$apartamento["apartamento"],'</option>';
                        }else{
                            echo '<option>',$apartamento["apartamento"],'</option>';
                        }
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
        <td>
            <select style="width: 150px;" name="codmorador" id="codmorador" class="campo_pequeno_select" required  title="Escolha aqui o morador para quem vai a correspondência">
                <?php
                $respessoa = $conexao->comando("select * from pessoa where codempresa = '{$_SESSION['codempresa']}' and morador = 's' and apartamento <> '' and bloco <> ''");
                $qtdpessoa = $conexao->qtdResultado($respessoa);
                if($qtdpessoa > 0){
                    echo '<option value="">--Selecione--</option>';
                    while($pessoa = $conexao->resultadoArray($respessoa)){
                        if(isset($correspondencia["codmorador"]) && $correspondencia["codmorador"] == $pessoa["codpessoa"]){
                            echo '<option selected value="',$pessoa["codpessoa"],'">',$pessoa["nome"],'</option>';
                        }else{
                            echo '<option value="',$pessoa["codpessoa"],'">',$pessoa["nome"],'</option>';
                        }
                    }
                }else{
                    echo '<option value="">--Nada encontrado--</option>';
                }
                ?>
            </select>
        </td>
        <td>Chave</td>
        <td>
            <input type="text" style="width: 151px" name="chave" id="chave" size="10" maxlength="10" required value="<?php if(isset($correspondencia["chave"])){echo trim($correspondencia["chave"]);}else { echo "";} ?>"/>
        </td>        
    </tr>
    <tr>
        <td>Observação</td>
        <td colspan="3">
            <textarea style="max-width: 510px;min-width: 510px;" cols="50" rows="10" name="observacao" id="observacao" placeholder="Escreva aqui observações sobre a correspondência"><?php if(isset($correspondencia["observacao"])){echo trim($correspondencia["observacao"]);}else { echo "";} ?></textarea>
        </td>
    </tr>
    </table>
        <?php if (!isset($correspondencia["codcorrespondencia"])) {   
            if($nivelp["inserir"] == 1){
                echo '<button onclick="inserir()">Cadastrar</button>';
            }
        } elseif (isset($correspondencia["codcorrespondencia"])) {
            if($nivelp["atualizar"] == 1){
                echo '<button style="margin-left: 5px;" onclick="atualizar()" style="margin-left: 10px;">Atualizar</button>';
            }
            if($nivelp["excluir"] == 1){
                echo '<button style="margin-left: 5px;" onclick="excluir()" style="margin-left: 10px;">Excluir</button>';
            }
            echo '<button style="margin-left: 5px;" onclick="btNovo()" style="margin-left: 10px;">Novo</button>';
        } ?>    
</form>

<?php include("./carregando.php");?>
<div id="listagemMorador"></div>