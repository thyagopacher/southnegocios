<form id="fbloqueio" role="form" autocomplete="on" class="form-horizlassificadol form-groups-bordered" method="get" onsubmit="return false;">
    <input type="hidden" name="codbloqueio" id="codbloqueio"  value="<?php if(isset($bloqueio["codbloqueio"])){echo $bloqueio["codbloqueio"];}else { echo "";} ?>"/>                       
    <table class="tabela_formulario">
    <tr>
        <td>Bloco</td>
        <td>
            <select style="width: 150px;" name="bloco" id="bloco">
                <?php 
                $resbloco = $conexao->comando("select distinct bloco from pessoa where codempresa = '{$_SESSION['codempresa']}' and status = 'a' and bloco <> '' order by bloco");
                $qtdbloco = $conexao->qtdResultado($resbloco);
                if($qtdbloco > 0){
                    echo "<option value=''>--Selecione--</option>";
                    while($bloco = $conexao->resultadoArray($resbloco)){
                        if(isset($visitante["bloco"]) && $visitante["bloco"] == $bloco["bloco"]){
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
            <select style="width: 150px;" name="apartamento" id="apartamento">
                <?php 
                $resapartamento = $conexao->comando("select distinct apartamento from pessoa where codempresa = '{$_SESSION['codempresa']}' and status = 'a' and apartamento <> '' order by apartamento");
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
            <select style="width: 150px;" name="codmorador" id="codmorador" title="Escolha aqui o morador para quem vai a correspondência">
                <?php
                $respessoa = $conexao->comando("select * from pessoa where codempresa = '{$_SESSION['codempresa']}' and status = 'a' and codnivel = 3");
                $qtdpessoa = $conexao->qtdResultado($respessoa);
                if($qtdpessoa > 0){
                    echo '<option value="">--Selecione--</option>';
                    while($pessoa = $conexao->resultadoArray($respessoa)){
                        echo '<option value="',$pessoa["codpessoa"],'">',$pessoa["nome"],'</option>';
                    }
                }else{
                    echo '<option value="">--Nada encontrado--</option>';
                }
                ?>
            </select>
        </td>
        <td>Endereço IP</td>
        <td><input type="text" name="enderecoip" id="enderecoip" class="ip_address" required size="20" maxlength="15" value="<?php if(isset($bloqueio["enderecoip"])){echo $bloqueio["enderecoip"];}else { echo "";} ?>"/></td>        
    </tr>
    </table>
    <?php 
    if (!isset($bloqueio["codbloqueio"])) {
        if($nivelp["inserir"] == 1){
            echo '<button onclick="inserir()">Cadastrar</button>';
        }
    } elseif (isset($bloqueio["codbloqueio"])) {
        if($nivelp["atualizar"] == 1){
            echo '<button style="margin-left: 10px" onclick="atualizar()">Atualizar</button>';
        }
        if($nivelp["excluir"] == 1){
            echo '<button style="margin-left: 10px" onclick="excluir()">Excluir</button>';
        }
        echo '<button style="margin-left: 10px" onclick="btNovo()">Novo</button>';
    } 
     ?>
</form>