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

if(isset($_SESSION['banco']) && empty($_SESSION['banco']) == false) {
	$id = $_SESSION['banco'];

	$sql = $pdo->prepare("SELECT * FROM contas WHERE id = :id");
	$sql->bindValue(":id", $id);
	$sql->execute();

	if($sql->rowCount() > 0) {
		$info = $sql->fetch();
	} else {
		header("Location: login.php");
		exit;
	}

} else {
	header("Location: login.php");
	exit;
}
?>

<html>
<head>
	<title>Caixa Eletronico</title>
</head>

<div class="container">
<body>
	<h1>Banco Miq Bank</h1>
	Titular: <?php echo $info['titular'];?><br/>
	Agencia: <?php echo $info['agencia'];?><br/>
	Conta: <?php echo $info['conta'];?><br/>
	Saldo <?php echo $info['saldo'];?><br/>
	<a href="sair.php">Sair</a>

<hr>
<h3>Movimentação Extrato</h3>

<a href="add-transacao.php">Adicionar Transação</a><br/>
<table border="1" width="400">
	<tr>
		<th>Data</th>
		<th>Valor</th>
		<th>Tipo</th>
	</tr>
	<?php
	$sql = $pdo->prepare("SELECT * FROM historico WHERE id_conta = :id_conta");
	$sql->bindValue(":id_conta", $id);
	$sql->execute();

	if($sql->rowCount() > 0) {
		foreach ($sql->fetchAll() as $item) {
		?>
		<tr>
			<td><?php echo date('d/m/y H:i', strtotime($item['data_operacao']));?>
			<td>
				<?php if($item['tipo'] == '0'): ?>
				<font color="green">R$ <?php echo $item['valor'] ?></font>
				<?php else: ?>
				<font color="red">- R$ <?php echo $item['valor'] ?></font>
				<?php endif; ?>
			</td>
			<td>
				<?php if($item['tipo'] == '0'): ?>
				<font color="green"><?php echo $item['transacao'] ?></font>
				<?php else: ?>
				<font color="red"><?php echo $item['transacao'] ?></font>
				<?php endif; ?>
			</td>
		</tr>
		<?php
		}
	}
	?>
</table>
</br>
</div>



