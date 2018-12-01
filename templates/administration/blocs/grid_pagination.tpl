<div class="row" id="page-grid-table-search-action">
	<div class="col-md-6 no-gutter">
		<div class="col-md-2 no-gutter">
			<button type="button" class="btn search">Recherche</button>
		</div>
		<div class="col-md-3 no-gutter">
			<button type="button" class="btn btn-link" id="filter-reset">Annule les filtres</button>
		</div>
		<div class="col-md-7 no-gutter data-found">
			{$total} résultat{if $total > 1}s{/if} trouvé{if $total > 1}s{/if}
		</div>
	</div>
	<div class="col-md-6 no-gutter" style="line-height:35px">
		<div class="row">
			<div class="col-md-6">
				<select name="by_page" id="page-select-by-page">
					<option {if isset($byPage) and $byPage == 10}selected='selected'{/IF}>10</option>
					<option {if isset($byPage) and $byPage == 50}selected='selected'{/IF}>50</option>
					<option {if isset($byPage) and $byPage == 100}selected='selected'{/IF}>100</option>
					<option {if isset($byPage) and $byPage == 200}selected='selected'{/IF}>200</option>
				</select>
				Résultats par pages
			</div>
			<div class="col-md-6 page-grid-search-pagination">
				<button class="btn btn-default page-past-pagination" type="button" {IF $currentPage == 1}disabled{/IF}><</button>
				<input type="text" name="page" class="page-select-pagination" value="{$currentPage}" type="button"> <label>sur {$nbPageMax}</label>
				<button class="btn btn-default page-next-pagination" type="button" {IF $currentPage == $nbPageMax}disabled{/IF}>></button>
			</div>
		</div>
	</div>
</div>