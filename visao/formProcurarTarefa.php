<form id="fptarefa" action="../control/ProcurarTarefaRelatorio.php" target="_blank" autocomplete="on" method="POST" onsubmit="return false;">
    <table class="tabela_formulario">
        <input type="hidden" name="html" id="html" value=""/>
        <input type="hidden" name="nome_pagina" id="nome_pagina" value="Relatório de Tarefas Enviados"/>
        <input type="hidden" name="tipo" id="tipo" value="pdf"/>
        <tr>
            <td>Nome</td>
            <td colspan="8"><input style="width: 590px;" type="text" name="nome" size="50" maxlength="250" placeholder="Digite nome aqui" value=""></td>
        </tr>
        <tr>
            <td>Prioridade</td>
            <td>
                <select style="width: 185px;" name="prioridade" id="prioridade">
                    <option value="">--Selecione--</option>
                    <option title="ta tudo parado mas o povo aguenta esperar" value="g" <?php if(isset($_GET["prioridade"]) && $_GET["prioridade"] == "g"){echo "selected";}?>>Grande</option>
                    <option value="m" <?php if(isset($_GET["prioridade"]) && $_GET["prioridade"] == "m"){echo "selected";}?>>Média</option>
                    <option value="p" <?php if(isset($_GET["prioridade"]) && $_GET["prioridade"] == "p"){echo "selected";}?>>Pequena</option>
                    <option title="Senão for feito hoje ta tudo acabado" value="u" <?php if(isset($_GET["prioridade"]) && $_GET["prioridade"] == "u"){echo "selected";}?>>Urgente</option>
                </select>                
            </td>
            <td>Resolvido</td>
            <td>
                <select style="width: 185px;" name="resolvido" id="resolvido">
                    <option value="">--Selecione--</option>
                    <option value="s" <?php if(isset($_GET["resolvido"]) && $_GET["resolvido"] == "s"){echo "selected";}?>>sim</option>
                    <option value="n" <?php if(isset($_GET["resolvido"]) && $_GET["resolvido"] == "n"){echo "selected";}?>>não</option>
                </select>                
            </td>
        </tr>
        <tr>
            <td>Liberado</td>
            <td>
                <select style="width: 185px;" name="liberado" id="liberado">
                    <option value="">--Selecione--</option>
                    <option value="s" <?php if(isset($_GET["liberado"]) && $_GET["liberado"] == "s"){echo "selected";}?>>sim</option>
                    <option value="n" <?php if(isset($_GET["liberado"]) && $_GET["liberado"] == "n"){echo "selected";}?>>não</option>
                </select>                
            </td>            
        </tr>
        <tr>
            <td>Dt. Inicio</td>
            <td><input type="date" class="data" name="data1" id="data1"/></td>
            <td>Dt. Fim</td>
            <td><input type="date" class="data" name="data2" id="data2"/></td>
        </tr>
    </table>
    <button onclick="procurarTarefa(false)">Procurar</button>
    <button onclick="abreRelatorioTarefa()">Gera PDF</button>
    <button onclick="abreRelatorio2Tarefa()">Gera Excel</button>    
</form>
<?php include("./carregando.php"); ?>
<div id="listagemTarefa"></div>
 