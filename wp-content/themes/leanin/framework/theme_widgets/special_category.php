<?php
/* Add our function to the widgets_init hook. */
add_action( 'widgets_init', 'kriesi_special_cat_widget' );

/* Function that registers our widget. */
function kriesi_special_cat_widget() {
	global $kriesiaddwidget;
	$kriesiaddwidget = 0;
	register_widget( 'Kriesi_special_cat_widget' );
}

class Kriesi_special_cat_widget extends WP_Widget {
	function Kriesi_special_cat_widget() 
	{
		$widget_ops = array('classname' => 'special_cat', 
							'description' => '创建一次博客或者图库的列表(Creates either a list of blog or gallery entries, depending on where you are on the page)');
		
		$this->WP_Widget( 'special_cat', THEMENAME.'/高级分类小工具', $widget_ops );
	}
 
	function widget($args, $instance) 
	{	
		global $h_option;
		extract($args, EXTR_SKIP);
		echo $before_widget;
		
		$modCats = "";
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
		
		if($h_option['showSidebar'] == 'frontpage' || $h_option['showSidebar'] == 'gallery')
		{
			$modCats = "&include=".$h_option['gallery']['gallery_cat_final'];
		}
		else if ($h_option['showSidebar'] == 'blog')
		{
			$modCats = "&exclude=".$h_option['gallery']['gallery_cat_final'];
		}
		
		echo "<ul>";
		wp_list_cats('sort_column=name&optioncount=0&hierarchical=0'.$modCats);
		echo "</ul>";
		echo $after_widget;
		
	}
 
 
	function update($new_instance, $old_instance) 
	{
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}

 
 
	function form($instance) 
	{
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'count' => '', 'cat' => '' ) );
		$title = strip_tags($instance['title']);
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>">标题/Title: 
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
		
		
			
<?php
	}
}
