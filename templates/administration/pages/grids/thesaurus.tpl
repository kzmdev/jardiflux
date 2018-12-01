<div class="loader-calk"></div>
<div class="page-action">
	<div class="row">
		<div class="col-md-12 button-action-zone">  
			<button type="button" class="btn btn-info btn-import" ><span class="ui-button-text">Importer les libelles marketing</span></button>
			<button type="button" class="btn btn-success" data-target="/thesaurus/export"><span class="ui-button-text">Exporter la liste</span></button>
		</div>
	</div>
</div>
<div class="page-upload" style="display:none">
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
			<button class="btn btn-success" id="fileUploaderBtn" type="button" data-script="/ajax/uploadmarketinglabel">Mettre à jour les libellés marketing</button>
		</div> 
	</div>
</div>
<div class="page-body">
	<div class="page-grid">
	<form class="page-grid-table-search" method="post">
		 {include file='blocs/grid_pagination.tpl'}
		<table class="page-grid-table table table-striped">
			<thead>
				<tr>
					<th style="width:15%">
						Code Attribut
					</th>
					<th style="width:15%">
						Code Option
					</th>
					<th style="width:25%">
						Libelle
					</th>
					<th style="width:45%">
						Thesaurus
					</th>
				</tr>
			</thead>
				<tr>
					<td><input class="form-control fields-filter" type="text" name="attribute_code" value="{IF isset($smarty.session.grids.thesaurus.attribute_code)}{$smarty.session.grids.thesaurus.attribute_code}{/IF}"></td>
					<td><input class="form-control fields-filter" type="text" name="options_code" value="{IF isset($smarty.session.grids.thesaurus.options_code)}{$smarty.session.grids.thesaurus.options_code}{/IF}"></td>
					<td><input class="form-control fields-filter" type="text" name="value" value="{IF isset($smarty.session.grids.thesaurus.value)}{$smarty.session.grids.thesaurus.value}{/IF}"></td>
					<td><input class="form-control fields-filter" type="text" name="thesaurus" value="{IF isset($smarty.session.grids.thesaurus.thesaurus)}{$smarty.session.grids.thesaurus.thesaurus}{/IF}"></td>
				</tr>
			{foreach from=$liste item=item}
				<tr class="grid-link-edit" data-target="thesaurus" data-code="{$item->options_code}">
					<td>
						{$item->attribute_code}
					</td>
					<td>
						{$item->options_code}
					</td>
					<td>
						{$item->value}
					</td>
					<td>
						{$item->thesaurus}
					</td>
				</tr>
			{/foreach}
		</table>
	</form>
	</div>
</div>