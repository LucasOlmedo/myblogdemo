<?php

function tStr($string){
    return addslashes(htmlentities(utf8_decode(trim($string))));
}

// gera a URL amigável
function limpaUrl($str){
    $str = strtolower(utf8_decode($str)); $i=1;
    $str = strtr($str, utf8_decode('àáâãäåæçèéêëìíîïñòóôõöøùúûýýÿ'), 'aaaaaaaceeeeiiiinoooooouuuyyy');
    $str = preg_replace("/([^a-z0-9])/",'-',utf8_encode($str));
    while($i>0) $str = str_replace('--','-',$str,$i);
    if (substr($str, -1) == '-') $str = substr($str, 0, -1);
    return $str;
}
// recebe uma data e hora no formato dd/mm/aaaa hh:mm:ss
// para o formato aaaa-mm-dd hh:mm:ss
// o nome significa brasil to datetime
function brToDt($val=null,$now=null){
	if($val==null){
		$date = new DateTime();
		return $date->format('Y-m-d H:i:s');
	}

	$tmp1 = explode(" ",$val);
	
	// se $tmp1[1] não existir, significa que pode ter vindo 
	// somente a data, exemplo, dd/mm/aaaa
	// sendo assim vamos considerar o valor 00:00:00 para o segundo campo
	if(!isset($tmp1[1])){
		if($now==null){
			$tmp1[1] = "00:00:00";
		} else {
			$date = new DateTime();
			$tmp1[1] = $date->format('H:i:s');
		}
	}
	
	// precisamos formatar somente $tmp1[0]
	$tmp2 = explode("/",$tmp1[0]);
	
	// vamos verificar se o resultado final é válido
	$datetime = $tmp2[2]."-".$tmp2[1]."-".$tmp2[0]." ".$tmp1[1];
	
	if(validateDate($datetime)){
		return $datetime;
	} else {
		return "0000-00-00 00:00:00";
	}
}

// recebe uma data e hora no formato aaaa-mm-dd hh:mm:ss
// e retorna dd/mm/aaaa hh:mm:ss
function dtToBr($val=null,$now=null){
	if($val == null){
		$date = new DateTime();
		return $date->format('d/m/Y H:i:s');
	}

	// vamos verificar se o que recebemos é valido
	if(validateDate($val)){
		$date = new DateTime($val);
		return $date->format('d/m/Y H:i:s');
	} else {
		if($now==null){
			return "00/00/0000 00:00:00";
		} else {
			$date = new DateTime();
			return $date->format('d/m/Y H:i:s');
		}
	}
}

function validateDate($date, $format = 'Y-m-d H:i:s'){
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
	
	/*if (date($format, strtotime($date)) == $data) {
        return true;
    } else {
        return false;
    }*/
}