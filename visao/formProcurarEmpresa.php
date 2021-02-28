<form id="fpempresa" name="fpempresa" action="../control/ProcurarEmpresaRelatorio.php" target="_blank" method="POST" onsubmit="return false;">
    <input type="hidden" name="nome_pagina" id="nome_pagina" value="Relatório de Empresas"/> 
    <input type="hidden" name="fornecedor" id="fornecedor" value="<?php if(isset($fornecedor)){ echo "true";}?>"/> 
    <input type="hidden" name="tipo" id="tipo" value="pdf"/>
    <table class="tabela_formulario">
        <tr>
            <td>Nome</td>
            <td colspan="8"><input style="width: 590px;" type="text" name="nome" size="50" maxlength="250" placeholder="Digite nome da empresa" value=""></td>
        </tr>
        <tr>
            <td>Dt. Inicio</td>
            <td style="width: 380px;"><input type="date" class="data" name="data1"/></td>
            <td>Dt. Fim</td>
            <td><input type="date" class="data" name="data2"/></td>
        </tr>
        <tr>
            <td>Status</td>
            <td>
                <select style="width: 130px;" name="codstatus" id="codstatus">
                    <?php
                    $resstatus = $conexao->comando("select * from statusempresa order by nome");
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
            <?php
            if(isset($_GET["codramo"]) && $_GET["codramo"] != NULL && $_GET["codramo"] != ""){
                echo '<input type="hidden" name="codramo" id="codramo" value="',$_GET["codramo"],'"/>';
            }else{
                echo '<td>Ramo</td>';
                echo '<td>';
                echo '<select style="width: 130px;" name="codramo" id="codramo">';
                $resramo = $conexao->comando("select * from ramo order by nome");
                $qtdramo = $conexao->qtdResultado($resramo);
                if($qtdramo > 0){
                    echo '<option value="">--Selecione--</option>';
                    while($ramo = $conexao->resultadoArray($resramo)){
                        echo '<option value="',$ramo["codramo"],'">',$ramo["nome"],'</option>';
                    }
                }else{
                    echo '<option value="">--Nada encontrado--</option>';
                }
                echo '</select>';
                echo '</td>';
            }
            ?>
        </tr>
    </table>
    <input type="hidden" name="html" id="html" value=""/>
    <button onclick="procurarEmpresa(false)">Procurar</button>
    <button onclick="abreRelatorio()">Gera PDF</button>
    <button onclick="abreRelatorio2()">Gera Excel</button>    
</form>
<?php include("./carregando.php");?>
<div id="listagemEmpresa"></div>
