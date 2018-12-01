<form class="form-horizontal" method="post">
	{include file='blocs/form_header.tpl'}
	<div class="page-form">
		<div class="row title">
			<div class="col-md-11">
				Propriété de la valeur d'attribut
			</div>
			<div class="col-md-1 page-form-arrow">
				<i class="fas fa-angle-up" data-toogle="fields_property"></i>
			</div>
		</div>
		<div class="row" id="fields_property">
			<div class="form-group form-line _required">
				<label for="attribute_code" class="col-sm-3 control-label admin__field-label"><span>Attribut</span></label>
				<div class="col-sm-9">
				  <input type="text" class="form-control" id="attribute_code" name="attribute_code" placeholder="Code de l'attribut" {IF isset($item->attribute_code)}readonly{/IF} value="{IF isset($item->attribute_code)}{$item->attribute_code}{/IF}">
				</div>
			</div>
			<div class="form-group form-line _required">
				<label for="options_code" class="col-sm-3 control-label admin__field-label"><span>Code</span></label>
				<div class="col-sm-9">
				  <input type="text" class="form-control" id="options_code" name="options_code" placeholder="options_code" {IF isset($item->options_code)}readonly{/IF} value="{IF isset($item->options_code)}{$item->options_code}{/IF}">
				</div>
			</div>
			<div class="form-group form-line">
				<label for="value" class="col-sm-3 control-label admin__field-label"><span>Valeur</span></label>
				<div class="col-sm-9">
				  <input type="text" class="form-control" id="value" name="value" placeholder="Valeur" {IF isset($item->value)}readonly{/IF} value="{IF isset($item->value)}{$item->value}{/IF}">
				</div>
			</div>
			{if $item->isAxe()}
			<div class="form-group form-line">
				<label for="label_marketing" class="col-sm-3 control-label admin__field-label"><span>Label Marketing</span></label>
				<div class="col-sm-9">
				  <input type="text" class="form-control" id="label_marketing" name="label_marketing" placeholder="Label Marketing"  value="{IF isset($item->label_marketing)}{$item->label_marketing}{/IF}">
				</div>
			</div>
			{/if}
		</div>
		<div class="row title">
			<div class="col-md-11">
				Thésaurus
			</div>
			<div class="col-md-1 page-form-arrow"><i class="fas fa-angle-up" data-toogle="fields_config"></i></div>
		</div>
		<div class="row" id="fields_config">
			{IF isset($thesaurus)}
				{foreach from=$thesaurus item=synonyme}
					<div class="input-group thesaurus-list">
						<input type="text" class="form-control thesaurus-input" name="thesaurus[]" value="{$synonyme}">
							<span class="input-group-btn">
								<button class="btn btn-default thesaurus-add-row" type="button"><span class="glyphicon glyphicon-object-align-vertical"></span></button>
							</span>
							<span class="input-group-btn">
								<button class="btn btn-danger thesaurus-del" type="button"><span class="glyphicon glyphicon-remove "></span></button>
							</span>
					</div>
				{/foreach}
			{ELSE}
				<div class="input-group thesaurus-list">
						<input type="text" class="form-control thesaurus-input" name="thesaurus[]" value="">
							<span class="input-group-btn">
								<button class="btn btn-default thesaurus-add-row" type="button"><span class="glyphicon glyphicon-object-align-vertical"></span></button>
							</span>
							<span class="input-group-btn">
								<button class="btn btn-danger thesaurus-del" type="button"><span class="glyphicon glyphicon-remove danger"></span></button>
							</span>
					</div>
			{/IF}
			
		</div>
	</div>
</form>