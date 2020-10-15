<?php
/**
 * Plugin Name: IA Slider
 * Plugin URI: http://ITsAli.com
 * Description: Wordpress Slider
 * Author: ITsAli.com
 * Version: 1.0.0
 * Author URI: http://ITsAli.com
 * License: GPL2+
 * Text Domain: iaslider
 */

// Error for direct path
defined('ABSPATH') or die("!!!");

// Directory path for 
define('IASLIDER_PATH', plugin_dir_url(__FILE__));

// Add scripts and styles
function iaslider_scripts() {
	wp_enqueue_style('bxslider', IASLIDER_PATH . '/css/jquery.bxslider.min.css');

	if(wp_script_is('jquery', 'enqueued')) {
		//return;
	} else {
		wp_enqueue_script('jquery');
	}

	wp_enqueue_script('bxsliderjs', IASLIDER_PATH . '/js/jquery.bxslider.min.js');
}
add_action('wp_enqueue_scripts', 'iaslider_scripts');

// Silder shortcode
// [iaslider]
function iaslider_shortcode() {
	$args = array(
		'posts_per_page' => 10,
		'post_type' => 'product',
		'meta_key' => '_thumbnail_id',
		'tax_query' => array(
			array(
				'taxonomy' => 'product_visibility',
				'field' => 'name',
				'terms' => 'featured',
				'operator' => 'IN'
			)
		)
	);

	$slider_products = new WP_Query($args);

	echo "<ul class='slider-products'>";

	while($slider_products->have_posts()) {
		$slider_products->the_post(); ?>

		<li>
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail(); ?>
				<?php the_title(); ?>
			</a>
		</li>


	<?php }

	echo "</ul>";

	wp_reset_postdata();
}
add_shortcode('iaslider', 'iaslider_shortcode');

// bxslider
function iaslider_execute() { ?>
	<script>
	$ = jQuery.noConflict();

    $(document).ready(function() {
      $('.slider-products').bxSlider({
      	auto: true      
      });
    });
  </script>

<?php }
add_action('wp_footer', 'iaslider_execute');
