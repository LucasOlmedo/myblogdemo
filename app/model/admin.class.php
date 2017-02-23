<?php

class Admin
{

//  COMPONENTE 'USUÁRIO'

    public function getUsuarioLoginSenha($pdo, $usuario, $senha)
    {

        $obj = $pdo->prepare("SELECT 
								usuario_id,
								usuario_user, 
								usuario_name
							FROM 
								blog_usuario 
							WHERE 
								usuario_user = :user AND
								usuario_pass = :pass");

        $obj->bindParam(":user", $usuario);
        $obj->bindParam(":pass", $senha);

        return ($obj->execute()) ? $obj->fetch(PDO::FETCH_OBJ) : false;
    }

    public function getAllUsers($pdo)
    {
        $obj = $pdo->prepare("SELECT 
								usuario_id,
								usuario_user, 
								usuario_name
							FROM 
								blog_usuario 
							ORDER BY
								usuario_id ASC
							");

        return ($obj->execute()) ? $obj->fetchAll(PDO::FETCH_ASSOC) : false;
    }

    public function getUserId($pdo, $usuario_id)
    {
        $obj = $pdo->prepare("SELECT 
								usuario_id,
								usuario_user, 
								usuario_pass,
								usuario_name
							FROM 
								blog_usuario 
							WHERE
								usuario_id = :usuario_id
							");

        $obj->bindParam(":usuario_id", $usuario_id);
        return ($obj->execute()) ? $obj->fetch(PDO::FETCH_ASSOC) : false;
    }

    public function updateUsuario($pdo, $usuario_id, $nome, $senha = null)
    {
        if ($senha == null) {
            $sql = "UPDATE 
						blog_usuario
					SET 
						usuario_name=? 
					WHERE 
						usuario_id=?";
            $obj = $pdo->prepare($sql);
            $obj->execute(array($nome, $usuario_id));
        } else {
            $sql = "UPDATE 
						blog_usuario
					SET 
						usuario_name=?,
						usuario_pass=?
					WHERE 
						usuario_id=?";
            $obj = $pdo->prepare($sql);
            $obj->execute(array($nome, md5($senha), $usuario_id));
        }

        return ($obj) ? $obj : false;

    }

    public function insertUsuario($pdo, $usuario, $nome, $senha)
    {

        $ins = $pdo->prepare("INSERT INTO blog_usuario(usuario_user, usuario_name, usuario_pass) VALUES(:usuario,:nome,:senha)");

        $ins->bindParam(":usuario", $usuario);

        $ins->bindParam(":nome", $nome);

        $ins->bindParam(":senha", $senha);

        $obj = $ins->execute();

        return ($obj) ? $obj : false;
    }

    public function deleteUsuario($pdo, $usuario_id)
    {
        $ins = $pdo->prepare("DELETE FROM 
								blog_usuario
							 WHERE
								usuario_id=:usuario_id");
        $ins->bindParam(":usuario_id", $usuario_id);

        $obj = $ins->execute();

        return ($obj) ? $obj : false;
    }

    public function getUserAllPosts($pdo, $usuario_id)
    {

        $obj = $pdo->prepare("SELECT
	                            post_title,
                                categoria_title,
	                            post_creation,
	                            post_url 
							FROM 
								blog_post
                            INNER JOIN
	                            blog_categoria 
                                ON 
                                blog_categoria.`categoria_id` = blog_post.`post_categoria_id`
							WHERE
								post_usuario_id = :usuario_id
							");

        $obj->bindParam(":usuario_id", $usuario_id);
        return ($obj->execute()) ? $obj->fetchAll(PDO::FETCH_ASSOC) : false;
    }

//  COMPONENTE 'CATEGORIA'

    public function getAllCategorias($pdo)
    {

        $obj = $pdo->prepare("SELECT 
								bc.categoria_id,
								bc.categoria_title,
								(
								 SELECT count(bp.post_id) 
								 FROM
									blog_post bp
								 WHERE
									bp.post_categoria_id = bc.categoria_id
								) AS numeroposts
							FROM 
								blog_categoria bc
							ORDER BY
								bc.categoria_id
							");

        return ($obj->execute()) ? $obj->fetchAll(PDO::FETCH_ASSOC) : false;
    }

    public function getCategoriaId($pdo, $categoria_id)
    {
        $obj = $pdo->prepare("SELECT 
								categoria_id,
								categoria_title
							FROM 
								blog_categoria 
							WHERE
								categoria_id = :categoria_id
							");

        $obj->bindParam(":categoria_id", $categoria_id);
        return ($obj->execute()) ? $obj->fetch(PDO::FETCH_ASSOC) : false;
    }

    public function updateDataCategoria($pdo, $categoria_id, $categoria_title)
    {

        $sql = "UPDATE 
					blog_categoria
				SET 
					categoria_title=? 
				WHERE 
					categoria_id=?";
        $obj = $pdo->prepare($sql);
        $obj->execute(array($categoria_title, $categoria_id));

        return ($obj) ? $obj : false;

    }

    public function insertCategoria($pdo, $categoria_title)
    {

        $ins = $pdo->prepare("INSERT INTO 
                                blog_categoria(categoria_title) 
                            VALUES(:categoria_title)");

        $ins->bindParam(":categoria_title", $categoria_title);

        $obj = $ins->execute();

        return ($obj) ? $obj : false;
    }

    public function deleteCategoria($pdo, $categoria_id)
    {
        $ins = $pdo->prepare("DELETE FROM 
								blog_categoria
							 WHERE
								categoria_id=:categoria_id");
        $ins->bindParam(":categoria_id", $categoria_id);

        $obj = $ins->execute();

        return ($obj) ? $obj : false;
    }

// COMPONENTE 'POST'

    public function getAllPosts($pdo)
    {

        $obj = $pdo->prepare("SELECT 
								*
							FROM 
								blog_post bp
							ORDER BY
								bp.post_id
							");

        return ($obj->execute()) ? $obj->fetchAll(PDO::FETCH_ASSOC) : false;
    }

    public function getPostId($pdo, $post_id)
    {

        $obj = $pdo->prepare("SELECT 	bp.post_id, bp.post_title, bp.post_text,
	                                    bp.post_blocked, bp.post_date, bp.post_url,
	                                    bp.post_categoria_id, bc.categoria_title, 
	                                    bp.post_usuario_id, bu.usuario_name, bp.post_creation
	
                              FROM 	blog_post bp

                              INNER JOIN blog_categoria bc 
	                                    ON bc.categoria_id = bp.post_categoria_id
	
                              INNER JOIN blog_usuario bu
	                                    ON bu.usuario_id = bp.post_usuario_id

                              WHERE
	                                    bp.post_id = :post_id
							");

        $obj->bindParam(":post_id", $post_id);

        return ($obj->execute()) ? $obj->fetch(PDO::FETCH_ASSOC) : false;
    }

    public function updateDataPost($pdo, $post_id, $post_title, $post_text, $post_blocked, $postcategoria, $postUrl, $post_date)
    {
        $sql = "UPDATE 
					blog_post
				SET 
					post_title=?,
					post_text=?,
					post_blocked=?,
					post_categoria_id=?,
					post_url=?,
					post_date=?
				WHERE 
					post_id=?";
        $obj = $pdo->prepare($sql);
        $obj->execute(array($post_title, $post_text, $post_blocked, $postcategoria, $postUrl, $post_date, $post_id));

        return ($obj) ? $obj : false;
    }

    public function insertPost($pdo, $post_title, $postUrl, $post_text, $post_blocked, $postcategoria, $post_date, $usuario_id, $post_creation)
    {
        $ins = $pdo->prepare("INSERT INTO 
								blog_post
								(
									post_title,
									post_url,
									post_text,
									post_blocked,
									post_categoria_id,
									post_date,
									post_usuario_id,
									post_creation
								) VALUES(
									:post_title,
									:post_url,
									:post_text,
									:post_blocked,
									:postcategoria,
									:post_date,
									:usuario_id,
									:post_creation
								)");
        $ins->bindParam(":post_title", $post_title);
        $ins->bindParam(":post_url", $postUrl);
        $ins->bindParam(":post_text", $post_text);
        $ins->bindParam(":post_blocked", $post_blocked);
        $ins->bindParam(":postcategoria", $postcategoria);
        $ins->bindParam(":post_date", $post_date);
        $ins->bindParam(":usuario_id", $usuario_id);
        $ins->bindParam(":post_creation", $post_creation);

        $obj = $ins->execute();

        return ($obj) ? $obj : false;
    }

    public function deletePost($pdo, $post_id)
    {

        // excluímos as imagens do banco de dados

        $ins = $pdo->prepare("DELETE FROM 
								blog_imagem
							 WHERE
								imagem_post_id=:post_id");
        $ins->bindParam(":post_id", $post_id);
        $obj = $ins->execute();

        // excluimos o post
        $ins = $pdo->prepare("DELETE FROM 
								blog_post
							 WHERE
								post_id=:post_id");
        $ins->bindParam(":post_id", $post_id);
        $obj = $ins->execute();

        return ($obj) ? $obj : false;
    }

// COMPONENTE 'IMAGEM'

    public function getImagemPost($pdo)
    {

        $obj = $pdo->prepare("
                        SELECT * FROM blog_imagem
                        WHERE imagem_post_id 
                        IS NOT NULL");

        return ($obj->execute()) ? $obj->fetchAll() : false;
    }

    public function selectFeaturedImg($pdo, $post_id)
    {

        $obj = $pdo->prepare("SELECT imagem_id, COUNT(*) 
                                FROM blog_imagem bi
                                WHERE bi.imagem_post_id = :post_id 
                                AND bi.imagem_featured = 1
                                HAVING COUNT(*) >= 1");

        $obj->bindParam(":post_id", $post_id);

        return ($obj->execute()) ? $obj->fetchAll(PDO::FETCH_ASSOC) : false;

    }

    public function getAllImagens($pdo, $post_id)
    {

        $obj = $pdo->prepare("SELECT 
								bi.imagem_id,
								bi.imagem_subtitle,
								bi.imagem_file,
								bi.imagem_featured
							FROM 
								blog_imagem bi
							WHERE
								bi.imagem_post_id = :post_id
							");
        $obj->bindParam(":post_id", $post_id);

        return ($obj->execute()) ? $obj->fetchAll(PDO::FETCH_ASSOC) : false;

    }

    public function getImagemId($pdo, $imagem_id)
    {

        $obj = $pdo->prepare("SELECT 
								bi.imagem_id,
								bi.imagem_subtitle,
								bi.imagem_file,
								bi.imagem_featured,
								bi.imagem_post_id AS post_id
							FROM 
								blog_imagem bi
							WHERE
								bi.imagem_id = :imagem_id
							");

        $obj->bindParam(":imagem_id", $imagem_id);

        return ($obj->execute()) ? $obj->fetch(PDO::FETCH_ASSOC) : false;
    }

    public function updateDataImagem($pdo, $imagem_id, $imagem_subtitle, $imagem_featured)
    {

        $sql = "UPDATE 
					blog_imagem
				SET 
					imagem_subtitle=?,
					imagem_featured=?
				WHERE 
					imagem_id=?";
        $obj = $pdo->prepare($sql);

        $obj->execute(array($imagem_subtitle, $imagem_featured, $imagem_id));

        return ($obj) ? $obj : false;
    }

    public function insertImagem($pdo, $post_id, $imagem_file, $imagem_subtitle, $imagem_featured)
    {

        $ins = $pdo->prepare("INSERT INTO 
								blog_imagem
								(
									imagem_file, 
									imagem_subtitle, 
									imagem_featured, 
									imagem_post_id
								) VALUES(
									:imagem_file, 
									:imagem_subtitle, 
									:imagem_featured, 
									:imagem_post_id
								)");

        $ins->bindParam(":imagem_file", $imagem_file);
        $ins->bindParam(":imagem_subtitle", $imagem_subtitle);
        $ins->bindParam(":imagem_featured", $imagem_featured);
        $ins->bindParam(":imagem_post_id", $post_id);

        $obj = $ins->execute();

        return ($obj) ? $obj : false;
    }

    public function deleteImagem($pdo, $imagem_id)
    {

        $ins = $pdo->prepare("DELETE FROM 
								blog_imagem
							 WHERE
								imagem_id=:imagem_id");

        $ins->bindParam(":imagem_id", $imagem_id);

        $obj = $ins->execute();

        return ($obj) ? $obj : false;
    }

}