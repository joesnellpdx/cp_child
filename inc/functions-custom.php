<?php

/**
 * CUSTOM FUNCTIONS
 */

/**
 * puls fix shortcodes
 */
function puls_fix_shortcodes($content){
	$array = array (
		'<p>[' => '[',
		']</p>' => ']',
		']<br />' => ']'
	);

	$content = strtr($content, $array);
	return $content;
}
add_filter('the_content', 'puls_fix_shortcodes');

// remove image links
function attachment_image_link_remove_filter( $content ) {
	if( !is_singular( 'talent-profile' ) ) {
		$content = preg_replace(
			array(
				'{<a(.*?)(wp-att|wp-content/uploads)[^>]*><img}',
				'{ wp-image-[0-9]*" /></a>}'
			),
			array( '<img', '" />' ),
			$content
		);

		return $content;
	}
}
add_filter( 'the_content', 'attachment_image_link_remove_filter' );


/**
 * Hide page stuff
 */
function hide_page_stuff() {
	remove_post_type_support( 'page', 'comments' );
}
add_action('init', 'hide_page_stuff');

/**
 * Add custom iage sizes
 */
function twenty_eleven_child_add_image_size() {
	add_image_size( 'rwd-small', 400, 240 );
	add_image_size( 'rwd-medium', 800, 480 );
	add_image_size( 'rwd-large', 1200, 720 );
	add_image_size( 'rwd-mediumx2', 1600, 960 );
	add_image_size( 'rwd-large2', 1800, 1080 );
	add_image_size( 'rwd-xl', 2000, 1200 );
	add_image_size( 'rwd-largex2', 2400, 1440 );
	add_image_size( 'rwd-xlx2', 4000, 2400 );
}
add_action( 'after_setup_theme', 'twenty_eleven_child_add_image_size', 11 );

/**
 * GET IMAGE ID FROM SRC
 */
function get_attachment_id_from_src($url) {
	global $wpdb;
	$prefix = $wpdb->prefix;

	if (strpos($url, 'http') === 0) {
		$img_source = $url;
	} else {
		$img_source = site_url() . $url;
	}

	$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM " . $prefix . "posts" . " WHERE guid='%s';", $img_source ));
	return $attachment[0];
}

//function register_multiple_menus() {
//
//	register_nav_menus( array(
//		'sites' => 'Sites Menu',
//	) );
//}
//add_action( 'init', 'register_multiple_menus' );

/**
 * Add custom li class to site navigation

 *
 * @return custom class
 */
function site_menu_li_classes( $classes , $item, $args, $depth ) {
	if( $args->theme_location === 'sites' ) {
		$classes[] = 'navigation__item';
	}

	return $classes;
}
add_filter( 'nav_menu_css_class', 'site_menu_li_classes', 10, 4 );

/**
 * Add custom link class to navigation

 *
 * @return custom class
 */
function site_menu_link_classes( $atts, $item, $args ) {
	if( $args->theme_location === 'sites' ) {
		$atts['class'] = 'navigation__link';
	}
	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'site_menu_link_classes', 10, 3 );

/**
 * Allow RICG Image Compression
 */
function custom_theme_setup() {
	add_theme_support( 'advanced-image-compression' );
}
add_action( 'after_setup_theme', 'custom_theme_setup' );

/**
 * Filter Yoast Meta Priority - move below meta boxes
 */
add_filter( 'wpseo_metabox_prio', function() { return 'low';});


function pulsair_remove_empty_p( $content ) {
	$array = array (
		'<p>[' => '[',
		']</p>' => ']',
		']<br />' => ']'
	);

	$newcontent = strtr($content, $array);
	$newercontent = preg_replace(
		array('{<a(.*?)(wp-att|wp-content/uploads)[^>]*><img}',
			'{ wp-image-[0-9]*" /></a>}'),
		array('<img','" />'),
		$newcontent);
	return $newercontent;
}

/**
 * Remove parent theme foooter stuff
 */
function my_site_footer() {
	if ( is_active_sidebar( 'freesiaempire_footer_options' ) ) :
		dynamic_sidebar( 'freesiaempire_footer_options' );
	else: ?>
		<div class="copyright">Copyright &copy; <?php echo auto_copyright('2016'); ?>
		<a title="Pulsair Systems" target="_blank" href="<?php echo esc_url( network_site_url() ); ?>">Pulsair Systems</a>
		</div>


	<?php endif;
}

/**
 * Remove parent theme foooter stuff
 */
function my_action_override() {

	remove_action( 'freesiaempire_sitegenerator_footer', 'freesiaempire_site_footer' );
	add_action( 'freesiaempire_sitegenerator_footer', 'my_site_footer' );

}
add_action( 'init', 'my_action_override' );

/**
 * Enable shortcodes in widgets
 */
add_filter('widget_text', 'do_shortcode');

/**
 * Auto copyright
 */
function auto_copyright($year = 'auto'){
	if(intval($year) == 'auto'){ $year = date('Y'); }
	if(intval($year) == date('Y')){ echo intval($year); }
	if(intval($year) < date('Y')){ echo intval($year) . ' - ' . date('Y'); }
	if(intval($year) > date('Y')){ echo date('Y'); }
}

/******************* Freesia Empire Header Display *************************/
function pulsair_header_display(){
	$freesiaempire_settings = freesiaempire_get_theme_options();
	$header_display = $freesiaempire_settings['freesiaempire_header_display'];
	$header_logo = $freesiaempire_settings['freesiaempire-img-upload-header-logo'];
	if ($header_display == 'header_text') { ?>
		<div id="site-branding">
			<?php if(is_home() || is_front_page()){ ?>
			<h1 id="site-title"> <?php }else{?> <h2 id="site-title"> <?php } ?>
					<a href="<?php echo esc_url(home_url('/'));?>" title="<?php echo esc_attr(get_bloginfo('name', 'display'));?>" rel="home"> <?php bloginfo('name');?> </a>
					<?php if(is_home() || is_front_page() || is_search()){ ?>
			</h1>  <!-- end .site-title -->
		<?php } else { ?> </h2> <!-- end .site-title --> <?php }
		$site_description = get_bloginfo( 'description', 'display' );
		if($site_description){?>
			<p id ="site-description"> <?php bloginfo('description');?> </p> <!-- end #site-description -->
		<?php } ?>
		</div> <!-- end #site-branding -->
		<?php
	} elseif ($header_display == 'header_logo') { ?>
		<div id="site-branding"> <a href="<?php echo esc_url(esc_url( network_site_url() ));?>" title="Pulsair Systems" rel="home"> <img src="<?php echo esc_url($header_logo);?>" id="site-logo" alt="Pulsair Systems"></a> </div> <!-- end #site-branding -->
	<?php } elseif ($header_display == 'show_both'){ ?>
		<div id="site-branding"> <a href="<?php echo esc_url(esc_url( network_site_url() ));?>" title="Pulsair Systems" rel="home"> <img src="<?php echo esc_url($header_logo);?>" id="site-logo" alt="Pulsair Systems"></a>
			<?php if(is_home() || is_front_page()){ ?>
			<h1 id="site-title"> <?php }else{?> <h2 id="site-title"> <?php } ?>
					<a href="<?php echo esc_url(home_url('/'));?>" title="<?php echo esc_attr(get_bloginfo('name', 'display'));?>" rel="home"> <?php bloginfo('name');?> </a>
					<?php if(is_home() || is_front_page()){ ?> </h1> <!-- end .site-title -->
		<?php }else{ ?> </h2> <!-- end .site-title -->
		<?php }
		$site_description = get_bloginfo( 'description', 'display' );
		if($site_description){?>
			<p id ="site-description"> <?php bloginfo('description');?> </p><!-- end #site-description -->
		<?php } ?>
		</div> <!-- end #site-branding -->
	<?php }
}
add_action('pulsair_site_branding','pulsair_header_display');

// VIDEO - disabled with jetpack
function my_embed_oembed_html($html, $url, $attr, $post_id) {
	return '<div class="puls-video">' . $html . '</div>';
}
add_filter('embed_oembed_html', 'my_embed_oembed_html', 99, 4);

function remove_youtube_controls($code){
	if(strpos($code, 'youtu.be') !== false || strpos($code, 'youtube.com') !== false){
		$return = preg_replace("@src=(['\"])?([^'\">\s]*)@", "src=$1$2&modestbranding=1&origin=" . get_bloginfo('url') . "&showinfo=0&rel=0", $code);
		return $return;
	}
	return $code;
}