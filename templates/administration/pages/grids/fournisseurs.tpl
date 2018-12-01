<div class="page-action">
	<div class="row">
		<div class="col-md-12 button-action-zone">  
			<button type="button" class="btn btn-warning" data-url="/attributes/add"><span class="ui-button-text">Ajouter un Fournisseur</span></button>
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
					<th>
						#
					</th>
					<th>
						Libelle
					</th>
					<th>
						Login
					</th>
				</tr>
			</thead>
				<tr>
					<td><input class="form-control fields-filter" type="text" name="code" value="{IF isset($smarty.session.grids.fournisseurs.code)}{$smarty.session.grids.fournisseurs.code}{/IF}"></td>
					<td><input class="form-control fields-filter" type="text" name="libelle" value="{IF isset($smarty.session.grids.fournisseurs.libelle)}{$smarty.session.grids.fournisseurs.libelle}{/IF}"></td>
					<td><input class="form-control fields-filter" type="text" name="login" value="{IF isset($smarty.session.grids.fournisseurs.login)}{$smarty.session.grids.fournisseurs.login}{/IF}"></td>
				</tr>
			{foreach from=$liste item=item}
				<tr class="grid-link-edit" data-target="fournisseurs" data-code="{$item->code}">
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
		</table>
	</form>
	</div>
</div>