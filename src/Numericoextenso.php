<?php namespace Mozware\Numericoextenso;

 class Numericoextenso {
 
 	function extenso($valor = 0, $maiusculas = false) {
    
	    if(!$maiusculas){

	        $singular = ["centavo", "metical", "mil", "milhão", "bilhão", "trilhão", "quatrilhão"];
	        $plural = ["centavos", "meticais", "mil", "milhões", "bilhões", "trilhões", "quatrilhões"];
	        $u = ["", "um", "dois", "três", "quatro", "cinco", "seis",  "sete", "oito", "nove"];

	    }else{

	        $singular = ["CENTAVO", "METICAL", "MIL", "MILHÃO", "BILHÃO", "TRILHÃO", "QUADRILHÃO"];
	        $plural = ["CENTAVOS", "METICAIS", "MIL", "MILHÕES", "BILHÕES", "TRILHÕES", "QUADRILHÕES"];
	        $u = ["", "um", "dois", "três", "quatro", "cinco", "seis",  "sete", "oito", "nove"];
	    }

    $c = ["", "cem", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos"];
    
    $d = ["", "dez", "vinte", "trinta", "quarenta", "cinquenta", "sessenta", "setenta", "oitenta", "noventa"];
    
    $d10 = ["dez", "onze", "doze", "treze", "catorze", "quinze", "dezesseis", "dezessete", "dezoito", "dezenove"];

    $z = 0;
    $rt = "";

    $valor = number_format($valor, 2, ".", ".");
    $inteiro = explode(".", $valor);
    for($i=0;$i<count($inteiro);$i++)
    for($ii=strlen($inteiro[$i]);$ii<3;$ii++)
    $inteiro[$i] = "0".$inteiro[$i];

    $fim = count($inteiro) - ($inteiro[count($inteiro)-1] > 0 ? 1 : 2);
    for ($i=0;$i<count($inteiro);$i++) {
        $valor = $inteiro[$i];
        $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
        $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
        $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : ""; 
        
        $r = $rc.(($rc && ($rd || $ru)) ? " e " : "").$rd.(($rd &&
        $ru) ? " e " : "").$ru;

        $t = count($inteiro)-1-$i;

        $r .= $r ? " ".($valor > 1 ? $plural[$t] : $singular[$t]) : " ";
        if ($valor == "000")$z++; elseif ($z > 0) $z--;
        if (($t==1) && ($z>0) && ($inteiro[0] > 0)) $r .= (($z>1) ? " de " : "").$plural[$t];
        if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
    }

    if(!$maiusculas){
        $return = $rt ? $rt : "zero";
    } else {
        
        if ($rt) $rt = ereg_replace(" E "," e ",ucwords($rt));
            $return = ($rt) ? ($rt) : "Zero" ;
    }

    if(!$maiusculas){
       
       return preg_replace("/E /","e ",ucwords($return));
       //return $return;

    }else{
	        return strtoupper($return);
	    }
	}
	
      function mostrar($valor){

        $dim = Numericoextenso::extenso($valor);
        $valor = number_format($valor, 2, ",", ".");
        $partes = explode(" ", $dim);
        
         $dim1=null;
         $dim2 =[];

         if(strcmp($partes[1],"Um")==0){

          for($i=1; $i<=count($partes); $i++){

                $dim2[$i]=$partes[$i+1];
                $dim1= implode(" ", $dim2);
          }

           return $dim1;

         } else{

          return $dim;
        };
   }
}