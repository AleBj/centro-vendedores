<?php
/**
 * The template for displaying all single posts
 *
 *
 *
 * @package WordPress
 * @subpackage Liebre
 * @since 1.0.0
 */

get_header();
$exclude_post = [];
array_push($exclude_post, $post->ID);
?>




<main>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	
	<?php 
	    $gcat = get_object_taxonomies('novedades');
	    $cat = wp_get_post_terms($post->ID, $taxonomy = $gcat[1]);
	    $ptag = get_the_tags();
	    $ptg = '';
	    if($ptag):
		    foreach ($ptag as $pt) {
		        $ptg .= $pt->slug.' ';
		    }
		endif;
    ?>

	<div class="breadcrumbs">
		<a href="<?php bloginfo('url') ?>/novedades">Novedades</a> 
		<i class="fa fa-angle-right"></i> <a href=""><?= $cat[0]->name; ?></a> <i class="fa fa-angle-right"></i> 
		<?php the_title(); ?>
	</div>
	<div class="wp" id="single">

		<div class="content-small">
			<h1><?php the_title(); ?></h1>
			<small class="date"><?php $post_date = get_the_date( 'd M Y' ); echo $post_date; ?></small>
		</div>
		<!-- fixear -->
		<div id="shared">

			<div class="wp-fixear">
				<div class="wp">

				<div class="content-small">
					<div class="category <?= $cat[0]->slug; ?>"><?= $cat[0]->name; ?></div>
					<a href="" class="share"><img src="<?php bloginfo('url'); ?>/wp-content/themes/meli/img/share.svg" alt="share"></a>
				</div>
				</div>
			</div>

		</div>
		<!-- fixear -->
		
		<div class="texto content-small content-novedad">

            <?php the_content(); ?>

			<!-- BLOQUES NOTAS -->
			
			<?php 
			// check if the flexible content field has rows of data
			if( get_field('elementos_nota') ):

			 	// loop through the rows of data
			    while ( has_sub_field('elementos_nota') ) :

					if( get_row_layout() == 'texto_nota' ): ?>

						<div class="texto content-small">
			        	<?php
			        		$bq_texto = get_sub_field('bq_texto_nota');
			        	 	echo strip_tags($bq_texto, '<a> <p> <h2> <h3> <ul> <ol> <li> <h4> <h5> <strong>');
			        	?>

			        	</div>

					<?php
			        elseif( get_row_layout() == 'imagen_full' ): 
			        	$image_size_IS = get_sub_field('image_size_IS');
			        ?>
			        	
						<div class="full-image <?= $image_size_IS; ?>">
			        		<?php
							$image = get_sub_field('bq_imagen_full');
				            echo wp_get_attachment_image( $image['ID'], 'large' ); 
				            ?>
						</div>
					
					<?php
			        elseif( get_row_layout() == 'imagenes_multiples' ): 
			        	$image_size_IM = get_sub_field('image_size_IM');
			        ?>
			        	
						<div class="block_multi_images <?= $image_size_IM; ?>">
			        		<?php
			        		if( have_rows('imagenes_IM') ):

							 	// loop through the rows of data
							    while ( have_rows('imagenes_IM') ) : the_row();

							        $image = get_sub_field('imagen_IM');
			            			echo wp_get_attachment_image( $image['ID'], 'large' ); 

							    endwhile;

							endif;
							
				            ?>
						</div>

			        <?php
			        elseif(get_row_layout() == 'imagen_texto_nota' ): 

				        $image_size = get_sub_field('tamano_image_IT');
				        $text_size = get_sub_field('tamano_texto_IT');	
				        $text_align = get_sub_field('text_align_IT');	
				        $img_align = get_sub_field('img_align_IT');
				        $invert = get_sub_field('invertir_IT');		        
				        $image = get_sub_field('Imagen_IT'); // wp_get_attachment_image( $image['ID'], 'large' );         
				        $text = get_sub_field('texto_IT'); //strip_tags($text, '<a> <p> <h2> <h3> <ul> <ol> <li> <h4> <h5> <strong>');
			        ?>

				       <div class="block_text_image <?= $text_align  ?>">
				       	<?php if($invert): ?>

				       		<div class="text_IT invert <?= $text_size ?>">
				       			<div class="wp_text_IT">
				       				<?php echo strip_tags($text, '<a> <p> <h2> <h3> <ul> <ol> <li> <h4> <h5> <strong>'); ?>
				       			</div>
				       		</div>

							<div class="image_IT invert <?= $image_size ?>">
								<div class="contentImg" style="justify-content: <?= $img_align; ?>">
				       				<?php echo wp_get_attachment_image( $image['ID'], 'large' ); ?>
				       			</div>
				       		</div>


				       	<?php else: ?>
							
							<div class="image_IT <?= $image_size ?>">
								<div class="contentImg" style="justify-content: <?= $img_align; ?>">
				       				<?php echo wp_get_attachment_image( $image['ID'], 'large' ); ?>
				       			</div>
				       		</div>

				       		<div class="text_IT <?= $text_size ?>">
				       			<div class="wp_text_IT">
					       			<?php echo strip_tags($text, '<a> <p> <h2> <h3> <ul> <ol> <li> <h4> <h5> <strong>'); ?>
					       		</div>
				       		</div>

				       	<?php endif; ?>
				       </div>
						
			        <?php
			        // check current row layout
			        elseif( get_row_layout() == 'cards_nota' ):
			        	$cards_size = get_sub_field('card_size');
			        	?>
						<div class="block_cards_news <?= $cards_size  ?>">
			        		<?php
			        		if( have_rows('card_single') ):
							 	// loop through the rows of data
							    while ( have_rows('card_single') ) : the_row(); 
							    	$headerCard = get_sub_field('header_CS');
							    	$bg_header = get_sub_field('bg_header_CS');
							    	$textoCard = get_sub_field('texto_CS');
							    	$imageCard = get_sub_field('imagen_CS');
							    	$alignHeader = get_sub_field('align_header_CS');

							    	$ext = pathinfo( $imageCard["url"], PATHINFO_EXTENSION );
							    ?>

							        
			            		<div class="card-news">
			            			<?php if($headerCard): ?>
			            				<div class="head-card-news" style="background-color: <?=$bg_header;?>;justify-content: <?= $alignHeader; ?>"><?= $headerCard; ?></div>
			            			<?php endif; ?>
			            			<?php if($imageCard): ?>
										
										<?php 
											if ( $ext == 'svg' ):
												echo file_get_contents( $imageCard["url"] ) ;
												// Non SVG Fallback
												else: 
												echo wp_get_attachment_image( $imageCard['ID'], 'large' ); 
											endif; ?>


			            			<?php endif; ?>

			            			<?php if($textoCard): ?>
			            				<div class="text-card-news">
			            					<?= $textoCard;  ?>
			            				</div>
			            			<?php endif; ?>
			            		</div>

							<?php    
								endwhile;

							endif; ?>

						</div>

			        <?php
			        // check current row layout
			        elseif( get_row_layout() == 'tablas_nota' ): ?>
						<div class="block_tables">
							<table>
							<?php
				        		$table = get_sub_field('tabla_nota');
				        		$xcs = 0;
				        		echo '<tr>';
				        		foreach ($table['header'] as $th) {
				        			$colspan = explode('-', $th['c']);
				        			if($colspan[0] == 'colspan'){	
				        				$nCol = $colspan[1];	        				
				        				$xcs = 1;
				        			}else{
				        				if($xcs == 0){
				        					echo '<th><span>' . $th['c'] . '</span></th>';
				        				}else{
				        					echo '<th colspan='.$nCol.'><span>' . $th['c'] . '</span></th>';
				        					$xcs = 0;
				        				}
				        				
				        			}

				        			
				        		}
				        		echo '</tr>';

				        		foreach ($table['body'] as $tr) {
				        			echo "<tr>";
				        			foreach ($tr as $td) {
				        				echo '<td>' . $td['c'] . '</td>';
				        			}
				        			echo "</tr>";
				        		}
				        	?>
			        		</table>
			        		<div class="disclaimer">
			        			<?php $disc = get_sub_field('texto_tabla'); 
			        				echo strip_tags($disc, '<br> <em>')
			        			?>
			        		</div>
						</div>
					<?php 
					// check contenido_custom_nota 
			        elseif( get_row_layout() == 'videos_nota' ):?>
					
					<div id="video_embebed">
						<?php 
							$titulo = get_sub_field('titulo_video_nota'); 
							$size = get_sub_field('tamano_reproductor_video_nota');
							
							if($titulo):	
						?>
						<div class="content_tit_video medium"><h2><?= $titulo; ?></h2></div>
						<?php endif; ?>
						<div class="content_emb_video <?= $size; ?>">
							<div class="videoEmb">
								<?php the_sub_field('link_video_nota'); ?>		
							</div>	
						</div>		
					</div>

					<?php 	
			        	// check current row layout
			        elseif( get_row_layout() == 'subtitulo' ):?>
						<div class="texto content-small anclas">
							<?php $textAncla =  get_sub_field('bq_subtitulo');?>
							<h2 id="<?= slugify($textAncla) ?>"><?php strip_tags(the_sub_field('bq_subtitulo')) ?></h2>
						</div>
					<?php 

					// check contenido_custom_nota 
			        elseif( get_row_layout() == 'contenido_custom_nota' ):?>
					<div id="custom_content">
						<style>
							<?php strip_tags(the_sub_field('css_code_nota')); ?>
						</style>

						<?php the_sub_field('html_code_nota'); ?>					
					</div>
					<?php 

					// check contenido_custom_nota 
			        elseif( get_row_layout() == 'blockquote_nota' ):?>
					<div class="content-small">
						<blockquote>
							<?php the_sub_field('texto_quote_nota'); ?>	
						</blockquote>				
					</div>
					<?php 

					// check Botones simples
			        elseif( get_row_layout() == 'btns_single_notas' ):?>
			        	<?php $justify = get_sub_field('justify_boton_simple');?>       	
					<div class="content-small singleButtons" style="justify-content: <?= $justify ?>;">
						<?php
						if( have_rows('boton_simple_nota') ):
						 	// loop through the rows of data
						    while ( have_rows('boton_simple_nota') ) : the_row(); 
						    	$ctBtsingle = get_sub_field('cta_bt_simple_nota');
						    	$urlBtsingle = get_sub_field('url_bt_simple_nota');
						    	$targetBtsingle = get_sub_field('target_bt_simple_nota');
						    	$styleBtsingle = get_sub_field('estilo_bt_simple_nota');
						    ?>

						    <a href="<?= $urlBtsingle ?>" class="btSingle <?= $styleBtsingle ?>" target="<?= $targetBtsingle?>"><?= $ctBtsingle ?></a>

						<?php    
							endwhile; 
						endif; ?>				
					</div>

					<?php endif;

			    endwhile;

			else :

			    // no layouts found

			endif;
			?>

			<!-- BLOQUES NOTAS -->


		</div>



		<?php if( have_rows('bloque_botones') ): ?>
			<?php while( have_rows('bloque_botones') ): the_row(); 

	        // Get sub field values.
	        $titulo = get_sub_field('titulo_bloque_btns');			       
	        if($titulo):
	        ?>
			<div class="content-small bloque-descarga">
			    
			        <h2><?= strip_tags($titulo); ?></h2>
					
					<?php $btns = get_sub_field('botones_bloque_btns'); ?>
			        <?php foreach( $btns as $btn): ?>
			        	<a href="<?= $btn["url_bloque_btns"] ?>" <?= ($btn["blank_bloque_btns"])? 'target="_blank"' : ''; ?>><?= $btn["cta_bloque_btns"] ?></a>
			        <?php endforeach; ?>

			    
			</div>
			<?php endif; endwhile; ?>
		<?php endif; ?>

	</div>

	<?php endwhile; else: ?>
	<p>Sorry, no posts matched your criterial.</p>
	<?php endif; ?>
	
	<!-- RELACIONADOS -->
	<div id="related" class="block_home novedades">
		<div class="wp">
			<h3>te puede interesar</h3>
		</div>
		<div class="content">

			<?php 
			 $the_query3 = new WP_Query( 
		    	array( 
		    	'post_type' => array('novedades'),
		    	'posts_per_page' => 3, 
		    	'post__not_in' => $exclude_post
		    ) );
		    ?>

			<?php if( $the_query3->have_posts() ) :

			    while( $the_query3->have_posts() ):
		        
		            $the_query3->the_post(); 

		            $gcat = get_object_taxonomies('novedades');
		            $cat = wp_get_post_terms(get_the_ID(), $taxonomy = $gcat[1]);

			    	array_push($exclude_post, get_the_ID());
			    	?>
                    <!-- NOVEDADES -->
                    <a href="<?php the_permalink()?>" class="card <?=$cat[0]->slug;?>">	
						<small><?php $post_date = get_the_date( 'd M Y' ); echo $post_date; ?></small>
						<h2><?php the_title(); ?></h2>
					</a>
		            

		    <?php endwhile;
		        wp_reset_postdata();  
		    endif; ?>
		</div>
	</div>
	<!-- RELATED END -->
	
</main>

<?php

get_footer(); 

?>