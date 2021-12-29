<?php 

require_once("config.php");
/*
//objeto $sql como instância da classe Sql
$sql = new Sql();
//variável $usuarios armazena array de arrays com todas as colunas de todas as linhas do banco de dados tb_usuarios
$usuarios = $sql->select("SELECT * FROM tb_usuarios");
//exibe json com os dados armazenados em $usuarios
echo json_encode($usuarios);
*/

$root = new Usuario();

$root->loadById(1);

echo $root;

 ?>