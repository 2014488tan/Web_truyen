<?php

class BT_Comment extends WP_Widget {
 
    function __construct() {
        parent::__construct(
            'bt_comment',
            'BT Comment',
            array( 'description'  =>  'Widget hiển thị bình luận.' )
        );
    }
 
    function form( $instance ) {
 	$options = get_option('my_option_name');
        $default = array(
            'title'       => '',
            'bg'          => '#FFF',
            'glyphicon'   => '',
        );
        $instance = wp_parse_args( (array) $instance, $default );
        $title = esc_attr($instance['title']);
        $bg = esc_attr($instance['bg']);
        $glyphicon = esc_attr($instance['glyphicon']);
        
        echo '<p>Tiêu đề <input type="text" class="widefat" name="'.$this->get_field_name('title').'" value="'.$title.'"/></p>';
        echo '<p>Mã màu nền <input type="text" class="widefat" name="'.$this->get_field_name('bg').'" value="'.$bg.'"/></p>';
        echo '<p>Glyphicon <input type="text" class="widefat" name="'.$this->get_field_name('glyphicon').'" value="'.$glyphicon.'" placeholder="glyphicon-list"/></p>';
        
        if($title) $title = ': '.$title;
        echo '<script> $(".widget-title h3").last().html("BT Comment'.$title.'"); </script>';
 
    }
 
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['bg'] = strip_tags($new_instance['bg']);
        $instance['glyphicon'] = strip_tags($new_instance['glyphicon']);
        return $instance;
    }
 
    function widget( $args, $instance ) {
        extract($args);
        $title = apply_filters( 'widget_title', $instance['title'] ).$title;
        $bg = $instance['bg'];
        $glyphicon = $instance['glyphicon'];

	echo '<style>#wpcomm{margin: 0px auto;padding: 15px; background: '.$bg.';border-top:none;max-width: 100%;} #wc_show_hide_loggedin_username { padding: 15px 15px 0px 15px; background: '.$bg.'; } #wc-comment-header{display:none}</style>';
	
        echo $before_widget;
        echo $before_title.'<span class="glyphicon '.$glyphicon.'"></span>&nbsp;'.$title.$after_title;
        
        if ( comments_open() || get_comments_number() ) : comments_template(); endif;
        
        echo $after_widget;
    }
 
}
 
add_action( 'widgets_init', 'create_bt_comment_widget' );
function create_bt_comment_widget() {
    register_widget('BT_Comment');
}