<?php

class Reponse
{
    public static function reponseJsonEtDie($tableauAConvertir)
    {
        echo json_encode($tableauAConvertir, JSON_PRETTY_PRINT);
        die();
    }
    public static function reponseJsonSansDie($tableauAConvertir)
    {
        echo json_encode($tableauAConvertir, JSON_PRETTY_PRINT);
    }
}