<?php
	add_action('after_setup_theme', 'remove_admin_bar');
 
	function remove_admin_bar() {
	if (!current_user_can('administrator') && !is_admin()) {
	  show_admin_bar(true);
	}
	}
	/* establecer el limitador de caché a 'private' */
	session_cache_limiter('private');
	$cache_limiter = session_cache_limiter();

	/* establecer la caducidad de la caché a 30 minutos */
	session_cache_expire(30);
	$cache_expire = session_cache_expire();

	add_action('init', 'cyb_session_start', 1);

	function cyb_session_start() {
	    if( ! session_id() ) {
	        session_start();
	    }
	}


	/* Quitar actualizaciones de los plugins de la lista "unset"*/
	function disable_plugin_updates( $value ) {
	   unset( $value->response['advanced-custom-fields-pro/acf.php'] );
	   return $value;
	}
	add_filter( 'site_transient_update_plugins', 'disable_plugin_updates' );

	// SVG
	function dmc_add_svg_mime_types($mimes) {
		$mimes['svg'] = 'image/svg+xml';
		return $mimes;
	}
	add_filter('upload_mimes', 'dmc_add_svg_mime_types');

	/**
	 * WIDGETS
	 *
	 
	function arphabet_widgets_init() {

		register_sidebar( array(
			'name'          => 'Home right sidebar',
			'id'            => 'home_right_1',
			'before_widget' => '<div>',
			'after_widget'  => '</div>',
			'before_title'  => '<h4>',
			'after_title'   => '</h4>',
		) );

	}*/


	// register_sidebar( array(
	// 	'name'          => 'Home right sidebar',
	// 	'id'            => 'sidebar-1',
	// 	'before_widget' => '<div>',
	// 	'after_widget'  => '</div>',
	// 	'before_title'  => '<h4>',
	// 	'after_title'   => '</h4>',
	// ) );

	# Post types
	# ----------------------------------
	$menu_position = 5;
	function add_post_type($name, $plural, $singular, $icon, $supports, $taxonomies) {
		global $menu_position;
		add_action('init', function() use ($name, $plural, $singular, $icon, $supports, $taxonomies) {
			global $menu_position;
			$plural_lowercase = strtolower($plural);
			$singular_lowercase = strtolower($singular);
			// Register taxonomy
			if (array_search('category', $taxonomies) !== false) {
				register_taxonomy(
					$name.'_categories',
					$name,
				array(
					'hierarchical' => true,
					'label' => 'Categorías de '.$plural,
					'query_var' => true,
					'rewrite' => true
				));
				// Inherit actions
				add_action($name.'_categories_add_form_fields', function() {
					do_action('category_add_form_fields');
				});
				add_action($name.'_categories_edit_form_fields', function($term) {
					do_action('category_edit_form_fields', $term);
				});
				add_action('create_'.$name.'_categories', function($term_id) {
					do_action('edited_category', $term_id);
				}, 10, 2);
				add_action('edited_'.$name.'_categories', function($term_id) {
					do_action('edited_category', $term_id);
				}, 10, 2);
				// Remove category from taxonomy
				if(($key = array_search('category', $taxonomies)) !== false)
					unset($taxonomies[$key]);
			}
			// Register post type
			$labels = array(
				'name' => _x($plural, 'post type general name'),
				'singular_name' => _x($singular, 'post type singular name'),
				'add_new' => _x('Añadir nuevo', $singular_lowercase),
				'add_new_item' => __('Añadir nuevo '.$singular_lowercase),
				'edit_item' => __('Editar '.$singular_lowercase),
				'new_item' => __('Nuevo '.$singular_lowercase),
				'all_items' => __('Todos los '.$plural_lowercase),
				'view_item' => __('Ver '.$singular_lowercase),
				'search_items' => __('Buscar '.$plural_lowercase),
				'not_found' => __('No se encontraron '.$plural_lowercase),
				'not_found_in_trash' => __('No hay '.$plural_lowercase.' en papelera'),
				'parent_item_colon' => '',
				'menu_name' => $plural
			);
			if (substr($singular_lowercase, -3) != 'ima')
			if (substr($singular_lowercase, -1) == 'a' || $singular_lowercase == 'novedad' || substr($singular_lowercase, -3) == 'rse') {
				$labels['new_item'] = __('Nueva '.$singular_lowercase);
				$labels['add_new'] = _x('Añadir nueva', $singular_lowercase);
				$labels['add_new_item'] = __('Añadir nueva '.$singular_lowercase);
				$labels['all_items'] = __('Todas las '.$plural_lowercase);
			}
			$args = array(
				'labels' => $labels,
				'description' => 'Contiene '.$plural_lowercase.' y datos específicos de los mismos',
				'public' => true,
				'menu_position' => $menu_position,
				'supports' => $supports,
				'taxonomies' => $taxonomies,
				'has_archive' => true,
				'menu_icon'	=> $icon,
				'rewrite' => array('slug' => $singular_lowercase, 'with_front'=>false)
			);
			register_post_type($name, $args);
		});
	}

	add_post_type('novedades', 'Novedades', 'novedad', 'dashicons-welcome-write-blog', array('title', 'editor', 'thumbnail', 'revisions'), array('category', 'post_tag', 'page-category'));
	add_post_type('notas', 'Notas', 'nota', 'dashicons-welcome-write-blog', array('title', 'editor', 'thumbnail', 'revisions'), array('category', 'post_tag', 'page-category'));
	add_post_type('webinars', 'Webinars', 'webinar', 'dashicons-format-video', array('title', 'editor', 'thumbnail', 'revisions'), array('category', 'post_tag', 'page-category'));
	add_post_type('alertas', 'Alertas', 'alerta', 'dashicons-format-status', array('title', 'editor', 'revisions'), array('category', 'post_tag', 'page-category'));


	#'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes' ),
	#'taxonomies' => array( 'category', 'post_tag', 'page-category' )

	
	# Admin
	# ----------------------------------
    if (is_admin()) {
        // acf_add_options_page(array(
        //     'page_title' => 'Bloques Home',
        //     'menu_title' => 'Slides Home',
        //     'menu_slug' => 'bloques-home',
        //     'icon_url' => 'dashicons-tickets-alt',
        //     'position' => 9
        // ));
        // acf_add_options_page(array(
        //     'page_title' => 'Destacados Home',
        //     'menu_title' => 'Destacados Home',
        //     'menu_slug' => 'Destacados-home',
        //     'icon_url' => 'dashicons-images-alt',
        //     'position' => 8
        // ));        
       acf_add_options_page(array(
            'page_title' => 'Banners',
            'menu_title' => 'Banners',
            'menu_slug' => 'banners',
            'icon_url' => 'dashicons-media-document',
            'position' => 9
        ));       
        acf_add_options_page(array(
            'page_title' => 'Footer',
            'menu_title' => 'Footer',
            'menu_slug' => 'footer',
            'icon_url' => 'dashicons-editor-ol',
            'position' => 9
        ));

    }


	# Frontend
	# ----------------------------------
	if (!is_admin()) {

		# Rewrite
		# ----------------------------------
		add_action('parse_request', function($wp) {
			global $post_type_any,$fff;

			if (!session_id()){
				session_start();
			}

			$parts = explode('/', $wp->request);
			$element = end($parts);
			$_SESSION['last_part'] = $element;

			if ($element) {
				// Is brand
				$brands = get_posts(array('post_type' => 'brand'));
				$brand_selected = null;
				foreach ($brands as $brand) {
					if ($element == $brand->post_name && $parts[count($parts) - 2] != $element) {
						$brand_selected = $brand;
						$brand_selected->logo = (object)get_field('logo', $brand->ID);
						$brand_selected->logo = $brand_selected->logo->url;
						$element = $parts[count($parts) - 2];
					}
				}
				// Is single?
				$post = get_posts(array('name' => $element, 'post_type' => $post_type_any));

				// var_dump($post);

				if (count($post) > 0) {
					$post = $post[0];
					$post_type = get_post_type_object($post->post_type);

					$wp->query_vars = array(
						'page' => '',
						'product' => $element,
						'post_type' => $post->post_type,
						'name' => $element
					);
					$wp->request = $post_type->rewrite['slug'] . '/' . $element;
					$wp->matched_rule = $post_type->rewrite['slug'] . '/([^/]+)(/[0-9]+)?/?$';
					$wp->matched_query = $post->post_type . '=' . $post_type->rewrite['slug'] . '&page=';
				} else {
					// Is Category
					$taxonomies = get_taxonomies(array('public' => true, '_builtin' => false), 'names', 'and');
					if ($taxonomies)
						foreach ($taxonomies as $taxonomy) {
							foreach (get_terms($taxonomy, array('hide_empty' => false)) as $term) {
								if ($term->slug == $element) {
									$taxonomy_list = get_terms($taxonomy);
									$taxonomy_term = $term;
									$file = 'category-' . str_replace('_categories', '', $taxonomy_term->taxonomy) . '.php';
									if (!file_exists(get_template_directory() . '/' . $file))
										echo "<h1>Error</h1>File missing: " . $file;
									else {
										require 'category.php';
										require $file;
									}
									die;
								}
							}
						}

					// Is static
					$files = scandir(get_template_directory());
					foreach ($files as $file) {
						if (strpos($file, 'static-') === 0)
							if ($file == 'static-' . $element . '.php') {
								require get_template_directory() . '/' . $file;
								die;
							}
					}
				}
			}
		});
	}

	
	/* Show Image in FrontEnd
	// Get the current category ID, e.g. if we're on a category archive page
	$category = get_category( get_query_var( 'cat' ) );
	 $cat_id = $category->cat_ID;
	// Get the image ID for the category
	$image_id = get_term_meta ( $cat_id, 'category-image-id', true );
	// Echo the image
	echo wp_get_attachment_image ( $image_id, 'large' );

	*/
	
	//Renombrar el nombre de menú post o entradas por Proyectos
	function modificar_post_label() {
	    global $menu;
	    global $submenu;
	    $menu[5][0] = 'Anteriores';
	    $submenu['edit.php'][5][0] = 'Anteriores';
	    $submenu['edit.php'][10][0] = 'A&ntilde;adir Anteriores';
	   
	    echo '';
	}
	 
	 
	function modificar_post_object() {
	    global $wp_post_types;
	    $labels = &$wp_post_types['post']->labels;
	    $labels->name = 'Anteriores';
	    $labels->singular_name = 'Anterior';
	    $labels->add_new = 'A&ntilde;adir Nueva';
	    $labels->add_new_item = 'A&ntilde;adir Nueva Anterior';
	    $labels->edit_item = 'Editar Anterior';
	    $labels->new_item = 'Nueva Anterior';
	    $labels->view_item = 'Ver Anterior';
	    $labels->search_items = 'Buscar Anteriores';
	    $labels->not_found = 'No se han encontrado Anteriores';
	    $labels->not_found_in_trash = 'No se han encontrado Anteriores en la papelera';
	    $labels->all_items = 'Todas las Anteriores';
	    $labels->menu_name = 'Anteriores';
	    $labels->name_admin_bar = 'Anteriores';
	}
	 
	add_action( 'admin_menu', 'modificar_post_label' );
	add_action( 'init', 'modificar_post_object' );


	/**
	 * Generate breadcrumbs
	 * @author CodexWorld
	 * @authorURL www.codexworld.com
	 */
	function get_breadcrumb() {
	    echo '<a href="'.home_url().'" rel="nofollow">Home</a>';
	    if (is_category() || is_single()) {
	        echo "&nbsp;&nbsp;&#187;&nbsp;&nbsp;";
	        

	        the_category(' &bull; ');

            if (is_single()) {

            	// echo "&nbsp;&nbsp;&#187;&nbsp;&nbsp;";
            	// echo get_post_type();
            	

	        	
                echo " &nbsp;&nbsp;&#187;&nbsp;&nbsp; ";
                the_title();
            }


	        
	        
	    } elseif (is_page()) {
	        echo "&nbsp;&nbsp;&#187;&nbsp;&nbsp;";
	        echo the_title();
	    } elseif (is_search()) {
	        echo "&nbsp;&nbsp;&#187;&nbsp;&nbsp;Search Results for... ";
	        echo '"<em>';
	        echo the_search_query();
	        echo '</em>"';
	    }
	}


	//AJAX SEARCH
	// add the ajax fetch js
	

	// the ajax function hero
	add_action('wp_ajax_data_fetch' , 'data_fetch');
	add_action('wp_ajax_nopriv_data_fetch','data_fetch');
	function data_fetch(){
 		$post_tags = [];
	    
	    //$the_query = new WP_Query( array('category_name'  => 'Novedades', 'posts_per_page' => -1, 's' => esc_attr( $_POST['keyword'] ), 'post_type' => array('post','notas','novedades') ) );
	    /*$the_query = new WP_Query( array( 'posts_per_page' => 1, 's' => esc_attr( $_POST['keyword'] ), 'post_type' => array('post') ) );

	    if( $the_query->have_posts() ) :
	        while( $the_query->have_posts() ): $the_query->the_post(); ?>
				<?php if( $_POST['keyword'] ):?>
				<div class="item">
					<h4>Antiguas <a href="">Ver más</a></h4>
					<a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title();?></a>
				</div>
				<?php array_push($post_tags, get_the_tags()); ?>
				<?php endif; ?>

	        <?php endwhile;

	        wp_reset_postdata();  
	    else:?>
			<div class="item">
				<h4>Antiguas <a href="">Ver más</a></h4>
			</div>
	    <?php endif;*/
	    $the_query3 = new WP_Query( 
	    	array( 
	    		'posts_per_page' => 3, 
	    		's' => esc_attr( $_POST['keyword'] ), 
	    		'post_type' => array('notas'),
			    'tax_query' => array(
			        array(
			            'taxonomy' => 'notas_categories',
			            'field'    => 'term_id',
			            'terms'    => array( 69 ),
			            'operator' => 'NOT IN',
			        ),
			    ) 
	    	) 
	    );

	    if( $the_query3->have_posts() ) :

	    	$iN = 0;
	        while( $the_query3->have_posts() ): $the_query3->the_post(); ?>
				<?php if( $_POST['keyword'] ):?>
				<div class="item">
					<?php if($iN == 0): ?>
					<h4>Notas <a onclick='clickGoSearch()'>Ver más</a></h4>
					<?php endif; ?>
					<a href="<?php echo esc_url( get_permalink() ); ?>">
						<?php the_title();?>	
						
						<?php $image = get_field('imagen_principal_nota');?>
						<div class="img" style="background-image: url(<?= $image['sizes']['thumbnail'] ?>)"></div>
					</a>
				</div>
				<?php array_push($post_tags, get_the_tags()); ?>
				<?php endif; $iN++;?>

	        <?php endwhile;

	        wp_reset_postdata();  
	    else:?>
			<div class="item">
				<h4>Notas</h4>
			</div> 
	    <?php endif;


	    $the_query2 = new WP_Query( 
	    array( 
	    	'posts_per_page' => 1, 
		    's' => esc_attr( $_POST['keyword'] ), 
		    'post_type' => array('novedades') ,
		    'tax_query' => array(
		        array(
		            'taxonomy' => 'novedades_categories',
		            'field'    => 'term_id',
		            'terms'    => array( 68 ),
		            'operator' => 'NOT IN',
		        ),
		    )
		) );

	    if( $the_query2->have_posts() ) :
	        while( $the_query2->have_posts() ): $the_query2->the_post(); ?>
				<?php if( $_POST['keyword'] ):?>
	            <div class="item">
					<h4>Novedades <a onclick='clickGoSearch()'>Ver más</a></h4>
					<a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title();?></a>
				</div>
				<?php array_push($post_tags, get_the_tags()); ?>
				<?php endif; ?>

	        <?php endwhile;

	        wp_reset_postdata();  
	    
	    else:?>
			<div class="item">
				<h4>Novedades </h4>
			</div> 
	    <?php endif;

	    $the_query4 = new WP_Query( array( 'posts_per_page' => 1, 's' => esc_attr( $_POST['keyword'] ), 'post_type' => array('lp_course') ) );

	    if( $the_query4->have_posts() ) :
	        while( $the_query4->have_posts() ): $the_query4->the_post(); ?>
				<?php if( $_POST['keyword'] ):?>
	            <div class="item">
					<h4>Cursos <a onclick='clickGoSearch()'>Ver más</a></h4>
					<a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title();?></a>
				</div>
				<?php array_push($post_tags, get_the_tags()); ?>
				<?php endif; ?>

	        <?php endwhile;

	        wp_reset_postdata();  
	    else:?>
			<div class="item">
				<h4>Cursos</h4>
			</div>
	    <?php endif;?>
		
		<div class="tags">
			<strong>tags:</strong>
			<!-- <a href="">Impuestos</a>
			<a href="">Cobro online</a>
			<a href="">Cobro presencial</a> -->
			<?php 
				foreach($post_tags as $post){
					if($post[0]):
					?>
					<a href="<?php bloginfo('url')?>/tags/?t=<?=$post[0]->slug?>"><?=$post[0]->name?></a>
			<?php	endif; 
				}
			?>
		</div>

		<?php
	    die();
	}

	/*Registrar Menú
	function register_my_menus() {
	  register_nav_menus(
	    array(
	      'menu_ppal' => __( 'menu_ppal' ),
	      'sub_menu' => __( 'sub_menu' )
	     )
	   );
	}
	add_action( 'init', 'register_my_menus' );
	add_theme_support( 'menus' );*/

	/*POLYLANG*/
	// pll_register_string("Botón Nosotros", "Nosotros", "HEADER");
	// pll_register_string("Botón Soluciones", "Soluciones y Servicios", "HEADER");
	// pll_register_string("Botón Proyectos", "Proyectos", "HEADER");
	// pll_register_string("Botón Contacto", "Contacto", "HEADER");

	// pll_register_string("Título Contacto", "Tienes un proyecto en mente?", "CONTACTO");
	// pll_register_string("Texto Contacto", "Envíanos un email con tu proyecto, duda y/o sugerencia. Muy pronto te estaremos respondiendo.", "CONTACTO");
	// pll_register_string("Botón Contacto", "Enviar un e-mail", "CONTACTO");
// the ajax function hero
	add_action('wp_ajax_data_search' , 'data_search');
	add_action('wp_ajax_nopriv_data_search','data_search');
	function data_search(){

	    //$the_query = new WP_Query( array('category_name'  => 'Novedades', 'posts_per_page' => -1, 's' => esc_attr( $_POST['keyword'] ), 'post_type' => array('post','notas','novedades') ) );
	  
	    $post_tags = [];

	    $the_query3 = new WP_Query( 
	    	array( 
	    		'posts_per_page' => -1, 
	    		's' => esc_attr( $_POST['keyword'] ), 
	    		'post_type' => array('notas'),
			    'tax_query' => array(
			        array(
			            'taxonomy' => 'notas_categories',
			            'field'    => 'term_id',
			            'terms'    => array( 69 ),
			            'operator' => 'NOT IN',
			        ),
			    ) 
	    	) 
	    );
	    $i++;
	    if( $the_query3->have_posts() ) :
		echo '<div class="block_home notas" style="display: block;"><div class="contentRes">';
	        while( $the_query3->have_posts() ): 
	        	$i++;
	        	$the_query3->the_post(); 

                $gcat = get_object_taxonomies('notas');
                $cat = wp_get_post_terms(get_the_ID(), $taxonomy = $gcat[1]);
                $ptag = get_the_tags();
                $ptg = '';
                foreach ($ptag as $pt) {
                    $ptg .= $pt->slug.' ';
                }
                $image = get_field('imagen_principal_nota');						
	        	?>
				<?php if( $_POST['keyword'] ):?>

                    
                        <!-- NOTA -->
                        <a href="<?php echo esc_url( get_permalink() ); ?>" class="card <?= $ptg ?> <?=$cat[0]->slug;?>">
                            <div class="img" style="background-image: url(<?= $image['sizes']['large'] ?>)"></div>
                            <div class="copy">
                        		<small class="<?=$cat[0]->slug;?>"><?=$cat[0]->name;?></small>
                                <h2><?php the_title();?></h2>
                                <?php $content = get_the_content(); ?>
                        		<p><?= $content ?></p>
                                <div class="tags">
                                	<?php $tags = get_the_tags();
		                            foreach ($tags as $tg) {?>
		                                <span><?= $tg->name ?></span>
		                            <?php } ?>
                                </div>
                            </div>
                        </a>

				<?php array_push($post_tags, get_the_tags()); ?>
				<?php endif; ?>

	        <?php endwhile;
	        
            echo '</div></div>';

	        wp_reset_postdata();  
	    else:?>
			<div class="block_home notas">
				<div class="noExist">No existen resultados para tu búsqueda.</div>
			</div>
	    <?php endif;

	    $the_query2 = new WP_Query( 
	    	array( 
	    		'posts_per_page' => -1, 
	    		's' => esc_attr( $_POST['keyword'] ), 
	    		'post_type' => array('novedades'),
			    'tax_query' => array(
			        array(
			            'taxonomy' => 'novedades_categories',
			            'field'    => 'term_id',
			            'terms'    => array( 68 ),
			            'operator' => 'NOT IN',
			        ),
			    ) 
	    	) 
	    );
	    $y++;
	    if( $the_query2->have_posts() ) :
	    echo '<div class="block_home novedades"><div class="contentRes">';
	    while( $the_query2->have_posts() ):
                $y++; $the_query2->the_post(); 
                ?>
				<?php if( $_POST['keyword'] ):					
                    $gcat = get_object_taxonomies('novedades');
                    $cat = wp_get_post_terms(get_the_ID(), $taxonomy = $gcat[1]);
				?>
                    
                        <!-- NOVEDADES -->
                        <a href="<?php echo esc_url( get_permalink() ); ?>" class="card <?=$cat[0]->slug;?>">
                    		<?= ($y == 1) ? '<div class="ribbon"><span>New</span><div class="triangle"></div></div>' : '';?>    

                            <small><?php $post_date = get_the_date( 'd M Y' ); echo $post_date; ?></small>
                            <h2><?php the_title();?></h2>
                        </a>

				<?php array_push($post_tags, get_the_tags()); ?>
				<?php endif; ?>

	    <?php endwhile;
        echo '</div></div>';
	        wp_reset_postdata();  
	    else:?>
			<div class="block_home novedades" style="display: block;">
				<div class="noExist">No existen resultados para tu búsqueda.</div>
			</div>
	    <?php endif;

	    $the_query4 = new WP_Query( array( 'posts_per_page' => -1, 's' => esc_attr( $_POST['keyword'] ), 'post_type' => array('lp_course') ) );

	    if( $the_query4->have_posts() ) :
		echo '<div class="block_home cursos"><div class="contentRes">';
	        while( $the_query4->have_posts() ): $the_query4->the_post(); ?>
	        	<?php 
					$gcat = get_object_taxonomies('lp_course');
					$cat = wp_get_post_terms(get_the_ID(), $taxonomy = $gcat[0]);
					$tag = wp_get_post_terms(get_the_ID(), $taxonomy = $gcat[1]);

					$img = get_the_post_thumbnail_url($post->ID, 'thumbnail');
				?>
				<?php if( $_POST['keyword'] ):?>
                    
                        <!-- CURSOS -->
                        <a href="<?php echo esc_url( get_permalink() ); ?>" class="card <?=$cat[0]->slug;?>">
                            <div class="img" style="background-image: url(<?= $img ?>"></div>
                            <div class="copy">
								<small class="<?=$cat[0]->slug;?>"><?=$cat[0]->name;?></small>
                                <h2><?php the_title();?></h2>
								<div class="tags">
									<?php foreach ($tag as $tg) {
										echo "<span>".$tg->name."</span>";
									} ?>									
								</div>
                                <div class="items">
                                    <div class="time"><img src="<?php bloginfo('template_url');?>/img/ico-reloj.svg" alt="Reloj"> 30 min.</div>
                                    <div class="file"><img src="<?php bloginfo('template_url');?>/img/ico-page.svg" alt="Page"> Sin evaluación</div>
                                    <div class="lessons"><img src="<?php bloginfo('template_url');?>/img/ico-book.svg" alt="Book"> 5 Lecciones</div>
                                </div>
                            </div>
                        </a>
				<?php array_push($post_tags, get_the_tags()); ?>
				<?php endif; ?>

	        <?php endwhile;
            echo '</div></div>';

	        wp_reset_postdata();  
	    else:?>
			<div class="block_home cursos">
				<div class="noExist">No existen resultados para tu búsqueda.</div>
			</div>
	    <?php endif;?>
		
		<div class="block_home etiquetas">
            <div class="contentRes">
			<?php 
				foreach($post_tags as $post){
					if($post[0]):
					?>
					<a href="<?php bloginfo('url');?>/tags/?t=<?=$post[0]->slug?>"><?=$post[0]->name?></a>
			<?php	endif; 
				}
			?>
			</div>
		</div>

		<?php
	    die();
	}

	// ACTUALIZA ALERTAS
	add_action('wp_ajax_act_alerts' , 'act_alerts');
	add_action('wp_ajax_nopriv_act_alerts','act_alerts');
	function act_alerts(){
		if ($_POST['keyword'] == 'all') {
		    $the_queryAlert = new WP_Query( 
		    	array( 
		    	'post_type' => array('alertas'),
		    	'posts_per_page' => 1,
			    'tax_query' => array(
			        array(
			            'taxonomy' => 'alertas_categories',
			            'field'    => 'slug',
			            'terms'    => 'general',
			            'operator' => 'IN',
			        ),
			    ) 
		    ) );
			# code...
		}else{
		    $the_queryAlert = new WP_Query( 
		    	array( 
		    	'post_type' => array('alertas'),
		    	'posts_per_page' => 3, 
		    	'tax_query' => array(
        			//'relation' => 'AND',
	                array (
	                    'taxonomy' => 'alertas_categories',
	                    'field' => 'slug',
	                    'terms' => $_POST['keyword'],
	                )
	            ),
		    ) );

		}

	    if( $the_queryAlert->have_posts() ) :

	    while( $the_queryAlert->have_posts() ):
                $the_queryAlert->the_post(); 

				$gcat = get_object_taxonomies('alertas');
				$cat = wp_get_post_terms(get_the_ID(), $taxonomy = $gcat[1]);

				$content = strip_tags(get_the_content(), '<i> <em> <strong>');
				$icon = get_field('icono_alert');
				$btn = get_field('botones_alert');

				(!$btn && !$icon) ? $elem = 'center' : $elem = 'no-center';
			?>

			<div class="alert <?php foreach ($cat as  $value) { echo $value->slug .' ';	} ?><?=$elem?> hiddenbx">
				<?= ($icon) ? '<img src="'.$icon['url'].'" alt="'.get_the_title().'" class="icon" />' : '';  ?>
				<p><?= $content  ?></p>
				<?php if( have_rows('botones_alert') ):?>
					<div class="btnsAlert">
					<?php
				    while ( have_rows('botones_alert') ) : the_row();

				        ?>
				        <a href="<?= the_sub_field('url_btn_alert') ?>" target="<?= the_sub_field('target_btn_alert') ?>"> <?= the_sub_field('cta_btn_alert') ?></a>
				        <?php
				        

				    endwhile;?>
					</div>
				    <?php
				endif; ?>
			</div>

	    <?php endwhile;
	        wp_reset_postdata();  
	    else:?>
			<div class="alerta"></div>
	    <?php endif;

	    die();
	}
	
	// ACTUALIZA NOVEDADES
	add_action('wp_ajax_act_novedades' , 'act_novedades');
	add_action('wp_ajax_nopriv_act_novedades','act_novedades');
	function act_novedades(){

	    //$the_query = new WP_Query( array('category_name'  => 'Novedades', 'posts_per_page' => -1, 's' => esc_attr( $_POST['keyword'] ), 'post_type' => array('post','notas','novedades') ) );

		if ($_POST['keyword'] == 'all') {
		    $the_query2 = new WP_Query( 
		    	array( 
		    	'post_type' => array('novedades'),
		    	'posts_per_page' => 3,
			    'tax_query' => array(
			        array(
			            'taxonomy' => 'novedades_categories',
			            'field'    => 'term_id',
			            'terms'    => array( 68 ),
			            'operator' => 'NOT IN',
			        ),
			    ) 
		    ) );
			# code...
		}else{
		    $the_query2 = new WP_Query( 
		    	array( 
		    	'post_type' => array('novedades'),
		    	'posts_per_page' => 3, 
		    	'tax_query' => array(
        			'relation' => 'AND',
	                array (
	                    'taxonomy' => 'novedades_categories',
	                    'field' => 'slug',
	                    'terms' => $_POST['keyword'],
	                ),
			        array(
			            'taxonomy' => 'novedades_categories',
			            'field'    => 'term_id',
			            'terms'    => array( 68 ),
			            'operator' => 'NOT IN',
			        )

	            ),
		    ) );

		}
	    $y = 0;
	    if( $the_query2->have_posts() ) :

	    while( $the_query2->have_posts() ):
                $y++; $the_query2->the_post(); 
                ?>
				<?php if( $_POST['keyword'] ):					
                    $gcat = get_object_taxonomies('novedades');
                    $cat = wp_get_post_terms(get_the_ID(), $taxonomy = $gcat[1]);
				?>
                    <!-- NOVEDADES -->
                    <a href="<?php the_permalink()?>" class="card <?=$cat[0]->slug;?> hiddenbx">	
                    	<?= ($y == 1 && $_POST['keyword'] == 'all') ? '<div class="ribbon"><span>New</span><div class="triangle"></div></div>' : '';?>    
						<small><?php $post_date = get_the_date( 'd M Y' ); echo $post_date; ?></small>
						<h2><?php the_title(); ?></h2>
					</a>

				<?php endif; ?>

	    <?php endwhile;
	        wp_reset_postdata();  
	    else:?>
			<div class="empty-card"><h2>No existen novedades</h2></div>
	    <?php endif;

	    die();
	}

	// ACTUALIZA NOTAS
	add_action('wp_ajax_act_notas' , 'act_notas');
	add_action('wp_ajax_nopriv_act_notas','act_notas');
	function act_notas(){

	    //$the_query = new WP_Query( array('category_name'  => 'Novedades', 'posts_per_page' => -1, 's' => esc_attr( $_POST['keyword'] ), 'post_type' => array('post','notas','novedades') ) );

		if ($_POST['keyword'] == 'all') {
		    $the_query3 = new WP_Query( 
		    	array( 
		    	'post_type' => array('notas'),
		    	'posts_per_page' => 5,
			    'tax_query' => array(
			        array(
			            'taxonomy' => 'notas_categories',
			            'field'    => 'term_id',
			            'terms'    => array( 69 ),
			            'operator' => 'NOT IN',
			        ),
			    ) 
		    ) );
			# code...
		}else{
		    $the_query3 = new WP_Query( 
		    	array( 
		    	'post_type' => array('notas'),
		    	'posts_per_page' => 5, 
		    	'tax_query' => array(
        			'relation' => 'AND',
	                array (
	                    'taxonomy' => 'notas_categories',
	                    'field' => 'slug',
	                    'terms' => $_POST['keyword'],
	                ),
			        array(
			            'taxonomy' => 'notas_categories',
			            'field'    => 'term_id',
			            'terms'    => array( 69 ),
			            'operator' => 'NOT IN',
			        )
	            ),
		    ) );

		}
	    $y = 0;
	    if( $the_query3->have_posts() ) :

	    while( $the_query3->have_posts() ):
            $y++; 
            $the_query3->the_post(); 

            $gcat = get_object_taxonomies('notas');
            $cat = wp_get_post_terms(get_the_ID(), $taxonomy = $gcat[1]);
            $ptag = get_the_tags();
            $ptg = '';
            foreach ($ptag as $pt) {
                $ptg .= $pt->slug.' ';
            }
            $image = get_field('imagen_principal_nota');	
            $r = '';
            if($_POST['keyword'] == 'all' && $y == 1){
            	$r = 'important';
            }
			?>
                
				<!-- NOTA -->
                <a href="<?php echo esc_url( get_permalink() ); ?>" class="card <?= $ptg; ?> <?=$cat[0]->slug;?> <?= $r ?> hiddenbx">
                    <div class="img" style="background-image: url(<?= $image['sizes']['large'] ?>)"></div>
                    <div class="copy">
                		<small class="<?=$cat[0]->slug;?>"><?=$cat[0]->name;?></small>
                        <h2><?php the_title();?></h2>
                        <?php $content = get_the_content(); ?>
                		<p><?= $content ?></p>
                        <div class="tags">
                        	<?php $tags = get_the_tags();
                            foreach ($tags as $tg) {?>
                                <span><?= $tg->name ?></span>
                            <?php } ?>
                        </div>
                    </div>
                </a>

	    <?php endwhile;
	        wp_reset_postdata();  
	    else:?>
			<div class="empty-card"><div class="copy"><h2>No existen notas</h2></div></div>
	    <?php endif;

	    die();
	}

	// ACTUALIZA CURSOS
	add_action('wp_ajax_act_cursos' , 'act_cursos');
	add_action('wp_ajax_nopriv_act_cursos','act_cursos');
	function act_cursos(){

	    //$the_query = new WP_Query( array('category_name'  => 'Novedades', 'posts_per_page' => -1, 's' => esc_attr( $_POST['keyword'] ), 'post_type' => array('post','notas','novedades') ) );

		if ($_POST['keyword'] == 'all') {
		    $the_query4 = new WP_Query( 
		    	array( 
		    	'post_type' => array('lp_course'),
		    	'posts_per_page' => 2
		    ) );
			# code...
		}else{
		    $the_query4 = new WP_Query( 
		    	array( 
		    	'post_type' => array('lp_course'),
		    	'posts_per_page' => 2, 
		    	'tax_query' => array(
	                array (
	                    'taxonomy' => 'course_category',
	                    'field' => 'slug',
	                    'terms' => $_POST['keyword'],
	                )
	            ),
		    ) );

		}
	    $y = 0;
	    if( $the_query4->have_posts() ) :

	    while( $the_query4->have_posts() ):
            $y++; 
            $the_query4->the_post(); 

            $gcat = get_object_taxonomies('lp_course');
			$cat = wp_get_post_terms(get_the_ID(), $taxonomy = $gcat[0]);
			$tag = wp_get_post_terms(get_the_ID(), $taxonomy = $gcat[1]);
			
            $img = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');	
           
			?>
                    
                <!-- CURSOS -->
                <a href="<?php echo esc_url( get_permalink() ); ?>" class="card hiddenbx <?=$cat[0]->slug;?>">
                    <div class="img" style="background-image: url(<?= $img ?>"></div>
                    <div class="copy">
						<small class="<?=$cat[0]->slug;?>"><?=$cat[0]->name;?></small>
                        <h2><?php the_title();?></h2>
						<div class="tags">
							<?php foreach ($tag as $tg) {
								echo "<span>".$tg->name."</span>";
							} ?>									
						</div>
                        <div class="items">
                            <div class="time"><img src="<?php bloginfo('template_url');?>/img/ico-reloj.svg" alt="Reloj"> 30 min.</div>
                            <div class="file"><img src="<?php bloginfo('template_url');?>/img/ico-page.svg" alt="Page"> Sin evaluación</div>
                            <div class="lessons"><img src="<?php bloginfo('template_url');?>/img/ico-book.svg" alt="Book"> 5 Lecciones</div>
                        </div>
                    </div>
                </a>

	    <?php endwhile;
	        wp_reset_postdata();  
	    else:?>
			<div class="empty-card">No existen cursos</div>
	    <?php endif;

	    die();
	}

   
?>
