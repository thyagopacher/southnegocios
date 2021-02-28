<form name="farquivoPessoa" id="farquivoPessoa" method="post" action="../control/InserirArquivoPessoa.php">
    <input type="hidden" name="codpessoa" id="codpessoa" value="<?php if(isset($_GET["codpessoa"])){echo $_GET["codpessoa"];}?>"/>
    <table class="tabela_formulario">
        <tr>
            <td>Nome</td>
            <td>
                <input placeholder="Digite nome arquivo" style="width: 500px;" type="text" required name="nome" id="nomeArquivoPessoa" maxlength="250"  value="<?php if(isset($arquivopessoa["nome"])){echo $arquivopessoa["nome"];}?>"/>
            </td>
        </tr>
        <tr>
            <td>Arquivo</td>
            <td>
                <input type="file" required name="arquivo" id="arquivoPessoa" required title="Escolha seu arquivo aqui"/>
            </td>
        </tr>  
        <tr>
            <td><input type="submit" name="submit" value="Enviar" title="Clique aqui para enviar arquivos da pessoa"/></td>
        </tr>
    </table>
</form>

<div class="progress">
    <div class="bar"></div>
    <div class="percent">0%</div>
</div>

<div id="status"></div>

<div id="listagemArquivoPessoa"></div>