<form class="form-horizontal">
	{include file='blocs/form_header.tpl'}
	<div class="page-form">
		<div class="row title">
			<div class="col-md-11">
				Propriétés
			</div>
			<div class="col-md-1 page-form-arrow">
				<i class="fas fa-angle-up" data-toogle="fields_property"></i>
			</div>
		</div>
		<div class="row" id="fields_property">
			<div class="form-group form-line _required">
				<label for="language_code" class="col-sm-3 control-label admin__field-label"><span>Code ISO du language</span></label>
				<div class="col-sm-9">
				  <input type="text" class="form-control" id="language_code" name="language_code" placeholder="Code ISO du language" value="{IF isset($item->language_code)}{$item->language_code}{/IF}">
				</div>
			</div>
			<div class="form-group form-line">
				<label for="attribute_type" class="col-sm-3 control-label admin__field-label"><span>Activé ?</span></label>
				<div class="col-sm-9">
				  <div class="switch-button switch-button-success">
                        <input type="checkbox" checked="" name="swt5" id="swt5">
						<span>
                          <label for="swt5"></label>
						 </span>
                      </div>
				</div>
			</div>
		</div>
		<div class="row title">
			<div class="col-md-11">
				Options (Libellés du language)
			</div>
			<div class="col-md-1 page-form-arrow">
				
			</div>
		</div>
		<div class="row" id="fields_option">
		{$item->translate|var_dump}
			<div class="form-group form-line">
				<label for="attribute_type" class="col-sm-3 control-label admin__field-label"><span>Libellés</span></label>
				<div class="col-sm-9">
					 <div class="input-group">
					  {foreach from=$flags item=flag key=code}
						<input type="text" class="form-control input-localizable {IF $code==$smarty.session.Auth.lg}visible{ELSE}hidden{/IF}" name="libelle[$code]" value="{IF isset($item->translate[$code])}{$item->translate[$code]}{/IF}">
					  {/foreach}
					  <div class="input-group-btn">
						<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{$_medias}flags/{$smarty.session.Auth.lg}.png"> <span class="caret"></span></button>
						<ul class="dropdown-menu dropdown-menu-right">
						{foreach from=$flags item=flag key=code}
							<li><img src="{$_medias}flags/{$code}.png"></li>
						{/foreach}
						</ul>
					  </div><!-- /btn-group -->
					</div><!-- /input-group -->
				</div>
			</div>
		</div>
	</div>
</form>