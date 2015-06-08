<?php
if(!class_exists('Voting'))
{
	class Voting
	{
		const POST_TYPE	= 'voting';
	
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
				'name'								=> __('Votings', 'reception'),
				'singular_name'				=> __('Voting', 'reception'),
				'menu_name'						=> __('Votings', 'reception'),
				'name_admin_bar'			=> __('Voting', 'reception'),				
				'all_items'						=> __('All Votings', 'reception'),
				'add_new'							=> __('Add New', 'reception'),
				'add_new_item'				=> __('Add New Voting', 'reception'),
				'edit_item'						=> __('Edit Voting', 'reception'),				
				'new_item'						=> __('New Voting', 'reception'),
				'view_item'						=> __('View Voting', 'reception'),
				'search_items'				=> __('Search Votings', 'reception'),
				'not_found'						=> __('No Votings found.', 'reception'),
				'not_found_in_trash'	=> __('No Votings found in Trash.', 'reception'),
				'parent_item_colon'		=> __('Parent Voting:', 'reception'),
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
				'menu_position'				=> 9,
				'description'					=> __('Votings deputy'),
				'menu_icon'						=> 'dashicons-book-alt',
				//'supports'						=> array( 'title', 'editor', 'author' )
			);
			register_post_type(self::POST_TYPE, $args);
		}
	}
}
?>