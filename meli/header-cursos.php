<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8" />
	<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title> 
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<link rel="shorcut icon" href="<?php bloginfo('url'); ?>/wp-content/themes/meli/favicon.ico" />
	
	<?php wp_head(); ?>
	
	<!-- <link rel="canonical" href="https://vendedores.mercadolibre.com.ar/" /> -->
	<meta property="og:locale" content="es_ES" />
	<meta property="og:type" content="website" />
	<meta property="og:title" content="Centro de vendedores" />
	<meta property="og:description" content="Todo lo que necesitás para vender exitosamente en Mercado Libre, en tu tienda online y en tu tienda física." />
	<!-- <meta property="og:url" content="https://vendedores.mercadolibre.com.ar/" /> -->
	<meta property="og:site_name" content="Centro de vendedores Argentina" />
	<meta property="og:image" content="<?php bloginfo('url'); ?>/wp-content/themes/meli/bienvenido_img-1.jpg" />
	<meta property="og:image:secure_url" content="<?php bloginfo('url'); ?>/wp-content/themes/meli/bienvenido_img-1.jpg" />
	<meta property="og:image:width" content="1600" />
	<meta property="og:image:height" content="459" />
	<meta name="twitter:card" content="summary_large_image" />
	<meta name="twitter:description" content="Todo lo que necesitás para vender exitosamente en Mercado Libre, en tu tienda online y en tu tienda física." />
	<meta name="twitter:title" content="Centro de vendedores" />
	<meta name="twitter:image" content="<?php bloginfo('url'); ?>/wp-content/themes/meli/bienvenido_img-1.jpg" />

    <link rel="stylesheet" type="text/css" href="<?php bloginfo('url'); ?>/wp-content/themes/meli/css/reset.css?v=1"/>
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('url'); ?>/wp-content/themes/meli/css/owl.carousel.css?v=1"/>
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('url'); ?>/wp-content/themes/meli/css/font-awesome.min.css?v=1"/>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('url'); ?>/wp-content/themes/meli/fonts/fonts.css?v=1">
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('url'); ?>/wp-content/themes/meli/style.css?v=1"/> 
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('url'); ?>/wp-content/themes/meli/css/css.css?v=1">

    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script> 
</head>
<body <?php body_class(); ?>>

<header>
	<div class="wp">
		<a href="<?php bloginfo('url') ?>/"><img src="<?php bloginfo('url'); ?>/wp-content/themes/meli/img/logo-meli.svg" alt="Centro de Vendedores" class="logo"></a>
		
		<div class="right">
		<nav>
			<ul> 
				<li><a href="<?php bloginfo('url') ?>/novedades" class="<?= ($slug == 'novedades') ? 'active' : '';  ?>">Novedades</a></li>
				<li><a href="<?php bloginfo('url') ?>/notas" class="<?= ($slug == 'notas') ? 'active' : '';  ?>">Notas</a></li>
				<li><a href="<?php bloginfo('url') ?>/cursos" class="<?= ($slug == 'cursos') ? 'active' : '';  ?>">Cursos</a></li>
				<!-- <li>Etiquetas <i class="fa fa-angle-down"></i>
					<div class="submenu">
						<?php 
						foreach ($tagsName as $tag) {
							echo '<a href="'.get_bloginfo('url').'/tags/?t='.$tag->slug.'">'.$tag->name.'</a>';
						}
						?>
					</div>
				</li> -->
			</ul>
		</nav>
		<a href="<?php bloginfo('url') ?>/buscar"><img src="<?php bloginfo('url'); ?>/wp-content/themes/meli/img/lupa@3x.png" alt="Search :: Centro de vendedores" class="lupa_header"></a>
		<div id="burger"><i></i><i></i><i></i></div>
		</div>
	</div>
</header>
