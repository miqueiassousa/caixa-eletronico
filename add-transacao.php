<?php
session_start();
require 'config.php';

if(isset($_POST['tipo'])) {
	$tipo = $_POST['tipo'];
	$valor = str_replace(",", ".", $_POST['valor']); // Padrão BR, altera o "." pela "," 
	$valor = floatval($valor); // Retorna um numero decimal

	if($tipo == 0) 
		{
			$transacao = 'Deposito';
		}	
	else 
		{
			$transacao = 'Saque';	
		}
	

	$sql = $pdo->prepare("INSERT INTO historico (id_conta, tipo, valor, data_operacao,transacao) VALUES (:id_conta, :tipo, :valor, NOW(), :transacao )");
	$sql->bindValue(":id_conta", $_SESSION['banco']);
	$sql->bindValue(":tipo", $tipo);
	$sql->bindValue(":valor", $valor);
	$sql->bindValue(":transacao", $transacao);
	$sql->execute();

	if($tipo == '0') {
		
		$sql = $pdo->prepare("UPDATE contas SET saldo = saldo + :valor WHERE id = :id");
		$sql->bindValue(":valor", $valor);
		$sql->bindValue(":id", $_SESSION['banco']);
		$sql->execute();
	} else {
		//Saque
		$sql = $pdo->prepare("UPDATE contas SET saldo = saldo - :valor WHERE id = :id");
		$sql->bindValue(":valor", $valor);
		$sql->bindValue(":id", $_SESSION['banco']);
		$sql->execute();

	}
	header("Location: index.php");
	exit;
} 

?>
<html>
<head>
	<title>Caixa Eletrônico</title>
</head>

<body>
	<form method="POST">
		Tipo de transação:<br/>
		<select name="tipo">
			<option value="0">Depósito</option>
			<option value="1">Retirada</option>
		</select></br><br/>

		Valor:<br/>

		<input type="text" name="valor" pattern="[0-9.,]{1,}" /><br/><br/> <!-- pattern: O padrão que pode ser aceito nesse campo -->

		<input type="submit" value="Adicionar" />
	</form>
</body>