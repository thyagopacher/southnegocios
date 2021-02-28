<?php


session_start();
//validação caso a sessão caia
if (!isset($_SESSION)) {
    die(json_encode(array('mensagem' => 'Sua sessão caiu, por favor logue novamente!!!', 'situacao' => false)));
}

function __autoload($class_name) {
    if (file_exists("../model/" . $class_name . '.php')) {
        include "../model/" . $class_name . '.php';
    } elseif (file_exists("../visao/" . $class_name . '.php')) {
        include "../visao/" . $class_name . '.php';
    } elseif (file_exists("./" . $class_name . '.php')) {
        include "./" . $class_name . '.php';
    }
}

// Tamanho máximo do arquivo (em Bytes)
$_UP['tamanho'] = 1024 * 1024 * 2; // 2Mb
$_UP['extensoes'] = array('jpg', 'png', 'gif', 'pdf'); // Array com as extensões permitidas
// Array com os tipos de erros de upload do PHP
$_UP['erros'][0] = 'Não houve erro';
$_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
$_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
$_UP['erros'][4] = 'Não foi feito o upload do arquivo';

$conexao = new Conexao();
$proposta = new Proposta($conexao);

$msg_retorno = "";
$sit_retorno = true;

$variables = (strtolower($_SERVER["REQUEST_METHOD"]) == "GET") ? $_GET : $_POST;
foreach ($variables as $key => $value) {
    $proposta->$key = $value;
}

if (!isset($proposta->codtabelap) || $proposta->codtabelap == NULL || $proposta->codtabelap == "") {
    die(json_encode(array('mensagem' => "Não pode realizar a proposta sem escolher uma tabela e um prazo!!!", 'situacao' => false)));
}

/* * setando beneficio */
if (isset($proposta->beneficio) && $proposta->beneficio != NULL && $proposta->beneficio != "") {
    $beneficiop = $conexao->comandoArray('select codbeneficio from beneficiocliente as beneficio where numbeneficio = "' . $proposta->beneficio . '"');
    if (isset($beneficiop["codbeneficio"]) && $beneficiop["codbeneficio"] != NULL && $beneficiop["codbeneficio"] != "") {
        $proposta->codbeneficio = $beneficiop["codbeneficio"];
    } else {
        $beneficio = new BeneficioCliente($conexao);
        $beneficio->codespecie = $_POST["codespecie"];
        $beneficio->codorgao = 5;
        $beneficio->codpessoa = $proposta->codcliente;
        $beneficio->matricula = $proposta->beneficio;
        $beneficio->numbeneficio = $proposta->beneficio;
        $beneficio->salariobase = 0;
        $beneficio->situacao = 'ativo';
        $resInserirBeneficio = $beneficio->inserir();
        if ($resInserirBeneficio == FALSE) {
            die(json_encode(array('mensagem' => "Erro ao inserir beneficio:" . mysqli_error($conexao->conexao), 'situacao' => false)));
        }
        $proposta->codbeneficio = mysqli_insert_id($conexao->conexao);
    }
}

$proposta->vlsolicitado = str_replace(",", ".", $proposta->vlsolicitado);
$proposta->vlliberado = str_replace(",", ".", $proposta->vlliberado);
$proposta->vlparcela = str_replace(",", ".", $proposta->vlparcela);
$proposta->codempresa = $_SESSION['codempresa'];
if (isset($_POST["codvendedor"]) && $_POST["codvendedor"] != NULL && $_POST["codvendedor"] != "") {
    $proposta->codfuncionario = $_POST["codvendedor"];
} else {
    $proposta->codfuncionario = $_SESSION['codpessoa'];
}
$resAtualizaCliente = $conexao->comando("update pessoa set codcategoria = 1 where codpessoa = '{$proposta->codcliente}' and codempresa = '{$_SESSION['codempresa']}'");
if ($resAtualizaCliente == FALSE) {
    die(json_encode(array('mensagem' => "Erro ao atualizar cliente de callcenter para cliente padrão! Causado por:" . mysqli_error($conexao->conexao), 'situacao' => false)));
}


$res = $proposta->inserir();
$codigo_proposta = mysqli_insert_id($conexao->conexao);
if ($res === FALSE) {
    $msg_retorno = "Erro ao cadastrar proposta! Causado por:" . mysqli_error($conexao->conexao);
    mail("thyago.pacher@gmail.com", "Erro sistema - control/InserirProposta.php", $msg_retorno);
    $sit_retorno = false;
} else {
    $msg_retorno = "Proposta cadastrado com sucesso!";
    $sit_retorno = true;

    $funcionario = $conexao->comandoArray('select nome, porcentagem from pessoa where codpessoa = ' . $proposta->codfuncionario . ' and codempresa = ' . $_SESSION["codempresa"]);
    $cliente = $conexao->comandoArray('select nome, cpf from pessoa where codpessoa = ' . $proposta->codcliente . ' and codempresa = ' . $_SESSION["codempresa"]);

    /*     * inseri em cta a pagar proposta paga */
    $conta = new Conta($conexao);
    $conta->codempresa = $_SESSION["codempresa"];
    $conta->codfuncionario = $_SESSION["codpessoa"];
    $conta->codtipo = $codigo_tipo;
    $conta->codproposta = $codigo_proposta;
    $conta->dtcadastro = date("Y-m-d H:i:s");
    $conta->movimentacao = "D";
    $conta->nome = "Comissão funcionário: " . $funcionario["nome"] . " - Proposta para cliente: {$cliente["nome"]} - CPF: {$cliente["cpf"]}";
    $conta->valor = $funcionario["porcentagem"] * $proposta->vlliberado;
    $resInserirComissao = $conta->inserir();
    if ($resInserirComissao == FALSE) {
        die(json_encode(array('mensagem' => "Erro ao inserir comissão:" . mysqli_error($conexao->conexao), 'situacao' => false)));
    }

    $observacao = new ObservacaoProposta($conexao);
    $observacao->codcliente = $proposta->codcliente;
    $observacao->codempresa = $_SESSION['codempresa'];
    $observacao->codfuncionario = $_SESSION['codpessoa'];
    $observacao->codstatus = $proposta->codstatus;
    $observacao->dtcadastro = date("Y-m-d H:i:s");
    $observacao->observacao = addslashes($_POST["observacao"]);
    $observacao->codbanco = $proposta->codbanco;
    $observacao->codconvenio = $proposta->codconvenio;
    $observacao->codtabela = $proposta->codtabela;
    $observacao->prazo = $proposta->prazo;
    $observacao->valor = str_replace(",", ".", $proposta->vlsolicitado);
    $observacao->codproposta = $codigo_proposta;
    $resInserirObservacao = $observacao->inserir();
    if ($resInserirObservacao == FALSE) {
        die(json_encode(array('mensagem' => "Observação de proposta não pode ser inserida por:" . mysqli_error($conexao->conexao), 'situacao' => false)));
    }

    $resdocumento = $conexao->comando("select * from documento where codbanco = 0 order by nome");
    $qtddocumento = $conexao->qtdResultado($resdocumento);
    if ($qtddocumento > 0) {
        while ($documento = $conexao->resultadoArray($resdocumento)) {
            $upload = new Upload($_FILES["arquivopessoa" . $documento["coddocumento"]]);
            if ($upload->erro == "") {
                $arquivo = new ArquivoPessoa($conexao);
                $arquivo->link = $upload->nome_final;
                $arquivo->codempresa = $_SESSION['codempresa'];
                $arquivo->codfuncionario = $_SESSION['codpessoa'];
                $arquivo->data = date('Y-m-d');
                $arquivo->nome = "documento" . $documento["coddocumento"];
                $arquivo->dtcadastro = date("Y-m-d H:i:s");
                $arquivo->codpessoa = $proposta->codcliente;
                $resInserirArquivo = $arquivo->inserir();
                if ($resInserirArquivo == FALSE) {
                    die(json_encode(array('mensagem' => "Não pode inserir:" . mysqli_error($conexao->conexao), 'situacao' => false)));
                }
            }
        }
    }
}

echo json_encode(array('mensagem' => $msg_retorno, 'situacao' => $sit_retorno));
