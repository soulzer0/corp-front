<?php
require_once('Imagem.php');
require_once('conexao.php');
define("PATH_SRC",     "../uploads");
define("PATH_PEQ",     "../uploads/pequenas");
define("PATH_TB",     "../uploads/thumb");

function getNowTime(){
    $_date = getdate();
    $_segundo = $_date["seconds"];
    $_minuto = $_date["minutes"];
    $_horas = $_date["hours"];
    return $_horas.":".$_minuto;
}
function ArrumaProBanco($txt){
	$ntxt = RemoverAcentos($txt);
	return strtolower(str_replace(" ","_",$ntxt));
}
function redimensionarImagem($path,$w,$h){
    $rs = @end(explode("/", $path ));
    $alvo = 'pequenas/'.$rs;
    $rees = str_replace($rs,$alvo, $path);             
    $img = new ResizeImage($path);               
    $img->resizeTo($w,$h,"exact");
    $img->saveImage($rees);
    
    return $rees;
}
function TraduzStatusPedido($valor){
    switch($valor){
        case 0 :
            return "Carrinho atual";
        break;
        case 1 :
            return "Pagamento em análise";
        break;
        case 2 :
            return "Pagamento Aprovado";
        break;
        case 3 :
            return "Preparação";
        break;
        case 4 :
            return "Despachado";
        break;
        case 5 :
            return "";
        break;
        case 99 :
            return "Carrinho salvo";
        break;
    }
}
function RemoverEspeciais($txt){
	$chars=array("(",")","[","]","{","}",",","+","!","@","#","$","%","¨","&","*","/","\\","<",">","ª","º","|");
	foreach($chars as $c){
		$txt=str_replace($c,"_",$txt);
	}
	return $txt;
}
function RemoverAcentos($txt){
	$ac_uni = " ,ç,Ç,^,~,¨,`,´,%,á,Á,à,À,ã,Ã,â,Â,ä,Ä,é,É,è,È,ê,Ê,ë,Ë,í,Í,ì,Ì,î,Î,ï,Ï,ó,Ó,ò,Ò,õ,Õ,ö,Ö,ô,Ô,ú,Ú,ù,Ù,û,Û,ü,Ü";

	$ac_utf = "_,&ccedil;,&Ccedil;,&circ;,&tilde;,&uml;,&grave;,&acute;,%,&aacute;,&Aacute;,&agrave;,&Agrave;,&atilde;,&Atilde;,&acirc;,&Acirc;,&auml;,&Auml;,&eacute;,&Eacute;,&egrave;,&Egrave;,&ecirc;,&Ecirc;,&euml;,&Euml;,&iacute;,&Iacute;,&igrave;,&Igrave;,&icirc;,&Icirc;,&iuml;,&Iuml;,&oacute;,&Oacute;,&ograve;,&Ograve;,&otilde;,&Otilde;,&ouml;,&Ouml;,&ocirc;,&Ocirc;,&uacute;,&Uacute;,&ugrave;,&Ugrave;,&ucirc;,&Ucirc;,&uuml;,&Uuml;";

	$ac_sem = "_,c,C,,,,,,porcento,a,A,a,A,a,A,a,A,a,A,e,E,e,E,e,E,e,E,i,I,i,I,i,I,i,I,o,O,o,O,o,O,o,O,o,O,u,U,u,U,u,U,u,U";

	$ac_uni = explode(",",$ac_uni);
	$ac_utf = explode(",",$ac_utf);
	$ac_sem = explode(",",$ac_sem);
	for($i=0;$i<sizeof($ac_sem);$i++){
		$txt = str_replace($ac_uni[$i],$ac_sem[$i],$txt);
		$txt = str_replace($ac_utf[$i],$ac_sem[$i],$txt);
	}
	return $txt;
}
function FileLog($nome,$texto){

	$f=fopen($nome,"a+");

	fwrite($f,"[".date("d/m/Y | H:i:s")."]".$texto."\r\n");

	fclose($f);

}
function FormatarMoeda($valor,$manterDezena=true){
	if($manterDezena) $valor=number_format($valor, 2, ',', '.');
	else $valor=number_format($valor, 0, '', '.');

	return $valor;
}
function RemoverMoeda($valor){
	$valor=str_replace("r$","",strtolower($valor));
	$valor=str_replace(",","",$valor);
	$valor=str_replace(".","",$valor);
	return $valor;
}
function formataReal($valor){
    $valor = number_format($valor,2,",",".");
    return "R$ ". $valor;
}
function gerarCodigoProduto($cat,$id,$colection){
    $cod = "000".$colection;
    $cod .= "0C0RP00".$cat;
    $cod .= "-0".$id;
    return $cod;
};
function xx(){
    $alfabeto = "123456789ABCDEFGHIJKLMNOPQRSTUVXWYZ";
    $tamanho = "30";
    $letra = " ";
    $resultado = "";
    for($i = 1;$i<$tamanho; $i++){
        $letra = substr( $alfabeto, rand(0,23),1);
        $resultado .= $letra;
    }
    date_default_timezone_set('America/Brasilia');
    $agora = getdate();
    $codigo = $agora['year'] . "_" . $agora['yday'];
    $codigo .=  $agora['hours'].$agora['minutes'].$agora['seconds'];
    return "foto_".$codigo."_".$resultado;
}
function extension($file){
    return strrchr($file,".");
}

function reArrayFiles(&$file_post) {

    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);

    for ($i=0; $i<$file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }

    return $file_ary;
}

function resize_image($file, $w, $h, $crop=FALSE) {
    list($width, $height) = getimagesize($file);
    $r = $width / $height;
    if ($crop) {
        if ($width > $height) {
            $width = ceil($width-($width*abs($r-$w/$h)));
        } else {
            $height = ceil($height-($height*abs($r-$w/$h)));
        }
        $newwidth = $w;
        $newheight = $h;
    } else {
        if ($w/$h > $r) {
            $newwidth = $h*$r;
            $newheight = $h;
        } else {
            $newheight = $w/$r;
            $newwidth = $w;
        }
    }
    $src = imagecreatefromjpeg($file);
    $dst = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

    return $dst;
}

function buscaRegistroNome($busca,$tabela,$parametro){
    $consulta = "SELECT * FROM ".$tabela." WHERE ".$parametro." LIKE '%".$busca."%''";
    return $consulta;
}
function mostrarAvisoUpload($numero){
    $upload_erros = array(
        UPLOAD_ERR_OK => "Sem erro.",
        UPLOAD_ERR_INI_SIZE => "O arquivo enviado excede o limite definido na diretiva upload_max_filesize do php.ini.",
        UPLOAD_ERR_FORM_SIZE => "O arquivo excede o limite definido em MAX_FILE_SIZE no formulário HTML.",
        UPLOAD_ERR_PARTIAL => " O upload do arquivo foi feito parcialmente.",
        UPLOAD_ERR_NO_FILE => "Nenhum arquivo foi enviado.",
        UPLOAD_ERR_NO_TMP_DIR => "Pasta temporária ausênte.",
        UPLOAD_ERR_CANT_WRITE => "Falha em escrever o arquivo em disco. Talvez falte permissão ou algum",
        UPLOAD_ERR_EXTENSION => "Uma extensão do PHP interrompeu o upload do arquivo. O PHP não fornece uma maneira de determinar qual extensão causou a interrupção. Examinar a lista das extensões carregadas com o phpinfo() pode ajudar.");
    return $upload_erros[$numero];
}
function publicarArquivos($imagens = array(),$id){
    $dir = "../uploads";
    //  echo "<br><br><br><br><pre>";    
    //                 print_r($imagens);
    //             echo "</pre><br><br><br><br><br>";
    foreach ($imagens as $key => $value) {
       
        $arq_tmp = $value['tmp_name'];
        $arq = $value['name'];
        $caminho = $dir."/".$arq;
      
        if(move_uploaded_file($arq_tmp,$caminho)){
            $msg = 'Arquivo publicado';
            $res= redimensionarImagem($caminho,200,200);
            $vals = " '".$id."', "; 
            $vals .= " '". $caminho."',  ";
            $vals .= " '".$res."' ";
            // echo $vals;
            $qri[$key] = cria("slm_imgs","conteudoID,img_grande,img_pequena",$vals);
            
         } else{
            echo mostrarAvisoUpload($imagens[1]['error']);
         }
    }
    // $arq_tmp = $imagem['tmp_name'];
    // $arq = basename($imagem['name']);
   
    return $qri;
}
function publicarArquivo($imagem,$id){
    $msg = array();
    $dir = "../uploads";
    $arq_tmp = $imagem[0]['tmp_name'];
    $arq = ArrumaProBanco(basename($imagem[0]['name']));
    $caminho = $dir."/".$arq;
    if(move_uploaded_file($arq_tmp,$caminho)){
       $msg[0] = 'Arquivo publicado';
       $res= redimensionarImagem($caminho,200,200);
       $vals = " '".$id."', ";
        $vals .= " '". $caminho."',  ";
            $vals .= " '".$res."' ";
            $msg[1] = cria("slm_imgs","conteudoID,img_grande,img_pequena",$vals);
    } else{
        $msg[0] = mostrarAvisoUpload($imagem[0]['error']);
    }
    return $msg;
}

function consulta($tabela, $colunas="", $where="", $order="", $groupby="", $limite="" ){
        $consulta = "SELECT ";
        $consulta .= ($colunas!="")? $colunas : " * " ;
        $consulta .= " FROM ".$tabela." ";
        $consulta .= ($where!="")? " WHERE ".$where." ":"";
        $consulta .= ($groupby!="")? "GROUP BY ".$groupby." ":"";
        $consulta .= ($order!="")? "ORDER BY ".$order." ":"";
        $consulta .= ($limite!="")? "LIMIT ".$limite." ":"";
        return $consulta;
}
function lista($tabela){
    $consulta = "SELECT * FROM ".$tabela;
    return $consulta;
}

function cria($tabela, $colunas, $valores){
      $cria = "INSERT INTO ".$tabela." (".$colunas.")";
      $cria .= " VALUES (".$valores.")";  
      return $cria;
}

function deleta($tabela, $condicao){
    $delete = "DELETE FROM ".$tabela." WHERE ".$condicao;  
    return $delete;
}
function atualiza($tabela, $colunas, $valores, $where){
    $update = "UPDATE ".$tabela. " SET ";
    for($i = 0;$i < count($colunas); $i++ ){
        $update .= $colunas[$i]." = '";  
        $update .=  $valores[$i];
        $update .= ($i==0)? "',":"'"; 
    }
    $update .= " WHERE ".$where;
    return $update;
}
function quickQuery($con, $query){
    $consulta = mysqli_query($con,$query);
    if(!$consulta){
        if( mysqli_connect_errno()){
            die("Conexão falhou: " . mysqli_connect_errno());
     }
    //     die("falha a na consulta ao banco");
    } else{
        if(empty($consulta)){
            return "erro";
        } else{
            
            if(is_bool($consulta) && $consulta){
                return $consulta;
            } else{
                return mysqli_fetch_assoc($consulta);
            }
            
        }
    
    }
}

function quickQueryArray($con, $query){
    $consulta = mysqli_query($con,$query);
    if(!$consulta){
        if( mysqli_connect_errno()){
            die("Conexão falhou: " . mysqli_connect_errno());
    }
    } else{
        for ($set = array (); $row = $consulta->fetch_assoc(); $set[] = $row);
        return $set;
    }
}

function limpaConsulta($consulta){
    mysqli_free_result($consulta); 
}

function login(){

}
function cadastroUsuario(){


}
function alteraSenha(){

}
function charset_decode_utf_8 ($string) {
    /* Only do the slow convert if there are 8-bit characters */
    /* avoid using 0xA0 (\240) in ereg ranges. RH73 does not like that */
    if (! preg_match("[\200-\237]", $string) and ! preg_match("[\241-\377]", $string))
        return $string;

    // decode three byte unicode characters
    $string = preg_replace("/([\340-\357])([\200-\277])([\200-\277])/", 
    "'&#'.((ord('\\1')-224)*4096 + (ord('\\2')-128)*64 + (ord('\\3')-128)).';'",   
    $string);

    // decode two byte unicode characters
    $string = preg_replace("/([\300-\337])([\200-\277])/",
    "'&#'.((ord('\\1')-192)*64+(ord('\\2')-128)).';'",
    $string);

    return $string;
}



?>