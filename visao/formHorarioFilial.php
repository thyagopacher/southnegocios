<form name="fhorariofilial" id="fhorariofilial" method="post" onsubmit="return false;">
    <input type="hidden" name="codfilial" id="codfilial" value="<?php if(isset($_GET["codempresa"])){echo $_GET["codempresa"];}?>"/>
    <table class="tabela_formulario" style="width: 900px;">
               
        <tr>
            <td colspan="3">
                Marcar/desmarcar todos<input type="checkbox" name="marcar_todos" id="marcar_todos" onclick="marcarTodos()"/>
            </td>
        </tr>
        <tr>
            <td>Funcionamento</td>
            <td colspan="3">
                <?php
                $sql = "select codhorario from horariofilial where codempresa = '{$_GET["codempresa"]}' and dia = 'segunda'";
                $horariofilial1 = $conexao->comandoArray($sql);
                $horariofilial2 = $conexao->comandoArray("select codhorario from horariofilial where codempresa = '{$_GET["codempresa"]}' and dia = 'terca'");
                $horariofilial3 = $conexao->comandoArray("select codhorario from horariofilial where codempresa = '{$_GET["codempresa"]}' and dia = 'quarta'");
                $horariofilial4 = $conexao->comandoArray("select codhorario from horariofilial where codempresa = '{$_GET["codempresa"]}' and dia = 'quinta'");
                $horariofilial5 = $conexao->comandoArray("select codhorario from horariofilial where codempresa = '{$_GET["codempresa"]}' and dia = 'sexta'");
                $horariofilial6 = $conexao->comandoArray("select codhorario from horariofilial where codempresa = '{$_GET["codempresa"]}' and dia = 'sabado'");
                $horariofilial7 = $conexao->comandoArray("select codhorario from horariofilial where codempresa = '{$_GET["codempresa"]}' and dia = 'domingo'");
                ?>
                <p class="funcionamento_p"><input type="checkbox" class="funcionamento" name="funcionamento[]" value="segunda" <?php if(isset($horariofilial1["codhorario"]) && $horariofilial1["codhorario"] != NULL && $horariofilial1["codhorario"] != ""){ echo 'checked';}?>/>Segunda</p>
                <p class="funcionamento_p"><input type="checkbox" class="funcionamento" name="funcionamento[]" value="terca" <?php if(isset($horariofilial2["codhorario"]) && $horariofilial2["codhorario"] != NULL && $horariofilial2["codhorario"] != ""){ echo 'checked';}?>/>Terça</p>
                <p class="funcionamento_p"><input type="checkbox" class="funcionamento" name="funcionamento[]" value="quarta" <?php if(isset($horariofilial3["codhorario"]) && $horariofilial3["codhorario"] != NULL && $horariofilial3["codhorario"] != ""){ echo 'checked';}?>/>Quarta</p>
                <p class="funcionamento_p"><input type="checkbox" class="funcionamento" name="funcionamento[]" value="quinta" <?php if(isset($horariofilial4["codhorario"]) && $horariofilial4["codhorario"] != NULL && $horariofilial4["codhorario"] != ""){ echo 'checked';}?>/>Quinta</p>
                <p class="funcionamento_p"><input type="checkbox" class="funcionamento" name="funcionamento[]" value="sexta" <?php if(isset($horariofilial5["codhorario"]) && $horariofilial5["codhorario"] != NULL && $horariofilial5["codhorario"] != ""){ echo 'checked';}?>/>Sexta</p>
                <p class="funcionamento_p"><input type="checkbox" class="funcionamento" name="funcionamento[]" value="sabado" <?php if(isset($horariofilial6["codhorario"]) && $horariofilial6["codhorario"] != NULL && $horariofilial6["codhorario"] != ""){ echo 'checked';}?>/>Sábado</p>
                <p class="funcionamento_p"><input type="checkbox" class="funcionamento" name="funcionamento[]" value="domingo" <?php if(isset($horariofilial7["codhorario"]) && $horariofilial7["codhorario"] != NULL && $horariofilial7["codhorario"] != ""){ echo 'checked';}?>/>Domingo</p>
            </td>
        </tr>
        
 
        <tr>
            <td colspan="3">Horários de Funcionamento</td>
        </tr>
        <tr>
            <td>Inicio</td>
            <td colspan="3">
                <?php  comboHoras("ini");?>
            </td>
        </tr>
        <tr>
            <td>Final</td>
            <td colspan="3">
                <?php  comboHoras("fin");?>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                REPETIR primeira caixa para todas<input type="checkbox" name="repetir_horario" id="repetir_horario" onclick="repetirHorario()"/>
            </td>
        </tr>
        
    </table>
    <?php echo '<input type="button" name="submit" value="Salvar" onclick="inserirHorarioFilial();"/>';?>
</form>

<?php
 
    function comboHoras($sufixo = ""){
        global $conexao;
        $diaSemana = array("segunda", "terca", "quarta", "quinta", "sexta", "sabado", "domingo");
        $atributo = "horafinal";
        if($sufixo == "ini"){
            $atributo = "horainicial";
        }
        for($i = 0; $i < 7; $i++){
            $sql = "select $atributo from horariofilial where codempresa = '{$_GET["codempresa"]}' and dia = '{$diaSemana[$i]}'";
            $horario = $conexao->comandoArray($sql);
            echo '<select class="comboHoras" name="horas',$sufixo,'[]" id="hora',$sufixo,$i,'" required>';
            for($j = 0; $j < 24; $j++){
                if($j < 10){
                    $horaComparar = "0"."$j:00:00";
                }else{
                    $horaComparar = "$j:00:00";
                }
                if(isset($horario[$atributo]) && $horario["$atributo"] == $horaComparar){
                    echo '<option selected value="',$j,':00:00">',$j,':00</option>';
                }else{
                    echo '<option value="',$j,':00:00">',$j,':00</option>';
                }
            }
            echo '</select>';
        }
    }
?>