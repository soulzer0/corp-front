<?php
   require_once('../geral.php');
    if(!empty($_POST['act'])){
        switch($_POST['act']){
            case 'add':
                if(empty($_POST['tamanho'])){
                    echo "Selecione um tamanho";
                } elseif (empty($_POST['qtd'])){
                    echo "Selecione a quantidade";

                } else{
                    $ns= explode("-",$_POST['cod']);
                    $prod_id = $ns[0]; 
                    $cli_id = $ns[1];
                    if($cli_id == 0){
                        echo "Crie uma conta para adcionar seus itens no carrinho!";
                    } else{

                        //BUSCA O ID DO PEDIDO DO CLIENTE ATUAL
                        $qr = consulta("pedidos","","clienteID = '{$cli_id}' AND status_pedido = '0'");
                        $res = quickQuery($con, $qr);

                        //BUSCA O PRODUTO A SER ADCIONADO NO CARRINHO
                        $qrp = consulta("produtos","","id = {$prod_id}");
                        $resp = quickQuery($con, $qrp);


                        if($resp[$_POST['tamanho']] < $_POST['qtd']){
                            echo "Sua compra excede nosso estoque!";
                        } else{
                            $total = $_POST['qtd'] * $resp['preco'];
                            $cria = cria("pedidos_item",'produtoID, clienteID, pedidoID, precototal, quantidade, tamanho',
                            "'{$prod_id}','{$cli_id}','{$res['id']}','{$total}','{$_POST['qtd']}','{$_POST['tamanho']}'");
                            $resu = quickQuery($con,$cria);
                            echo "Item adcionado ao carrinho";
                           
                        }  
                        
                        
                    }
                 
                }
            break;
            case 'remove':
                $del = deleta('pedidos_item',"itemID={$_POST['id']}");
                $re = quickQuery($con,$del);
                
                echo "Exclusão foi um sucesso";
            break;
            case "rmv_qtd":
                $qr = consulta("pedidos_item","","itemID={$_POST['id']}");
                echo $qr;
                $r = quickQuery($con,$qr);
                $qr2 = atualiza("pedidos_item","quantidade",$_POST['valor'], $_POST['id']);
                
                $re = quickQuery($con, $qr2);
                
            break;
            case 'add_qtd':
            
            break;
        }
    } else{
        print_r($_POST);
        echo "vazio....";
    }

?>