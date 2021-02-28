<form id="fPpessoa" method="POST" target="_blank" action="../control/ProcurarPessoaRelatorio.php" onsubmit="return false;">
        <?php
        if(isset($_GET["callcenter"]) && $_GET["callcenter"] == "true"){
            echo '<input type="hidden" name="codcategoria" id="categoria" value="6"/>';
        }else{
            echo '<input type="hidden" name="codcategoria" id="categoria" value="1"/>';
        }
        ?>
    <input type="hidden" name="callcenter" id="callcenter" value="<?php if(isset($_GET["callcenter"])){echo "s";}?>"/>      
    <input type="hidden" name="tipo" id="tipo" value="pdf"/>
    <table class="tabela_formulario">
        <tr>
            <td style="width: 100px;">Dt. Inicio:</td>
            <td><input style="width: 205px;" type="date" class="data" name="data1" title="Data inicial de seu cadastro"/></td>
            <td>Dt. Fim:</td>
            <td><input style="width: 205px;" type="date" class="data" name="data2" title="Data final de seu cadastro" value="<?=date('Y-m-d')?>"/></td>
        </tr> 
        
        <tr>
            <td>Status:</td>
            <td style="width: 230px;">
                <select style="width: 210px;" name="status" id="status">
                    <option value="">Ambos</option>
                    <option value="a" <?php if(isset($_GET["status"]) && $_GET["status"] == "a"){echo "selected";}?>>Ativo</option>
                    <option value="i" <?php if(isset($_GET["status"]) && $_GET["status"] == "i"){echo "selected";}?>>Inativo</option>
                </select>
            </td>
            <td>E-mail:</td>
            <td>
                <input style="width: 208px;" type="email" name='email' id="email" maxlength="250"/>
            </td>
        </tr>
        <tr>
            <td>Ordem</td>
            <td>
                <select style="width: 210px;" name="ordem" id="ordem">
                    <option value="1">Nome</option>
                    <option value="2">Dt. Cadastro</option>
                </select>
            </td>
            <td>Carteira</td>
            <td>
                <select style="width: 215px;" name="carteira" id="carteira">
                    <?php
                    $rescarteira = $conexao->comando("select * from carteira where codempresa = '{$_SESSION['codempresa']}'");
                    $qtdcarteira = $conexao->qtdResultado($rescarteira);
                    if($qtdcarteira > 0){
                        echo '<option value="">--Selecione--</option>';
                        while($carteira = $conexao->resultadoArray($rescarteira)){
                            echo '<option value="',$carteira["codcarteira"],'">',$carteira["nome"],'</option>';
                        }
                    }else{
                        echo '<option value="">--Nada encontrado--</option>';
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Margem Inic.</td>
            <td><input class="real" style="width: 205px;" type="text" name="margem_inicial" id="margem_inicial" value=""/></td>
            <td>Margem Final</td>
            <td><input class="real" style="width: 210px;" type="text" name="margem_fim" id="margem_fim" value=""/></td>
        </tr>
        <tr>
            <td>C/Beneficio</td>
            <td>
                <select name="cbeneficio" id="cbeneeficio">
                    <option value="">--Selecione--</option>
                    <option value="s">SIM</option>
                    <option value="n">NÃO</option>
                </select>
            </td>
            <td>C/Empréstimo</td>
            <td>
                <select name="cemprestimo" id="cemprestimo">
                    <option value="">--Selecione--</option>
                    <option value="s">SIM</option>
                    <option value="n">NÃO</option>
                </select>                
            </td>
        </tr>
        <tr>
            <td>C/Telefone</td>
            <td>
                <select name="ctelefone" id="ctelefone">
                    <option value="">--Selecione--</option>
                    <option value="s">SIM</option>
                    <option value="n">NÃO</option>
                </select>
            </td>
            <td>C/Endereço</td>
            <td>
                <select name="cendereco" id="cendereco">
                    <option value="">--Selecione--</option>
                    <option value="s">SIM</option>
                    <option value="n">NÃO</option>
                </select>                
            </td>
        </tr>
        <?php if(isset($nivelp["codpagina"]) && ($nivelp["codpagina"] == 55 || $nivelp["codpagina"] == 58)){?>
        <tr>
            <td>Situação</td>
            <td>
                <select style="width: 210px;" name="codstatus" id="codstatus">
                    <?php
                    $resstatus = $conexao->comando("select * from statuspessoa order by nome");
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
            <td>CPF</td>
            <td><input style="width: 212px;" type="text" name="cpf" id="cpf" class="cpf" value="" title="Se quiser pode digitar só o começo do cpf para uma busca parcial"/></td>
        </tr>
        <?php }?>
    </table>
    
    <button onclick="procurarPessoa(false)">Procurar</button>
    <?php if($nivelp["gerapdf"] == 1){?>
    <button onclick="abreRelatorioPessoa()">Gera PDF</button>
    <?php }?>
    <?php if($nivelp["geraexcel"] == 1){?>
    <button onclick="abreRelatorioPessoa2()">Gera Excel</button> 
    <?php }?>
</form>
<?php include("./carregando.php");?>
<div id="listagem"></div>
