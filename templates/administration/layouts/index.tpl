<!DOCTYPE html>
<html lang="fr">
  <head>
	{include file='blocs/header.tpl'}
  </head>
  <body class="am-splash-screen">
  {if isset($alert['style'])}
	<div class="alert alert-{$alert['style']} alert-dismissible" role="alert">
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	 {if isset($alert['type'])} <b>{$alert['type']}!</b> {/if}{if isset($alert['text'])}{$alert['text']}{/if}
	</div>
  {/if}
    {$__content}
 <!-- /container -->
	{$__js}
	{debug}
  </body>
 </html>