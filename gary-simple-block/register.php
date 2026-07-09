<?php
/**
 * Basic Block Registration
 *
 * Demonstrates pure PHP-only block registration of a block that displays some post titles and thumbs 
 * along which some settings that can be modified in the WP sidebar
 */

defined( 'ABSPATH' ) || exit;  // prevent direct access via browser

add_action(
	'init',
	function () {
		
		// register js for the block
		wp_register_script(
			'gary-simple-block-view',
			PHPBLOCKS_URL . 'gary-simple-block/view.js',
			array(),
			PHPBLOCKS_VERSION,
			array( 'in_footer' => true )
		);

		// register stylesheet for the block
		wp_register_style(
			'gary-simple-block-style',
			PHPBLOCKS_URL . 'gary-simple-block/style.css',
			array(),
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
				'title'           => 'Gary\'s Simple Block',
				'description'     => 'A simple block that outputs some post title and thumbs vertically or horizontally and allows styling.',
				'category'        => 'widgets',
				'icon'            => 'text', // choose an icon from https://developer.wordpress.org/resource/dashicons/
				'version'         => PHPBLOCKS_VERSION,

				'style'           => 'gary-simple-block-style', 

				'attributes'      => array(
					'heading'      => array(
						'type'    => 'string',
						'default' => 'This is a heading',
						'label'   => 'Heading Text',
					),
					'headingLevel' => array(
						'type'    => 'string',
						'enum'    => array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ),
						'default' => 'h2',
						'label'   => 'Heading Level',
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
				'supports'        => array( // defines what style elements users can change inside wp
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
					wp_enqueue_script('gary-simple-block-view');

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
						$catListHtml.='<li>';
						$catListHtml.='<a href="' .get_the_permalink() . '">' . get_the_post_thumbnail(get_the_ID(), 'small') . '</a>';
						$catListHtml.='<h4><a href="' .get_the_permalink() . '">'.get_the_title().'</a></h4>';
						$catListHtml.='</li>'; 
					}

					// reset the wp query
					wp_reset_postdata(); 

					$wrapper = get_block_wrapper_attributes(
						array(
							'class' => 'demoblock-simple',
						)
					);

					// get the heading level set, and do some validation to make sure it's valid and fall back on a default if not
					$tag = in_array( $attributes['headingLevel'], array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ), true )
						? $attributes['headingLevel']
						: 'h2';

					// return all HTML for the block, including the list elements created above
					return sprintf(
						'<div %s>
						<%s class="demoblock-simple__heading">%s</%s>
						<ul class="demoblock-simple__category %s">%s</ul>
					</div>',
						$wrapper,
						$tag,
						esc_html( $attributes['heading'] ),
						$tag,
						$attributes['direction'],
						wp_kses_post($catListHtml) // sanitize generated HTML for safety using "KSES Strips Evil Scripts"
					);
				},
			)
		);
	}
);

