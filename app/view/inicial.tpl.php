<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<div class="container">

    <div class="row">

        <div class="col-sm-8 blog-main">

            <?php foreach($tpl["inicial"]["posts"] as $post) { ?>

                <?php $date = new datetime($post["post_date"]); ?>

                <div class="blog-post">

                    <h2 class="blog-post-title">
                        <a href="index.php?r=post&url=<?=$post["post_url"] ?>" style="text-decoration:none; color:#777;"
                           onmouseover=" this.style.color='#210397';" onmouseout="this.style.color='#777';" >
                            <?=$post["post_title"]?>
                        </a>
                    </h2>
                    <p class="blog-post-meta">
                        <?=$date->format('d/m/Y H:i:s') ?><br>
                        Escrito por <i><?=$post["post_usuario_name"] ?></i>
                        em <b><?=$post["post_categoria"] ?></b>
                    </p>
                    <?php if($post["post_imagem_featured"] != ""){ ?>
                        <img src="upload/<?=$post["post_imagem_featured"] ?>" style="width: 100%; height: auto;"/>
                    <?php } ?>
                </div>

                <!-- /.blog-post -->

            <?php } ?>

        </div>

        <!-- /.blog-main -->

        <!--
            Bloco de código para a sidebar, que exibe o 'Sobre' e carrega as categorias.
        -->

        <div class="col-sm-3 col-sm-offset-1 blog-sidebar">
            <div class="sidebar-module sidebar-module-inset">
                <h4>Sobre</h4>
                <p>Fale um pouco sobre você</p>
            </div>

            <!--
                Carrega as categorias.
            -->

            <div class="sidebar-module">
                <h4>Categorias</h4>
                <ol class="list-unstyled">
                    <?php foreach($tpl["inicial"]["categorias"] as $categoria) { ?>
                        <li><font size="4">
                                <a href="index.php?r=categoria&id=<?=$categoria["categoria_id"] ?>"
                                   style="text-decoration:none; color:#777;"
                                   onmouseover=" this.style.color='#210397';" onmouseout="this.style.color='#777';">

                                    <?=$categoria["categoria_title"]?>

                                </a></font></li>
                    <?php } ?>
                </ol>
            </div>

        </div>

        <!-- /.blog-sidebar -->

    </div>

    <!-- /.row -->

</div>

<!-- /.container -->