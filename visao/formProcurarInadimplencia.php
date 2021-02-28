<form id="fpinadimplencia" name="fpinadimplencia" action="../control/ProcurarInadimplenciaRelatorio.php" target="_blank" method="POST" onsubmit="return false;">
    <input type="hidden" name="nome_pagina" id="nome_pagina" value="Relatório de Inadimplência"/> 
    <input type="hidden" name="tipo" id="tipo" value="pdf"/>
    <table class="tabela_formulario">
        <tr>
            <td>Bloco</td>
            <td>
                <select style="width: 185px" name="bloco" id="pbloco">
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
                <select style="width: 185px" name="apartamento" id="papartamento">
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
            <td>Dt. Inicio</td>
            <td><input type="date" class="data" name="data1"/></td>
            <td>Dt. Fim</td>
            <td><input type="date" class="data" name="data2"/></td>
        </tr>
        <tr>
            <td>Periodo</td>
            <td>
                <select style="width: 185px;" name="periodo" id="periodo">
                    <?php
                    $resperiodo = $conexao->comando("select distinct(periodo) from inadimplencia where codempresa = '{$_SESSION['codempresa']}' and periodo <> '' order by periodo");
                    $qtdperiodo = $conexao->qtdResultado($resperiodo);
                    if($qtdperiodo > 0){
                        echo '<option value="">--Selecione--</option>';
                        while($periodo = $conexao->resultadoArray($resperiodo)){
                            echo '<option>',$periodo["periodo"],'</option>';
                        }
                    }else{
                        echo '<option value="">--Nada encontrado--</option>';
                    }
                    ?>
                </select>
            </td>
            <td></td>
            <td></td>
        </tr>
    </table>
    <input type="hidden" name="html" id="html" value=""/>
    <button onclick="procurarInadimplencia(false)" class="btn btn-info">Procurar</button>
    <button onclick="abreRelatorio()">Gera PDF</button>
    <button onclick="abreRelatorio2()">Gera Excel</button>    
</form>
<?php include("./carregando.php");?>
<div id="listagem"></div>
