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

/*
//carrega um usuário
$root = new Usuario();

$root->loadById(1);

echo $root;
*/
/*
//carrega um alista de usuários
$lista = Usuario::getList();

echo json_encode($lista);
*/

/*
//Carrega um alista de usuários pelo login
$search = Usuario::search("jo");

echo json_encode($search);
*/

/*
//carrega o usuário usando o login e a senha
$usuario = new Usuario();
$usuario->login("root", "!@#$%");

echo $usuario;
*/

/*
//criando um novo usuário
$aluno = new Usuario("aluno", "@lun0");


//trecho desnecessário, pois os parâmetros de login serão //passados por método construtor
//$aluno->setDeslogin("aluno");
//$aluno->setDessenha("@lun0");


$aluno->insert();

echo $aluno;
*/

/*
//Alterar um usuário
$usuario = new Usuario();

$usuario->loadById(8);

$usuario->update("professor", "!@#$%¨&*");

echo $usuario;
*/

$usuario = new Usuario();

$usuario->loadById(7);

$usuario->delete();

echo $usuario;

 ?>