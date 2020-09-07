<!-- banners -->
<?php if( have_rows('banner_footer', 'option') ): ?>	

	<?php while( have_rows('banner_footer', 'option') ): the_row(); 

		// vars
		$image = get_sub_field('imagen_banner');
		$titulo = get_sub_field('titulo_banner');
		$content = get_sub_field('bajada_banner');
		$link = get_sub_field('link_banner');
		?>

		

			<?php if( $link ): ?>
				<a href="<?php echo $link; ?>" class="wp-banner">
			<?php endif; ?>

				<img src="<?php echo $image['url']; ?>" alt="<?php echo $titulo ?>" />
				
				<div class="copy">
				<?php if($titulo): ?>
					<h4>  <?php echo $titulo; ?></h4>
				<?php endif; ?>

				<?php if($content): ?>
					<p>  <?php echo $content; ?></p>
				<?php endif; ?>
				</div>

			<?php if( $link ): ?>
				</a>
			<?php endif; ?>

		  


	<?php endwhile; ?>

<?php endif; ?>