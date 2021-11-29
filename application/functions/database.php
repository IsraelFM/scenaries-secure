<?php
require_once('../functions/common.php');

$database = getenv('MYSQL_DATABASE');
$password = getenv('MYSQL_PASSWORD');
$user = getenv('MYSQL_USER');

try {
	$pdo = new PDO(
		"mysql:host=database:3306;dbname=$database",
		$user,
		$password,
	);
} catch (PDOException $e) {
	$pdo = null;
	response_header(
		false,
		'Infelizmente não foi possível processar o serviço solicitado. Tente novamente mais tarde'
	);
	die();
}
