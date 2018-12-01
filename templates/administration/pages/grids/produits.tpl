<div class="page-action">
	<div class="row">
		<div class="col-md-12 button-action-zone">  
			<button type="button" class="btn btn-warning" data-url="/attributes/add"><span class="ui-button-text">Exporter</span></button>
		</div>
	</div>
</div>
<div class="page-body">
	<div class="page-grid">
	<form class="page-grid-table-search" method="post">
		 
		<table class="page-grid-table table table-striped">
			<thead>
				<tr>
					<th>
						sku
					</th>
					<th>
						Designation
					</th>
					<th>
						Complétude
					</th>
				</tr>
			</thead>
				<tr>
					<td><input class="form-control fields-filter" type="text" name="code" value="{IF isset($smarty.session.grids.produits.code)}{$smarty.session.grids.produits.code}{/IF}"></td>
					<td><input class="form-control fields-filter" type="text" name="libelle" value="{IF isset($smarty.session.grids.produits.libelle)}{$smarty.session.grids.produits.libelle}{/IF}"></td>
					<td><input class="form-control fields-filter" type="text" name="login" value="{IF isset($smarty.session.grids.produits.login)}{$smarty.session.grids.produits.login}{/IF}"></td>
				</tr>
			{if isset($liste)}
				{foreach from=$liste item=item}
				<tr class="grid-link-edit" data-target="produits" data-code="{$item->code}">
					<td>
						{$item->code}
					</td>
					<td>
						{$item->libelle}
					</td>
					<td>
						{$item->login}
					</td>
				</tr>
				{/foreach}
			{/if}
		</table>
	</form>
	</div>
</div>