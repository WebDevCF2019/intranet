<?php

$mdp = ["admin","test","xc25d9"];

foreach ($mdp AS $key => $item){
    $arr[]=password_hash($item,PASSWORD_DEFAULT);
    $unique[]=uniqid('key',true);
    echo (password_verify($item,$arr[$key]))? "ok<br>" : "ko<br>";
}

echo "<pre>";
var_dump($arr,$unique);
echo "</pre>";