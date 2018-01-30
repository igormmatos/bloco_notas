<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

class Usuario
{
  private $id;
  private $email;
  private $senha;


  public function __construct ($id=null, $email=null, $senha=null)
  {
    $tipo_conexao = $_SERVER['HTTP_HOST'];

    define('SERVIDOR', 'mysql:host=localhost;dbname=bd_nota');
    define('USUARIO', 'root');
    define('SENHA', 'root');

    $this -> id = $id;
    $this -> email = $email;
    $this -> senha = $senha;
  }

  public function login()
  {
    $con = new PDO(SERVIDOR, USUARIO, SENHA);
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
    {
      $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
    {
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else{
      $ip = $_SERVER['REMOTE_ADDR'];
    }
    date_default_timezone_set('America/Sao_Paulo');
    $agora = date('Y-m-d H:i:s');

    $this->email=$_POST['email'];
    $this->senha=$_POST['senha'];

    $sql = $con->prepare("SELECT * FROM usuarios_nota WHERE email=? AND senha = ?");
    $sql->execute(array($this->email, $this->senha)) ;

    $r=$sql->fetch();

    if ($r){
      $_SESSION['logado'] = true;
      $_SESSION['user'] = $this->email;
      $_SESSION['user_id'] = $r['id'];
      $_SESSION['ip'] = $ip;

      $sql = $con->prepare("UPDATE usuarios_nota SET ip_acesso =?, ultimo_acesso=? WHERE id = ?");
      $sql->execute(array($ip,$agora,$_SESSION['user_id']));

      if(isset($_SESSION['msg']) || isset($_SESSION['alert'])){
        unset($_SESSION['msg']);
        unset($_SESSION['alert']);
      }
      header("Location: index.php");
    }
    else{
      $_SESSION['msg'] = "<strong>Login ou Senha</strong> incorretos!";
      $_SESSION['alert'] = "alert-danger";
    }
  }
  public function add(){
    $con = new PDO(SERVIDOR, USUARIO, SENHA);

    if($_POST['email'] != null && $_POST['senha'] != null){
      $this->email=$_POST['email'];
      $this->senha=$_POST['senha'];


      $sql = $con->prepare("SELECT * FROM usuarios_nota WHERE email=?");
      $sql->execute(array($this->email)) ;

      $r=$sql->fetch();

      if ($r){
        $_SESSION['msg'] = "<strong>Login</strong> já existe!";
        $_SESSION['alert'] = "alert-warning";
      }
      else{
        $sql = $con->prepare("INSERT INTO usuarios_nota VALUES(NULL,?,?)");

        $sql->execute(array($this->email, $this->senha)) ;
        header("Location: index.php");
      }
    }
    else
    {
      $_SESSION['msg'] = "<strong>Login ou Senha</strong> vazios!";
      $_SESSION['alert'] = "alert-danger";
    }
  }
}
