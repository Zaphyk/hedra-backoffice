<?php
	
	function filter($text){
		//var $array_raw = "QWERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm,.1234567890$%|_-";
		//var $array_clean = array();
		//for($i = 0; $i < strlen($array_raw); $i++){
		//	array_push($array_clean, $array_raw[$i]);
		//}
		//return filter_advanced("GET_param", $text, $out, $array_clean);	
        return htmlspecialchars($text);
    }
/*
	function filter_advanced($name, $value, $resultado, $values, $largo = 60, $multilinias = false)
    {
        if (strlen($value) <= $largo) {

            for ($i = 0; $i < strlen($value); $i++) {
                $char = substr($value, $i, 1);

                //TODO REVISAR ACA PORQUE ESTO ES RARO
                if (((strpos($values, $char)) === false && $multilinias == false) || ($multilinias == true && (strpos($values, $char) === false && $char != PHP_EOL && $char != "\n" && $char != "\r"))) {
                    $value = "";
                    //$this->resultadoError($resultado, $name . _INVALID_CHARACTERS);
                    break;
                }
            }
        } else {
            $value = "";
            //$this->resultadoError($resultado, $name . _IS_TOO_LONG);
        }

        if (htmlspecialchars($value) !== $value) {
            $value = "";
            //$this->resultadoError($resultado, $name . _INVALID_FORMAT);
        }
        return $value;
    }
*/

?>