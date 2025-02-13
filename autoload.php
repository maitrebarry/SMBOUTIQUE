<?php
require_once ('partials/database.php');
//inclure automatiquement les fichiers
spl_autoload_register (function ($class_name)
{
    $fils="classes/".$class_name.'.php';
    if (file_exists($fils)) {
        # code...
        require_once($fils);
    }
});
