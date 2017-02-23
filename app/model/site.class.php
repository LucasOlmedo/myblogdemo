<?php
class Site {

/*
    Variável 'sqlPost' contém a consulta de postagens no geral.
*/

public $sqlPost = "SELECT 
							bp.post_id, 
							bp.post_title,
							bp.post_text,
							bp.post_blocked,
							bp.post_date,
							bp.post_creation,
							bp.post_url,
							bc.categoria_id as post_categoria_id,
							bc.categoria_title as post_categoria,
							bu.usuario_id,
							bu.usuario_name as post_usuario_name,
							(
							 SELECT 
								bi.imagem_file
							 FROM 
								blog_imagem bi
							 WHERE
								bi.imagem_post_id = bp.post_id AND
								bi.imagem_featured = 1
							 ORDER BY
								bi.imagem_id DESC
							 LIMIT 1
							 ) as post_imagem_featured
						FROM 
							blog_categoria bc,
							blog_usuario bu,
							blog_post bp
						WHERE
							bp.post_categoria_id = bc.categoria_id AND
							bp.post_usuario_id = bu.usuario_id ";

/*
    Função que lista as categorias cadastradas no banco de dados, trazendo seu id e título.
*/

public function listCategoria($pdo){
    $obj = $pdo->prepare("SELECT categoria_id, categoria_title FROM blog_categoria");
    return ($obj->execute()) ? $obj : false;
}

/*
    Função que lista os posts (bloqueados ou não) cadastrados no banco de dados, utilizando as variaveis que indicam a condição "bloqueado ou não", e a categoria do post, complementando a consulta com um 'where'.
*/

public function listPost($pdo, $blocked = "NI", $categoria_id = null){
    $where = " ";

    if($blocked !== "NI")
        $where .= " AND bp.post_blocked = :blocked";

    if($categoria_id != null)
        $where .= " AND bp.post_categoria_id = :categoria_id";

    $obj = $pdo->prepare($this->sqlPost." ".$where." ORDER BY bp.post_id DESC");

    if($blocked !== "NI")
        $obj->bindParam(":blocked", $blocked);

    if($categoria_id != null)
        $obj->bindParam(":categoria_id", $categoria_id);

    $obj->execute();
    return $obj;
}

/*
    Esta função consulta um post selecionado por ID, trazendo todos os dados usando a variável 'sqlPost'.
*/

public function getPost($pdo, $post_id, $url=null){
    if($url==null){
			$where = " AND bp.post_id = :post_id ";
			$obj = $pdo->prepare($this->sqlPost." ".$where);
			$obj->bindParam(":post_id",$post_id);
		} else {
			$where = " AND bp.post_url = :post_url ";
			$obj = $pdo->prepare($this->sqlPost." ".$where);
			$obj->bindParam(":post_url",$url);
		}

		return ($obj->execute()) ? $obj->fetch(PDO::FETCH_OBJ) : false;
}

/*
    Monta a lista das imagens contidas dentro do blog.
    Podem, ou não, ser imagens destaque (featured).
*/

public function listImagemPost($pdo, $post_id, $featured = "NI"){

    $sql = "SELECT * FROM blog_imagem WHERE imagem_post_id = :post_id  ";
    $where = "";

    if($featured != "NI")
        $where = " AND imagem_featured = ".$featured." ";

    $obj = $pdo->prepare($sql." ".$where);
    $obj->bindParam(":post_id",$post_id);
    $obj->execute();
    return $obj;
}
}