<?php
require_once('../geral.php');
    if(empty($_POST['act'])){
        echo "Nenhuma ação determinada...";
    } else{

        switch($_POST['act']){
            case 'add_user':
                
                if(empty($_POST['nome'])){
                    echo 'Insira seu nome completo para continuar';
                }
                   
                elseif(empty($_POST['senha'])){
                    echo 'Insira uma senha para continuar';
                }
                elseif(empty($_POST['email'])){
                    echo 'Digite seu email para continuar.';
                    
                    
                    
                }
                    
                elseif(empty($_POST['csenha'])){
                    echo 'Complete o campo de confirmação de senha';
                }
                    
                else{
                    $qqr = consulta("clientes","","email like '{$_POST['email']}'","","",1);
                    $re = quickQuery($con, $qqr);
                    // if(!empty($re)){
                    //     echo "Email já cadastrado";
                    // }  else{
                    if($_POST['senha'] === $_POST['csenha']){
                        
                        $qr = cria("clientes","email,senha,nome","'{$_POST['email']}','{$_POST['senha']},'{$_POST['nome']}'");
                        $r = quickQuery($con, $qr);
                        
                        echo "Conta criada";
                    } else {
                        echo "Senha não confere com a confirmação!";
                    }
                }
            break;
            case 'enter_ac':
                if(empty($_POST['email'])){
                    echo 'Digite seu email para realizar o login.';
                }
                   
                elseif(empty($_POST['senha'])){
                    echo 'Insira sua senha para realizar o login.';
                } else{
                    $qqre = consulta("clientes","","email like '{$_POST['email']}'","","",1);
                    $re = quickQuery($con, $qqre);
                    if(empty($re)){
                        echo "Login falhou! Email Inválido!";
                    } else{
                        // print_r($re);
                        $qqrs = consulta("clientes","senha ","id = {$re['id']}","","",1);
                        
                        $res = quickQuery($con, $qqrs);
                        if($res['senha'] == $_POST['senha']) {
                            echo "Login ocorreu com Sucesso!";
                            $_SESSION['logado'] = true;
                            $_SESSION['user_id'] = $re['id'];
                            $qc = consulta('pedidos',"","status_pedido = 99");
                            $rc = quickQuery($con, $qc);
                            if(empty($rc)){
                                echo "nenhuma pedido, criando um novo...";
                                $mysqltime = date ('Y-m-d H:i:s'); 
                                $qrp = cria("pedidos","clienteID,status_pedido,data_pedido","'{$re['id']}', '0','{$mysqltime}' ");
                                $rreee = quickQuery($con,$qrp);
                            } else{
                                $qap =  " UPDATE pedidos SET status_pedido=0 WHERE clienteID=".$re['id']." and status_pedido=99"; 
                                $rap = quickQuery($con,$qap);
                            }
                            
                           
                            
                            // print_r($qrp);
                        }else{
                            
                            echo "Login Falhou! Senha Incorreta!";
                        }
                        // if(empty($res)){
                            
                          
                        // } 
                    } 
                }
              
            break;
            case 'edit_ac':
                $qr = consulta("clientes","nome,email,telefone","id={$_SESSION['user_id']}" );
                $str = "";
               
                $re = quickQuery($con,$qr);
                if(empty($_POST['name'])){
                    echo "Insira um nome";
                } elseif(empty($_POST['mail'])){
                    echo "Insira um email válido";
                }   elseif(empty($_POST['tel'])){
                    echo "Insira um telefone!";
                } else{
                    if($_POST['name'] != $re['nome']){
                        $str = "nome ='".$_POST['name']."'";
                    }
                    if($_POST['tel'] != $re['telefone']){
                        $str .= ",telefone='".$_POST['tel']."'";
                       
                    }
                    if($_POST['mail'] != $re['email']){
                        $str .= "email='".$_POST['mail']."'";
                    }
                    $qr = "UPDATE clientes SET ".$str." WHERE id= {$_SESSION['user_id']} ";
                    $res = quickQuery($con,$qr);
                }
                
                print_r($re);
            break;
        }
            



    }




?>