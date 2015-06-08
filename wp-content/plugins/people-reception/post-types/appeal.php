<?php
if(!class_exists('Appeal'))
{
	class Appeal
	{
		const POST_TYPE	= 'appeal';
	
		public function __construct()
		{
			add_action('init', array(&$this, 'init'));
		}

		public function init()
		{
			$this->create_post_type();
		}

		public function create_post_type()
		{
			$labels = array(
				'name'								=> __('Appeals', 'reception'),
				'singular_name'				=> __('Appeal', 'reception'),
				'menu_name'						=> __('Appeals', 'reception'),
				'name_admin_bar'			=> __('Appeal', 'reception'),				
				'all_items'						=> __('All Appeals', 'reception'),
				'add_new'							=> __('Add New', 'reception'),
				'add_new_item'				=> __('Add New Appeal', 'reception'),
				'edit_item'						=> __('Edit Appeal', 'reception'),				
				'new_item'						=> __('New Appeal', 'reception'),
				'view_item'						=> __('View Appeal', 'reception'),
				'search_items'				=> __('Search Appeals', 'reception'),
				'not_found'						=> __('No Appeals found.', 'reception'),
				'not_found_in_trash'	=> __('No Appeals found in Trash.', 'reception'),
				'parent_item_colon'		=> __('Parent Appeal:', 'reception'),
			);
			$args = array(
				'taxonomies'					=> array('post_tag'),
				'labels'							=> $labels,
				'public'							=> true,
				'publicly_queryable'	=> true,
				'show_ui'							=> true,
				'show_in_menu'				=> true,
				'query_var'						=> true,
				'rewrite'							=> array('slug' => self::POST_TYPE),
				'capability_type'			=> 'post',
				'has_archive'					=> true,
				'hierarchical'				=> false,
				'menu_position'				=> 7,
				'description'					=> __('Answers to appeals of citizens'),
				'menu_icon'						=> 'dashicons-media-document',
				//'supports'						=> array( 'title', 'editor', 'author' )
			);
			register_post_type(self::POST_TYPE, $args);
		}
	}
}
?>