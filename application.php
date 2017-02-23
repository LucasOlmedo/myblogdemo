<?php
class App
{

    /*
        Definição das variáveis do Banco de Dados.
        Acesso ao database 'blog_php' localizado no host 'localhost'.
        Com seguintes dados de acesso:

        Usuário : db_user -> 'root',
        Senha   : db_pass -> ''
    */

    public $db_host = "localhost";
    public $db_user = "id896947_myblogdemo";
    public $db_pass = "F33fw64rJWO#!qurgEyV";
    public $db_name = "id896947_blog_php";

    /*
        Área para definição de configurações para o site
    */

    public $site_title = "MyBlog!";
    public $ext_img = array('jpg','gif','png');

    /*
        Área para definição de configurações do sistema
    */

    public $system_upload_file = "upload/";

    /*
        Variável utilizada para fazer a conexão usando PDO.
    */

    public $connection;


    /*
        Método '__construct' faz a conexão usando PDO, dentro de um try/catch.
        A variável 'param' recebe uma instrução PDO para ajustar os caracteres para UTF-8.

    */

    function __construct()
    {
        try {
            $param = array(
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8',
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET character_set_connection=utf8',
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET character_set_client=utf8',
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET character_set_results=utf8'
            );
            $this->connection = new PDO(
                'mysql:host=' . $this->db_host .
                ';port=3306;
                dbname=' . $this->db_name,
                $this->db_user,
                $this->db_pass,
                $param
            );
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /*
        O método 'loadModel' instancia qualquer classe que esteja dentro da pasta 'app/model'.
    */

    function loadModel($model)
    {
        include "app/model/" . strtolower($model) . ".class.php";
        return new $model();
    }

    /*
        O método 'loadView' instancia qualquer view que esteja dentro da pasta 'app/view'.
    */

    function loadView($view, $tpl){
        include "app/view/" . strtolower($view) . ".tpl.php";
    }

    function uploadImagem($arquivo){

		$img_tmp = $this->system_upload_file."tmp/".$arquivo['name'];

        $file_name = $arquivo["name"];

        $ext = pathinfo($file_name, PATHINFO_EXTENSION);

		if(array_search($ext,$this->ext_img) === 0) {

			if(move_uploaded_file($arquivo['tmp_name'], $img_tmp)){

				// criar um nome unico para o arquivo
				$foto = md5(uniqid(time())).".".$ext;

				include("libs/wideimage/WideImage.php");

				WideImage::load($img_tmp)->resize(800, 800, "inside")->saveToFile($this->system_upload_file.$foto);

				WideImage::load($img_tmp)->resize(250, 250, "inside")->saveToFile($this->system_upload_file."thumb/".$foto);

				unlink($this->system_upload_file."tmp/".$file_name);

				return $foto;
			}
		}

		return false;
	}
}