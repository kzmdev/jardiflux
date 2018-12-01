<?php
$test = '{"identifier":"1365965","values":{"variante_name":[{"locale":null,"scope":null,"data":"TEST STAN2"}]}}';
$new = json_decode($test);
var_dump($new);

$o = new \stdClass();
$o->identifier = "1365965";
$o->values = new \stdClass();
$o->values->variante_name = [];
$o->values->variante_name[0] = new \stdClass();
$o->values->variante_name[0]->locale = null;
$o->values->variante_name[0]->scope = null;
$o->values->variante_name[0]->data = "TEST STAN2";

echo json_encode($o);
echo "<br>";
echo $test;
echo "<br>";
echo json_encode($new);
?>