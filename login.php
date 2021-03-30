<?php
session_start();
include('conexao.php');

if(empty($_POST['usuario']) || empty($_POST['senha'])) {
	header('Location: index.php');
	exit();
}


$usuario = $_POST['usuario'];
$senha = $_POST['senha'];


    $conexao = conexao::getInstance();
	$sql = 'SELECT count(*) as contador  FROM tab_login WHERE usuario = :usuario and  senha = :senha';
	$stm = $conexao->prepare($sql);
	$stm->bindValue(':usuario', $usuario);
	$stm->bindValue(':senha', $senha);
	$retorno = $stm->execute();
	$row = $stm->fetch();
    $us = $row["contador"];
    var_dump($retorno);
	echo "executou".$us;



if($us == 1) {
	$_SESSION['usuario'] = $usuario;
	header('Location: lista_cliente.php');
	exit();
} else {
	$_SESSION['nao_autenticado'] = true;
	header('Location: index.php');
	exit();
}
