<?php
    if (isset($_FILES["arquivo"])) {
        
        include "Upload.php";
        include "../model/Conexao.php";
        include "../model/Pessoa.php";
        include "../model/Emprestimo.php";
        include "../model/Telefone.php";
        include "../model/BeneficioCliente.php";
        $delimitador = ',';
        $cerca       = '"';        
        $upload      = new Upload($_FILES["arquivo"]);
        if ($upload->erro == "") {
            $conexao   = new Conexao();
            $f         = fopen("../arquivos/".$upload->nome_final, 'r');
            if ($f) {
                // Ler cabecalho do arquivo
                $cabecalho = fgetcsv($f, 0, $delimitador, $cerca);
                // Enquanto nao terminar o arquivo
                while (!feof($f)) {
                    // Ler uma linha do arquivo
                    $linha = fgetcsv($f, 0, $delimitador, $cerca);
                    if (!$linha) {
                        continue;
                    }
                    $vetorLinha   = explode(",", $linha);
                    $pessoa       = new Pessoa($conexao);
                    $pessoa->nome = $vetorLinha[1];
                    
                }
                fclose($f);
            }            
        }
    }else{
        die(json_encode(array('mensagem' => "Arquivo não encontrado, por favor selecione algum!!!", 'situacao' => false)));
    }
