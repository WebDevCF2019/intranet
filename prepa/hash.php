<?php
echo "<h3>Codage de admin avec password_hash</h3>";
echo $a = password_hash("admin",PASSWORD_DEFAULT);
echo "<br>";
echo $b = password_hash("admin",PASSWORD_DEFAULT);
echo "<br>";
echo $c = password_hash("admin",PASSWORD_DEFAULT);
echo "<br>";
echo $d = password_hash("admin",PASSWORD_DEFAULT);
echo "<br>";
echo password_verify("admin",$a);
echo "<br>";
echo password_verify("admin",$b);
echo "<br>";
echo password_verify("admin",$c);
echo "<br>";
echo password_verify("admin",$d);
echo "<br>";




$mdp = ["admin","test","xc25d9"];

foreach ($mdp AS $key => $item){
    $arr[$key]=password_hash($item,PASSWORD_DEFAULT);
    $unique[]=uniqid('key',true);
    echo (password_verify($item,$arr[$key]))? "ok<br>" : "ko<br>";
}

echo "<pre>";
var_dump($arr,$unique);
echo "</pre>";

foreach ($mdp AS $key => $item){
    $arr[$key]=password_hash($item,PASSWORD_DEFAULT);
    echo (password_verify($item,$arr[$key]))? "ok<br>" : "ko<br>";
}
foreach ($mdp AS $key => $item){
    echo (password_verify($item,$arr[$key]))? "ok<br>" : "ko<br>";
}
echo "<pre>";
var_dump($arr,$unique);
echo "</pre>";