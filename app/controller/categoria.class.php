<?php
	class Categoria {

		function listCategorias($app,$admin=null,$msg=""){
			// carrega o model do painel
			if($admin==null)
				$admin = $app->loadModel("Admin");

			$categorias = $admin->getAllCategorias($app->connection);

			$param = array("title"=>$app->site_title,
						   "page" => "listarcategorias",
						   "dados" => array(
								"categorias" => $categorias,
								"msg" => $msg
							)
				);

			$app->loadView("Admin",$param);
		}

		function updateCategoria($app){

			$categoria_id = (int)$_GET["id"];

			$admin = $app->loadModel("Admin");

			$obj = $admin->getCategoriaId($app->connection, $categoria_id);

			$param = array("title"=>$app->site_title,
						   "page" => "formcategoria",
						   "dados" => array(
								"tituloform" => "Alterar categoria",
								"action"=>"execUpdateCategoria",
								"categoria_id"=>$obj["categoria_id"],
								"categoria_title"=>$obj["categoria_title"],
								"labelbtnsubmit"=>"Alterar Categoria"
							)
				);

			$app->loadView("Admin",$param);
		}

		function execUpdateCategoria($app){

			$admin = $app->loadModel("Admin");

			$categoria_title = utf8_encode($_POST['categoria_title']);

			$categoria_id = (int)$_POST["categoria_id"];

			$obj = $admin->updateDataCategoria($app->connection, $categoria_id, tStr($categoria_title));

			if($obj) {
				$mensagem = "Alteração efetuada com sucesso!";
			} else {
				$mensagem = "Alteração falhou!";
			}

			$this->listCategorias($app,$admin,$mensagem);
		}

		function deleteCategoria($app){

			$admin = $app->loadModel("Admin");

			$categoria_id = (int)$_GET["id"];

			$obj = $admin->deleteCategoria($app->connection, $categoria_id);

			if($obj) {
				$mensagem = "Exclusão efetuada com sucesso!";
			} else {
				$mensagem = "Exclusão falhou! Verifique se a categoria não possui registros.";
			}

			$this->listCategorias($app,$admin,$mensagem);
		}

		function insertCategoria($app){

			$param = array(
                            "title"=>$app->site_title,
						   "page" => "formcategoria",
						   "dados" => array(
								"tituloform" => "Cadastrar nova categoria",
								"action"=>"execInsertCategoria",
								"categoria_id"=>"",
								"categoria_title"=>"",
								"labelbtnsubmit"=>"Cadastrar categoria"
							)
				);

			$app->loadView("Admin",$param);
		}

		function execInsertCategoria($app){

			$admin = $app->loadModel("Admin");

			$categoria_title = utf8_encode($_POST["categoria_title"]);

			$obj = $admin->insertCategoria($app->connection, tStr($categoria_title));

			if($obj) {
				$mensagem = "Cadastro efetuado com sucesso!";
			} else {
				$mensagem = "Cadastro falhou!";
			}

			$this->listCategorias($app,$admin,$mensagem);
		}
}