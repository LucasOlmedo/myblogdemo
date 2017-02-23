<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<div class="container marginTop">
	<div class="row">
		<div class="col-xs-12">
			<a href="index.php?r=admin&c=posts&a=insertPost" class="btn btn-primary btn-large">Escrever novo post</a>

			<?php if($tpl["dados"]["msg"] != "") { ?>

				<div class="alert alert-info alert-dismissible marginTop" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong><?=$tpl["dados"]["msg"]?></strong>
				</div>

			<?php } ?>

			<table class="table table-striped table-bordered table-hover marginTop">
				<thead>
					<tr>
						<th width="150">ID</th>
						<th width="450">Título</th>
						<th width="250">Data de criação</th>
						<th colspan="4">Opções</th>
					</tr>
				</thead>

				<tbody>
					<?php foreach($tpl["dados"]["posts"] as $post) { ?>

					<tr>
						<td><?=$post["post_id"]?></td>
						<td><?=$post["post_title"]?></td>
						<td><?=$post["post_creation"]?></td>
                        <td>
							<a href="index.php?r=post&url=<?=$post["post_url"]?>" class="btn btn-warning" target="_blank">Ver</a>
						</td>
                        <td>
							<a href="index.php?r=admin&c=imagens&id=<?=$post["post_id"]?>" class="btn btn-success">Imagem</a>
						</td>
						<td>
							<a href="index.php?r=admin&c=posts&a=updatePost&id=<?=$post["post_id"]?>" class="btn btn-primary">Alterar</a>
						</td>
						<td>
							<a href="index.php?r=admin&c=posts&a=deletePost&id=<?=$post["post_id"]?>" class="btn btn-danger" onclick="return confirm('Deseja realmente excluir o registro?')">Excluir</a>
						</td>
					</tr>

					<?php } ?>
				</tbody>

			</table>

		</div>
	</div>
</div>