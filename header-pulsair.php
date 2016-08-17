<?php
/**
 * Displays the header content
 *
 * @package Theme Freesia
 * @subpackage Freesia Empire
 * @since Freesia Empire 1.0
 */
?>
	<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<?php
$freesiaempire_settings = freesiaempire_get_theme_options(); ?>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<?php wp_head(); ?>
	</head>
<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<!-- Masthead ============================================= -->
	<header id="masthead" class="site-header">
		<?php
		if($header_image = $freesiaempire_settings['freesiaempire_display_header_image'] == 'top'){
			do_action('freesiaempire_header_image');
		}
		echo '<div class="top-header">
						<div class="container clearfix">';
		do_action('freesiaempire_site_branding');

		echo '<div class="menu-toggle">      
								<div class="line-one"></div>
								<div class="line-two"></div>
								<div class="line-three"></div>
							</div>';

		echo '<div class="header-info clearfix">';
		if(has_nav_menu('social-link') && $freesiaempire_settings['freesiaempire_top_social_icons'] == 0):
			echo '<div class="header-social-block">';
			do_action('social_links');
			echo '</div>'.'<!-- end .header-social-block -->';
		endif;
		if( is_active_sidebar( 'freesiaempire_header_info' )) {
			dynamic_sidebar( 'freesiaempire_header_info' );
		}
		echo ' </div> <!-- end .header-info -->';
		$search_form = $freesiaempire_settings['freesiaempire_search_custom_header'];
		if (1 != $search_form) { ?>
			<div id="search-toggle" class="header-search"></div>
			<div id="search-box" class="clearfix">
				<?php get_search_form();?>
			</div>  <!-- end #search-box -->
		<?php }

		echo '</div> <!-- end .container -->
				</div> <!-- end .top-header -->';
		if($header_image = $freesiaempire_settings['freesiaempire_display_header_image'] == 'below'){
			do_action('freesiaempire_header_image');
		}
		?>
		<!-- Main Header============================================= -->
		<div id="sticky_header">
			<div class="container clearfix">
				<!-- Main Nav ============================================= -->
				<?php
				if (has_nav_menu('primary')) { ?>
					<?php $args = array(
						'theme_location' => 'primary',
						'container'      => '',
						'items_wrap'     => '<ul class="menu">%3$s</ul>',
					); ?>
					<nav id="site-navigation" class="main-navigation clearfix">
						<?php wp_nav_menu($args);//extract the content from apperance-> nav menu ?>
					</nav> <!-- end #site-navigation -->
				<?php } else {// extract the content from page menu only ?>
					<nav id="site-navigation" class="main-navigation clearfix">
						<?php	wp_page_menu(array('menu_class' => 'menu')); ?>
					</nav> <!-- end #site-navigation -->
				<?php } ?>
			</div> <!-- end .container -->
		</div> <!-- end #sticky_header -->
		<?php
		$enable_slider = $freesiaempire_settings['freesiaempire_enable_slider'];
		freesiaempire_slider_value();
		if ($enable_slider=='frontpage'|| $enable_slider=='enitresite'){
			if(is_front_page() && ($enable_slider=='frontpage') ) {
				if($freesiaempire_settings['freesiaempire_slider_type'] == 'default_slider') {
					freesiaempire_page_sliders();
				}else{
					if(class_exists('Freesia_Empire_Plus_Features')):
						freesiaempire_image_sliders();
					endif;
				}
			}
			if($enable_slider=='enitresite'){
				if($freesiaempire_settings['freesiaempire_slider_type'] == 'default_slider') {
					freesiaempire_page_sliders();
				}else{
					if(class_exists('Freesia_Empire_Plus_Features')):
						freesiaempire_image_sliders();
					endif;
				}
			}
		}
		if(!is_page_template('page-templates/freesiaempire-corporate.php') && !is_page_template('alter-front-page-template.php') && !is_page_template('page-templates/pulsair-corporate.php')) {
			if (('' != freesiaempire_header_title()) || function_exists('bcn_display_list')) {
				if(is_home()){
					if($freesiaempire_settings['freesiaempire_blog_header_display'] == 'show'){ ?>
						<div class="page-header clearfix">
							<div class="container">
								<h2 class="page-title"><?php echo freesiaempire_header_title();?></h2> <!-- .page-title -->
								<?php freesiaempire_breadcrumb(); ?>
							</div> <!-- .container -->
						</div> <!-- .page-header -->
					<?php }
				} else { ?>
					<div class="page-header clearfix">
						<div class="container">
							<h1 class="page-title"><?php echo freesiaempire_header_title();?></h1> <!-- .page-title -->
							<?php freesiaempire_breadcrumb(); ?>
						</div> <!-- .container -->
					</div> <!-- .page-header -->
				<?php }
			}
		} ?>
	</header> <!-- end #masthead -->
	<!-- Main Page Start ============================================= -->
	<div id="content">
<?php if (!is_page_template('page-templates/freesiaempire-corporate.php') ){
	if(is_page_template('three-column-blog-template.php') || is_page_template('our-team-template.php') || is_page_template('about-us-template.php') || is_page_template('portfolio-template.php') ){

	}else{

		global $post, $wp_query;
		if(is_home()){
			$the_page_id = $wp_query->queried_object->ID;
		} else {
			$the_page_id = $post->ID;
		}

		$p_herobg = get_post_meta( $the_page_id, '_pacorp_herobg_id', true );
		$p_herotitle = get_post_meta( $the_page_id, '_pacorp_herotitle', true );
		$p_herocontent = get_post_meta( $the_page_id, '_pacorp_herocontent', true );
		$p_herolink  = get_post_meta( $the_page_id, '_pacorp_herolink', true);
		$p_herolinktext  = get_post_meta( $the_page_id, '_pacorp_herolinktext', true);
		$p_herocolor  = get_post_meta( $the_page_id, '_pacorp_herocolor', true);

		if(!empty($p_herobg)){

			$imageID = $p_herobg;
			$img_src = wp_get_attachment_image_url( $imageID, 'rwd-small' );
			$img_fallback = wp_get_attachment_image_url( $imageID, 'rwd-large' );
			$srcset_value = wp_get_attachment_image_srcset( $imageID, 'full' );
			$srcset       = $srcset_value ? ' srcset="' . esc_attr( $srcset_value ) . '"' : '';
			$alt          = get_post_meta( $imageID, '_wp_attachment_image_alt', true );

			if((!empty($p_herocolor)) && ($p_herocolor == 'on') ) {
				$p_hero_class = ' pa-hero--light';
			} else {
				$p_hero_class = '';
			}


			echo '<div class="pa-hero' . $p_hero_class . '">';
			echo '<figure class="pa-hero__bg img-fit">';
			echo '<img src="' . $img_src . '" ' . $srcset . ' sizes="100vw" alt="' . $alt . '" data-fallback-img="' . $img_fallback . '">';
			echo '<div class="pa-hero__content clearfix">';
			echo '<div class="pa-hero__content-inner clearfix">';
			echo '<h2 class="pa-hero__title">' . $p_herotitle . '</h2>';
			echo '<p class="pa-hero__text">' . $p_herocontent . '</p>';
			echo '<p class="btn-contain">';
			echo '<a title="' . $p_herolinktext . '" href="' . $p_herolink . '" class="btn-default btn-hero vivid">' . $p_herolinktext . '<span>❭</span></a>';
			echo '</p>';
			echo '</div>';
			echo '</div>';
			echo '</figure>';
			echo '</div>';
		}
		?>

		<div class="container clearfix">
	<?php }
} ?>