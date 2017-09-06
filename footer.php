<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package under-strap
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'under-strap' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'under-strap' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( esc_html__( 'Theme: %1$s by %2$s.', 'under-strap' ), 'under-strap', '<a href="http://underscores.me/" rel="designer">Underscores.me</a>' ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

<script type="text/javascript">
$(document).ready(function() {
	// Content
    $('.site-content').addClass('container');
    $('.site-info').addClass('container');
    $('.content-area').addClass('col-md-8');
	// Widget
    $('.widget-area').addClass('col-md-4');
    $('.widget > ul').addClass('list-group');
    $('.widget > ul > li').addClass('list-group-item');
    // Calendar
    $('#calendar_wrap').addClass('panel-body');
    $('#wp-calendar').addClass('table');
    // Text
    $('.textwidget').addClass('panel-body');
    // Tag Cloud
    $('.tagcloud').addClass('panel-body');
    // Form
    $('select,textarea,input:not([type=button],[type=submit])').addClass('form-control');
    $('[type=button],[type=submit]').addClass('btn btn-default');
    // Add to ...
});
</script>
</body>
</html>
