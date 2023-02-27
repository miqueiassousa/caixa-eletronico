<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>

	<link rel="stylesheet" href="assets\bootstrap\css\bootstrap.min">

	<script src="assets/js/jquery.js"></script>
	<script src="assets/js/navbar-animation-fix.js"></script>
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
	
</body>
</html>

<?php
session_start();
require 'config.php';

if (isset($_POST['agencia']) && empty($_POST['agencia']) == false) {
	$agencia = addslashes($_POST['agencia']);
	$conta = addslashes($_POST['conta']);
	$senha = addslashes($_POST['senha']);

	$sql = $pdo->prepare("SELECT * FROM contas WHERE agencia = :agencia AND conta = :conta AND senha = :senha");
	$sql->bindValue(":agencia", $agencia);
	$sql->bindValue(":conta", $conta);
	$sql->bindValue(":senha", md5($senha));
	$sql->execute();

	if ($sql->rowCount() > 0) {
		$sql = $sql->fetch();

		$_SESSION['banco'] = $sql['id'];
		header("Location: index.php");
		exit;
	}
}

?>

<html>

<head>
	<title>Caixa Eletrônico</title>
</head>
<div class="container">

	<body>
		<form method="POST">
</br>
			<b>Utilizar para teste: Agencia: 123 Conta: 123 Senha: 123</b>
			<hr>
			Agência:<br />
			<input type="text" name="agencia" /><br /><br />
			Conta:<br />
			<input type="text" name="conta" /><br /><br />
			Senha: <br />
			<input type="password" name="senha">

			<input type="submit" name="Entrar">
		</form>
	</body>
</div>