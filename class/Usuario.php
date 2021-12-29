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

            $this->setData($results[0]);

        }
    }

    //cria lista com todos os usuarios que estão na tabela
    //função pode ser estática porque não utiliza a pseudo-variável $this, portanto não precisa ser instanciada
    public static function getList(){
        $sql = new Sql();

        return $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin;");
    }

    public static function search($login){

        $sql = new Sql();

        return $sql->select("SELECT * FROM tb_usuarios WHERE deslogin LIKE :SEARCH ORDER BY deslogin", array(
            ':SEARCH'=>"%".$login."%" 
        ));

    }

    //função que verifica login e senha para exibir json
    public function login($login, $password){

        $sql = new Sql();
        $results = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN AND dessenha = :PASSWORD", array(
            ":LOGIN"=>$login,
            ":PASSWORD"=>$password
        ));
        if (count($results)>0){

            $this->setData($results[0]);

        } else {

            throw new Exception("Login e/ou senha inválidos.");

        }

    }

    //função para receber dados da variável
    public function setData($data){

        $this->setIdusuario($data['idusuario']);
        $this->setDeslogin($data['deslogin']);
        $this->setDessenha($data['dessenha']);
        $this->setDtcadastro(new datetime($data['dtcadastro']));

    }

    //criar um usuário novo a partir da classe de usuários
    public function insert(){

        $sql = new Sql();

        //sp_nomeDaTabela_oQueElaFaz
        //sp = Storage Procedure
        //select informa qual id foi selecionado na tabela
        //CALL para MySql, para Sqlserver EXECUTE
        //para tornar dinâmico, criar variável com switch
        //CONVENÇÃO para nomes no banco de dados:
        //v = variables;
        //p = parameters
        //sem prefixos: subentende-se que se trata do nome do campo da coluna da tabela
        $results = $sql->select("CALL sp_usuarios_insert(:LOGIN, :PASSWORD)", array(
            ':LOGIN'=>$this->getDeslogin(),
            ':PASSWORD'=>$this->getDessenha()
        ));

        if (count($results)>0) {
            $this->setData($results[0]);
        }

    }

    public function update($login, $password){

        $this->setDeslogin($login);
        $this->setDessenha($password);

        $sql = new Sql();

        $sql->query("UPDATE tb_usuarios SET deslogin = :LOGIN, dessenha = :PASSWORD WHERE idusuario = :ID", array(
            ':LOGIN'=>$this->getDeslogin(),
            ':PASSWORD'=>$this->getDessenha(),
            ':ID'=>$this->getIdusuario()
        ));

    }

    public function delete(){

        $sql = new Sql();
        //não utiliza o * pois este se refere às colunas, que de qualquer forma já serão eliminadas
        $sql->query("DELETE FROM tb_usuarios WHERE idusuario = :ID", array(
            ':ID'=>$this->getIdusuario()
        ));
        //posso colocar tudo como null também
        $this->setIdusuario(0);
        $this->setDeslogin("");
        $this->setDessenha("");
        $this->setDtcadastro(new DateTime());

    }

    //método construtor para objeto de instância da classe
    // o = "" serve para evitar erros: caso não for informado, retornará vazio, tornando-os parâmetros "não obrigatórios"
    public function __construct($login = "", $password = ""){

        $this->setDeslogin($login);
        $this->setDessenha($password);

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