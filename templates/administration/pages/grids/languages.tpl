<div class="page-action">
	<div class="row">
		<div class="col-md-12 button-action-zone">  
			<button type="button" class="btn btn-warning" data-url="/languages/add"><span class="ui-button-text">Ajouter un language</span></button>
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
						Language code
					</th>
					<th>
						Libelle
					</th>
					<th>
						Actif
					</th>
				</tr>
				<tr>
					<td><input class="form-control" type="text" name="language_entity" value="{IF isset($smarty.session.grids.languages.language_entity)}{$smarty.session.grids.languages.language_entity}{/IF}"></td>
					<td><input class="form-control" type="text" name="language_code" value="{IF isset($smarty.session.grids.languages.language_code)}{$smarty.session.grids.languages.language_code}{/IF}"></td>
					<td><input class="form-control" type="text" name="libelle" value="{IF isset($smarty.session.grids.languages.libelle)}{$smarty.session.grids.languages.libelle}{/IF}"></td>
					<td><select class="form-control" name="actif">
                        <option value=""></option>
                        <option value="1" {IF isset($smarty.session.grids.languages.actif) and $smarty.session.grids.languages.actif == 1}selected='selected'{/IF}>Oui</option>
                        <option value="null" {IF isset($smarty.session.grids.languages.actif) and $smarty.session.grids.languages.actif == "null"}selected='selected'{/IF}>Non</option>
                       </select>
					</td>
				</tr>
			</thead>
			<tbody>
		{foreach from=$liste item=item}
			<tr class="grid-link-edit" data-target="languages" data-code="{$item->language_code}">
				<td>
					{$item->language_entity}
				</td>
				<td>
					{$item->language_code}
				</td>
				<td>
					{$item->translate[$lg]}
				</td>
				<td class="label__check">
					<i class="fa fa-check icon {IF is_null($item->actif)}unchecked{else}checked{/IF}" data-ref="{$item->language_entity}"></i>
				</td>
			</tr>
		{/foreach}
			</tbody>
		</table>
	</form>
	</div>
</div>