<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

class Notas
{
  private $id;
  private $titulo;
  private $descricao;
  private $prioridade;
  private $data_entrega;
  private $status;
  private $data_adicao;
  private $user_id;

  public function __construct ($id=null, $prioridade=null, $status=null, $titulo=null, $descricao=null, $data_entrega=null,$data_adicao=null, $user_id =null)
  {
    $tipo_conexao = $_SERVER['HTTP_HOST'];

    define('SERVIDOR', 'mysql:host=localhost;dbname=bd_nota');
    define('USUARIO', 'root');
    define('SENHA', 'root');
    $this -> id = $id;
    $this -> titulo = $titulo;
    $this -> descricao = $descricao;
    $this -> prioridade = $prioridade;
    $this -> data_entrega = $data_entrega;
    $this -> status = $status;
    $this -> data_adicao = $data_adicao;
    $this -> user_id = $user_id;
  }

  public function view()
  {
    $con = new PDO(SERVIDOR, USUARIO, SENHA);

    $sql = $con->prepare("SELECT * FROM notas WHERE id=?");
    $sql->execute(array($this->id)) ;

    $r=$sql->fetch();

    echo json_encode($r);
  }
  public function listar(){
    define('QTDE_REGISTROS', 12);
    define('RANGE_PAGINAS', 4);

    /* Recebe o número da página via parâmetro na URL */
    $pagina_atual = (isset($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1;
    /* Calcula a linha inicial da consulta */
    $linha_inicial = ($pagina_atual -1) * QTDE_REGISTROS;

    $this->user_id = $_SESSION['user_id'];
    $prioridade_decode = 0;
    $cor_fonte = "text-muted";
    $con = new PDO(SERVIDOR, USUARIO, SENHA);

    $sql = $con->prepare("SELECT * FROM notas WHERE user_id = ? ORDER BY id DESC LIMIT ".$linha_inicial.",".QTDE_REGISTROS."");
    $sql->execute(array($this->user_id));
    $notass=$sql->fetchAll(PDO::FETCH_CLASS);

    $sql = $con->prepare("SELECT COUNT(*) AS total_registros FROM notas WHERE user_id = ?");
    $sql->execute(array($this->user_id));
    $total=$sql->fetch(PDO::FETCH_OBJ);

    $primeira_pagina = 1;

    $ultima_pagina  = ceil($total->total_registros / QTDE_REGISTROS);
    $pagina_anterior = ($pagina_atual > 1) ? $pagina_atual-1 : 1;
    $proxima_pagina = ($pagina_atual < $ultima_pagina) ? $pagina_atual +1 : $ultima_pagina;

    $range_inicial  = (($pagina_atual - RANGE_PAGINAS) >= 1) ? $pagina_atual - RANGE_PAGINAS : 1 ;

    $range_final   = (($pagina_atual + RANGE_PAGINAS) <= $ultima_pagina ) ? $pagina_atual + RANGE_PAGINAS : $ultima_pagina ;

    if($notass == null)
    {
      echo "<tbody>
      <tr class='text-left'>
      <td>
      <strong>Ainda não existem notas.. Adicione para visualizá-la aqui.</strong>
      </td>
      <td></td>
      <td></td>
      <td></td>
      </tr>
      </tbody>";
    }
    else{

      $linha_tabela_topo = '<thead id="topo_tabela">';
      $linha_tabela_topo .='<tr>';
      $linha_tabela_topo .= '<th>Data/Hora: Adição</th>';
      $linha_tabela_topo .= '<th>Título</th>';
      $linha_tabela_topo .= '<th class="text-center">Data/Hora: Entrega</th>';
      $linha_tabela_topo .= '<th class="text-center">Prioridade</th>';
      $linha_tabela_topo .= '</tr>';
      $linha_tabela_topo .= '</thead>';

      echo $linha_tabela_topo;

      foreach($notass AS $notas){
        $linha_tabela = '<tbody id="'.$notas-> id.'" style="cursor:pointer;" title="CLIQUE PARA VISUALIZAR">';
        $linha_tabela .=  '<tr class="'.$notas-> status.'">';
        $linha_tabela .=    '<td>';
        $linha_tabela .= (new DateTime($notas->data_adicao))->format('d/m/Y H:i:s');
        $linha_tabela .= '</td>';
        $linha_tabela .= '<td>'.$notas->titulo.'</td>';
        $linha_tabela .= '<td class="text-center"><strong>';
        $linha_tabela .= (new DateTime($notas->data_entrega))->format('d/m/Y');
        $linha_tabela .= '</strong></td>';
        switch ($notas->prioridade) {
          case '0':
          $prioridade_decode = 'BAIXA';
          $cor_fonte = 'text-muted';
          break;
          case '1':
          $prioridade_decode = 'MÉDIA';
          $cor_fonte = 'text-warning';
          break;
          case '2':
          $prioridade_decode = 'ALTA';
          $cor_fonte = 'text-danger';
          break;
        }
        $linha_tabela .= '<td class="text-center '.$cor_fonte.'">';
        $linha_tabela .= '<b>';
        $linha_tabela .= $prioridade_decode;
        $linha_tabela .= '</b></td>';

        echo $linha_tabela;
      }
      echo "</table>";

      echo '<ul class="pager text-center">';
      $ativo_primeira = ($pagina_atual == 1) ? 'active' : '' ;
      echo '<li class="previous "><a class="paginacao '.$ativo_primeira.'" href="index.php?page='.$primeira_pagina.'" ><b>Primeira</b></a></li>';
      echo '<li class="previous"><a class="paginacao" href="index.php?page='.$pagina_anterior.'" ><i class="fa fa-arrow-left"></i></a></li>';
      echo '<ul class="pagination text-center" style="margin-top: -1px">';
      for ($i=$range_inicial; $i <= $range_final; $i++){
        $ativo = ($i == $pagina_atual) ? 'active' : '' ;
        echo "<li class=''><a class='paginacao ".$ativo."' href='index.php?page=".$i."'>".$i."</a></li>";
      }
      echo '</ul>';
      $ativo_ultima = ($pagina_atual == $ultima_pagina) ? 'active' : '' ;
      echo '<li class="next"><a class="paginacao '.$ativo.'" href="index.php?page='.$ultima_pagina.'" >Última</a></li>';
      echo '<li class="next"><a class="paginacao" href="index.php?page='.$proxima_pagina.'" ><i class="fa fa-arrow-right"></i></a></li>';
      echo '</ul>';
    }
  }

  public function delete(){
    $this->id = $_GET['id'];
    $con = new PDO(SERVIDOR, USUARIO, SENHA);
    $sql = $con->prepare("DELETE FROM notas WHERE id=?");
    $sql->execute(array($this->id));
    unset($_SESSION['msg']);
    unset($_SESSION['alert']);

    $_SESSION['msg'] = "<strong>Eliminado</strong> com sucesso!";
    $_SESSION['alert'] = "alert-danger";
    header("Location: index.php");
  }

  public function update(){
    $con = new PDO(SERVIDOR, USUARIO, SENHA);

    if ( !isset($_GET['prioridade']) &&  !isset($_GET['status']) ){
      if(!isset($_POST['titulo']) &&  !isset($_POST['data']))
      {
        $this->descricao=$_POST['descricao'];
        $sql = $con->prepare("UPDATE notas SET descricao=? WHERE id=?");
        $r = $sql->execute(array($this->descricao,$this->id)) ;
      }
      else if(!isset($_POST['descricao']) && !isset($_POST['data'])){
        $this->titulo=$_POST['titulo'];
        $sql = $con->prepare("UPDATE notas SET titulo=? WHERE id=?");
        $r = $sql->execute(array($this->titulo,$this->id)) ;
      }
      else if(!isset($_POST['descricao']) &&  !isset($_POST['titulo'])){
        $this->data_entrega=$_POST['data'];
        $sql = $con->prepare("UPDATE notas SET data_entrega=? WHERE id=?");
        $r = $sql->execute(array($this->data_entrega,$this->id)) ;
      }
    }
    else if  ( !isset($_GET['status']) ){
      $this->prioridade=$_GET['prioridade'];

      $sql = $con->prepare("UPDATE notas SET prioridade=? WHERE id=?");
      $sql->execute(array($this->prioridade, $this->id)) ;
    }
    else if ( !isset($_GET['prioridade']) ){
      $this->prioridade=$_GET['status'];

      $sql = $con->prepare("UPDATE notas SET status=? WHERE id=?");
      $r = $sql->execute(array($this->prioridade, $this->id)) ;
    }
  }
  public function add(){
    if (isset($_POST['notas']) ){
      $con = new PDO(SERVIDOR, USUARIO, SENHA);

      $this->user_id = $_SESSION['user_id'];
      $this->titulo=$_POST['notas']['titulo'];
      $this->descricao=$_POST['notas']['descricao'];
      $this->data_entrega=$_POST['notas']['data_entrega'];

      try
      {
        $this->titulo = str_replace("<script>","<code>", $this->titulo);
        $sql = $con->prepare("INSERT INTO notas (id, titulo, descricao, data_entrega, user_id) VALUES(NULL,?,?,?,?)");

        $sql->execute(array($this->titulo, $this->descricao, $this->data_entrega, $this->user_id));
        $_SESSION['msg'] = "<strong>Cadastrado</strong> com sucesso!";
        $_SESSION['alert'] = "alert-success";
        header("Location: index.php");
      }
      catch ( PDOException $e )
      {
        echo 'Erro  ' . $e->getMessage();
        die('0');
      }
    }
  }
  public function informar(){
    if (isset($_POST['feed']) ){
      $con = new PDO(SERVIDOR, USUARIO, SENHA);
      $this->user_id = 1;
      $this->titulo=$_POST['feed']['titulo_feed'];
      $this->descricao=$_POST['feed']['descricao_feed']."<br> Reportado por: ".$_SESSION['user_id'];
      $this->data_entrega=$_POST['feed']['data_entrega_feed'];

      printf($this->user_id);
      printf($this->titulo);
      printf($this->descricao);
      printf($this->data_entrega);
      try
      {
        $sql = $con->prepare("INSERT INTO notas (id, titulo, descricao, data_entrega, user_id) VALUES(NULL,?,?,?,?)");

        $sql->execute(array($this->titulo, $this->descricao, $this->data_entrega, $this->user_id));
        $_SESSION['msg'] = "<strong>Informado</strong> com sucesso!";
        $_SESSION['alert'] = "alert-success";
        header("Location: index.php");
      }
      catch ( PDOException $e )
      {
        echo 'Erro  ' . $e->getMessage();
        die('0');
      }
    }
  }
}

/*

<?php
require_once ("classes/Nota.php");

$notas = new Notas();

$notas->add();
?>
*/
