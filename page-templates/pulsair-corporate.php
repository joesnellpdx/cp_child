<?php
/**
 * Template Name: Pulsair Corporate Template
 *
 * Displays Pulsair Corporate template.
 *
 * @package Theme Freesia
 * @subpackage Freesia Empire
 * @since Freesia Empire 1.0.5
 */
get_header('pulsair');
$freesiaempire_settings = freesiaempire_get_theme_options();
global $post, $wp_query;
if(is_home()){
	$the_page_id = $wp_query->queried_object->ID;
} else {
	$the_page_id = $post->ID;
}

echo '<div id="main">';
echo '<section class="our_feature">';
echo '<div class="container clearfix">';
echo '<div class="container_container">';
$p_title = get_post_meta( $the_page_id, '_pacorp_title', true );
$p_subcontent = get_post_meta( $the_page_id, '_pacorp_subtitle', true );
$p_subtitle = get_post_meta( $the_page_id, '_pacorp_subtitle-replace', true );
$p_grid  = get_post_meta( $the_page_id, '_pacorp_grid', true);

if(empty($p_title)){
	$p_title = get_the_title($the_page_id);
}
echo '<h1 class="page-title--custom freesia-animation fadeInUp">' . $p_title . '</h1>';

if(!empty($p_subtitle)){
	echo '<div class="feature-sub-title freesia-animation fadeInUp">' . wpautop($p_subtitle) . '</div>';
}

if(!empty($p_subcontent)){
	echo '<div class="container_container container_container--align-left freesia-animation fadeInUp">' . wpautop(do_shortcode($p_subcontent)) . '</div>';
}

if((!empty($p_grid)) && ($p_grid == 'on') ) {
	echo pa_page_grids($the_page_id);
}
//$custom_cont = wpautop(do_shortcode(get_post_field('post_content', $the_page_id)));
//$custom_cont = the_content();
echo '<div class="container_container container_container--align-left freesia-animation fadeInUp">' . the_content() . '</div>';
echo '</div>';
echo '</div>';
echo '</section>';
//	echo '</div> <!-- entry-content clearfix-->';
if($freesiaempire_settings['freesiaempire_disable_features'] != 1){
	echo '<!-- Our Feature ============================================= -->';
	global $post;
	$freesiaempire_features = '';
	$freesiaempire_total_page_no = 0;
	$freesiaempire_list_page	= array();
	for( $i = 1; $i <= $freesiaempire_settings['freesiaempire_total_features']; $i++ ){
		if( isset ( $freesiaempire_settings['freesiaempire_frontpage_features_' . $i] ) && $freesiaempire_settings['freesiaempire_frontpage_features_' . $i] > 0 ){
			$freesiaempire_total_page_no++;

			$freesiaempire_list_page	=	array_merge( $freesiaempire_list_page, array( $freesiaempire_settings['freesiaempire_frontpage_features_' . $i] ) );
		}

	}
	if (( !empty( $freesiaempire_list_page ) || !empty($freesiaempire_settings['freesiaempire_features_title']) || !empty($freesiaempire_settings['freesiaempire_features_description']) )  && $freesiaempire_total_page_no > 0 ) {
		$freesiaempire_features 	.= '<section class="our_feature">
						<div class="container clearfix">
							<div class="container_container">';
		$get_featured_posts 		= new WP_Query(array(
			'posts_per_page'      	=> $freesiaempire_settings['freesiaempire_total_features'],
			'post_type'           	=> array('page'),
			'post__in'            	=> $freesiaempire_list_page,
			'orderby'             	=> 'post__in',
		));
		if($freesiaempire_settings['freesiaempire_features_title'] != ''){
			$freesiaempire_features .= '<h2 class="freesia-animation fadeInUp">'. esc_attr($freesiaempire_settings['freesiaempire_features_title']).'</h2>';
		}
		if($freesiaempire_settings['freesiaempire_features_description'] != ''){
			$freesiaempire_features .= '<p class="feature-sub-title freesia-animation fadeInUp">'. esc_attr($freesiaempire_settings['freesiaempire_features_description']).'</p>';
		}
		$freesiaempire_features .= '<div class="column clearfix">';
		$j = 1;
		while ($get_featured_posts->have_posts()):$get_featured_posts->the_post();
			$attachment_id = get_post_thumbnail_id();
			$image_attributes = wp_get_attachment_image_src($attachment_id,'full');
			$title_attribute       	 	 = apply_filters('the_title', get_the_title($post->ID));
			$excerpt               	 	 = get_the_excerpt();
			if( $j % 3 == 1 && $j >= 1 ) {
				$delay_value = "0.1s";
			}
			elseif ( $j % 3 == 2 && $j >= 1 ) {
				$delay_value = "0.2s";
			}
			else {
				$delay_value = "0.3s";
			}
			$freesiaempire_features .= '<div class="three-column freesia-animation fadeInLeft" data-wow-delay="'.$delay_value .'">
					<div class="feature-content">';
			if ($image_attributes) {
				$freesiaempire_features 	.= '<a class="feature-icon" href="'.get_permalink().'" title="'.the_title('', '', false).'"' .' alt="'.get_permalink().'">'.get_the_post_thumbnail($post->ID, 'thumbnail').'</a>';
			}
			$freesiaempire_features 	.= '<article>';
			if ($title_attribute != '') {
				$freesiaempire_features .= '<h3 class="feature-title"><a href="'.get_permalink().'" title="'.the_title('', '', false).'" rel="bookmark">'.get_the_title().'</a></h3>';
			}
			if ($excerpt != '') {
				$excerpt_text = $freesiaempire_settings['freesiaempire_tag_text'];
				$excerpt_length = substr(get_the_excerpt(), 0 , 85);
				$freesiaempire_features .= '<p>'.$excerpt_length.' </p>';
			}
			$freesiaempire_features 	.= '</article>';
			$excerpt = get_the_excerpt();
			$content = get_the_content();
			if(strlen($excerpt) < strlen($content)){
				$excerpt_text = $freesiaempire_settings['freesiaempire_tag_text'];
				if($excerpt_text == '' || $excerpt_text == 'Read More') :
					$freesiaempire_features 	.= '<a title='.'"'.get_the_title(). '"'. ' '.'href="'.get_permalink().'"'.' class="more-link">'.__('Read More', 'freesia-empire').'</a>';
				else:
					$freesiaempire_features 	.= '<a title='.'"'.get_the_title(). '"'. ' '.'href="'.get_permalink().'"'.' class="more-link">'.$freesiaempire_settings[ 'freesiaempire_tag_text' ].'</a>';
				endif;
			}
			$freesiaempire_features 	.='</div> <!-- end .feature-content -->
					</div><!-- end .three-column -->';
			$j++;
		endwhile;
		$freesiaempire_features 	.='</div><!-- .end column-->';
		$freesiaempire_features 	.='</div><!-- end .container_container -->';
		$freesiaempire_features 	.='</div><!-- .container -->
					</section><!-- end .our_feature -->';
	}
	echo $freesiaempire_features;
}
wp_reset_postdata();
if( is_active_sidebar( 'freesiaempire_corporate_page_sidebar' ) ) {
	dynamic_sidebar( 'freesiaempire_corporate_page_sidebar' );
} ?>
	</div>
	<!-- end #main -->
<?php get_footer(); ?>