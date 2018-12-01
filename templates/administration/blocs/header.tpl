<meta charset="utf-8">
<title>{$smarty.const.SITE_NAME}{if isset($template_ss_titre) and $template_ss_titre != ""} - {$template_ss_titre}{/if}</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name='robots' content='no-index, no-follow'>
<meta name="description" content='{IF isset($_seo["description"])}{$_seo["description"]}{/IF}'>
<meta name="Keywords" content='{IF isset($_seo["tag"])}{$_seo["tag"]}{/IF}'>
<link rel="shortcut icon" href="{$_template_dir}img/favicon/favicon.ico" />
<link rel="apple-touch-icon" sizes="57x57" href="{$_template_dir}img/favicon/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="{$_template_dir}img/favicon/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="{$_template_dir}img/favicon/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="{$_template_dir}img/favicon/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="{$_template_dir}img/favicon/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="{$_template_dir}img/favicon/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="{$_template_dir}img/favicon/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="{$_template_dir}img/favicon/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="{$_template_dir}img/favicon/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="{$_template_dir}img/favicon/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="{$_template_dir}img/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="{$_template_dir}img/favicon/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="{$_template_dir}img/favicon/favicon-16x16.png">
<link rel="manifest" href="{$_template_dir}img/favicon/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="{$_template_dir}img/favicon/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">
{$__css}
<link href="{$_template_dir}css/style.css" rel="stylesheet">