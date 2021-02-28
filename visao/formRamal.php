<form id="framal" action="<?=$action?>" method="post" novalidate="novalidate" onsubmit="return false;">      
    <input type="hidden" name="codramal" value="<?php if(isset($ramal["codramal"])){echo $ramal["codramal"];}?>"/>
    <table class="tabela_formulario">
        <tr>
            <td>Ramal</td>
            <td>
                <input type="text" name="ramal" id="ramal" maxlength="50" value="<?php if(isset($ramal["ramal"])){echo $ramal["ramal"];}?>"/>
            </td>
            <td>Telefone</td>
            <td>
                <input type="text" class="telefone" name="telefone" id="telefone" maxlength="15" value="<?php if(isset($ramal["telefone"])){echo $ramal["telefone"];}?>"/>
            </td>
        </tr>
        <tr>
            <td>Empresa</td>
            <td>
                <select style='width: 140px;' name='codempresa' id="codempresa">
                    <?php
                    $resempresa = $conexao->comando("select * from empresa order by razao");
                    $qtdempresa = $conexao->qtdResultado($resempresa);
                    if($qtdempresa > 0){
                        echo '<option value="">--Selecione--</option>';
                        while($empresa2 = $conexao->resultadoArray($resempresa)){
                            if(isset($ramal["codempresa"]) && $ramal["codempresa"] == $empresa2["codempresa"]){
                                echo '<option selected value="',$empresa2["codempresa"],'">',$empresa2["razao"],'</option>';
                            }else{
                                echo '<option value="',$empresa2["codempresa"],'">',$empresa2["razao"],'</option>';
                            }
                        }
                    }else{
                        echo '<option value="">--Nada encontrado--</option>';
                    }
                    ?>
                </select>
            </td>
            <td>Nome</td>
            <td>
                <input type="text" name="nome" id="nome" list="nomes" maxlength="15" value="<?php if(isset($ramal["nome"])){echo $ramal["nome"];}?>"/>
                <datalist id="nomes">
                    <?php
                    $resnome = $conexao->comando("select distinct nome from ramal where codempresa = '{$_SESSION['codempresa']}' order by nome");
                    $qtdnome = $conexao->qtdResultado($resnome);
                    if($qtdnome > 0){
                        while($nome = $conexao->resultadoArray($resnome)){
                            echo '<option>',$nome["nome"],'</option>';
                        }
                    }
                    ?>
                </datalist>
            </td>
        </tr>
   
    </table>
    <?php
    if(!isset($_GET["codramal"])){
        echo '<input type="button" name="submit" value="Cadastrar" onclick="inserirRamal()"/>';
    }else{
        echo '<input style="margin-left: 5px;" type="button" value="Atualizar" onclick="atualizarRamal()"/>';
        if(isset($_SESSION['codpessoa']) && $_SESSION['codpessoa'] == 6){
           echo '<input style="margin-left: 5px;" type="button" onclick="excluirRamal();" value="Excluir"/>';
        }
        echo '<button style="margin-left: 5px;" onclick="btNovoRamal()">Novo</button>';
    }
    
    ?> 
</form>