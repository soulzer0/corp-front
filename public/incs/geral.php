<?php

define("BASE_URL_SITE","/corpiro.co/Site/");
define("BASE_URL_ADM","/corpiro.co/adm/");
require_once('conexao.php');
require_once('funcoes.php');
require_once('Imagem.php');
date_default_timezone_set('Brazil/East');
setlocale(LC_TIME,"portuguese");
session_start();
//mysqli_set_charset('utf8',$con);
$nav = explode("/", "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");

if(isset($_GET['act'])){
        if($_GET['act']=="logout"){
                $qr = " UPDATE pedidos SET status_pedido=99 WHERE clienteID=".$_GET['user']." and status_pedido=0";
                print_r($qr);
                $rd = quickQuery($con,$qr);
                session_destroy();
                session_start();
                $_SESSION['logado'] = false;
                Header("Location:?act=login");
        }
}
      


$pagina = ($nav[2]!="" ) ? $nav[2] : 'configs';

// $consulta_config = "SELECT nomeproduto, precounitario, tempoentrega FROM produtos";
// $produtos = mysqli_query($con, $consulta_config);

// if(!$produtos){
//         die("Falha na consulta ao banco de dados");
// } 

$consulta = consulta("select","produtos","nomeproduto, precounitario, tempoentrega");

// comentar essa linha para alternar acesso site/adm
// $pagina = (isset( $_GET['act']))?   $_GET['act'] : 'configs';

$_date = getdate();
$_segundo = $_date["seconds"];
$_minuto = $_date["minutes"];
$_horas = $_date["hours"];
$_dia = $_date["mday"];
$_dia_locale = strftime('%A');
$_mes = $_date["mon"];
$_mes_locale = strftime('%B');
$_ano = $_date["year"];

// echo $_horas. ":" . $_minuto. " - " . $_dia_locale.",".$_mes_locale." de ".$_ano;
//  print_r($_GET['act']);
  
?>