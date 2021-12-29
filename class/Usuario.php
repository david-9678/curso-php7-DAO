<?php 

class Usuario {
    //atributos das colunas do banco de dados
    private $idusuario;
    private $deslogin;
    private $dessenha;
    private $dtcadastro;
    //getters and setters
    public function getIdusuario(){
        return $this->idusuario;
    }

    public function setIdusuario($value){
        $this->idusuario = $value;
    }

    public function getDeslogin(){
        return $this->deslogin;
    }

    public function setDeslogin($value){
        $this->deslogin = $value;
    }

    public function getDessenha(){
        return $this->dessenha;
    }

    public function setDessenha($value){
        $this->dessenha = $value;
    }

    public function getDtcadastro(){
        return $this->dtcadastro;
    }

    public function setDtcadastro($value){
        $this->dtcadastro = $value;
    }
    //função para carregar colunas do banco de dados pelo ID
    public function loadById($id){
        //objeto sql instanciando classe Sql
        $sql = new Sql();
        //$results retorna um array de arrays com os valores das colunas do ID, utilizando o método select que pertence à classe Sql ($sql está como instância da classe Sql)
        $results = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(
            ":ID"=>$id
        ));
        //verifica se o ID em questão existe e atribui o valor da colua aos setters
        if (count($results)>0){

            $row = $results[0];

            $this->setIdusuario($row['idusuario']);
            $this->setDeslogin($row['deslogin']);
            $this->setDessenha($row['dessenha']);
            $this->setDtcadastro(new datetime($row['dtcadastro']));

        }
    }
    //método construtor que exibe (echo) uma string (json) com os nomes dos campos
    public function __toString(){
        //retorna os valores com os getters
        return json_encode(array(
            "idusuario"=>$this->getIdusuario(),
            "deslogin"=>$this->getDeslogin(),
            "dessenha"=>$this->getDessenha(),
            "dtcadastro"=>$this->getDtcadastro()->format("d/m/Y H:i:s")
        ));

    }

}

 ?>