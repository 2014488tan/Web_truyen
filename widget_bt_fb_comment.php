<?php

class BT_FB_Comment extends WP_Widget {
 
    function __construct() {
        parent::__construct(
            'bt_fb_comment',
            'BT FB Comment',
            array( 'description'  =>  'Widget hiển thị bình luận bằng Facebook.' )
        );
    }
 
    function form( $instance ) {
 
        $default = array(
            'title'       => '',
            'comment_number' => 10,
            'order'       => 'reverse_time',
            'color'       => 'light',
            'nen'         => '',
            'glyphicon'   => '',
        );
        $instance = wp_parse_args( (array) $instance, $default );
        $title = esc_attr($instance['title']);
        $comment_number = esc_attr($instance['comment_number']);
        $order = esc_attr($instance['order']);
        $color = esc_attr($instance['color']);
        $nen = esc_attr($instance['nen']);
        $glyphicon = esc_attr($instance['glyphicon']);
        
        echo '<p>Tiêu đề <input type="text" class="widefat" name="'.$this->get_field_name('title').'" value="'.$title.'"/></p>';
        echo '<p>Số bình luận mỗi trang <input type="number" class="widefat" name="'.$this->get_field_name('comment_number').'" value="'.$comment_number.'" placeholder="'.$comment_number.'" max="30" /></p>';
        echo '<p>Sắp xếp <select class="widefat" name="'.$this->get_field_name('order').'">'; ?>
        <option value="social" <?php if($order == 'social') echo 'selected="selected"';?> >Hàng đầu</option>
        <option value="time" <?php if($order == 'time') echo 'selected="selected"';?> >Cũ nhất</option>
        <option value="reverse_time" <?php if($order == 'reverse_time') echo 'selected="selected"';?> >Mới nhất</option>
        <?php echo '</select></p>';
        echo '<p>Màu sắc <select class="widefat" name="'.$this->get_field_name('color').'">'; ?>
        <option value="light" <?php if($color == 'light') echo 'selected="selected"';?> >Sáng</option>
        <option value="dark" <?php if($color == 'dark') echo 'selected="selected"';?> >Tối</option>
        <?php echo '</select></p>';
        echo '<p>Mã màu nền <input type="text" class="widefat" name="'.$this->get_field_name('nen').'" value="'.$nen.'" placeholder="#FFFFFF"/></p>';
        echo '<p>Glyphicon <input type="text" class="widefat" name="'.$this->get_field_name('glyphicon').'" value="'.$glyphicon.'" placeholder="glyphicon-list"/></p>';
        if($title) $title = ': '.$title;
        echo '<script> $(".widget-title h3").last().html("BT FB Comment'.$title.'"); </script>';
 
    }
 
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['comment_number'] = strip_tags($new_instance['comment_number']);
        $instance['order'] = strip_tags($new_instance['order']);
        $instance['color'] = strip_tags($new_instance['color']);
        $instance['nen'] = strip_tags($new_instance['nen']);
        $instance['glyphicon'] = strip_tags($new_instance['glyphicon']);
        return $instance;
    }
 
    function widget( $args, $instance ) {
        extract($args);
        $title = apply_filters( 'widget_title', $instance['title'] ).$title;
        $comment_number = $instance['comment_number'];
        $order = $instance['order'];
        $color = $instance['color'];
        $nen = $instance['nen'];
        $glyphicon = $instance['glyphicon'];
        
	$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	
        echo $before_widget;
        echo $before_title.'<span class="glyphicon '.$glyphicon.'"></span>&nbsp;'.$title.$after_title;
        echo '<div style="background:'.$nen.';padding: 0px 7px;"><div class="fb-comments" data-href="'.$url.'" data-width="100%" data-numposts="'.$comment_number.'" data-colorscheme="'.$color.'" data-order-by="'.$order.'"></div></div>';
        echo $after_widget;
    }
 
}
 
add_action( 'widgets_init', 'create_bt_fb_comment_widget' );
function create_bt_fb_comment_widget() {
    register_widget('BT_FB_Comment');
}