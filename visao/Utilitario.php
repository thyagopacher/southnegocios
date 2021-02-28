<?php

/**
 * aplica mascara diversas no valor passado, por padrão setado a mascara de telefone
 * @param string $string valor para colocar mascara
 * @param string $mascara mascara para se colocar no valor
 */
class Utilitario {

    public static function mascara_string($string, $mascara = "(##)####-####") {
        $string2 = str_replace(" ", "", $string);
        $tam     = strlen($string2);
        for ($i = 0; $i < strlen($tam); $i++) {
            $mascara[strpos($mascara, "#")] = $string2[$i];
        }
        return $mascara;
    }

    public static function converteRealAmericano($valor){
        if(strpos($valor, "R$")){
            $valor = str_replace("R$", "", trim($valor));
        }else{
            $valor = trim($valor);
        }
        
        $valor = str_replace(".", "", $valor);
        return str_replace(",", ".", $valor); 
    }

}
