<div class="page-action">
	<div class="row">
		<div class="col-md-12 button-action-zone">  
			<button type="button" class="btn btn-success reindexation"><span class="ui-button-text">Réindexation</span></button>
		</div>
	</div>
</div>
<div class="page-body">
	<div class="page-grid">
		<table class="page-grid-table table table-striped">
			<thead>
				<tr>
					<th style="width:3%">
						&nbsp;
					</th>
					<th style="width:23%">
						Indexer
					</th>
					<th style="width:42%">
						Description
					</th>
					<th style="width:15%">
						Status
					</th>
					<th style="width:15%">
						Dernière éxecution
					</th>
				</tr>
			</thead>
			<tbody>
			{foreach from=$liste item=item}
				<tr>
					<td style="text-align:center"><input type="checkbox" value="{$item->id}" class="select_indexation"></td>
					<td>{$item->label}</td>
					<td>{$item->description}</td>
					<td>
						<span class="label label-info">{$item->state}</span>
					</td>
					<td>{$item->updated_at}</td>
				</tr>
			{/foreach}
			</tbody>
		</table>
	</div>
</div>