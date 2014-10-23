<?php
spl_autoload_register(function ($class) {
    require_once( 'classes/' . $class . '.class.php');
});

// Tableau de test
$tab = array(
	0 => array(
		"id" => "01234",
		"firstname" => "Thomas",
		"lastname" => "Moreira",
		"num" => "0123456789"
	),
	1 => array(
		"id" => "45765",
		"firstname" => "Amélie",
		"lastname" => "Camama",
		"num" => "1234567890"
	),
	2 => array(
		"id" => "39676",
		"firstname" => "Buzz",
		"lastname" => "La Foudre",
		"num" => "2345678901"
	)
);

$tab = new Tableau($tab);

echo "<pre>";
var_dump($tab->listBy("id"));
echo "</pre>";
?>