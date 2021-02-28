<form name="ftarefa" id="ftarefa" method="post" action="<?=$action?>">
    <input type="hidden" name="codtarefa" id="codtarefa" value="<?php if(isset($_GET["codtarefa"])){echo $_GET["codtarefa"];}?>"/>
    <table class="tabela_formulario">
        <tr>
            <td>Localização</td>
            <td>
                <input list="paginas" type="text" required name="localizacao" id="localizacao" value="<?php if(isset($tarefa["localizacao"])){echo $tarefa["localizacao"];}?>"/>
                <datalist id="paginas">
                <?php
                $respagina = $conexao->comando("select nome from pagina order by nome");
                $qtdpagina = $conexao->qtdResultado($respagina);
                if($qtdpagina > 0){
                    while($pagina = $conexao->resultadoArray($respagina)){
                        echo '<option>',$pagina["nome"],'</option>';
                    }
                }
                ?>
                </datalist>
            </td>
            <td>Prioridade</td>
            <td>
                <select name="prioridade" id="prioridade" required>
                    <option value="">--Selecione--</option>
                    <option title="ta tudo parado mas o povo aguenta esperar" value="g" <?php if(isset($tarefa["prioridade"]) && $tarefa["prioridade"] == "g"){echo "selected";}?>>Grande</option>
                    <option value="m" <?php if(isset($tarefa["prioridade"]) && $tarefa["prioridade"] == "m"){echo "selected";}?>>Média</option>
                    <option value="p" <?php if(isset($tarefa["prioridade"]) && $tarefa["prioridade"] == "p"){echo "selected";}?>>Pequena</option>
                    <option title="Senão for feito hoje ta tudo acabado" value="u" <?php if(isset($tarefa["prioridade"]) && $tarefa["prioridade"] == "u"){echo "selected";}?>>Urgente</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Descrição</td>
            <td colspan="3">
                <textarea style="margin: 0px; width: 580px; height: 124px;" name="descricao" id="descricao" required placeholder="Digite aqui a descrição"><?php if(isset($tarefa["descricao"])){echo $tarefa["descricao"];}?></textarea>
            </td>
        </tr>
        <tr>
            <td>Imagem</td>
            <td colspan="3">
                <input type="file" name="imagem" id="imagem" title="Escolha seu tarefa aqui"/><br>
                <?php
                if(isset($tarefa["imagem"]) && $tarefa["imagem"] != NULL && $tarefa["imagem"] != ""){
                    echo '<a target="_blank" href="../arquivos/',$tarefa["imagem"],'">';
                    echo "<img width='150px' src='../arquivos/".$tarefa["imagem"]."' alt='Imagem tarefa'/>";
                    echo '</a>';
                }
                ?>
            </td>
        </tr> 
        <?php if(isset($tarefa)){?>
        <tr>
            <td>Liberado</td>
            <td>
                <select name="liberado" id="liberador" required title="Se tu considera o erro liberado e finalizado!!!">
                    <option value="n" <?php if(isset($tarefa["liberado"]) && $tarefa["liberado"] == "n"){echo "selected";}?>>não</option>
                    <option value="s" <?php if(isset($tarefa["liberado"]) && $tarefa["liberado"] == "s"){echo "selected";}?>>sim</option>
                </select>
            </td>
            <td>Resolvido</td>
            <td>
                <select name="resolvido" id="resolvido" required title="Se o desenvolvedor considerou resolvido">
                    <option value="n" <?php if(isset($tarefa["resolvido"]) && $tarefa["resolvido"] == "n"){echo "selected";}?>>não</option>
                    <option value="s" <?php if(isset($tarefa["resolvido"]) && $tarefa["resolvido"] == "s"){echo "selected";}?>>sim</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Obs. Resolvido</td>
            <td colspan="3">
                <textarea name="obsresolvido" style="margin: 0px; width: 580px; height: 124px;" id="obsresolvido"><?php if(isset($tarefa["obsresolvido"])){echo $tarefa["obsresolvido"];}?></textarea>
            </td>
        </tr>
        <?php }?>
        <tr>
            <?php if(!isset($_GET["codtarefa"]) && isset($nivelp["inserir"]) && $nivelp["inserir"] == "1"){?>
            <td><input type="submit" name="submit" value="Cadastrar" title="Clique aqui para enviar tarefa e cadastrar"/></td>
            <?php }?>
            <?php if(isset($_GET["codtarefa"]) && isset($nivelp["atualizar"]) && $nivelp["atualizar"] == "1"){?>
            <td><input type="submit" name="submit" value="Atualizar" title="Clique aqui para enviar tarefa e atualizar"/></td>
            <?php }?>
        </tr>
    </table>
</form>
