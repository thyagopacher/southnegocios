<form id="fCadastroinadimplencia" role="form" autocomplete="on" method="post" onsubmit="return false;">
    <input type="hidden" name="codinadimplencia" id="codinadimplencia"  value="<?php if (isset($inadimplencia["codinadimplencia"])) {echo $inadimplencia["codinadimplencia"];} ?>"/>                                           
    <table class="tabela_formulario">
        <tr>
            <td>Bloco</td>
            <td>
                <select style="width: 150px" name="bloco" id="bloco">
                    <?php
                    $resbloco = $conexao->comando("select distinct(bloco) as bloco from pessoa where codempresa = '{$_SESSION['codempresa']}' and bloco <> '' and apartamento <> '' order by bloco");
                    $qtdbloco = $conexao->qtdResultado($resbloco);
                    if($qtdbloco > 0){
                        echo '<option value="">--Selecione--</option>';
                        while($bloco = $conexao->resultadoArray($resbloco)){
                            if(isset($inadimplencia["bloco"]) && $inadimplencia["bloco"] == $bloco["bloco"]){
                                echo '<option selected>',$bloco["bloco"],'</option>';
                            }else{
                                echo '<option>',$bloco["bloco"],'</option>';
                            }
                        }
                    }else{
                        echo '<option value="">--Nada encontrado--</option>';
                    }
                    ?>
                </select>
            </td>
            <td>Apartamento</td>
            <td>
                <select style="width: 170px" name="apartamento" id="apartamento">
                    <?php
                    $sql            = "select distinct(apartamento) as apartamento from pessoa where codempresa = '{$_SESSION['codempresa']}' and bloco <> '' and apartamento <> '' order by apartamento";
                    $resapartamento = $conexao->comando($sql);
                    $qtdapartamento = $conexao->qtdResultado($resapartamento);
                    if($qtdapartamento > 0){
                        echo '<option value="">--Selecione--</option>';
                        while($apartamento = $conexao->resultadoArray($resapartamento)){
                            if(isset($inadimplencia["apartamento"]) && trim($inadimplencia["apartamento"]) == trim($apartamento["apartamento"])){
                                echo '<option selected>',$apartamento["apartamento"],'</option>';
                            }else{
                                echo '<option>',$apartamento["apartamento"],'</option>';  
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
            <td>Cota Cond.</td>
            <td>
                <input style="width: 150px;" type="text" name="cotacondominio" id="cotacondominio" class="real" size="5" maxlength="10" value="<?php if (isset($inadimplencia["cotacondominio"])) {echo number_format($inadimplencia["cotacondominio"], 2, ",", "");} else {echo "";} ?>"/>
            </td>
            <td>Fundo</td>
            <td>
                <input style="width: 170px;" type="text" name="fundoreserva" id="fundoreserva" class="real" size="5" maxlength="10" value="<?php if (isset($inadimplencia["fundoreserva"])) {echo number_format($inadimplencia["fundoreserva"], 2, ",", "");} else {echo "";} ?>"/>
            </td>
        </tr>
        <tr>
            <td>Rateio Água</td>
            <td>
                <input style="width: 150px;" type="text" name="rateioagua" id="rateioagua" class="real" size="5" maxlength="10" value="<?php if (isset($inadimplencia["rateioagua"])) {echo number_format($inadimplencia["rateioagua"], 2, ",", "");} else {echo "";} ?>"/>
            </td>
            <td>Juros</td>
            <td>
                <input style="width: 170px;" type="text" name="juro" id="juro" class="real" size="5" maxlength="10" value="<?php if (isset($inadimplencia["juro"])) {echo number_format($inadimplencia["juro"], 2, ",", "");} else {echo "";} ?>"/>
            </td>
        </tr>
        <tr>
            <td>Tx. extra 1</td>
            <td>
                <input style="width: 150px;" type="text" name="txextra1" id="txextra1" class="real" size="5" maxlength="10" value="<?php if (isset($inadimplencia["txextra1"])) {echo number_format($inadimplencia["txextra1"], 2, ",", "");} else {echo "";} ?>"/>
            </td>
            <td>Tx. extra 2</td>
            <td>
                <input style="width: 170px;" type="text" name="txextra2" id="txextra2" class="real" size="5" maxlength="10" value="<?php if (isset($inadimplencia["txextra2"])) {echo number_format($inadimplencia["txextra2"], 2, ",", "");} else {echo "";} ?>"/>
            </td>
        </tr>
        <tr>
            <td>Multa</td>
            <td>
                <input style="width: 150px;" type="text" name="multa" id="multa" class="real" size="5" maxlength="10" value="<?php if (isset($inadimplencia["multa"])) {echo number_format($inadimplencia["multa"], 2, ",", "");} else {echo "";} ?>"/>
            </td>
            <td>Dt. Pgto</td>
            <td>
                <input style="width: 170px;" type="date" name="dtpagamento" id="dtpagamento" size="5" maxlength="10" value="<?php if (isset($inadimplencia["dtpagamento2"])) {echo $inadimplencia["dtpagamento2"];} else {echo date('Y-m-d');} ?>"/>
            </td>
        </tr>
        <tr>
            <td>Período</td>
            <td>
                <?php comboPeriodo();?>
            </td>  
            <td>Dt. Venc.</td>
            <td>
                <input style="width: 170px;" type="date" name="dtvencimento" id="dtvencimento" size="5" maxlength="10" value="<?php if (isset($inadimplencia["dtvencimento"])) {echo $inadimplencia["dtvencimento"];} else {echo date('Y-m-d');} ?>"/>
            </td>            
        </tr>
    </table>
    <?php
    if (!isset($_GET["codinadimplencia"])) {
        $estiloCadastra = "";
        $estiloAtualiza = "display: none;";
    } elseif (isset($_GET["codinadimplencia"])) {
        $estiloCadastra = "display: none;";
        $estiloAtualiza = "";
    }
    if ($nivelp["inserir"] == 1) {
        echo '<input type="button" name="button" id="btInserirInadimplencia" value="Cadastrar" onclick="inserirInadimplencia();" style="',$estiloCadastra,'"/>';
    }        
    if ($nivelp["atualizar"] == 1) {
        echo '<input type="button" name="button" id="btAtualizarInadimplencia" value="Atualizar" onclick="atualizarInadimplencia();" style="',$estiloAtualiza,'"/>';
    }
    if ($nivelp["excluir"] == 1) {
        echo '<button style="margin-left: 10px" id="btExcluirInadimplencia" onclick="excluirInadimplencia()" style="',$estiloAtualiza,'">Excluir</button>';
    }
    echo '<button style="margin-left: 10px" onclick="btNovoInadimplencia()" style="',$estiloAtualiza,'">Novo</button>';    
    ?>    
</form>

<?php

function comboPeriodo(){
    global $inadimplencia;
    $arr_meses = array(
      '01' => 'Janeiro',
      '02' => 'Fevereiro',
      '03' => 'Março',
      '04' => 'Abril',
      '05' => 'Maio',
      '06' => 'Junho',
      '07' => 'Julho',
      '08' => 'Agosto',
      '09' => 'Setembro',
      '10' => 'Outubro',
      '11' => 'Novembro',
      '12' => 'Dezembro'
   );
    echo '<select style="width: 150px;" name="periodo" id="periodo">';
    echo '<option value="">--Selecione--</option>';
    foreach ($arr_meses as $key => $mes) {
        if($inadimplencia["periodo"] == $mes){
            echo '<option selected>',$mes,'/', date("Y"),'</option>';
        }else{
            echo '<option>',$mes,'/', date("Y"),'</option>';
        }
    }
    echo '</select>';
}