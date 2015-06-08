<?php
if(!class_exists('Transcript'))
{
	class Transcript
	{
		const POST_TYPE	= 'transcript';
	
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
				'name'								=> __('Transcripts', 'reception'),
				'singular_name'				=> __('Transcript', 'reception'),
				'menu_name'						=> __('Transcripts', 'reception'),
				'name_admin_bar'			=> __('Transcript', 'reception'),				
				'all_items'						=> __('All Transcripts', 'reception'),
				'add_new'							=> __('Add New', 'reception'),
				'add_new_item'				=> __('Add New Transcript', 'reception'),
				'edit_item'						=> __('Edit Transcript', 'reception'),				
				'new_item'						=> __('New Transcript', 'reception'),
				'view_item'						=> __('View Transcript', 'reception'),
				'search_items'				=> __('Search Transcripts', 'reception'),
				'not_found'						=> __('No Transcripts found.', 'reception'),
				'not_found_in_trash'	=> __('No Transcripts found in Trash.', 'reception'),
				'parent_item_colon'		=> __('Parent Transcript:', 'reception'),
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
				'description'					=> __('Text transcript of speeches'),
				'menu_icon'						=> 'dashicons-book-alt',
				//'supports'						=> array( 'title', 'editor', 'author' )
			);
			register_post_type(self::POST_TYPE, $args);
		}
	}
}
?>