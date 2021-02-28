<div id='footer_chat'></div>
<div class="chat-sidebar" style="float: left;display: none">
    <a style="margin-top: 60px; margin-right: 50px;" href="javascript: fecharChat();">Minimizar</a>
    <?php
if ($_SESSION["codnivel"] != "1") {
    $andNivelChat = " and (pessoa.codempresa = '{$_SESSION['codempresa']}' or pessoa.codnivel = 1)";
}
$sql = "select pessoa.codpessoa, pessoa.nome, pessoa.imagem, empresa.razao as empresa 
        from acesso 
        inner join pessoa on pessoa.codpessoa = acesso.codpessoa and pessoa.codempresa = acesso.codempresa
        inner join nivel on nivel.codnivel = pessoa.codnivel and nivel.codempresa = acesso.codempresa
        inner join empresa on empresa.codempresa = pessoa.codempresa
        where acesso.data = '" . date('Y-m-d') . "' 
        and acesso.dtsaida = '0000-00-00 00:00:00' 
        and nivel.nome <> 'Morador' 
        and pessoa.codpessoa <> '{$_SESSION['codpessoa']}' {$andNivelChat}
        order by nome";

$respessoa = $conexao->comando($sql);
$qtdpessoa = $conexao->qtdResultado($respessoa);
if ($qtdpessoa > 0) {
    while ($pessoa = $conexao->resultadoArray($respessoa)) {
        echo '<div class="sidebar-name">';
        if ($_SESSION["codnivel"] == 1) {
            $titulo = $pessoa["empresa"];
        } else {
            $titulo = "";
        }
        ?>
        <a style="width: 100%" title='<?= $titulo ?>' href="javascript:register_popup('<?= $pessoa["codpessoa"] ?>', '<?= $pessoa["nome"] ?>');">
            <?php
            if (isset($pessoa["imagem"]) && $pessoa["imagem"] != NULL && $pessoa["imagem"] != "" && file_exists("../arquivos/{$pessoa["imagem"]}")) {
                echo '<img style="float: left;" width="30" height="30" src="../arquivos/', $pessoa["imagem"], '" alt="Imagem perfil de usuário"/>';
            } else {
                echo '<img style="float: left;" width="30" height="30" src="../visao/recursos/img/sem_imagem.png" alt="Imagem perfil de usuário"/>';
            }
            echo '<p style="background: green; width: 10px; height: 10px;border-radius: 20px; float: left;"></p>';
            echo '<p style="float: left;margin: 0;padding: 0;width: 138px;height: 34px;margin-top: 10px;">';
            echo $pessoa["nome"];
            
            echo '</p>';
            echo '</a>';
            echo '</div>';
        }
    }
        ?>
</div>

