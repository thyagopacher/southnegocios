<form id="fpranking" action="../control/ProcurarRankingRelatorio.php" target="_blank" role="form" class="form-horizontal form-groups-bordered" method="POST" onsubmit="return false;">                       
    <table class="tabela_formulario">
        <input type="hidden" name="html" id="html" value=""/>
        <input type="hidden" name="tipo" id="tipo" value="pdf"/>
        <input type="hidden" name="procurar" id="procurar" value="<?=$nivelp["procurar"]?>"/>
        <tr>
            <td>Mês</td>
            <td>
                <select name="mes" id="mes">
                    <?php
                    for($i = 1; $i <= 12; $i++){
                        if(date("m") == $i){
                            echo '<option selected value="',$i,'">',$i,' / ',date("Y"),'</option>';
                        }else{
                            echo '<option value="',$i,'">',$i,' / ',date("Y"),'</option>';
                        }
                    }
                    ?>
                </select>
            </td>
            <td></td>
            <td></td>
        </tr>
    </table>
</form>
<?php include("./carregando.php");?>
<div id="listagemRanking"></div>
