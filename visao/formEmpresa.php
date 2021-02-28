<script src="../visao/recursos/js/Endereco.js" type="text/javascript"></script>

<form id="fempresa" action="<?=$action?>" role="form" autocomplete="off" method="post" enctype="multipart/form-data">
    <table class="tabela_formulario">
    <input type="hidden" name="codempresa" id="codempresa"  value="<?php if(isset($_GET["codempresa"])){echo $_GET["codempresa"];}else{echo $_SESSION['codempresa'];} ?>"/>      
    <?php
    if (isset($_GET["codramo"]) && $_GET["codramo"] != NULL && $_GET["codramo"] != "") {
        echo '<input type="hidden" name="codramo" value="', $_GET["codramo"], '"/>';
    } else {
        echo '<tr>';
        echo '<td>Ramo</td>';
        echo '<td><select style="width: 230px;" id="codramo" name="codramo" required>';
        $res = $conexao->comando("select * from ramo order by nome");
        $qtd = $conexao->qtdResultado($res);
        if ($qtd > 0) {
            echo '<option value="">--Selecione--</option>';
            while ($ramo = $conexao->resultadoArray($res)) {
                if (isset($empresaf["codramo"]) && $empresaf["codramo"] == $ramo["codramo"]) {
                    echo '<option selected value="', $ramo["codramo"], '">', $ramo["nome"], '</option>';
                } else {
                    echo '<option value="', $ramo["codramo"], '">', strtoupper($ramo["nome"]), '</option>';
                }
            }
        } else {
            echo '<option value="">Nada encontrado</option>';
        }
        echo '</select></td>';
        echo '</tr>';
    }
    ?>
    <tr>
        <td>Razão</td>
        <td colspan="3">
            <input required style="width: 600px; max-width: 600px;"  type="text" required name="razao" id="razao" size="50" maxlength="250" placeholder="Digite seu nome aqui" value="<?php if (isset($empresaf["razao"])) {echo $empresaf["razao"];}?>">            
        </td>

    </tr>
    <?php if(isset($empresaf["codramo"]) && $empresaf["codramo"] == "6"){?>
    <tr>
        <td>CNPJ</td>
        <td>
            <input style="width: 225px;" type="text" name="cnpj" id="cnpj" value="<?php if (isset($empresaf["cnpj"])) {echo $empresaf["cnpj"];}?>"/>
        </td>
        <td>Fantasia</td>
        <td>
            <input style="width: 220px;" type="text" name="fantasia" id="fantasia" value="<?php if (isset($empresaf["fantasia"])) {echo $empresaf["fantasia"];}?>"/>
        </td>
    </tr>
    <?php }?>
    <tr>
        <td>Porcentagem</td>
        <td>
            <input class="real" style="width: 220px;" type="text" name="porcentagem" id="porcentagem" value="<?php if (isset($empresaf["porcentagem"])) {echo $empresaf["porcentagem"];}?>"/>
        </td>
        <td>CEP</td>
        <td>
            <input style="width: 225px;max-width: 225px;" class="cep" required type="text" name="cep" id="cep" value="<?php if (isset($empresaf["cep"])) {echo $empresaf["cep"];}?>" title="Digite aqui cep" placeholder="Digite CEP">            
        </td>
        
    </tr>
    <tr>
        <td>Tipo Logradouro</td>
        <td>
            <input style="width: 225px;max-width: 225px;" required type="text" name="tipologradouro" id="tipologradouro" value="<?php if (isset($empresaf["tipologradouro"])) {echo $empresaf["tipologradouro"];}?>" title="Digite aqui tipo logradouro" placeholder="rua, bairro, avenida, etc...">            
        </td>
        <td>Logradouro</td>
        <td>
            <input style="width: 225px;max-width: 225px;" required type="text" name="logradouro" id="logradouro" value="<?php if (isset($empresaf["logradouro"])) {echo $empresaf["logradouro"];}?>" title="Digite aqui logradouro" placeholder="Digite aqui logradouro">
        </td>
    </tr>
    <tr>
        <td>Número</td>
        <td>
            <input style="width: 225px;max-width: 225px;" required type="text" name="numero" id="numero" value="<?php if (isset($empresaf["numero"])) {echo $empresaf["numero"];}?>" title="Digite aqui numero" placeholder="Digite aqui numero">
        </td>
        <td>Bairro</td>
        <td>
            <input style="width: 225px;max-width: 225px;" required type="text" name="bairro" id="bairro" value="<?php if (isset($empresaf["bairro"])) {echo $empresaf["bairro"];} ?>" title="Digite aqui bairro" placeholder="Digite aqui bairro">
        </td>
    </tr>
    <tr>
        <td>Cidade</td>
        <td>
            <input style="width: 225px;max-width: 225px;" required type="text" name="cidade" id="cidade" value="<?php if (isset($empresaf["cidade"])) {echo $empresaf["cidade"];}?>" title="Digite aqui cidade" placeholder="Digite aqui cidade">
        </td>
        <td>Estado</td>
        <td>
            <input style="width: 225px;max-width: 225px;" required type="text" name="uf" id="uf" value="<?php if (isset($empresaf["uf"])) {echo $empresaf["uf"];}?>" title="Digite aqui estado" placeholder="Digite aqui estado">
        </td>
    </tr>
    <tr>
        <td>Telefone fixo</td>
        <td>
            <input style="width: 225px;max-width: 225px;" required type="text" name="telefone" id="telefone" class="telefone" value="<?php if (isset($empresaf["telefone"])) {
        echo $empresaf["telefone"];
    }?>" title="Digite aqui telefone fixo" placeholder="(00)0000-0000">
        </td>
        <td>Celular</td>
        <td>
            <input style="width: 225px;max-width: 225px;" required type="text" name="celular" id="celular" class="telefone" value="<?php if (isset($empresaf["celular"])) {echo $empresaf["celular"];}?>" title="Digite aqui celular" placeholder="(00)0000-0000">
        </td> 
    </tr>
    <tr>
        <td>E-mail</td>
        <td colspan="3">
            <input required livre="sim" style="width: 608px;max-width: 608px;"  autocomplete="off"  type="email" name='email' id="email" size="50" maxlength="250" value="<?php if (isset($empresaf["email"])) {echo $empresaf["email"];  }?>" title="Digite aqui e-mail" placeholder="aaa@aaa.com.br">
        </td>
    </tr>
    <tr>
        <td>Logo</td>
        <td colspan="3">
            <input type="file" name="logo" id="logo"/>
            <div id="imagemCarregada">
        <?php
        if (isset($empresaf["logo"]) && $empresaf["logo"] != NULL && $empresaf["logo"] != "") {
            echo '<img width="150" src="../arquivos/', $empresaf["logo"], '" alt="Logo da empresa" title="Logo da empresa"/>';
        }
        ?>         
            </div>            
        </td>
    </tr>
    <?php if(isset($_SESSION["codnivel"]) && $_SESSION["codnivel"] == 1){?>
    <tr>
        <td>Status</td>
        <td colspan="3">
            <select style="width: 230px;" name='codstatus' id='codstatus' required>
                <?php
                $resstatus = $conexao->comando("select * from statusempresa order by nome");
                $qtdstatus = $conexao->qtdResultado($resstatus);
                if($qtdstatus > 0){
                    echo '<option value="">--Selecione--</option>';
                    while($status = $conexao->resultadoArray($resstatus)){
                        if(isset($empresaf["codstatus"]) && $empresaf["codstatus"] == $status["codstatus"]){
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
    </tr>
    <?php }?>
    </table>
<?php 
    if (!isset($empresaf["codempresa"])) {
        if($nivelp["inserir"] == 1){
            echo '<input type="submit" name="submit" value="Cadastrar"/>';
        }
    } elseif (isset($empresaf["codempresa"])) { 
        if($nivelp["atualizar"] == 1){
            echo '<input style="margin-left: 10px;" type="submit" name="submit" value="Atualizar"/>';
        }
        if($nivelp["excluir"] == 1){
            echo '<button style="margin-left: 10px;" onclick="excluir()" name="btExcluir">Excluir</button>';
        }
        echo '<button style="margin-left: 10px;" onclick="btNovo()">Novo</button>';
    }
    ?>
    

</form>

<div class="progress">
    <div class="bar"></div>
    <div class="percent">0%</div>
</div>

<div id="status"></div>


