<form id="fchat" autocomplete="on" method="get" onsubmit="return false;">    
    <table class="tabela_formulario">
    <tr>
        <td>Loja</td>
        <td>
            <select style="width: 150px;" name="condominio" id="condominio">
                <?php 
                $resempresa2 = $conexao->comando("select codempresa, razao from empresa order by razao");
                $qtdempresa2 = $conexao->qtdResultado($resempresa2);
                if($resempresa2 > 0){
                    echo "<option value=''>--Selecione--</option>";
                    while($empresa2 = $conexao->resultadoArray($resempresa2)){
                        echo '<option value="',$empresa2["codempresa"],'">',$empresa2["razao"],'</option>';
                    }
                }else{
                    echo "<option value=''>--Nada encontrado--</option>";
                }
                ?>
            </select> 
        </td>        
        <td style="width: 50px;">Logado</td>
        <td>
            <select style="width: 180px;" name="logado" id="logado">
                <?php 
                $sql = "select pessoa.codpessoa, pessoa.nome 
                from acesso 
                inner join pessoa on pessoa.codpessoa = acesso.codpessoa and pessoa.codempresa = acesso.codempresa
                inner join nivel on nivel.codnivel = pessoa.codnivel
                where acesso.data = '".date('Y-m-d')."' and acesso.dtsaida = '0000-00-00 00:00:00' and nivel.nome <> 'Morador' order by nome";
                $reslogado = $conexao->comando($sql) or die("<pre>$sql</pre>");
                $qtdlogado = $conexao->qtdResultado($reslogado);
                if($qtdlogado > 0){
                    echo "<option value=''>--Selecione--</option>";
                    while($logado = $conexao->resultadoArray($reslogado)){
                        echo '<option value="',$logado["codpessoa"],'">',$logado["nome"],'</option>';
                    }
                }else{
                    echo "<option value=''>--Nada encontrado--</option>";
                }
                ?>
            </select>
        </td>
    </tr>
    
    </table>
    <?php 
        echo '<button id="btIniciarChat" onclick="iniciarChat();">Iniciar</button>';
     ?>
</form>