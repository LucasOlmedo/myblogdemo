<?php
	class Post {

        function listPosts($app,$admin=null,$msg=""){

			// carrega o model do painel

			if($admin==null)
				$admin = $app->loadModel("Admin");

			$posts = $admin->getAllPosts($app->connection);

			$param = array(
                "title"=>$app->site_title,
                "page" => "listarposts",
				"dados" => array(
				    "posts" => $posts,
				    "msg" => $msg
				)
            );

			$app->loadView("Admin",$param);
		}

		function updatePost($app){

			$post_id = (int)$_GET["id"];

			$admin = $app->loadModel("Admin");
			$site = $app->loadModel("Site");

			$obj = $site->getPost($app->connection, $post_id);
			$categorias = $admin->getAllCategorias($app->connection);

			$post_creation = dtToBr($obj->post_creation);
			$post_date = dtToBr($obj->post_date);

			$param = array("title"=>$app->site_title,
						   "page" => "formpost",
						   "dados" => array(
								"tituloform" => "Alterar post",
								"action"=>"execUpdatePost",
								"post_id"=>$obj->post_id,
								"post_title"=>$obj->post_title,
								"post_text"=>$obj->post_text,
								"post_blocked"=>$obj->post_blocked,
								"post_categoria_id"=>$obj->post_categoria_id,
								"post_creation"=>$post_creation,
								"post_date"=>$post_date,
								"auxPostData"=>$post_date,
								"usuario_name"=>$obj->post_usuario_name,
								"labelbtnsubmit"=>"Alterar Post",
								"categorias"=>$categorias
							)
						   );

			$app->loadView("Admin",$param);
		}

		function execUpdatePost($app){

			$admin = $app->loadModel("Admin");

			$post_id = (int)$_POST["post_id"];

			$post_title = utf8_encode($_POST["post_title"]);

			$postUrl = limpaUrl($post_title);

			$post_text = utf8_decode($_POST["post_text"]);

			$post_blocked = (int)$_POST["post_blocked"];

			$post_categoria_id = (int)$_POST["post_categoria_id"];

			$post_date = brToDt($_POST["post_date"]);

			$obj = $admin->updateDataPost($app->connection, $post_id, tStr($post_title), $post_text, $post_blocked, $post_categoria_id, $postUrl, $post_date);

			if($obj) {
				$mensagem = "Alteração efetuada com sucesso!";
			} else {
				$mensagem = "Alteração falhou!";
			}

            $this->listPosts($app,$admin,$mensagem);
		}

		function deletePost($app){

			$admin = $app->loadModel("Admin");

			$post_id = (int)$_GET["id"];

			// precisamos excluir todas as imagens do post
			// vamos pegar as imagens

			$obj = $admin->getAllImagens($app->connection, $post_id);

			// excluimos os arquivos fisicos
			foreach($obj as $imagem){
				@unlink("upload/".$imagem["imagem_file"]);
				@unlink("upload/thumb/".$imagem["imagem_file"]);
			}

			// excluímos do banco de dados
			$obj = $admin->deletePost($app->connection, $post_id);

			if($obj) {
				$mensagem = "Exclusão efetuada com sucesso!";
			} else {
				$mensagem = "Exclusão falhou!";
			}

			$this->listPosts($app,$admin,$mensagem);
		}

		function insertPost($app){

			$admin = $app->loadModel("Admin");

			$categorias = $admin->getAllCategorias($app->connection);

			$param = array("title"=>$app->site_title,
						   "page" => "formpost",
						   "dados" => array(
								"tituloform" => "Cadastrar post",
								"action"=>"execInsertPost",
								"post_id"=>"",
								"post_title"=>"",
								"post_text"=>"",
								"post_blocked"=>0,
								"post_categoria_id"=>"",
								"post_creation"=>"",
								"post_date"=>dtToBr(),
								"auxPostData"=>dtToBr(),
								"usuario_name"=>"",
								"labelbtnsubmit"=>"Cadastrar Post",
								"categorias"=>$categorias
							)
						   );

			$app->loadView("Admin",$param);
		}

		function execInsertPost($app){

			$admin = $app->loadModel("Admin");

			$post_title = utf8_encode($_POST["post_title"]);
			$postUrl = limpaUrl($post_title);
			$post_text = utf8_decode($_POST["post_text"]);
			$post_blocked = (int)$_POST["post_blocked"];
			$post_categoria_id = (int)$_POST["post_categoria_id"];
			$post_date = brToDt($_POST["post_date"]);
			$usuario_id = $_SESSION["usuario_id"];

			$obj = $admin->insertPost($app->connection,
										 tStr($post_title),
										 $postUrl,
										 $post_text,
										 $post_blocked,
										 $post_categoria_id,
										 $post_date,
										 $usuario_id,
										 brToDt());

			if($obj) {
				$mensagem = "Cadastro efetuado com sucesso!";
			} else {
				$mensagem = "Cadastro falhou!";
			}

			$this->listPosts($app,$admin,$mensagem);
		}
}