		<footer class="container_12">
	        <nav role="navigation">
	            <?php wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false ) ); ?>
	        </nav>
	        <p>&copy; <?php echo date( 'Y' ); ?> <?php bloginfo( 'name' ); ?></p>

	    </footer>
		<?php wp_footer(); ?>
	</body>
</html>