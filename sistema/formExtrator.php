<div class="row">
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Relatório</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <form id="formExtrator" target="_blank" action="../control/Extrator.php" method="post">
                    <input type="hidden" name="codnivel" id="codnivel" value="<?= $_GET["codnivel"] ?>"/>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nome">Tabela</label>
                                <select name="tabela" id="tabela">
                                    <?php
                                    $resTabelaExtrator = $conexao->comando("show tables");
                                    $qtd = $conexao->qtdResultado($resTabelaExtrator);
                                    if($qtd > 0){
                                        echo '<option value="">--Selecione--</option>';
                                        while($tabela = $conexao->resultadoArray($resTabelaExtrator)){
                                            if($tabela["Tables_in_sistema"] == "ajuda" || $tabela["Tables_in_sistema"] == "smtp" || $tabela["Tables_in_sistema"] == "advertencia"  || strpos($tabela["Tables_in_sistema"], "status") !== FALSE || strpos($tabela["Tables_in_sistema"], "categoria") !== FALSE
                                                     || strpos($tabela["Tables_in_sistema"], "erro") !== FALSE || strpos($tabela["Tables_in_sistema"], "upload") !== FALSE || $tabela["Tables_in_sistema"] == "consumoluz"
                                                     || $tabela["Tables_in_sistema"] == "nivelpagina" || $tabela["Tables_in_sistema"] == "valorcampo" || $tabela["Tables_in_sistema"] == "campoextra" || $tabela["Tables_in_sistema"] == "arquivo"
                                                     || $tabela["Tables_in_sistema"] == "pagina"  || $tabela["Tables_in_sistema"] == "paginamorador"  || $tabela["Tables_in_sistema"] == "achado"
                                                     || $tabela["Tables_in_sistema"] == "atestado"  || $tabela["Tables_in_sistema"] == "comunicado"  || $tabela["Tables_in_sistema"] == "aviso"
                                                     || $tabela["Tables_in_sistema"] == "tipoachado" || $tabela["Tables_in_sistema"] == "tipoinformativo" || $tabela["Tables_in_sistema"] == "votoenquete"
                                                     || $tabela["Tables_in_sistema"] == "enquete" || $tabela["Tables_in_sistema"] == "mudanca" || $tabela["Tables_in_sistema"] == "comentarioclassificado"
                                                     || $tabela["Tables_in_sistema"] == "consumoagua" || $tabela["Tables_in_sistema"] == "modulo" || $tabela["Tables_in_sistema"] == "classificado"
                                                     || $tabela["Tables_in_sistema"] == "servico" || $tabela["Tables_in_sistema"] == "ramo" || $tabela["Tables_in_sistema"] == "produto"
                                                     || $tabela["Tables_in_sistema"] == "manutencao" || $tabela["Tables_in_sistema"] == "mensagem"){
                                                continue;
                                            }
                                            $tabelaSelecionada = str_replace("configuracao", "configuração ", $tabela["Tables_in_sistema"]);
                                            $tabelaSelecionada = str_replace("correspondencia", "correspondência", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("observacao", "observação ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("manutencao", "manutenção ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("arquivo", "arquivo ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("agenda", "agenda ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("servico", "serviço", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("acesso", "acesso ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("email", " e-mail ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("mudanca", " mudança ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("ambiente", " ambiente ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("classificado", " classificado ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("ocorrencia", " ocorrência ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("importacao", " importação ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("eletronico", " eletrônico ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("agua", " água ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("morador", " morador ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("tipo", " tipo ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("visitante", " visitante ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("mensagem", " mensagem ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("orcamento", " orçamento ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("horario", " horário ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("voto", " voto ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("pedido", " pedido ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("beneficio", " beneficio ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("cliente", " cliente ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("estado", " estado ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("orgao", " órgão ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("sms", " sms ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("padrao", " padrão ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("ligacao", " ligação ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("cotacao", " cotação ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("conteudo", " conteúdo ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("agencia", " agência ", $tabelaSelecionada);
                                            echo '<option value="',$tabela["Tables_in_sistema"],'">',trim($tabelaSelecionada),'</option>';
                                        }
                                    }else{
                                        echo '<option value="">--Nada encontrado--</option>';
                                    }
                                    ?>
                                </select>
                        </div>

                        <div class="form-group">
                            <label for="sexo">Campos</label>
                            <div id="listagemCamposTabela"></div>
                        </div>
                        <!-- /.form-group -->
                    </div>                    
                </form>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="submit" name="submit" id="btGerarRelatorio" value="Gerar Relatório" class="btn btn-primary"/>
                    </div>                                        
                </div>
            </div>
        </div>
    </div>
    <!--/.col (right) -->
</div>   <!-- /.row -->