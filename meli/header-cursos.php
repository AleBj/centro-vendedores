<?php 
	global $wp;
	$slug = add_query_arg( array(), $wp->request );

	// error_reporting(E_ALL);
	// ini_set('display_errors', '1');
	$the_query_tags = new WP_Query( array(
    'posts_per_page' => -1,
    'post_type' => array('notas','novedades')
	) ); 
	$tagsName = [];
	$arrayControl = [];

	while ( $the_query_tags->have_posts() ) :

	    $the_query_tags->the_post();
	    $tag = get_the_tags();
	    if($tag){
	    
	    foreach ($tag as $t) {
	        $obj = new stdClass();
	        $obj->name = $t->name;
	        $obj->slug = $t->slug;

	        if (!in_array($obj->name, $arrayControl)) {
	            array_push($tagsName, $obj);
	        }
	        array_push($arrayControl, $obj->name);
	    }

	    }
	  
	endwhile;
	wp_reset_postdata();
?>
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
	<meta property="og:title" content="<?php _e( 'Centro de vendedores', 'meli-centro-vendedores' ); ?>" />
	<meta property="og:description" content="<?php _e( 'Todo lo que necesitás para vender exitosamente en Mercado Libre, en tu tienda online y en tu tienda física.', 'meli-centro-vendedores' ); ?>" />
	<!-- <meta property="og:url" content="https://vendedores.mercadolibre.com.ar/" /> -->
	<meta property="og:site_name" content="<?php _e( 'Centro de vendedores', 'meli-centro-vendedores' ); ?>" />
	<meta property="og:image" content="<?php bloginfo('url'); ?>/wp-content/themes/meli/bienvenido_img-1.jpg" />
	<meta property="og:image:secure_url" content="<?php bloginfo('url'); ?>/wp-content/themes/meli/bienvenido_img-1.jpg" />
	<meta property="og:image:width" content="1600" />
	<meta property="og:image:height" content="459" />
	<meta name="theme-color" content="#ffffff" />
	<meta name="twitter:card" content="summary_large_image" />
	<meta name="twitter:description" content="<?php _e( 'Todo lo que necesitás para vender exitosamente en Mercado Libre, en tu tienda online y en tu tienda física.', 'meli-centro-vendedores' ); ?>" />
	<meta name="twitter:title" content="<?php _e( 'Centro de vendedores', 'meli-centro-vendedores' ); ?>" />
	<meta name="twitter:image" content="<?php bloginfo('url'); ?>/wp-content/themes/meli/bienvenido_img-1.jpg" />

    <link rel="stylesheet" type="text/css" href="<?php bloginfo('url'); ?>/wp-content/themes/meli/css/reset.css?v=1"/>
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('url'); ?>/wp-content/themes/meli/css/owl.carousel.css?v=1"/>
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('url'); ?>/wp-content/themes/meli/css/font-awesome.min.css?v=1"/>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('url'); ?>/wp-content/themes/meli/fonts/fonts.css?v=1">
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('url'); ?>/wp-content/themes/meli/style.css?v=1"/> 
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('url'); ?>/wp-content/themes/meli/css/css.css?v=<?php echo date('s'); ?>">
 	
 	

	<!-- Hotjar Tracking Code for Centro de Vendedores -->
	<script>
	(function(h,o,t,j,a,r){
	h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
	h._hjSettings={hjid:745061,hjsv:6};
	a=o.getElementsByTagName('head')[0];
	r=o.createElement('script');r.async=1;
	r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
	a.appendChild(r);
	})(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
	</script>
	
    <!-- <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>  -->
    <script src="<?php bloginfo('url'); ?>/wp-content/themes/meli/js/jquery-3.2.1.min.js"></script>
</head>
<body <?php body_class(); ?>>
<?php 
$blog_id = get_current_blog_id();
echo '<!--'; 
echo $blog_id;
echo '-->';
?>

<header>
	<div class="wp">
		<a href="<?php bloginfo('url') ?>/">
			<?php if($blog_id == 6): ?>
			<img src="<?php bloginfo('url'); ?>/wp-content/themes/meli/img/logo-meli_pt.svg" alt="Centro de Vendedores" class="logo">
				<?php else: ?>
			<img src="<?php bloginfo('url'); ?>/wp-content/themes/meli/img/logo-meli.svg" alt="Centro de Vendedores" class="logo">
			<?php endif ?>
		</a>
		
		<div class="right">
		<nav>
			<ul> 
				<li><a href="<?php bloginfo('url') ?>/novedades" class="<?= ($slug == 'novedades') ? 'active' : '';  ?>"><?php _e( 'Novedades', 'meli-centro-vendedores' ); ?></a></li>
				<li><a href="<?php bloginfo('url') ?>/notas" class="<?= ($slug == 'notas') ? 'active' : '';  ?>"><?php _e( 'Notas', 'meli-centro-vendedores' ); ?></a></li>
				<li><a href="<?php bloginfo('url') ?>/webinars" class="<?= ($slug == 'webinars' || $slug == 'webinars-anteriores') ? 'active' : '';  ?>"><?php _e( 'Webinars', 'meli-centro-vendedores' ); ?></a></li>
				<li><a href="<?php bloginfo('url') ?>/cursos" class="<?= ($slug == 'cursos') ? 'active' : '';  ?>"><?php _e( 'Cursos', 'meli-centro-vendedores' ); ?></a></li>
				<li><?php _e( 'Etiquetas', 'meli-centro-vendedores' ); ?> <i class="fa fa-angle-down"></i>
					<div class="submenu">
						<?php 
						foreach ($tagsName as $tag) {
							echo '<a href="'.get_bloginfo('url').'/tags/?t='.$tag->slug.'">'.$tag->name.'</a>';
						}
						?>
					</div>
				</li>
			</ul>
		</nav>
		<a href="<?php bloginfo('url') ?>/buscar"><img src="<?php bloginfo('url'); ?>/wp-content/themes/meli/img/lupa@3x.png" alt="Search :: Centro de vendedores" class="lupa_header"></a>
		<div id="burger"><i></i><i></i><i></i></div>
		</div>
	</div>
</header>
