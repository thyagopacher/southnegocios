<?php
include "../model/Conexao.php";
$conexao = new Conexao();
$site = $conexao->comandoArray("select * from site");
?>
<!-- =============================================== -->
<!-- =                                             = -->
<!-- =                Keyners	                   = -->
<!-- =                                             = -->
<!-- =          http://keyners.com/	               = -->
<!-- =============================================== -->


<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
    <head>

        <!-- Basic Page Needs
  ================================================== -->
        <meta charset="utf-8">
        <title>South Negócios</title>
        <meta name="keywords" content="<?= $site["palavrachave"] ?>" />
        <meta name="description" content="<?= $site["descricao"] ?>">
        <meta name="author" content="thyago henrique pacher - thyago.pacher@gmail.com">
        <meta http-equiv="X-UA-Compatible" content="IE=9" />


        <!-- Mobile Specific Metas
  ================================================== -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

        <!-- PT Sans -->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,600&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

        <!-- Crete Roung -->
        <link href='http://fonts.googleapis.com/css?family=Crete+Round&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

        <!-- CSS
  ================================================== -->
        <link rel="stylesheet" href="/visao/recursos/css/reset.css">
        <link rel="stylesheet" href="/visao/recursos/css/base.css">
        <link rel="stylesheet" href="/visao/recursos/css/skeleton.css">
        <link rel="stylesheet" href="/visao/recursos/css/layout.css">

        <!--[if lt IE 9]>
                <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.js"></script>
        <script type="text/javascript" src="/visao/recursos/js/validate.js"></script>
        <script type="text/javascript" src="/visao/recursos/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
        <link rel="stylesheet" type="text/css" href="/visao/recursos/js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
        <script type="text/javascript">
            $(document).ready(function () {
                $("a[rel=example_group]").fancybox({
                    'transitionIn': 'none',
                    'transitionOut': 'none',
                    'titlePosition': 'over',
                    'titleFormat': function (title, currentArray, currentIndex, currentOpts) {
                        return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
                    }
                });
            });
        </script>

    </head>
    <body>


        <header>			
            <nav>
                <div class='container'>
                    <div class='five columns logo'>
                        <a href='#'><img style="width: 150px;" src="/visao/recursos/img/logo.png" alt="Logo"/></a>
                    </div>

                    <div class='eleven columns'>
                        <ul class='mainMenu'>
                            <li><a href='index.html' title='Home'>Home</a></li>
                            <li><a href='#' title='Sobre a empresa'>Sobre nós</a></li>
                            <li><a href='#' title='Pricing'>Pricing</a></li>
                            <li><a href='#' title='Blog'>Blog</a></li>
                            <li><a href='#' title='Portfolio'>Portfolio</a></li>
                            <li><a href='#' title='Contato'>Contato</a></li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class='container'>
                <div class='slogan'>
                    <div class='ten columns'>
                        <h1>Big catchy title</h1>
                        <h2>Bit smaller but still in need slogan</h2>
                    </div>

                    <div class='six columns'>
                        <h4>Offer EXCLUSIVE</h4>
                        <p>Nunc rhoncus, erat quis sagittis convallis, arcu tellus tempor felis, sed tempor ipsum lorem vitae dolor. Morbi blandit condimentum lectus, id porta est sagittis et. Integer eget tortor sit amet ante eleifend lacinia quis ut</p>
                        <a href='#' class='button medium green'>See the price</a>
                    </div>
                </div>
            </div>	
        </header>


        <div class='clear'></div>
        <div class='clear'></div>


        <div class='container'>

            <div class='one-third column'>
                <img src='/visao/recursos/img/misc/team.png'>
                <h3>Consórcios</h3>
                <p style="height: 140px;">Com a South Consórcios, você contará com uma equipe especializado no seguimento,
                    que fará toda a consultoria necessária para o melhor negócio
                    <a style="color: #00AFEF;font-size: 20px;" href="#"><h3 style="">Cartas de crédito</h3></a>
                </p>
            </div>


            <div class='one-third column'>
                <img src='/visao/recursos/img/misc/team.png'>
                <h3>Seguros</h3>
                <p style="height: 140px;">
                    Seu patrimônio nas mãos de  quem entende de seguro. Seguro de Veículos, Vida, Coletivo, Residencial, Empresarial,  Agrícola e Assistência Funeral
                    <a style="color: #00AFEF;font-size: 20px;" href="/cotacao"><h3 style="">Cotação online</h3></a>
                </p>
            </div>



            <div class='one-third column'>
                <img src='/visao/recursos/img/misc/team.png'>
                <h3>Externa Promotora</h3>
                <p style="height: 140px;">A Externa Promotora é parceira dos correspondentes bancários e produtores independentes, disponibilizando suas linhas de crédito, seguros e consórcios para serem comercializadas em todo território nacional.
                    Oferece ainda, capacitação técnica e sistema de informação GRATUITO
                    <a style="color: #00AFEF;font-size: 20px;" href="/parceiro"><h3 style="">Seja parceiro</h3></a>
                </p>
            </div>

        </div>


        <div class='clear'></div>


        <div class='orange'>

            <div class='container'>
                <h3>Get to know what we do</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                <a href='#' class='dalej'>See closer what we do</a>
            </div>

        </div>

        <div class='container'>
            <div class='sixteen columns form'>
                <h3>Formulário de contato</h3>
                <p>Preencha o formulário de contato e em breve responderemos</p>
                <form>
                    <label>Nome</label>
                    <input type='text' name='nome' id="nome" placeholder='Digite nome'>
                    <label>Endereço de e-mail?</label>
                    <input type='text' name='email' id="email" placeholder='Digite e-mail'>
                    <label>Mensagem</label>
                    <textarea cols='50' rows='15' name='mensagem' id="mensagem" placeholder="Digite aqui mensagem"></textarea>
                    <input type='submit' value='Enviar'>
                </form>
            </div>
        </div>


        <div class='clear'></div>


        <footer>
            <div class='container'>

                <div class='eight columns'>
                    <h5>Some stuff can go here</h5>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam. Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                </div>

                <div class='four columns'>
                    <h5>Contato</h5>
                    <p>
                        SouthNegocios®<br>
                        <?= $site["filial1"] ?>-PR: <?= $site["telefone"] ?><br>
                        <?= $site["filial2"] ?>-PR: <?= $site["telefone2"] ?>
                    </p>
                    <p><a href='mailto:<?= $site["email"] ?>'><?= $site["email"] ?></a></p>
                </div>


                <a id='top' href='#'>&uarr;</a>	
            </div>
        </footer>
        <script type="text/javascript">
            var form = $('form');

            $(document).ready(function () {
                form.validate({
                    ignore: "",
                    rules: {
                        'message': {
                            required: true,
                        },
                        'name': {
                            required: true,
                        },
                        'mail': {
                            required: true,
                            email: true
                        }
                    },
                    errorPlacement: function (error, element) {
                    }

                });
            });
        </script>


        <script type="text/javascript">
            var toper = $('a#top');


            $(window).scroll(function () {
                if ($(this).scrollTop() > 100) {
                    toper.fadeIn(200);
                } else {
                    toper.fadeOut(200);
                }
            });

            toper.click(function () {
                $('html, body').animate({scrollTop: 0}, 500);
                return false;
            });
        </script>


    </body>
</html>