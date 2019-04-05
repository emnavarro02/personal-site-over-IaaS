<?php

function getObjectFromFile($filename)
{
    $str = file_get_contents($filename);
    return json_decode($str);
}

$config = getObjectFromFile('config/config.json');

$info =  getObjectFromFile('config/info.json');
