<?php
    header('Content-Type: text/html; charset=utf-8');
    $cpf = $_POST["cpf"];
    if(isset($_POST["cpf"]) && $_POST["cpf"] != NULL && $_POST["cpf"] != ""){
        
        function __autoload($class_name) {
            if(file_exists("../model/".$class_name . '.php')){
                include "../model/".$class_name . '.php';
            }elseif(file_exists("../visao/".$class_name . '.php')){
                include "../visao/".$class_name . '.php';
            }elseif(file_exists("./".$class_name . '.php')){
                include "./".$class_name . '.php';
            }
        }
        $conexao   = new Conexao();
        $beneficio = new BeneficioCliente($conexao);
        /**limpando cpf para pesquisar*/
        $cpf       = str_replace(".", "", $cpf);
        $cpf       = str_replace("-", "", $cpf);
        $consulta_cpf = $beneficio->consultaCpfInss($cpf);
//        $conteudo = file_get_contents("consultacpf.xml");
//        $consulta_cpf = simplexml_load_string(strtolower($conteudo));
        if(isset($consulta_cpf->consulta->ok) && $consulta_cpf->consulta->ok != NULL && $consulta_cpf->consulta->ok != ""){
            echo '<table class="tabela_formulario">';
            echo '<tr><td>Status da consulta</td><td>'.$consulta_cpf->consulta->ok.'</td></tr>';
            $qtdbeneficio = count($consulta_cpf->consulta->consulta_cpf->resultado);
            $numeros_nb   = "";
            $separador    = ",";
            $linhaConsulta = 0;
            foreach ($consulta_cpf->consulta->consulta_cpf->resultado as $key => $resultado2) {
                echo "<tr><td>Nome</td><td>".$resultado2->nome.'</td></tr>';
                if($linhaConsulta == $qtdbeneficio - 1){
                    $separador = "";
                }
                $numeros_nb .= "'$resultado2->beneficio'" .$separador;
                
                echo "<tr><td>Beneficio:</td><td><a style='color: blue;' href='javascript: consultaBeneficioInss({$resultado2->beneficio})' title='Clique aqui para abrir detalhadamento do beneficio'>".$resultado2->beneficio.'</a></td></tr>';
                echo "<tr><td>Nascimento:</td><td>".$resultado2->data_nascimento.'</td></tr>';
                echo "<tr><td>Mãe:</td><td>".$resultado2->mae.'</td></tr>';
                echo "<tr><td>Dt. Inicio Beneficio:</td><td>".$resultado2->data_inicio_beneficio.'</td></tr>';
                echo "<tr><td>Espécie Beneficio:</td><td>".$resultado2->especie.'</td></tr>';
                echo "<tr><td>NIT:</td><td>".$resultado2->nit.'</td></tr>';
                echo "<tr><td>Municipio:</td><td>".$resultado2->municipio.'</td></tr>';
                echo "<tr><td>UF:</td><td>".$resultado2->uf.'</td></tr>';   
                $linhaConsulta++;
            }
            if($qtdbeneficio > 1){
                $arrayJavascript = "new Array($numeros_nb)";
                echo '<tr><td><a href="javascript: consultaBeneficioInss(',$arrayJavascript,')">Consultar Beneficios</a></td></tr>';
            }
            echo '</table>';
            
            include "../model/Log.php";
            $log             = new Log($conexao);
            $log->acao       = "procurar";
            $log->codempresa = $_SESSION['codempresa'];
            $log->codpagina  = 4;
            $log->codpessoa  = $_SESSION['codpessoa'];
            $log->data       = date('Y-m-d');
            $log->hora       = date('H:i:s');
            $log->observacao =  "Consulta CPF INSS: CPF : {$cpf}";
            $log->inserir();             
        }else{
            echo $consulta_cpf->msg;
        }
    }else{
        echo 'Não pode consultar sem cpf...';
    }