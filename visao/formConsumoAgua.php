<form id="fconsumo" autocomplete="off" method="post" onsubmit="return false;">
    <input type="hidden" name="codconsumo" id="codconsumo"  value="<?php if(isset($consumo["codconsumo"])){echo $consumo["codconsumo"];}else { echo "";} ?>"/>                       
    <table class="tabela_formulario">
    <tr> 
        <td>Data</td>
        <td><input style="width: 205px;" type="date" name="data" class="data" required value="<?php if(isset($consumo["data"])){echo $consumo["data"];}else { echo date('Y-m-d');} ?>" title="Digite aqui data" placeholder="Digite aqui data"/></td>   
        <td>Leitura</td>
        <td>
            <input style="width: 200px;" type="text" name="leitura" size="10" maxlength="10" title="Coloque aqui os m³ gastos com água" value="<?php if(isset($consumo["leitura"])){echo $consumo["leitura"];}else { echo "";} ?>"/>
        </td>        
    </tr>
    <tr>
        <?php
        $sql = "select bloco, apartamento 
        from pessoa 
        where bloco not in(select bloco from consumoagua where data >= '".date("Y-m-")."01' and data <= '".date("Y-m-")."30' and consumoagua.codempresa = pessoa.codempresa)
        and apartamento not in(select apartamento from consumoagua where data >= '".date("Y-m-")."01' and data <= '".date("Y-m-")."30' and consumoagua.codempresa = pessoa.codempresa)
        and bloco <> '' and apartamento <> ''    
        and codempresa = '{$_SESSION['codempresa']}' order by bloco limit 1";
        $bloco = $conexao->comandoArray($sql);
        ?>
        <td>Bloco</td>
        <td>
            <?=$bloco["bloco"]?>
            <input type="hidden" name="bloco" id="bloco" value="<?=$bloco["bloco"]?>"/>
        </td>
        <td>Apartamento</td>
        <td>
            <?=$bloco["apartamento"]?>
            <input type="hidden" name="apartamento" id="apartamento" value="<?=$bloco["apartamento"]?>"/>
        </td>
    </tr>     
    <?php 
    $sql        = "select * from consumoagua where apartamento = '{$bloco["apartamento"]}' and bloco = '{$bloco["bloco"]}' and codempresa = '{$_SESSION['codempresa']}' and data < '".date("Y-m-")."01'";
    $resconsumo = $conexao->comando($sql);
    $qtdconsumo = $conexao->qtdResultado($resconsumo);
    if($qtdconsumo == 0){
    ?>
    <tr>
        <td>Mês Ant</td>
        <td>
            <input style="width: 205px;" required type="text" name="leituraant" size="10" maxlength="10" title="Coloque aqui os m³ gastos com água" value=""/>
        </td>          
    </tr>
    <?php }?>
    </table>
        <?php 
        if (!isset($consumo["codconsumo"])) {   
            if($nivelp["inserir"] == 1){
                echo '<button style="margin-left: 5px;" onclick="inserir()">Cadastrar</button>';
            }
        } elseif (isset($consumo["codconsumo"])) {
            if($nivelp["atualizar"] == 1){
                echo '<button style="margin-left: 5px;" onclick="atualizar()" style="margin-left: 10px;">Atualizar</button>';
            }
            if($nivelp["excluir"] == 1){
                echo '<button style="margin-left: 5px;" onclick="excluir()" style="margin-left: 10px;">Excluir</button>';
            }
            echo '<button style="margin-left: 5px;" onclick="btNovo()" style="margin-left: 10px;">Novo</button>';
        } 
        ?>    
</form>
<?php include("./carregando.php");?>
<div id="listagemMorador"></div>