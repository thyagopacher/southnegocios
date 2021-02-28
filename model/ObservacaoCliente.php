<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class ObservacaoCliente{
    
    public $codobservacao;
    public $codpessoa;
    public $dtcadastro;
    public $texto;
    public $codempresa;
    public $codfuncionario;
    private $conexao;   
    
    public function __construct($conn) {
        $this->conexao = $conn;
    }
    
    public function __destruct() {
        unset($this);
    }
    
    public function inserir(){
        $sql = "insert into observacaocliente(codpessoa, dtcadastro, texto, codempresa, codfuncionario) 
        values('{$this->codpessoa}', '{$this->dtcadastro}', '".addslashes($this->texto)."', '{$this->codempresa}', '{$this->codfuncionario}');";
        return $this->conexao->comando($sql);
    }
    
    public function atualizar(){
        $setar = "";
        if(isset($this->texto) && $this->texto != NULL && $this->texto != ""){
            $setar .= ", texto = '".addslashes($this->texto)."'";
        }
        if(isset($this->codfuncionario) && $this->codfuncionario != NULL && $this->codfuncionario != ""){
            $setar .= ", codfuncionario = '{$this->codfuncionario}'";
        }
        return $this->conexao->comando("update observacaocliente set codpessoa = '{$this->codpessoa}',
        where codobservacao = '{$this->codobservacao}' {$setar} and codempresa = '{$this->codempresa}'");
    }  
    
    public function excluir($codobservacao){
        return $this->conexao->comando("delete from observacaocliente where codobservacao = '{$codobservacao}' and codempresa = '{$this->codempresa}'");
    }
    
    public function procuraCodigo($codobservacao){
        return $this->conexao->comandoArray("select * from observacaocliente where codobservacao = '{$codobservacao}' and codempresa = '{$this->codempresa}'");
    }
    
    public function procuraCodpessoa($codpessoa){
        return $this->conexao->comando("select * from observacaocliente where codpessoa = '{$codpessoa}' and codempresa = '{$this->codempresa}' order by dtcadastro");
    } 

    public function procuraData($dtcadastro1, $dtcadastro2){
        return $this->conexao->comando("select * from observacaocliente where dtcadastro >= '{$dtcadastro1}' and dtcadastro <= '{$dtcadastro2}' and codempresa = '{$this->codempresa}' order by dtcadastro");
    } 
    
}