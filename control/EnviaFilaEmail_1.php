<?php

include("../model/Conexao.php");
include("../model/FilaEmail.php");
$conexao = new Conexao();
$fila    = new FilaEmail($conexao);
$resfila = $fila->procuraNEnviado();
$qtdfila = $conexao->qtdResultado($resfila);
if ($qtdfila > 0) {
    include("./Email.php");
    while ($fila2 = $conexao->resultadoArray($resfila)) {
        $email        = new Email();
        $empresa      = $conexao->comandoArray("select razao, email, logo, telefone, tipologradouro, logradouro, numero, bairro, cidade, uf from empresa where codempresa = '{$fila2["codempresa"]}'");    
        $configuracao = $conexao->comandoArray("select copiaemail from configuracao where codempresa = '{$fila2["codempresa"]}'");
        $sql = "select pessoa.nome, pessoa.email, telefone.numero as telefone 
        from pessoa
        left join telefone on telefone.codpessoa = pessoa.codpessoa and telefone.codempresa = pessoa.codempresa and telefone.tipo = 'f'
        where pessoa.codpessoa = '{$fila2["codfuncionario"]}'";
        $funcionario  = $conexao->comandoArray($sql);
        $email->origem       = $empresa["razao"];
        $email->origem_email = $empresa["email"];
        if(isset($fila2["codpagina"]) && $fila2["codpagina"] != NULL && $fila2["codpagina"] > 0){
            $sql = "select * from retornoemail where codpagina = '{$fila2["codpagina"]}' and codempresa = '{$fila2["codempresa"]}'";
            $retorno = $conexao->comandoArray($sql);
            if(isset($retorno["email"]) && $retorno["email"] != NULL && $retorno["email"] != ""){
                $email->origem_email = $retorno["email"];
            }
        }
        if($fila2["tipo"] == 1){
            $email->trocaSenha();
        }            
        $email->assunto      = $fila2["assunto"];
        $email->para         = $fila2["para"];
        $email->para_email   = $fila2["para_email"];
        $email->mensagem     = $fila2["texto"];
        $assinatura = $conexao->comandoArray("select * from assinaturaemail where codempresa = '{$fila2["codempresa"]}'");
        $email->mensagem    .= "<br>".trocaPalavraChave($assinatura["texto"], $empresa, $funcionario);

        if(strpos($email->assunto, "Reenvio de senha para acesso condominio - Condominio") == FALSE && strpos($email->assunto, "Reenvio de senha para acesso ao GestCCon") == FALSE && strpos($email->assunto, "Cadastro efetuado no condom") == FALSE){
            if(isset($configuracao) && isset($configuracao["copiaemail"]) && $configuracao["copiaemail"] != NULL && $configuracao["copiaemail"] != ""){
                $email->copia       = "";
                $email->copia_email = $configuracao["copiaemail"];
            }
        }
 
        $resenvioEmail = $email->envia(); 
        if($resenvioEmail){
            $sql = "update filaemail set situacao = 's' where codfila = '{$fila2["codfila"]}'
            and codempresa = '{$fila2["codempresa"]}'";
            $resfilaAtualizacao = $conexao->comando($sql);
            if($resfilaAtualizacao == FALSE){
                $texto = "A fila de e-mails falhou dia ".date("d/m/Y H:i:s"). " 
                ao enviar para {$fila2["para"]}, foram enviados porém não conseguiu atualizar status do enviado!";
                mail("thyago.pacher@gmail.com", "Falha no envio da fila de e-mails gestccon", $texto);                
            }
        }else{
            $texto = "A fila de e-mails falhou dia ".date("d/m/Y H:i"). " ao enviar para {$fila2["para"]}. Erro caussado por:". $email->erro; 
            mail("thyago.pacher@gmail.com", "Falha no envio da fila de e-mails gestccon", $texto);
            break;
        }
        unset($email);
    }
}


function trocaPalavraChave($texto, $empresa, $funcionario){
    $texto = str_replace("][", "] [", $texto);
    $texto = str_replace("\n", "<br>", $texto);
    $texto = (str_replace("[logo]", '<img width="100" src="http://gestccon.com.br/sistema/arquivos/'.$empresa["logo"].'" alt="Logo da empresa" title="Logo condominio"/>', $texto));
    $texto = str_replace("[data]", date("d/m/Y H:i:s"), $texto);
    $texto = str_replace("[nome_funcionario]", $funcionario["nome"], $texto);
    if(isset($funcionario) && strpos($texto, "[email_funcionario]")){
        $texto = str_replace("[email_funcionario]", $funcionario["email"], $texto);
    }
    if(isset($funcionario) && strpos($texto, "[telefone_funcionario]")){
        $texto = str_replace("[telefone_funcionario]", $funcionario["telefone"], $texto);
    }
    if(isset($empresa) && strpos($texto, "[condominio]")){
        $texto = str_replace("[condominio]", $empresa["razao"], $texto);
    }
    if(isset($empresa) && strpos($texto, "[telefone_condominio]")){
        $texto = str_replace("[telefone_condominio]", $empresa["telefone"], $texto);
    }
    if(isset($funcionario) && strpos($texto, "[endereco_condominio]")){
        $endereco  = "{$empresa["tipologradouro"]}: {$empresa["logradouro"]} {$empresa["numero"]}<br>";
        $endereco .= "Bairro: {$empresa["bairro"]} - Cidade: {$empresa["cidade"]}, Estado: {$empresa["uf"]}<br>";
        $texto     = str_replace("[endereco_condominio]", $endereco, $texto);
    }
    $texto = str_replace("src=\"", 'src="', $texto);
    return ($texto);
}        