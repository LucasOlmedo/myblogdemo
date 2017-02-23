<?php
	class Imagem {
        
		function listImagens($app, $post_id, $admin=null, $msg=""){
			// carrega o model do painel
			if($admin==null)
				$admin = $app->loadModel("Admin");

			$imagens = $admin->getAllImagens($app->connection, $post_id);
			
			$param = array("title"=>$app->site_title, 
						   "page" => "listarimagens",
						   "dados" => array(
								"imagens" => $imagens,
								"post_id" => $post_id,
								"msg" => $msg
							)
				);
							 
			$app->loadView("Admin",$param);
		}
		
		function updateImagem($app){
			$imagem_id = (int)$_GET["id"];
			
			$admin = $app->loadModel("Admin");
			
			$obj = $admin->getImagemId($app->connection, $imagem_id);
					
			$param = array("title"=>$app->site_title, 
						   "page" => "formimagem",
						   "dados" => array(
								"tituloform" => "Alterar imagem",
								"action"=>"execUpdateImagem",
								"imagem_id"=>$obj["imagem_id"],
								"imagem_subtitle"=>$obj["imagem_subtitle"],
								"imagem_featured"=>$obj["imagem_featured"],
								"post_id"=>$obj["post_id"],
								"labelbtnsubmit"=>"Alterar Imagem"
							)
						   );
							 
			$app->loadView("Admin",$param);
		}
		
		function execUpdateImagem($app){
            
			$admin = $app->loadModel("Admin");
			
			$imagem_id = (int)$_POST["imagem_id"];
			$imagem_subtitle = tStr($_POST["imagem_subtitle"]);
			$imagem_featured = (int)$_POST["imagem_featured"];
			$post_id = (int)$_POST["post_id"];
            
            // consulta para saber se já existe imagem destaque
            
            $img_bd = $admin->selectFeaturedImg($app->connection, $post_id);
            
            if((($img_bd) && ($img_bd[0]["imagem_id"] != $imagem_id)) && $imagem_featured == 1){
                
                $mensagem = "Alteração falhou! Verifique se o post já tem uma imagem destaque.";
                
            }else{
                
                $obj = $admin->updateDataImagem($app->connection, $imagem_id, $imagem_subtitle, $imagem_featured);

                if($obj) {
                    $mensagem = "Alteração efetuada com sucesso!";
                } else {
                    $mensagem = "Alteração falhou!";
                }
            }
					
			$this->listImagens($app,$post_id,$admin,$mensagem);
		}
		
		function deleteImagem($app){
            
			$admin = $app->loadModel("Admin");
			$imagem_id = (int)$_GET["id"];
			$post_id = (int)$_GET["post_id"];
			
			// precisamos excluir os arquivos físicos
			// vamos pegar os dados da imagem
			$obj = $admin->getImagemId($app->connection, $imagem_id);
            
            $img_contains = $admin->getImagemPost($app->connection);
            
            // exclui fisicamente se nenhum outro post estiver usando esta imagem.
            
            if($img_contains){
			     unlink("upload/".$obj["imagem_file"]);
			     unlink("upload/thumb/".$obj["imagem_file"]);
            }
			
			// excluímos do banco de dados
			$obj = $admin->deleteImagem($app->connection, $imagem_id);
			
			if($obj) {
				$mensagem = "Exclusão efetuada com sucesso!";
			} else {
				$mensagem = "Exclusão falhou!";
			}
			
			$this->listImagens($app,$post_id,$admin,$mensagem);
            
		}
		
		function insertImagem($app){
            
			$post_id = (int)$_GET["post_id"];
			
			$param = array("title"=>$app->site_title, 
						   "page" => "formimagem",
						   "dados" => array(
								"tituloform" => "Cadastrar imagem",
								"action"=>"execInsertImagem",
								"imagem_id"=>"",
								"imagem_subtitle"=>"",
								"imagem_featured"=>0,
								"post_id"=>$post_id,
								"labelbtnsubmit"=>"Cadastrar Imagem"
							)
						   );
							 
			$app->loadView("Admin",$param);
		}
		
		function execInsertImagem($app){
            
			$admin = $app->loadModel("Admin");
            
			$post_id = (int)$_POST["post_id"];
			
			if($_FILES["arquivo"]["tmp_name"] == ""){
                
				$this->listImagens($app,$post_id,$admin,"Falha ao cadastrar imagem! Selecione uma imagem.");
				return;              
			}
			
			$img = $app->uploadImagem($_FILES["arquivo"]);
			
			if($img == false){
                unlink("upload/".$img);
                unlink("upload/thumb/".$img);
				$this->listImagens($app,$post_id,$admin,"Falha ao cadastrar imagem, verifique o tipo de arquivo enviado!");
				return;
			}
			
			$imagem_subtitle = tStr($_POST["imagem_subtitle"]);
			$imagem_featured = (int)$_POST["imagem_featured"];      
            
            // consulta para saber se já existe imagem destaque
            
            $img_bd = $admin->selectFeaturedImg($app->connection, $post_id);
            
            //caso não exista imagem destaque, permite normalmente o cadastro
            
            if($img_bd == null){
                $obj = $admin->insertImagem($app->connection, $post_id, $img, $imagem_subtitle, $imagem_featured);
			
                if($obj) {
				    $mensagem = "Cadastro efetuado com sucesso!";
                } else {
                    unlink("upload/".$img);
                    unlink("upload/thumb/".$img);
				    $mensagem = "Cadastro falhou!";
                }
            }else{
                
                // caso exista imagem destaque, e não for selecionado imagem destaque, então cadastra normal
                
                if($img_bd < 1 || $imagem_featured == 0){
                
                $obj = $admin->insertImagem($app->connection, $post_id, $img, $imagem_subtitle, $imagem_featured);
			
                    if($obj) {
				        $mensagem = "Cadastro efetuado com sucesso!";
                    } else {
                        unlink("upload/".$img);
                        unlink("upload/thumb/".$img);
				        $mensagem = "Cadastro falhou!";
                    }
                    
                // caso exista e for selecionado uma nova, o cadastro é bloqueado    
                
                } else {
                    unlink("upload/".$img);
                    unlink("upload/thumb/".$img);
                    $mensagem = "Cadastro falhou! Esse post já possui uma imagem em destaque.";
                }
            }               
            
			$this->listImagens($app,$post_id,$admin,$mensagem);
		}
}