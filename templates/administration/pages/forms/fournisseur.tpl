<form class="form-horizontal">
	{include file='blocs/form_header.tpl'}
	<div class="page-form">
		<div class="row title">
			<div class="col-md-11">
				Propriété du fournisseur
			</div>
			<div class="col-md-1 page-form-arrow">
				<i class="fas fa-angle-up" data-toogle="fields_property"></i>
			</div>
		</div>
		<div class="row" id="fields_property">
			<div class="form-group form-line _required">
				<label for="login" class="col-sm-3 control-label admin__field-label"><span>Login</span></label>
				<div class="col-sm-9">
				  <input type="text" class="form-control" id="login" name="login" placeholder="Login" value="{IF isset($item->login)}{$item->login}{/IF}">
				</div>
			</div>
			<div class="form-group form-line">
				<label for="libelle" class="col-sm-3 control-label admin__field-label"><span>Libelle</span></label>
				<div class="col-sm-9">
				  <input type="text" class="form-control" id="libelle" name="libelle" placeholder="Libelle" value="{IF isset($item->libelle)}{$item->libelle}{/IF}">
				</div>
			</div>
			<div class="form-group form-line">
				<label for="new_mdp" class="col-sm-3 control-label admin__field-label"><span>Nouveau mot de passe</span></label>
				<div class="col-sm-9">
				  <input type="text" class="form-control" id="new_mdp" name="motdepasse" placeholder="Nouveau mot de passe">
				</div>
			</div>
			<div class="form-group form-line">
				<label for="new_mdp2" class="col-sm-3 control-label admin__field-label"><span>Confirmer le mot de passe</span></label>
				<div class="col-sm-9">
				  <input type="text" class="form-control" id="new_mdp2"  placeholder="">
				</div>
			</div>
		</div>
		<div class="row title">
			<div class="col-md-11">
				Configuration de l'import
			</div>
			<div class="col-md-1 page-form-arrow"><i class="fas fa-angle-up" data-toogle="fields_config"></i></div>
		</div>
		<div class="row" id="fields_config">
			<div id="dl_contener">
				<div id="dl_zone">
					<input class="fileUploaderInput" type="file" name="Drag and drop a file or click here">
					<div class="emptyContainer">
						<i class="fas fa-download fa-5x"></i>
						<span id="fileUploaderText">Déposez votre fichier csv ici, ou cliquez ici pour le chercher sur votre disque</span>
					</div>
				</div>
			</div>
			<div class ="row">
				<div class="col-md-12" style="text-align:center;margin-bottom:15px">
					<button class="btn btn-success" id="fileUploaderBtn" type="button">Mettre à jour les champs</button>
				</div> 
			</div>
			<div class="row">
				<div class="col-md-8" id="entetes_zone" data-fournisseur="{$item->code}">
					<div class="loader-calk"></div>
					<div class="am-scroller nano has-scrollbar">
						<div class="nano-content col-md-12">
							<div id="list-headers">
								<table id="tbl-headers">
									<thead>
										<tr>
											<th>Entêtes</th>
											<th>Correspondance</th>
										</tr>
									</thead>
									<tbody>
									{foreach from=$mapping key=header item=map}
										<tr>
											<td>{$header}</td>
											<td class="droppable" data-headers="{$header}">{if $map["attributs_code"] != ""}
												<span class='label label-success tags_selected ' id="tag_{$map["attributs_code"]}">{$map["attributs_label"]}<i class="fas fa-times"></i></span>
												{/IF}
											</td>
										</tr>
									{/foreach}
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4" id="tags_zone">
					<div class="am-scroller nano has-scrollbar">
						<div class="nano-content">
							<div class="search">
								<input type="text" id="input-search-tags">
							</div>
							<div class="list-tags">
								{foreach from=$attributs item=attribut}
									<span class="label label-default tags_move" data-search="{$attribut->get('natural')|lower}" data-code="{$attribut->get('code')}">{$attribut->get('label')}</span>
								{/foreach}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>