      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
               <?php
               if($_SESSION["imagem"] != NULL && $_SESSION["imagem"] != ""){
                   echo '<img src="../arquivos/',$_SESSION["imagem"],'" class="img-circle" alt="Imagem usuário">';
               }else{
                   echo '<img src="../visao/recursos/img/sem_imagem.png" class="img-circle" alt="Imagem usuário">';
               }
               ?>
              
            </div>
            <div class="pull-left info">
              <p><?=$_SESSION["nome"]?></p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
          <!-- search form -->
          <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type='text' name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MENU DE NAVEGAÇÃO</li>
            <li>
                <a href="/sistema/"><i></i> <span>Inicial</span> <i class="fa fa-angle-left pull-right"></i></a>
            </li>
            <?php
            $resmodulo = $conexao->comando("select * from modulo order by codmodulo");
            $qtdmodulo = $conexao->qtdResultado($resmodulo);
            if($qtdmodulo > 0){
                while($modulo = $conexao->resultadoArray($resmodulo)){
                    echo '<li class="active treeview">';
                    echo '<a href="#"><i class="fa ',$modulo["icone"],'"></i> <span>',$modulo["nome"],'</span> <i class="fa fa-angle-left pull-right"></i></a>';
                    $respagina = $conexao->comando("select distinct pagina.nome, pagina.link, pagina.titulo, pagina.abreaolado 
                    from pagina
                    inner join nivelpagina on nivelpagina.codpagina = pagina.codpagina
                    inner join nivel on nivel.codnivel = nivelpagina.codnivel
                    where pagina.codmodulo = '{$modulo["codmodulo"]}' 
                    and ((nivel.padrao = 's' and nivel.codnivel = '{$_SESSION["codnivel"]}') or (nivel.padrao <> 's' and nivel.codnivel = '{$_SESSION["codnivel"]}'))
                    order by pagina.nome");
                    $qtdpagina = $conexao->qtdResultado($respagina);
                    if($qtdpagina > 0){
                        echo '<ul class="treeview-menu">';
                        while($pagina = $conexao->resultadoArray($respagina)){
                            if($pagina["abreaolado"] == "n"){
                                echo '<li class="active"><a href="',$pagina["link"],'"><i class="fa ',$pagina["icone"],'"></i>',$pagina["nome"],'</a></li>';
                            }else{
                                echo '<li class="active"><a target="_blank" href="',$pagina["link"],'"><i class="fa ',$pagina["icone"],'"></i>',$pagina["nome"],'</a></li>';
                            }
                        }
                        echo '</ul>';
                    }
                    echo '</li>';
                }
            }
            ?>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>