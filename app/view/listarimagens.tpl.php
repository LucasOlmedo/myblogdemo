<div class="container marginTop">
	<div class="row">
		<div class="col-xs-12">
			<a href="index.php?r=admin&c=imagens&a=insertImagem&post_id=<?=$tpl["dados"]["post_id"]?>"
               class="btn btn-primary btn-large">Nova imagem destaque</a>
            <a href="index.php?r=admin&c=posts" class="btn btn-success btn-large">Voltar</a>
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
                        <th width="100">ID</th>
						<th width="200">Imagem</th>
						<th width="400">Imagem legenda</th>
						<th colspan="3">Opções</th>
					</tr>
				</thead>

				<tbody>
					<?php foreach($tpl["dados"]["imagens"] as $imagem) { ?>

					<tr>
                        <td><?=$imagem["imagem_id"]?></td>
						<td><img src="upload/thumb/<?=$imagem["imagem_file"]?>" width="100%" /></td>
						<td><?=$imagem["imagem_subtitle"]?></td>
                        <td>
                            <a href="upload/<?=$imagem["imagem_file"]?>" target="_blank" class="btn btn-warning">Ver imagem</a>
                        </td>
						<td>
							<a href="index.php?r=admin&c=imagens&a=updateImagem&id=<?=$imagem["imagem_id"]?>" class="btn btn-primary">Alterar</a>
						</td>
						<td>
							<a href="index.php?r=admin&c=imagens&a=deleteImagem&id=<?=$imagem["imagem_id"]?>&post_id=<?=$tpl["dados"]["post_id"]?>" class="btn btn-danger" onclick="return confirm('Deseja realmente excluir o registro?')">Excluir</a>
						</td>
					</tr>

					<?php } ?>
				</tbody>

			</table>

		</div>
	</div>
</div>