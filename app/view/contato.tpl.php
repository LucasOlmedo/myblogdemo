<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<div class="container">

    <div class="row">

        <div class="col-sm-12">

            <form class ="form-horizontal" action="index.php?r=contact" method="post" role="form">

                <?php if($tpl["contato"]["msg"] != "") { ?>
                <div class="alert marginTop <?=$tpl["contato"]["class"]?> ">
                    <strong><?=$tpl["contato"]["msg"]?></strong>
                </div>
                <?php } ?>

                <div class="well well-sm">
                    <strong><font color="red">* Campo obrigatório</font></strong>
                </div>

                <div class="form-group">
                    <label for="InputName">Seu nome:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="nome" id="nome" placeholder="Digite o seu nome." required>
                        <span class="input-group-addon"><font color="red">*</font></span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="InputEmail">Seu e-mail:</label>
                    <div class="input-group">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Digite o seu e-mail. Ex: x@x.com" required>
                        <span class="input-group-addon"><font color="red">*</font></span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="mensagem">Mensagem:</label>
                    <div class="input-group">
                        <textarea name="mensagem" id="mensagem" rows="10" class="form-control"></textarea>
                        <span class="input-group-addon"><font color="red">*</font></span
                    </div>
                </div>

                <br>

                <input type="hidden" name="frm_enviar" value="s" />
                <input type="submit" name="submit" id="submit" value="Enviar" class="btn btn-primary">

            </form>

        </div>

    </div>

    <!-- /.row -->

</div>
</div>