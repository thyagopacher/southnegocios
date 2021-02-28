<form action="<?=$action?>" id="fservico" role="form" autocomplete="on" method="post">
    <table class="tabela_formulario">
        <input type="hidden" name="codservico" id="codservico"  value="<?php
        if (isset($servico["codservico"])) {
            echo $servico["codservico"];
        } else {
            echo "";
        }
        ?>"/>                                             
        <tr>
            <td style="width: 50px;">Nome</td>
            <td colspan="3">
                <input style="width: 565px;" type="text" list="servicos" required name="nome" id="nome" size="50" maxlength="250" placeholder="Digite seu nome aqui" value="<?php if (isset($servico["nome"])) {echo $servico["nome"];}?>"/>
            </td>
        <datalist id="servicos">
            <?php
            $resnome = $conexao->comando("select distinct nome from servico where codempresa = '{$_SESSION['codempresa']}'");
            $qtdnome = $conexao->qtdResultado($resnome);
            if ($qtdnome > 0) {
                while ($nome = $conexao->resultadoArray($resnome)) {
                    echo '<option>', $nome["nome"], '</option>';
                }
            }
            ?>
        </datalist>
        </tr>
        <tr>
            <td style="width: 50px;">Valor</td>
            <td style="width: 65px;">
                <input type="text" style='width: 207px;' name="valor" id="valor" class="real" size="18" required value="<?php
            if (isset($servico["valor"])) {echo number_format($servico["valor"], 2, ",", "");} else {echo "";}?>" title="valor da serviço" placeholder="valor da serviço"/>
            </td>
            <td style="width: 40px;">Data</td>
            <td>
                <input style="margin-left: -35px;" type="date" name="data" id="data" class="data" value="<?php if (isset($servico["data"])) {echo $servico["data"];}else{echo date('Y-m-d');}?>"/>
            </td>            
        </tr>

        <tr>
            <td>Imagem</td>
            <td colspan="2">
                <input type="file" name="imagem" id="imagem"/>
                <?php
                if(isset($servico["imagem"]) && $servico["imagem"] != NULL && $servico["imagem"] != ""
                    && (strstr($servico["imagem"], '.png') || strstr($servico["imagem"], '.jpg') || strstr($servico["imagem"], '.jpeg'))){
                    echo '<a target="_blank" href="../arquivos/',$servico["arquivo"],'"><img width="150" src="../arquivos/',$servico["imagem"],'" alt="Imagem da serviço"/></a>';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td>Bloco</td>
            <td>
                <select style="width: 212px;" name="bloco" id="pbloco">
                    <?php 
                    $sql      = "select distinct bloco from pessoa where codempresa = '{$_SESSION['codempresa']}' and status = 'a' and bloco <> '' and apartamento <> '' and codnivel <> '1' order by bloco";
                    $resbloco = $conexao->comando($sql);
                    $qtdbloco = $conexao->qtdResultado($resbloco);
                    if($qtdbloco > 0){
                        echo "<option value=''>--Selecione--</option>";
                        while($bloco = $conexao->resultadoArray($resbloco)){
                            if(isset($servico) && $servico["bloco"] == $bloco["bloco"]){
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
            <td>Apto</td>
            <td>
                <select style="width: 185px;margin-left: -35px;" name="apartamento" id="papartamento">
                    <?php 
                    $sql            = "select distinct apartamento from pessoa where codempresa = '{$_SESSION['codempresa']}' and status = 'a' and apartamento <> '' and bloco <> '' and codnivel <> '1' order by apartamento";
                    $resapartamento = $conexao->comando($sql);
                    $qtdapartamento = $conexao->qtdResultado($resapartamento);
                    if($qtdapartamento > 0){
                        echo "<option value=''>--Selecione--</option>";
                        while($apartamento = $conexao->resultadoArray($resapartamento)){
                            if(isset($servico) && $servico["apartamento"] == $apartamento["apartamento"]){
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
                <select style="width: 212px;" name="codmorador" id="pcodmorador">
                    
                    <?php
                    $respessoa = $conexao->comando("select codpessoa, nome from pessoa where codempresa = '{$_SESSION['codempresa']}' and status = 'a' and bloco <> '' and apartamento <> '' and codnivel <> '1'");
                    $qtdpessoa = $conexao->qtdResultado($respessoa);
                    if($qtdpessoa > 0){
                        echo '<option value="">--Selecione--</option>';
                        while($pessoa = $conexao->resultadoArray($respessoa)){
                            if(isset($servico) && $servico["codmorador"] == $pessoa["codpessoa"]){
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
            <td>Tipo</td>
            <td>
                <select style="width: 185px;margin-left: -35px;" name="codtipo" id="codtipo" required>
                    <?php
                    $sql = "select * from tiposervico where codempresa = '{$_SESSION['codempresa']}' order by nome";
                    $restipo = $conexao->comando($sql);
                    $qtdtipo = $conexao->qtdResultado($restipo);
                    if($qtdtipo > 0){
                        echo '<option value="">--Selecione--</option>';
                        while($tipo = $conexao->resultadoArray($restipo)){
                            echo '<option value="',$tipo["codtipo"],'">',$tipo["nome"],'</option>';
                        }
                    }else{
                        echo '<option value="">--Nada encontrado--</option>';
                    }
                    ?>
                </select>
            </td>
        </tr>
    </table>
        <?php
        if (!isset($_GET["codservico"]) || $_GET["codservico"] == NULL || $_GET["codservico"] == "") {
            if(isset($nivelp) && $nivelp["inserir"] == 1){
                echo '<input type="submit" name="submit" value="Cadastrar"/>';
            }
        } elseif (isset($_GET["codservico"])) {
            if(isset($nivelp) && $nivelp["atualizar"] == 1){
                echo '<input type="submit" name="submit" value="Atualizar"/>';
            }
            if(isset($nivelp) && $nivelp["excluir"] == 1){
                echo '<button style="margin-left: 10px;" onclick="excluirServico()">Excluir</button>';
            }
            echo '<button style="margin-left: 10px;" onclick="btNovoServico()">Novo</button>';
        }
        ?>    
</form>