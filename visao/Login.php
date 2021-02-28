<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>South Negócios.. - VPS</title>
        <link href="http://southnegocios.com/visao/recursos/css/style.css" rel="stylesheet" type="text/css">
        <link href="http://southnegocios.com/visao/recursos/css/sweet-alert.css" rel="stylesheet" type="text/css">

    </head>

    <body> 
        <header> 
            <div id="superior"> 
                <div class="central">
                    <div class="conteudo"> 
                        <form method="post" id="login-superior" action="../control/Login.php">
                            <div id="lado-a-login-superior">
                                <input type="text" name="login" id="login" placeholder="Digite seu Login" class="input-login-superior input-a-login-superior"/>
                                <label class="label-login-superior"><input type='password' name='senha' placeholder="Digite sua senha" class="input-login-superior input-b-login-superior"/>
                                    <a href="javascript: reenviaSenha()" title="">esqueçeu sua senha ?</a>
                                </label>
                                <input type="submit" value="Entrar" id="botao-logiar-superior"/>
                            </div>
                        </form>
                        <nav id="menu-superior"> 
                            <ul id="ul-menu-superior">  
                                <li class="li-ul-menu-superior">
                                    <a href="" title="" class="a-li-ul-menu-superior">Home</a>
                                </li> 
                                <li class="li-ul-menu-superior"> 
                                    <a href="" title="" class="a-li-ul-menu-superior">Empresa</a>
                                </li>
                                <li class="li-ul-menu-superior"> 
                                    <a href="" title="" class="a-li-ul-menu-superior">Sistema</a>
                                </li> 
       
                                <li class="li-ul-menu-superior"> 
                                    <a href="mailto: thyago.pacher@gmail.com?subject=Contato com o desenvolvedor&body=Suporte sistema" title="" class="a-li-ul-menu-superior">Contato</a>
                                </li> 
                            </ul> 
                        </nav> 
                    </div> 
                </div> 
            </div>  
        </header>
        <div class="conteudo-central"></div>
        <footer>
            <div id="inferior">  
                <div class="central"> 
                    <div class="conteudo"> 

                        <div id="direitos">  
                            <h2 id="h2-direitos">Copyright © 2012 - <?=date("Y");?> - Todos os direitos reservados - <span class="span-bold"><a style="color: white" target="_blank" href="http://sitesesistemaspg.com">Sites e Sistemas PG</a></span></h2>  
                        </div>  
                    </div> 
                </div> 
            </div>  
        </footer>
    </body>
</html>
<script type="text/javascript" src="http://southnegocios.com/visao/recursos/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="http://southnegocios.com/visao/recursos/js/sweet-alert.min.js"></script>
<script type="text/javascript" src="http://southnegocios.com/visao/recursos/js/Geral.js"></script>
