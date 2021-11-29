<?php
require_once('../functions/database.php');
require_once('../functions/common.php');

$username = trim($_POST['username']);
$password = trim($_POST['password']);

if (empty($username) || empty($password)) {
	$pdo = null;
	response_header(
		false,
		'A senha e o usuário são campos obrigatórios'
	);
}

try {
	$statement = $pdo->prepare(
		"SELECT id, fullname, password
			FROM `users`
			WHERE `username` = :username"
	);
	$statement->execute([ 'username' => $username ]);

	$user = $statement->fetchObject();
	$pass_hashed = false;

	if ($user) {
		$pass_hashed = password_verify($password, $user->password);
	}

	if (!$user || !$pass_hashed) {
		$pdo = null;
		response_header(
			false,
			'O nome de usuário ou a senha não são correspondentes'
		);
	}

	unset($user->password);
	$pdo = null;
	response_header(
		true,
		'Login efetuado com sucesso',
		$user
	);
} catch (PDOException $e) {
	$pdo = null;
	response_header(
		false,
		'Um erro inesperado aconteceu. Por favor, tente mais tarde'
	);
}
