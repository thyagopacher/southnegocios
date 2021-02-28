<form id="fachado" autocomplete="on" role="form" action="<?=$action?>" autocomplete="off" class="form-horizontal form-groups-bordered" method="POST">
    <input type="hidden" name="codachado" id="codachado"  value="<?php if(isset($achado["codachado"])){echo $achado["codachado"];}else{ echo "";}?>"/>                            
<table class="tabela_formulario">
    <tr>
        <td>Data</td>
        <td style="width: 294px;"><input style="width: 175px" type="date" class="data" name="data" value="<?php if(isset($achado["data"])){echo $achado["data"];}else{ echo date('Y-m-d');}?>"/></td>
        <td>Tipo</td>
        <td>
            <select style="width: 178px;" name="codtipo" id="codtipo" required>
                <?php
                $restipo = $conexao->comando("select * from tipoachado where codempresa = '{$_SESSION['codempresa']}' order by nome");
                $qtdtipo = $conexao->qtdResultado($restipo);
                if($qtdtipo > 0){
                    echo '<option value="">--Selecione--</option>';
                    while($tipo = $conexao->resultadoArray($restipo)){
                        if(isset($achado) && $achado["codtipo"] != NULL && $achado["codtipo"] != "" && isset($tipo["codtipo"]) && $tipo["codtipo"] == $achado["codtipo"]){
                            echo '<option selected value="',$tipo["codtipo"],'">',$tipo["nome"],'</option>';
                        }else{
                            echo '<option value="',$tipo["codtipo"],'">',$tipo["nome"],'</option>';
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
        <td>Descrição</td>
        <td colspan="3"><input type="text" style="width: 545px;" required size="50" name="descricao" placeholder="Digite descrição aqui" value="<?php if(isset($achado["descricao"])){echo $achado["descricao"];}else{ echo "";}?>"></td>
    </tr>
    <tr>
        <td>Imagem</td>
        <td colspan="3">
            <input type="file" name="imagem" id="imagem"/>
            <div id="imagemCarregada">
                <?php
                    if(isset($achado["imagem"]) && $achado["imagem"] != NULL && $achado["imagem"] != ""){
                        if(file_exists("../arquivos/".$achado["imagem"])){
                            echo '<img width="150" src="../arquivos/',$achado["imagem"],'" alt="Imagem do achado ',$achado["descricao"],'"/>';
                        }else{
                            echo '<img width="150" src="../visao/recursos/img/sem_imagem.png"/>';
                        }
                    }
                ?>
            </div>
        </td>    
    </tr>
    <tr>
        <?php if(isset($_GET["codachado"])){?>
        <td>Status</td>
        <td>
            <select style="width: 175px;" name="codstatus" id="codstatus" required>
                <?php
                $resstatus = $conexao->comando("select * from statusachado order by nome");
                $qtd = $conexao->qtdResultado($resstatus);
                if($qtd > 0){
                    echo '<option value="">--Selecione--</option>';
                    while($status = $conexao->resultadoArray($resstatus)){
                        if(isset($achado["codstatus"]) && $achado["codstatus"] != NULL && $achado["codstatus"] == $status["codstatus"]){
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
         <?php }?>            
    </tr>
    <?php
    if(isset($achado["entreguep"]) && $achado["entreguep"] != NULL && $achado["entreguep"] != ""){
        $displayEntregue = "";
        if(isset($achado["entreguep"]) && $achado["entreguep"] == "m" && $achado["codpessoaentregue"] > 0){
            $displayMorador = "";
            $sql            = "select codpessoa, apartamento, bloco from pessoa where codempresa = '{$_SESSION['codempresa']}' and codpessoa = '{$achado["codpessoaentregue"]}' and apartamento <> '' and bloco <> ''";
            $morador        = $conexao->comandoArray($sql);
        }else{
            $displayMorador = "display: none";
        }
        if(isset($achado["entreguep"]) && $achado["entreguep"] == "v"){
            $displayVisitante = "";
            $sql = "select codvisitante from visitante where codempresa = '{$_SESSION['codempresa']}' and codvisitante = '{$achado["codpessoaentregue"]}'";
            $visitante2 = $conexao->comandoArray($sql);
        }else{
            $displayVisitante = "display: none";
        }
        if(isset($achado["entreguep"]) && $achado["entreguep"] == "f"){
            $funcionario = $conexao->comandoArray("select codpessoa from pessoa where codempresa = '{$_SESSION['codempresa']}' and codpessoa = '{$achado["codpessoaentregue"]}'");
        }else{
            $displayFuncionario = "display: none";
        }
    }else{
        $displayEntregue = "display: none";
        $displayMorador = "display: none";
        $displayVisitante = "display: none";
        $displayFuncionario = "display: none";
    }
    ?>
    <tr id="entregue1" style="<?=$displayEntregue?>">
        <td>Entregue para</td>
        <td>
            <select style="width: 175px;" name="entreguep" id="entreguep">
                <option value="">--Selecione--</option>
                <option value="m" <?php if(isset($achado["entreguep"]) && $achado["entreguep"] == "m" && $achado["codpessoaentregue"] > 0){echo "selected";}?>>Morador</option>
                <option value="v" <?php if(isset($achado["entreguep"]) && $achado["entreguep"] == "v" && $achado["codpessoaentregue"] > 0){echo "selected";}?>>Visitante</option>
                <option value="f" <?php if(isset($achado["entreguep"]) && $achado["entreguep"] == "f" && $achado["codpessoaentregue"] > 0){echo "selected";}?>>Funcionário</option>
            </select>
        </td>
    </tr>
    <tr id="morador1" style="<?=$displayMorador?>">
        <td>Bloco</td>
        <td>
            <select  style="width: 175px;" name="bloco" id="bloco">
                <?php 
                $resbloco = $conexao->comando("select distinct bloco from pessoa where codempresa = '{$_SESSION['codempresa']}' and status = 'a' and bloco <> '' and apartamento <> '' order by bloco");
                $qtdbloco = $conexao->qtdResultado($resbloco);
                if($qtdbloco > 0){
                    echo "<option value=''>--Selecione--</option>";
                    while($bloco = $conexao->resultadoArray($resbloco)){
                        if(isset($morador["bloco"]) && $morador["bloco"] == $bloco["bloco"]){
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
            <select  style="width: 175px;" name="apartamento" id="apartamento">
                <?php 
                $resapartamento = $conexao->comando("select distinct apartamento from pessoa where codempresa = '{$_SESSION['codempresa']}' and status = 'a' and bloco <> '' and apartamento <> '' order by apartamento");
                $qtdapartamento = $conexao->qtdResultado($resapartamento);
                if($qtdapartamento > 0){
                    echo "<option value=''>--Selecione--</option>";
                    while($apartamento = $conexao->resultadoArray($resapartamento)){
                        if(isset($morador["apartamento"]) && $morador["apartamento"] == $apartamento["apartamento"]){
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
    <tr id="morador2" style="<?=$displayMorador?>">
        <td>Morador</td>
        <td>
            <select style="width: 175px;" name="codmorador" id="codmorador" title="Escolha aqui o morador para quem vai entregar o achado">
                <?php
                $respessoa = $conexao->comando("select * from pessoa where codempresa = '{$_SESSION['codempresa']}' and status = 'a' and apartamento <> '' and bloco <> ''");
                $qtdpessoa = $conexao->qtdResultado($respessoa);
                if($qtdpessoa > 0){
                    echo '<option value="">--Selecione--</option>';
                    while($pessoa = $conexao->resultadoArray($respessoa)){
                        if(isset($morador) && $morador["codpessoa"] == $pessoa["codpessoa"]){
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
    </tr>
    <tr id="funcionario1" style="<?=$displayFuncionario?>">
        <td>Funcionário</td>
        <td>
            <select style="width: 175px;" name="codfuncionario" id="codfuncionario" title="Escolha aqui o funcionário">
                <?php
                $respessoa2 = $conexao->comando("select * from pessoa where codempresa = '{$_SESSION['codempresa']}' and status = 'a' and codnivel <> '3'");
                $qtdpessoa2 = $conexao->qtdResultado($respessoa2);
                if($qtdpessoa2 > 0){
                    echo '<option value="">--Selecione--</option>';
                    while($pessoa = $conexao->resultadoArray($respessoa2)){
                        if(isset($funcionario) && $funcionario["codpessoa"] == $pessoa["codpessoa"]){
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
    </tr>
    <tr id="visitante1" style="<?=$displayVisitante?>">
        <td>Visitante</td>
        <td>
            <select style="width: 175px;" name="codvisitante" id="codvisitante" title="Escolha aqui o visitante">
                <?php
                $sql = "select * from visitante where codempresa = '{$_SESSION['codempresa']}'";
                $resvisitante2 = $conexao->comando($sql);
                $qtdvisitante2 = $conexao->qtdResultado($resvisitante2);
                if($qtdvisitante2 > 0){
                    echo '<option value="">--Selecione--</option>';
                    while($visitante = $conexao->resultadoArray($resvisitante2)){
                        if(isset($visitante2) && $visitante2["codvisitante"] == $visitante["codvisitante"]){
                            echo '<option selected value="',$visitante["codvisitante"],'">',$visitante["nome"],'</option>';
                        }else{
                            echo '<option value="',$visitante["codvisitante"],'">',$visitante["nome"],'</option>';
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
        <td>Local</td>
        <td colspan="3">
            <input style="width: 170px;" type="text" name="local" id="local" required list="locais"/>
            <datalist id="locais">
                <?php
                $reslocal = $conexao->comando("select distinct local from achado where codempresa = '{$_SESSION['codempresa']}' order by local");
                $qtdlocal = $conexao->qtdResultado($reslocal);
                if($qtdlocal > 0){
                    while($local = $conexao->resultadoArray($reslocal)){
                        echo '<option>',$local["local"],'</option>';
                    }
                }
                ?>
            </datalist>
        </td>
    </tr>
</table>
        <?php
        if (!isset($achado["codachado"])) {
            if($nivelp["inserir"] == 1){
                echo '<input type="submit" name="submit" value="Cadastrar"/>';
            }
        } elseif (isset($achado["codachado"])) {
            if($nivelp["atualizar"] == 1){
                echo '<input style="margin-left: 5px;" type="submit" name="submit" value="Atualizar"/>';
            }
            if($nivelp["excluir"] == 1){
                echo '<button style="margin-left: 5px;" onclick="excluirAchado()">Excluir</button>';
            }
            echo '<button style="margin-left: 5px;" onclick="btNovoAchado()">Novo</button>';
        } 
        ?>
</form>

<div class="progress">
    <div class="bar"></div>
    <div class="percent">0%</div>
</div>
<div id="status"></div>
