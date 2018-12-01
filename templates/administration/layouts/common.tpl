<!DOCTYPE html>
<html lang="fr">
  <head>
    {include file='blocs/header.tpl'}
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
	<link rel="stylesheet" href="{$_template_dir}css/nanoscroller.css">
	<link rel="stylesheet" href="{$_template_dir}css/select2.min.css">
	<link rel="stylesheet" href="{$_template_dir}css/s7-style.css">
  </head>
  <body cz-shortcut-listen="true">
	<div class="am-wrapper am-sticky-footer">
		<div class="am-left-sidebar">
			<div class="content">
				<div style="text-align:center;padding-bottom:20px">
					<a href="/{$_adminpath}/dashboard"><img src="/{#logo#}" style="width:80px; height:80px"></a>
				</div>
				<ul class="sidebar-elements">
					<li class="parent {IF $menu_selected == 'products'}active{/IF}">
						<a href="/{$_adminpath}/products">
							<i class="fas fa-database fa-2x"></i><span>Produits</span>
						</a>
					</li>
					<li class="parent {IF $menu_selected == 'thesaurus'}active{/IF}">
						<a href="/{$_adminpath}/thesaurus">
							<i class="fas fa-book fa-2x"></i><span>Thésaurus</span>
						</a>
					</li>
					<li class="parent {IF $menu_selected == 'imports'}active{/IF}">
						<a href="/{$_adminpath}/products">
							<i class="fas fa-download fa-2x"></i><span>Imports</span>
						</a>
					</li>
					<li class="parent{IF $menu_selected == 'params'} active{/IF}">
						<a href="#">
							<i class="fas fa-cogs fa-2x"></i><span>Administration</span>
						</a>
						<ul class="sub-menu">
							<li class="title">Administration</li>
							<li class="nav-items">
								<div class="am-scroller nano has-scrollbar">
									<div class="content nano-content" style="margin-right: 0px; right: -17px;">
										<ul>
											<li><span class="title">Les structures</span></li>
											<li><a href="/{$_adminpath}/attributes">Attributs</a></li>
											<li><a href="/{$_adminpath}/entities">Familles</a></li>
											<li><a href="/{$_adminpath}/fournisseurs">Fournisseurs</a></li>
											<li><a href="/{$_adminpath}/distributeurs">Distributeurs</a></li>
										</ul>
										<hr>
										<ul>
											<li><span class="title">Les&nbsp;comptes&nbsp;Utilisateurs</span></li>
											<li><a href="/{$_adminpath}/roles">Roles</a></li>
											<li><a href="/{$_adminpath}/rights">Droits</a></li>
										</ul>
										<hr>
										<ul>
											<li><span class="title">Paramétrage</span></li>
											<li><a href="/{$_adminpath}/configuration">Configuration des variables</a></li>
											<li><a href="/{$_adminpath}/cache">Vidage du cache</a></li>
											<li><a href="/{$_adminpath}/indexations">Indexation</a></li>
										</ul>
									</div>
									<div class="nano-pane" style="display: block;">
										<div class="nano-slider" style="height: 72px; transform: translate(0px, 0px);">
										</div>
									</div>
								</div>
							</li>
						</ul>
					</li>
				</ul>
				<!--Sidebar bottom content-->
			</div>
		</div>
		<div class="am-content">
			<div class="page-content">
				<header>
					<div class="row">
						<div class="col-md-8">
							{IF isset($template_ss_titre)}<h2 class="page-title">{$template_ss_titre}</h2>{/IF}
						</div>
						<div class="col-md-4">
						<!--	<ul class="header-action">
								<li>
									<a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="dropdown-toggle"><span class="icon s7-comment"></span></a>
								</li>
								<li>
									<a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="dropdown-toggle"><span class="icon s7-bell"></span></a>
								</li>
							</ul> -->
						</div>
					</div>
				</header>
				{$__content}
			</div>
			<footer>
				<span class="pull-right"><strong>EasySite</strong> Version 1.0</span><span><img src="/{#logo#}" style="width:20px; height:20px"> This is a footer text</span>
			</footer>
		</div>
	</div>
	{$__js}
<script language="Javascript" src="{$_template_dir}js/nanoscroller.js"></script>
<script language="Javascript" src="{$_template_dir}js/gritter.js"></script>
<script language="Javascript" src="{$_template_dir}js/datepicker.js"></script>
<script language="Javascript" src="{$_template_dir}js/select2.js"></script>
<script language="Javascript" src="{$_template_dir}js/slider.js"></script>
<script language="Javascript" src="{$_template_dir}js/main.js"></script>
	 <script type="text/javascript">
    $(document).ready(function(){
    	//initialize the javascript
    	App.init();
    	App.uiNotifications();
		App.formElements();
	});
  </script>
  </body>
