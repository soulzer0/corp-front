<?php
require_once('../geral.php');
//action.php

// $connect = new PDO("mysql:host=localhost; dbname=testing", "root", "");

$received_data = json_decode(file_get_contents("php://input"));
print_r($received_data);
$data = array();

// SELECT * FROM clientes 
// WHERE email LIKE '%".$received_data->query."%' 
// OR nome LIKE '%".$received_data->query."%' 
// ORDER BY id DESC

$query = "
		SELECT * FROM `pedidos_item` as pei 
		INNER JOIN produtos as p 
		ON pei.produtoID = p.id 
		INNER JOIN pedidos as pe 
		on pei.pedidoID = pe.id
		INNER JOIN slm_imgs as i 
		ON p.codigo = i.conteudoID
		WHERE pei.clienteID={$_SESSION['user_id']} AND pe.status_pedido=0
		GROUP BY p.nome, pei.tamanho
	";
// if($received_data->query != '')
// {
// 	$query = "
// 		SELECT * FROM `pedidos_item` as pei 
// 		INNER JOIN produtos as p 
// 		ON pei.produtoID = p.id 
// 		INNER JOIN pedidos as pe 
// 		on pei.pedidoID = pe.id
// 		INNER JOIN slm_imgs as i 
// 		ON p.codigo = i.conteudoID
// 		WHERE pei.clienteID={$_SESSION['user_id']} AND pe.status_pedido=0
// 		GROUP BY p.nome, pei.tamanho
// 	";
// }
// else
// {
// 	$query = "
// 	SELECT * FROM clientes 
// 	ORDER BY id DESC
// 	";
// }

$data =  quickQueryArray($con,$query);


// while($row = $statement->fetch(PDO::FETCH_ASSOC))
// {
// 	$data[] = $row;
// }

echo json_encode($data);

?>
