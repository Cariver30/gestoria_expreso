<?php
    namespace App\Helpers;


class Helper {
    
    public static function capitalizeFirst($cadena, $all=null){
        if(!$all) {
            $fc = mb_strtoupper(mb_substr($cadena, 0, 1));
            return $fc.mb_strtolower(mb_substr($cadena, 1));
        }
        return mb_convert_case($cadena, MB_CASE_TITLE, 'UTF-8');
    }
}
