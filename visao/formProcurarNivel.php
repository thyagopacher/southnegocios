<form id="fpnivel" role="form" autocomplete="on" class="form-horizontal form-groups-bordered" method="POST" onsubmit="return false;">
    <p>
        <label>Nome</label>
        <input type="search" size="50" name="nome" placeholder="Digite nome aqui" value="">
    </p>
    <p>
        <?php
        if(isset($naomaster) && $naomaster == true){
            echo '<button onclick="procurarNivel2(false)">Procurar</button>';
        }else{
            echo '<button onclick="procurarNivel(false)">Procurar</button>';
        }
        ?>
    </p>
</form>
<?php include("./carregando.php");?>
<div id="listagemNivel"></div>
