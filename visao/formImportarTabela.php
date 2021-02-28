<form id="fImportacaoTabela" action="../control/ImportacaoTabelaPrazoCSV.php" method="POST">
    <table class="tabela_formulario">
        <tr>
            <td>Arquivo</td>     
            <td><input type="file" name="arquivo" id="arquivo" title="Escolha aqui sua tabela .csv"/></td>
        </tr>
    </table>
    <?php
        if ($nivelp["inserir"] == 1) {
            echo '<input type="submit" name="submit" value="Importar" id="btInserirTabela"/>';
        }        
    ?>
</form>
* Tabela deve estar no formato .csv<br>
* Data de alteração formato dd/mm/YYYY<br>
<a href="/arquivos/importacao_tabela_prazo.csv" target="_blank">Download planilha padrão</a>
<div class="progress">
    <div class="bar"></div>
    <div class="percent">0%</div>
</div>
<div id="status"></div>

