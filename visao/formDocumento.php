<form id="fdocumento" onsubmit="return false;" method="POST">
    <input type="hidden" name="coddocumento" id="coddocumento"  value="<?php if(isset($documento["coddocumento"])){echo $documento["coddocumento"];}else{ echo "";}?>"/>                            
<table class="tabela_formulario">
    <tr>
        <td>Nome</td>
        <td><input required type="text" name="nome" id="nome" placeholder="Nome" value="<?php if(isset($documento["nome"])){echo $documento["nome"];}?>"/></td>     
        <td>Banco</td>
        <td>
            <select name="codbanco" id="codbanco">
                <?php
                $resbanco = $conexao->comando("select * from banco order by nome");
                $qtdbanco = $conexao->qtdResultado($resbanco);
                if($qtdbanco > 0){
                    echo '<option value="">--Selecione--</option>';
                    while($banco = $conexao->resultadoArray($resbanco)){
                        echo '<option value="',$banco["codbanco"],'">',$banco["nome"],'</option>';
                    }
                }else{
                    echo '<option value="">--Nada encontrado--</option>';
                }
                ?>
            </select>
        </td>     
    </tr>
  
</table>
        <?php
        if (!isset($documento["coddocumento"])) {
            if($nivelp["inserir"] == 1){
                echo '<input type="submit" name="button" id="Cadastrar" value="Cadastrar" onclick="inserirDocumento()"/>';
            }
        } elseif (isset($documento["coddocumento"])) {
            if($nivelp["atualizar"] == 1){
                echo '<input style="margin-left: 5px;" type="submit" name="submit" value="Atualizar" onclick="atualizarDocumento()"/>';
            }
            if($nivelp["excluir"] == 1){
                echo '<button style="margin-left: 5px;" onclick="excluirDocumento()">Excluir</button>';
            }
            echo '<button style="margin-left: 5px;" onclick="btNovoDocumento()">Novo</button>';
        } 
        ?>
</form>

<div class="progress">
    <div class="bar"></div>
    <div class="percent">0%</div>
</div>
<div id="status"></div>
