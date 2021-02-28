<form id="fpconsumo" action="PDF.php" target="_blank" role="form" class="form-horizontal form-groups-bordered" method="POST" onsubmit="return false;">                   
    <table class="tabela_formulario">
        <input type="hidden" name="tipo" id="tipo" value="pdf"/>
        <tr>
            <td>Dt. Inicio</td>
            <td><input style="width: 205px;" type="date" class="data" name="data1"/></td>
            <td>Dt. Fim</td>
            <td><input style="width: 200px;" type="date" class="data" name="data2"/></td>
        </tr>
        <tr>
            <td>Bloco</td>
            <td>
                <select style="width: 212px;" name="bloco" id="bloco2">
                    <?php 
                    $resbloco = $conexao->comando("select distinct bloco from pessoa where codempresa = '{$_SESSION['codempresa']}' and status = 'a' and bloco <> '' and apartamento <> '' order by bloco");
                    $qtdbloco = $conexao->qtdResultado($resbloco);
                    if($qtdbloco > 0){
                        echo "<option value=''>--Selecione--</option>";
                        while($bloco = $conexao->resultadoArray($resbloco)){
                            echo '<option>',$bloco["bloco"],'</option>';
                        }
                    }else{
                        echo "<option value=''>--Nada encontrado--</option>";
                    }
                    ?>
                </select> 
            </td>
            <td>Apartamento</td>
            <td>
                <select style="width: 205px;" name="apartamento" id="apartamento2">
                    <?php 
                    $resapartamento = $conexao->comando("select distinct apartamento from pessoa where codempresa = '{$_SESSION['codempresa']}' and status = 'a' and apartamento <> '' and bloco <> '' order by apartamento");
                    $qtdapartamento = $conexao->qtdResultado($resapartamento);
                    if($qtdapartamento > 0){
                        echo "<option value=''>--Selecione--</option>";
                        while($apartamento = $conexao->resultadoArray($resapartamento)){
                            echo '<option>',$apartamento["apartamento"],'</option>';
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
            <td colspan="3">
                <select style="width: 212px;" name="codmorador" id="codmorador2">
                    <option value="">--Selecione--</option>
                    <?php
                    $respessoa = $conexao->comando("select codpessoa, nome from pessoa where codempresa = '{$_SESSION['codempresa']}' and status = 'a' and bloco <> '' and apartamento <> ''");
                    $qtdpessoa = $conexao->qtdResultado($respessoa);
                    if($qtdpessoa > 0){
                        while($pessoa = $conexao->resultadoArray($respessoa)){
                            echo '<option value="',$pessoa["codpessoa"],'">',$pessoa["nome"],'</option>';
                        }
                    }else{
                        echo '<option value="">--Selecione--</option>';
                    }
                    ?>
                </select>                  
            </td>
        </tr>
    </table>
    <button onclick="procurarConsumo(false)">Procurar</button>
    <button onclick="abreRelatorioConsumo()">Gera PDF</button>
    <button onclick="abreRelatorio2Consumo()">Gera Excel</button>    
</form>
<?php include("./carregando.php");?>
<div id="listagemConsumo"></div>

<form action="Excel.php" method="post" target="_blank" id="fpconta2" name="fpconta2">
    <input type="hidden" name="nome_pagina" id="nome_pagina" value="Relatório de Contas"/>
    <input type="hidden" name="html" id="html2" value=""/>
</form>