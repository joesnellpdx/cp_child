<?php

// Register Custom Post Type
function client_post_type() {

	$labels = array(
		'name'                  => _x( 'Client Items', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Client Item', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Client Items', 'text_domain' ),
		'name_admin_bar'        => __( 'Client Item', 'text_domain' ),
		'archives'              => __( 'Client Item Archives', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Client Item:', 'text_domain' ),
		'all_items'             => __( 'All Client Items', 'text_domain' ),
		'add_new_item'          => __( 'Add New Client Item', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Item', 'text_domain' ),
		'edit_item'             => __( 'Edit Item', 'text_domain' ),
		'update_item'           => __( 'Update Item', 'text_domain' ),
		'view_item'             => __( 'View Item', 'text_domain' ),
		'search_items'          => __( 'Search Item', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Client Item', 'text_domain' ),
		'description'           => __( 'Generate Client Items', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'page-attributes', ),
		'taxonomies'            => array( 'client_item_tax' ),
		'hierarchical'          => true,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-screenoptions',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'pt_client', $args );

}
add_action( 'init', 'client_post_type', 0 );

// Register Custom Taxonomy
function client_item_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Client Pages', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Client Page', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Client Pages', 'text_domain' ),
		'all_items'                  => __( 'All Items', 'text_domain' ),
		'parent_item'                => __( 'Parent Item', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
		'new_item_name'              => __( 'New Item Name', 'text_domain' ),
		'add_new_item'               => __( 'Add New Item', 'text_domain' ),
		'edit_item'                  => __( 'Edit Item', 'text_domain' ),
		'update_item'                => __( 'Update Item', 'text_domain' ),
		'view_item'                  => __( 'View Item', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'popular_items'              => __( 'Popular Items', 'text_domain' ),
		'search_items'               => __( 'Search Items', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
		'no_terms'                   => __( 'No items', 'text_domain' ),
		'items_list'                 => __( 'Items list', 'text_domain' ),
		'items_list_navigation'      => __( 'Items list navigation', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => false,
	);
	register_taxonomy( 'client_item_tax', array( 'pt_client' ), $args );

}
add_action( 'init', 'client_item_taxonomy', 0 );

function client_logos_shortcode($atts, $content=null){
	$a = shortcode_atts( array(
		'title' => '',
	), $atts );

	$args = array(
		'post_type'      => 'pt_client',
		'posts_per_page' => 99,
		'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
	);

	$html = '';

	$the_query = new WP_Query( $args );

	if ( $the_query->have_posts() ) :



	$html .= '<div class="container clearfix">';
	$html .= '<div class="container_container">';
	if(!empty($a['title'])){
		$html .= '<h2 class="grid-title freesia=animation fadeInUp">' . $a['title'] . '</h2>';
	}
	$html .= '<div class="column column--clients clearfix">';
		while ( $the_query->have_posts() ) : $the_query->the_post();

		$client_bg  = get_post_meta( get_the_id(), '_cltm_bg_id', true);

		$img_src      = wp_get_attachment_image_url( $client_bg, 'rwd-small' );
		$img_fallback = wp_get_attachment_image_url( $client_bg, 'full' );
		$srcset_value = wp_get_attachment_image_srcset( $client_bg, 'large' );
		$srcset       = $srcset_value ? ' srcset="' . esc_attr( $srcset_value ) . '"' : '';
		$alt          = get_post_meta( $client_bg, '_wp_attachment_image_alt', true );

		$html .= '<div class="six-column freesia-animation fadeInLeft" data-wow-delay="0.1s">';
		$html .= '<figure class="feature__figure feature__figure--clients img-fit">';
		$html .= '<img src="' .  $img_src . '" ' .  $srcset . ' sizes="100vw" alt="' .  $alt . '" data-fallback-img="' . $img_fallback . '">';

		$html .= '</figure>';
		$html .= '</div>';


		//// del

			$html .= '<div class="six-column freesia-animation fadeInLeft" data-wow-delay="0.1s">';
			$html .= '<figure class="feature__figure feature__figure--clients img-fit">';
			$html .= '<img src="' .  $img_src . '" ' .  $srcset . ' sizes="100vw" alt="' .  $alt . '" data-fallback-img="' . $img_fallback . '">';

			$html .= '</figure>';
			$html .= '</div>';
			$html .= '<div class="six-column freesia-animation fadeInLeft" data-wow-delay="0.1s">';
			$html .= '<figure class="feature__figure feature__figure--clients img-fit">';
			$html .= '<img src="' .  $img_src . '" ' .  $srcset . ' sizes="100vw" alt="' .  $alt . '" data-fallback-img="' . $img_fallback . '">';

			$html .= '</figure>';
			$html .= '</div>';
			$html .= '<div class="six-column freesia-animation fadeInLeft" data-wow-delay="0.1s">';
			$html .= '<figure class="feature__figure feature__figure--clients img-fit">';
			$html .= '<img src="' .  $img_src . '" ' .  $srcset . ' sizes="100vw" alt="' .  $alt . '" data-fallback-img="' . $img_fallback . '">';

			$html .= '</figure>';
			$html .= '</div>';
			$html .= '<div class="six-column freesia-animation fadeInLeft" data-wow-delay="0.1s">';
			$html .= '<figure class="feature__figure feature__figure--clients img-fit">';
			$html .= '<img src="' .  $img_src . '" ' .  $srcset . ' sizes="100vw" alt="' .  $alt . '" data-fallback-img="' . $img_fallback . '">';

			$html .= '</figure>';
			$html .= '</div>';
			$html .= '<div class="six-column freesia-animation fadeInLeft" data-wow-delay="0.1s">';
			$html .= '<figure class="feature__figure feature__figure--clients img-fit">';
			$html .= '<img src="' .  $img_src . '" ' .  $srcset . ' sizes="100vw" alt="' .  $alt . '" data-fallback-img="' . $img_fallback . '">';

			$html .= '</figure>';
			$html .= '</div>';
			$html .= '<div class="six-column freesia-animation fadeInLeft" data-wow-delay="0.1s">';
			$html .= '<figure class="feature__figure feature__figure--clients img-fit">';
			$html .= '<img src="' .  $img_src . '" ' .  $srcset . ' sizes="100vw" alt="' .  $alt . '" data-fallback-img="' . $img_fallback . '">';

			$html .= '</figure>';
			$html .= '</div>';
			$html .= '<div class="six-column freesia-animation fadeInLeft" data-wow-delay="0.1s">';
			$html .= '<figure class="feature__figure feature__figure--clients img-fit">';
			$html .= '<img src="' .  $img_src . '" ' .  $srcset . ' sizes="100vw" alt="' .  $alt . '" data-fallback-img="' . $img_fallback . '">';

			$html .= '</figure>';
			$html .= '</div>';
			$html .= '<div class="six-column freesia-animation fadeInLeft" data-wow-delay="0.1s">';
			$html .= '<figure class="feature__figure feature__figure--clients img-fit">';
			$html .= '<img src="' .  $img_src . '" ' .  $srcset . ' sizes="100vw" alt="' .  $alt . '" data-fallback-img="' . $img_fallback . '">';

			$html .= '</figure>';
			$html .= '</div>';
			$html .= '<div class="six-column freesia-animation fadeInLeft" data-wow-delay="0.1s">';
			$html .= '<figure class="feature__figure feature__figure--clients img-fit">';
			$html .= '<img src="' .  $img_src . '" ' .  $srcset . ' sizes="100vw" alt="' .  $alt . '" data-fallback-img="' . $img_fallback . '">';

			$html .= '</figure>';
			$html .= '</div>';
			$html .= '<div class="six-column freesia-animation fadeInLeft" data-wow-delay="0.1s">';
			$html .= '<figure class="feature__figure feature__figure--clients img-fit">';
			$html .= '<img src="' .  $img_src . '" ' .  $srcset . ' sizes="100vw" alt="' .  $alt . '" data-fallback-img="' . $img_fallback . '">';

			$html .= '</figure>';
			$html .= '</div>';


			///// del



		endwhile;
		wp_reset_postdata();



	$html .= '</div>';
	$html .= '</div>';
	$html .= '</div>';

	else :
		$html .= '<p>Sorry, no posts matched your criteria.</p>';
	endif;

	return $html;
}
add_shortcode( 'client_logos', 'client_logos_shortcode' );

function pa_page_clients($pageID) {

	$postID = get_post($pageID);
	$slug = $postID->post_name;

	$args = array(
		'post_type'      => 'pt_client',
		'posts_per_page' => 99,
		'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
		'client_item_tax' => $slug
	);

	?>



	<div class="column clearfix">

		<?php $the_query = new WP_Query( $args ); ?>

		<?php if ( $the_query->have_posts() ) : ?>

			<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

				<?php
				/**
				 * Metabox values
				 */

				$client_subtitle = get_post_meta( get_the_id(), '_gitm_subtitle', true );
				$client_link  = get_post_meta( get_the_id(), '_gitm_link', true);
				$client_bg  = get_post_meta( get_the_id(), '_gitm_bg_id', true);

				$img_src      = wp_get_attachment_image_url( $client_bg, 'rwd-small' );
				$img_fallback = wp_get_attachment_image_url( $client_bg, 'full' );
				$srcset_value = wp_get_attachment_image_srcset( $client_bg, 'large' );
				$srcset       = $srcset_value ? ' srcset="' . esc_attr( $srcset_value ) . '"' : '';
				$alt          = get_post_meta( $client_bg, '_wp_attachment_image_alt', true );
				?>

				<?php if(!empty($client_bg)) : ?>

					<div class="three-column freesia-animation fadeInLeft" data-wow-delay="0.1s">
						<div class="feature-content feature-content--client">
							<div class="feature-icon feature-image feature">
								<article>
									<figure class="feature__figure feature__figure--clients img-fit">
										<img src="<?php echo $img_src; ?>" <?php echo $srcset; ?> sizes="100vw" alt="<?php echo $alt; ?>" data-fallback-img="<?php echo $img_fallback; ?>">
										<figcaption class="feature__caption">
											<h3 class="feature-title feature__title"><?php the_title(); ?></h3>
											<p class="feature__subtitle"><?php echo $client_subtitle; ?></p>
											<a href="<?php echo $client_link; ?>" title="<?php the_title(); ?>" class="feature__more">View more</a>
										</figcaption>
									</figure>
								</article>
							</div>
						</div>
					</div>
				<?php endif; ?>

			<?php endwhile; ?>

			<?php wp_reset_postdata(); ?>

		<?php else : ?>
			<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
		<?php endif; ?>
	</div>

	<?php
}