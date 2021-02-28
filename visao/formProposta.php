<form id="fproposta" action="../control/InserirProposta.php" method="POST">
    <input type="hidden" name="codcliente" id="codcliente" value="<?php if(isset($pessoa["codpessoa"])){echo $pessoa["codpessoa"];}?>"/>
    <input type="hidden" name="codproposta" id="codproposta"  value="<?php if (isset($proposta["codproposta"])) {echo $proposta["codproposta"];} ?>"/>                            
    <table class="tabela_formulario">
        <tr>
            <td>Nome <?=$pessoa["nome"]?></td>
            <td>CPF <?=$pessoa["cpf"]?></td>
            <td>
                <?php
                if(isset($_SESSION["codnivel"]) && ($_SESSION["codnivel"] == 1 || $_SESSION["codnivel"] == 18)){
                    echo 'Vendedor(a) <select name="codvendedor" id="codvendedor">';
                    $respessoa = $conexao->comando("select codpessoa, nome from pessoa where codempresa = '{$_SESSION['codempresa']}' and codcategoria not in(1,6) order by nome");
                    $qtdpessoa = $conexao->qtdResultado($respessoa);
                    if($qtdpessoa > 0){
                        echo '<option value="">--Selecione--</option>';
                        while($pessoa = $conexao->resultadoArray($respessoa)){
                            echo '<option value="',$pessoa["codpessoa"],'">',$pessoa["nome"],'</option>';
                        }
                    }
                    echo '</select>';
                }
                ?>
            </td>
        </tr>
        <tr>          
            <td>
                Código<br><input type="text" name="codbanco1" id="codbanco1" value="" title="Digite aqui para buscar o banco"/>
            </td>
            <td>
                Banco<br>
                <select name="codbanco" id="codbanco" required style="width: 230px;">
                    <?php
                    $resbanco = $conexao->comando("select * from banco where nome <> '' order by nome");
                    $qtdbanco = $conexao->qtdResultado($resbanco);
                    if ($qtdbanco > 0) {
                        echo '<option value="">--Selecione--</option>';
                        while ($banco = $conexao->resultadoArray($resbanco)) {
                            echo '<option value="', $banco["codbanco"], '">', $banco["nome"], '</option>';
                        }
                    } else {
                        echo '<option value="">--Nada encontrado--</option>';
                    }
                    ?>
                </select>
            </td>
            <td>
                Convênio<br>
                <select style="width: 178px;" name="codconvenio" id="codconvenio" required>
                    <?php
                    $resconvenio = $conexao->comando("select * from convenio where nome <> '' order by nome");
                    $qtdtconvenio = $conexao->qtdResultado($resconvenio);
                    if ($qtdtconvenio > 0) {
                        echo '<option value="">--Selecione--</option>';
                        while ($convenio = $conexao->resultadoArray($resconvenio)) {
                            if (isset($proposta) && $proposta["codconvenio"] != NULL && $proposta["codconvenio"] != "" && $convenio["codconvenio"] == $proposta["codconvenio"]) {
                                echo '<option selected value="', $convenio["codconvenio"], '">', $convenio["nome"], '</option>';
                            } else {
                                echo '<option value="', $convenio["codconvenio"], '">', $convenio["nome"], '</option>';
                            }
                        }
                    } else {
                        echo '<option value="">--Nada encontrado--</option>';
                    }
                    ?>
                </select>
            </td>     
        </tr>
        <tr>
           
            <td colspan="3">
                Tabela<br>
                <select name="codtabela" id="codtabela" required>
                    <?php
                    $restabela = $conexao->comando("select * from tabela where nome <> '' order by nome");
                    $qtdtabela = $conexao->qtdResultado($restabela);
                    if ($restabela > 0) {
                        echo '<option value="">--Selecione--</option>';
                        while ($tabela = $conexao->resultadoArray($restabela)) {
                            if (isset($proposta["codtabela"]) && $proposta["codtabela"] != NULL && $proposta["codtabela"] == $tabela["codtabela"]) {
                                echo '<option selected value="', $tabela["codtabela"], '">', $tabela["nome"], '</option>';
                            } else {
                                echo '<option value="', $tabela["codtabela"], '">', $tabela["nome"], '</option>';
                            }
                        }
                    } else {
                        echo '<option value="">--Nada encontrado--</option>';
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                Prazo<br>
                <input type="number" class="inteiro" name="prazo" id="prazo" required value="<?php if (isset($proposta["prazao"])) {echo $proposta["prazao"];} ?>"/>
            </td>  
            <td>
                Valor Proposta<br><input type="text" class="real" name="vlsolicitado" id="vlsolicitado" required value="<?php if (isset($proposta["vlsolicitado"])) {echo $proposta["vlsolicitado"];} ?>"/>
            </td>            
        </tr>
        <tr>
            <td>
                Valor Parcela<br><input type="text" class="real" name="vlparcela" id="vlparcela" value="<?php if (isset($proposta["vlparcela"])) {echo $proposta["vlparcela"];} ?>"/>
            </td>
            <td>
                Valor Liberado<br><input type="text" class="real" name="vlliberado" id="vlliberado" value="<?php if (isset($proposta["vlliberado"])) {echo $proposta["vlliberado"];} ?>"/>
            </td>
            <td>
                Num. Beneficio<br>
                <select style="width: 300px;" name="codbeneficio" id="codbeneficio">
                    <?php
                    $resbeneficio = $conexao->comando("select *, especie.nome as especie 
                    from beneficiocliente
                    inner join especie on especie.codespecie = beneficiocliente.codespecie
                    where beneficiocliente.codpessoa = '{$_GET["codpessoa"]}' and beneficiocliente.codempresa = '{$_SESSION['codempresa']}'");
                    $qtdbeneficio = $conexao->qtdResultado($resbeneficio);
                    if($qtdbeneficio > 0){
                        echo '<option value="">--Selecione--</option>';
                        while($beneficio = $conexao->resultadoArray($resbeneficio)){
                            if(isset($proposta["codbeneficio"]) && $proposta["codbeneficio"] != NULL && $proposta["codbeneficio"] == $beneficio["codbeneficio"]){
                                echo '<option selected value="',$beneficio["codbeneficio"],'">',$beneficio["numbeneficio"],' - ',$beneficio["especie"],'</option>';
                            }else{
                                echo '<option value="',$beneficio["codbeneficio"],'">',$beneficio["numbeneficio"],' - ',$beneficio["especie"],'</option>';
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
            <td>
                Código<br><input type="text" name="num_codbanco2" id="num_codbanco2" value="" title="Digite aqui para buscar o banco"/>
            </td>
            <td> 
                Banco para depósito<br>
                <select name="codbanco2" id="codbanco2" style="width: 230px;">
                    <?php
                    $resbanco = $conexao->comando("select * from banco where nome <> '' order by nome");
                    $qtdbanco = $conexao->qtdResultado($resbanco);
                    if ($qtdbanco > 0) {
                        echo '<option value="">--Selecione--</option>';
                        while ($banco = $conexao->resultadoArray($resbanco)) {
                            echo '<option value="', $banco["codbanco"], '">', $banco["nome"], '</option>';
                        }
                    } else {
                        echo '<option value="">--Nada encontrado--</option>';
                    }
                    ?>
                </select>
            </td>
            <td>
                Agência<br>
                <input type="text" style="width: 100px;" name="agencia" id="agencia" value="<?php if (isset($proposta["agencia"])) {echo $proposta["agencia"];} ?>"/>
            </td>
        </tr>
        <tr>
            <td>
                Conta<br>
                <input type="text" style="width: 100px;" name="conta" id="conta" value="<?php if (isset($proposta["conta"])) {echo $proposta["conta"];} ?>"/>
            </td>
            <td>
                Operação<br>
                <input type="text" style="width: 100px;" name="operacao" id="operacao" value="<?php if (isset($proposta["operacao"])) {echo $proposta["operacao"];} ?>"/>
            </td>
            <td>
                Poupança<br>
                <input type="checkbox" name="poupanca" id="poupanca" <?php if (isset($proposta["operacao"]) && $proposta["operacao"] == "s") {echo "checked";} ?> value="s"/>
            </td>
        </tr>
        <tr>
            <td>
                Dt. Venda<Br>
                <input type="date" style="width: 150px;" name="dtvenda" id="dtvenda" value="<?php if (isset($proposta["dtvenda"])) {echo $proposta["dtvenda"];} ?>"/>
            </td>
            <?php if($_SESSION["codnivel"] == 1 || $_SESSION["codnivel"] == 18){?>
            <td>
                Pendenciar Proposta<Br>
                <select name="pendente" id="pendente">
                    <option value=" ">--Selecione--</option>
                    <option value="s" <?php if (isset($proposta["pendente"]) && $proposta["pendente"] == "s") {echo "selected";} ?>>SIM</option>
                    <option value="n" <?php if (isset($proposta["pendente"]) && $proposta["pendente"] == "n") {echo "selected";} ?>>NÃO</option>
                </select>
            </td>
            <?php }?>
        </tr>
        <tr>
            <td colspan="4">
                Observação<br>
                <input type="text" style="width: 600px;" name="observacao" id="observacaoProposta" value="<?php if (isset($proposta["observacao"])) {echo $proposta["observacao"];} ?>"/>
            </td>            
        </tr>
        <tr id="status_proposta" style="<?php if(!isset($proposta["codproposta"])){echo "display: none";}?>">
            <td>
                Status<br>
                <select name="codstatus" id="codstatusProposta">
                    <?php
                    $resstatus = $conexao->comando("select * from statusproposta order by nome");
                    $qtdstatus = $conexao->qtdResultado($resstatus);
                    if($qtdstatus > 0){
                        echo '<option value="">--Selecione--</option>';
                        while($status = $conexao->resultadoArray($resstatus)){
                            echo '<option value="',$status["codstatus"],'">',$status["nome"],'</option>';
                        }
                    }else{
                        echo '<option value="">--Nada encontrado--</option>';
                    }
                    ?>
                </select>
            </td>
            <td>
                Dt. Pago<Br>
                <input type="date" style="width: 150px;" name="dtpago" id="dtpago" value="<?php if (isset($proposta["dtpago"])) {echo $proposta["dtpago"];} ?>"/>
            </td>            
        </tr>
        
        <?php 
        $resdocumento = $conexao->comando("select * from documento where codbanco = 0 order by nome");
        $qtddocumento = $conexao->qtdResultado($resdocumento);
        if($qtddocumento > 0){
            $linhaDocumento = 0;
            while($documento = $conexao->resultadoArray($resdocumento)){
                echo '<tr>';
                echo '<td>';
                $sql = "select nome, link from arquivopessoa where nome = 'documento{$documento["coddocumento"]}' and codpessoa = '{$_GET["codpessoa"]}' and codempresa = '{$_SESSION["codempresa"]}'";
                $arquivop = $conexao->comandoArray($sql);                
                if(isset($arquivop["nome"]) && $arquivop["nome"] != NULL && $arquivop["nome"] != ""){
                    $situacao = "OK";
                    $requiredPadrao = "";
                }else{
                    $situacao = ""; 
                    $requiredPadrao = "";
                }                   
                echo $documento["nome"],' - ',$situacao,'<br>';
                echo '<input type="file" name="arquivopessoa',$documento["coddocumento"],'" id="arquivopessoa',$documento["coddocumento"],'" title="Por favor insira o documento de ',$documento["nome"],'" ',$requiredPadrao,' id="arquivopessoa',$documento["nome"],'"/>';
                if(isset($arquivop["nome"]) && $arquivop["nome"] != NULL && $arquivop["nome"] != ""){
                    echo '<a href="../arquivos/',$arquivop["link"],'" target="_blank">';
                    echo '<img style="width: 20px;" src="../visao/recursos/img/download.png"/>';
                    echo 'Download arquivo';
                    echo '</a>';
                }
                $linhaDocumento++;
                echo '</td>';
                echo '</tr>';
            }
        }
        ?>
        
    </table>
    <div id="documentos_banco"></div>
    <?php
        if ($nivelp["inserir"] == 1) {
            echo '<input type="submit" name="submit" value="Cadastrar" id="btInserirProposta"/>';
        }        
        if ($nivelp["atualizar"] == 1) {
            echo '<input style="margin-left: 5px; display: none" type="submit" name="submit" id="btAtualizarProposta" value="Atualizar"/>';
        }
        if ($nivelp["excluir"] == 1) {
            echo '<button id="btExcluirProposta" style="margin-left: 5px; display: none" onclick="excluirProposta()">Excluir</button>';
        }
        echo '<button style="margin-left: 5px;" onclick="btNovoProposta()">Novo</button>';
    ?>
</form>
<form action="../control/FichaProposta.php" target="_blank" method="POST">
    <input type="hidden" name="codpessoa" value="<?php if(isset($_GET["codpessoa"])){echo $_GET["codpessoa"];}?>"/>
    <p>
        <input type="submit" name="Procurar"/>
    </p>
</form>
<div class="progress">
    <div class="bar"></div>
    <div class="percent">0%</div>
</div>
<div id="status"></div>

<div id="listagemProposta"></div>