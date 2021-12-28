<?php 

class Sql extends PDO{

	//variável de conexão
	private $conn;

	//método construtor para conectar autmaticamente no banco de dados
	public function __construct(){
		
		//colocar parâmetros do PDO no atributo conn (pode ser passado por parâmero - parametrizado)
		$this->conn = new PDO("mysql:host=localhost;dbname=dbphp7", "root", "Mysql31840615#" );
	}


	//deixar parâmetros disponíveis para outros métodos
	private function setParams($statment, $parameters = array()){

		//associar parâmetros
		foreach ($parameters as $key => $value) {
			
			$this->setParam($key, $value);

		}

	}

	private function setParam($statment, $key, $value){

		//bindParam para cada parâmetro associado
		$statment->bimdParam($key, $value);

	}


	//função para comandos no banco de dados
	//rawQuery: bruta para ser tratada
	//params por padrão serão array
	public function query($rawQuery, $params = array()){

		//variável stmt somente de dentro da function
		//classe estendida, potanto tem acesso ao prepare
		$stmt = $this->conn->prepare($rawQuery);

		//seta cada um dos params
		$this->setParams($stmt, $params);

		//execução do comando no banco de dados sem retorno de dado algum
		//stmt retorna ele mesmo
		$stmt->execute();

		//retorna o stmt
		return $stmt;

	}

	//método para SELECT
	//parmâmetros por padrão como array
	public function select($rawQuery, $params = array()):array{

		//chama função query para preparar query e setar os parâmetros
		$stmt = $this->query($rawQuery, $params);

		//variável stmt como resposta porque o método fetch(objeto) está dentro do stmt
		//FETCH_ASSOC retorna somente os dados associativos, sem os indexs
		//return retorna o array (conforme declaração de retorno na reclaração da função) com todos os dados
		return $stmt->fetchAll(PDO::FETCH_ASSOC);

	}

}

 ?>