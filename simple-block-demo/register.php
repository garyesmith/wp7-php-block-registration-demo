<?php
/**
 * Register basic WP7 PHP Block
 *
 * Demonstrates pure PHP-only block registration of a block that displays some post titles and thumbs 
 * along which some settings that can be modified in the WP sidebar
 * 
 */

defined( 'ABSPATH' ) || exit;  // prevent direct access via browser

add_action(
	'init',
	function () {

		// register js for the block
		wp_register_script(
			'simple-block-demo-view',
			PHPBLOCKS_URL . 'simple-block-demo/view.js',
			array(),
			PHPBLOCKS_VERSION,
			array( 'in_footer' => true )
		);

		// register stylesheet for the block
		wp_register_style(
			'simple-block-demo-style',
			PHPBLOCKS_URL . 'simple-block-demo/style.css',
			array( 'dashicons' ),
			PHPBLOCKS_VERSION
		);

		// obtain list of all site categories and reformat them into key/value format
		$categories = get_categories( [ 'hide_empty' => false ] );
    	$category_options = array();
		foreach ( $categories as $category ) {
			$category_options[ $category->slug ] = $category->name;
		}

		// create list of directional options in key/value format
		$direction_options=[
			'horizontal' => 'Horizontal',
			'vertical' => 'Verical'
		];

		// create list of directional options in key/value format
		$maxnum_options=[
			'1' => 1,
			'2' => 2,
			'3' => 3
		];

		register_block_type(
			'example-php-block/hello',
			array(
				'title'           => 'Simple PHP Block Demo',
				'description'     => 'A simple block that outputs some post title and thumbs vertically or horizontally and allows styling.',
				'category'        => 'widgets',
				'icon'            => 'text', // choose an icon from https://developer.wordpress.org/resource/dashicons/
				'version'         => PHPBLOCKS_VERSION,

				'style'           => 'simple-block-demo-style', 

				'attributes'      => array(
					'heading'      => array(
						'type'    => 'string',
						'default' => 'This is a heading',
						'label'   => 'Heading Text',
					),
					'selectedCategory' => [
						'type'    => 'string',
						'default' => 'uncategorized',
						'label'   => 'Category',
						'enum'    => array_keys( $category_options ), // this will render in admin sidebar as a select
						'enumNames' => array_values( $category_options ), 
					],
					'direction' => [
						'type'    => 'string',
						'default' => 'horizontal',
						'label'   => 'Default Direction',
						'enum'    => array_keys( $direction_options ), // this will render in admin sidebar as a select
						'enumNames' => array_values( $direction_options ),						
					],
					'maxPosts' => [
						'type'    => 'integer',
						'default' => '3',
						'label'   => 'Max Posts',
						'enum'    => array_keys( $maxnum_options ), // this will render in admin sidebar as a select
						'enumNames' => array_values( $maxnum_options ),						
					]
				),
				'supports'        => array( // defines what style elements users can change in admin sidebar
					'autoRegister' => true,
					'color'        => array(
						'text'       => true,
						'background' => true,
					),
					'spacing'      => array(
						'padding' => true,
						'margin'  => true,
					),
					'typography'   => array(
						'fontSize' => true,
					),
					'html'         => false, // set to true if you want people to be able to edit your block HTML inside WP
				),
				'render_callback' => function ( $attributes ) {

					wp_enqueue_script('simple-block-demo-view');

					// get the ID of the category selected in the sidebar
					$cat_id = get_category_by_slug( $attributes['selectedCategory'] );

					// retrieve up to maxPosts posts in the specified category
					$args = array(
						'cat'            => $cat_id->term_id,
						'posts_per_page' => $attributes['maxPosts'], 
						'post_status'    => 'publish'
					);
					$cat_query = new WP_Query( $args );

					// build list items HTML for all the retrieved posts
					$catListHtml='';
					while ($cat_query->have_posts()) {
						$cat_query->the_post();
						$catListHtml .= sprintf(
							'<li>
								<a href="%s">
									<div class="image-container">
										%s
									</div>
									<div class="heading-container">
										<h4>%s</h4>
									</div>
								</a>
							</li>',
							get_the_permalink(),
							get_the_post_thumbnail(get_the_ID(), 'small'),
							get_the_title()
						);
					}

					// reset the wp query
					wp_reset_postdata(); 

					// generate the required classes and inline styles for a block's root element 
					$block_wrapper = get_block_wrapper_attributes(
						array(
							'class' => 'simple-block-demo relative',
						)
					);

					// return all HTML for the block, including the list elements created above
					return sprintf(
						'<div %s>
							<h2>%s</h2>
							<ul class="%s">%s</ul>
						</div>',
						$block_wrapper,
						esc_html( $attributes['heading'] ),
						esc_html( $attributes['direction']),
						wp_kses_post($catListHtml) 
					);
				},
			)
		);
	}
);

