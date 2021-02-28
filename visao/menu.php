<div id='cssmenu' style="margin-bottom: 10px;">
    <?php
    $sql = "select distinct modulo.codmodulo, modulo.nome 
    from modulo 
    inner join pagina on pagina.codmodulo = modulo.codmodulo
    inner join nivelpagina on nivelpagina.codpagina = pagina.codpagina
    inner join nivel on nivel.codnivel = nivelpagina.codnivel
    where 1 = 1 
    and ((nivel.padrao = 's' and nivel.codnivel = '{$_SESSION["codnivel"]}') or (nivel.padrao <> 's' and nivel.codnivel = '{$_SESSION["codnivel"]}'))
    and nivel.codnivel = '{$_SESSION["codnivel"]}'    
    order by modulo.codmodulo";
    $resmodulo = $conexao->comando($sql)or die("Erro ao executar o comando: <pre>$sql</pre>");
    $qtdmodulo = $conexao->qtdResultado($resmodulo);
    ?>    
    <?php
    if ($qtdmodulo > 0) {
        $modulos = array();
        $paginas = array();
        $i = 1;
        if($qtdmodulo == 2){
            $widthOperadorMenu = "width: 360px;";
        }
        echo '<ul style="',$widthOperadorMenu,'">';
        echo '<li class="active"><a href="index.php"><span>Inicio</span></a></li>';
        while ($modulo = $conexao->resultadoArray($resmodulo)) {
            echo '<li class="has-sub "><a href="#"><span>', $modulo["nome"], '</span></a>';
            if ($_SESSION["codnivel"] != 1 && $modulo["codmodulo"] == 8) {
                continue;
            }
            $sql = "select distinct pagina.nome, pagina.link, pagina.titulo 
                    from pagina
                    inner join nivelpagina on nivelpagina.codpagina = pagina.codpagina
                    inner join nivel on nivel.codnivel = nivelpagina.codnivel
                    where pagina.codmodulo = '{$modulo["codmodulo"]}' 
                    and ((nivel.padrao = 's' and nivel.codnivel = '{$_SESSION["codnivel"]}') or (nivel.padrao <> 's' and nivel.codnivel = '{$_SESSION["codnivel"]}'))
                    order by pagina.nome";
            $respagina = $conexao->comando($sql)or die($sql);
            $qtdpagina = $conexao->qtdResultado($respagina);
            if ($qtdpagina > 0) {
                echo '<ul>';
                while ($pagina = $conexao->resultadoArray($respagina)) {
                    echo '<li><a href="/visao/', $pagina["link"], '"><span>', $pagina["nome"], '</span></a></li>';
                }
                echo '</ul>';
            }
        }
        echo '</ul>';
    }
    ?>
</div>
</div>
</div>