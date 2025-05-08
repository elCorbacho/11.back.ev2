<?php
// utils/Validator.php

class Validator {

    public static function esEmailValido($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function esNumeroEntero($valor) {
        return is_numeric($valor) && (int)$valor == $valor;
    }

    public static function esCadenaNoVacia($cadena) {
        return isset($cadena) && trim($cadena) !== '';
    }

    public static function esTelefonoValido($telefono) {
        return preg_match('/^\+?[0-9]{7,15}$/', $telefono);
    }

    public static function esFechaValida($fecha) {
        $d = DateTime::createFromFormat('Y-m-d', $fecha);
        return $d && $d->format('Y-m-d') === $fecha;
    }

    public static function esAnioValido($anio) {
        return preg_match('/^\d{4}$/', $anio) && $anio > 1900 && $anio <= (int)date('Y');
    }

    public static function esEnumValido($valor, $opciones) {
        return in_array($valor, $opciones);
    }

    public static function sanitizarTexto($texto) {
        return htmlspecialchars(strip_tags($texto));
    }
}
