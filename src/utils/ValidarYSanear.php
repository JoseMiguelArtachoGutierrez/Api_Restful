<?php

namespace utils;

class ValidarYSanear{

    public static function validarYSanearString($cadena){
        return filter_var($cadena, FILTER_SANITIZE_STRING);
    }
    public static function validarYSanearInt($cadena){
        return filter_var($cadena, FILTER_SANITIZE_NUMBER_INT);
    }
    public static function validarYSanearEmail($cadena){
        return filter_var($cadena, FILTER_SANITIZE_EMAIL);
    }
    public static function quitarEtiquetasYEspacios($cadena){
        $cadena= strip_tags($cadena);
        return trim($cadena);
    }
}