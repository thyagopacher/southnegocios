<form id="fPpessoa" role="form" class="form-horizontal form-groups-bordered" method="POST" target="_blank" action="../control/ProcurarPessoaRelatorio.php" onsubmit="return false;">
    <input type="hidden" name="html" id="html" value=""/>
    <input type="hidden" name="tipo" id="tipo" value="pdf"/>
    <input type="hidden" name="nome_pagina" id="nome_pagina" value="Relatório de Pessoas Cadastradas"/>      
    <input type="hidden" name="callcenter" id="callcenter" value="<?php if(isset($_GET["callcenter"])){echo "s";}?>"/>      
    <table class="tabela_formulario">
        <tr>
            <td style="width: 100px;">Dt. Inicio:</td>
            <td><input style="width: 205px;" type="date" name="data1" title="Data inicial de seu cadastro" value=""/></td>
            <td>Dt. Fim:</td>
            <td><input style="width: 205px;" type="date" name="data2" title="Data final de seu cadastro" value=""/></td>
        </tr>
        
        <tr>
            <td>Status:</td>
            <td style="width: 230px;">
                <select style="width: 210px;" name="status" id="status">
                    <option value="">Ambos</option>
                    <option value="a" <?php if(isset($_GET["status"]) && $_GET["status"] == "a"){echo "selected";}?>>Ativo</option>
                    <option value="i" <?php if(isset($_GET["status"]) && $_GET["status"] == "i"){echo "selected";}?>>Inativo</option>
                </select>
            </td>
            <td>E-mail:</td>
            <td>
                <input style="width: 208px;" type="email" name='email' id="email" maxlength="250"/>
            </td>
        </tr> 
    </table>
    <button onclick="procurarPessoa(false)">Procurar</button>
    <button onclick="abreRelatorioPessoa()">Gera PDF</button>
    <button onclick="abreRelatorioPessoa2()">Gera Excel</button>    
</form>
<?php include("./carregando.php");?>
<div id="listagem"></div>

<form action="Excel.php" method="post" target="_blank" id="fPpessoa2" name="fPpessoa2">
    <input type="hidden" name="nome_pagina" id="nome_pagina" value="Relatório de Pessoas Cadastradas"/>  
    <input type="hidden" name="html" id="html2" value=""/>
</form>