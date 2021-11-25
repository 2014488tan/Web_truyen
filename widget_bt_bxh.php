<?php

class BT_BXH extends WP_Widget {
 
    function __construct() {
        parent::__construct(
            'bt_bxh',
            'BT Bảng xếp hạng',
            array( 'description'  =>  'Widget hiển thị bảng xếp hạng.' )
        );
    }
 
    function form( $instance ) {
 	$options = get_option('my_option_name');
        $default = array(
            'title'       => '',
            'post_number' => 10,
            'loai'        => 'post',
            'kemtheo'     => 'luotxem',
            'glyphicon'   => '',
        );
        $instance = wp_parse_args( (array) $instance, $default );
        $title = esc_attr($instance['title']);
        $post_number = esc_attr($instance['post_number']);
        $loai = esc_attr($instance['loai']);
        $kemtheo = esc_attr($instance['kemtheo']);
        $glyphicon = esc_attr($instance['glyphicon']);
        
        echo '<p>Tiêu đề <input type="text" class="widefat" name="'.$this->get_field_name('title').'" value="'.$title.'"/></p>';
        echo '<p>Số lượng <input type="number" class="widefat" name="'.$this->get_field_name('post_number').'" value="'.$post_number.'" placeholder="'.$post_number.'" max="30" /></p>';
        echo '<p>Loại <select class="widefat" name="'.$this->get_field_name('loai').'">'; ?>
        <option value="post" <?php if($loai == 'post') echo 'selected="selected"';?> ><?php echo $options['breadcrumb'] ? $options['breadcrumb'] : 'Truyện'; ?></option>
        <option value="post_ngan" <?php if($loai == 'post_ngan') echo 'selected="selected"';?> ><?php echo $options['breadcrumb_ngan'] ? $options['breadcrumb_ngan'] : 'Truyện ngắn'; ?></option>
        <?php echo '</select></p>';
        
        echo '<p>Kèm theo <select class="widefat" name="'.$this->get_field_name('kemtheo').'">'; ?>
        <option value="thoigiantruoc" <?php if($kemtheo == 'thoigiantruoc') echo 'selected="selected"';?> >Thời gian trước</option>
        <option value="thoigiandang" <?php if($kemtheo == 'thoigiandang') echo 'selected="selected"';?> >Thời gian đăng</option>
        <option value="luotxem" <?php if($kemtheo == 'luotxem') echo 'selected="selected"';?> >Lượt xem</option>
        <option value="chuongcuoi" <?php if($kemtheo == 'chuongcuoi') echo 'selected="selected"';?> >Chương cuối</option>
        <option value="chuyenmuc" <?php if($kemtheo == 'chuyenmuc') echo 'selected="selected"';?> >Chuyên mục</option>
        <?php echo '</select></p>';
        
        echo '<p>Glyphicon <input class="widefat" name="'.$this->get_field_name('glyphicon').'" value="'.$glyphicon.'" placeholder="glyphicon-list"/></p>';
        
        if($title) $title = ': '.$title;
        echo '<script> $(".widget-title h3").last().html("BT Bảng xếp hạng'.$title.'"); </script>';
 
    }
 
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['post_number'] = strip_tags($new_instance['post_number']);
        $instance['loai'] = strip_tags($new_instance['loai']);
        $instance['kemtheo'] = strip_tags($new_instance['kemtheo']);
        $instance['glyphicon'] = strip_tags($new_instance['glyphicon']);
        return $instance;
    }
 
    function widget( $args, $instance ) {
        extract($args);
        $title = apply_filters( 'widget_title', $instance['title'] ).$title;
        $post_number = $instance['post_number'];
        $loai = $instance['loai'];
        $kemtheo = $instance['kemtheo'];
        $glyphicon = $instance['glyphicon'];
 
        echo $before_widget;
        echo $before_title.'<span class="glyphicon '.$glyphicon.'"></span>&nbsp;'.$title.$after_title;
        
        $i = 1;
	
        $args = array(
		'post_type'      => $loai,
		'post_status'    => 'publish',
		'posts_per_page' => $post_number,
		'post__not_in'   => array($ID_parent),
		'orderby'        => 'meta_value_num',
		'meta_key'       => 'tw_views_post',
		'ignore_sticky_posts' => -1,
		'order'          => 'DESC'
	);
        
        $query = new WP_Query($args);
 	
        while($query->have_posts()): $query->the_post();
	echo '<div class="row top-item" itemscope="" itemtype="http://schema.org/Book">
                <div class="col-xs-12 inrow_bxh">
					<div class="top-num top-'; echo $i; echo'">'; echo $i; echo '</div>
					<div class="s-title">
						<h3 itemprop="name">
							<a href="'; echo get_the_permalink(); echo '" itemprop="url" title="'; the_title(); echo '">'; the_title(); echo '</a>
						</h3>
					</div>
					<div>
						';
						echo '<span style="opacity:0.8">';
						if($kemtheo == 'thoigiantruoc'){
							echo human_time_diff( get_post_modified_time(), current_time('timestamp') ).' trước';
						}
						else if($kemtheo == 'thoigiandang'){
							echo the_date();
						}
						else if($kemtheo == 'luotxem'){
							echo '<span class="glyphicon glyphicon-eye-open" style="font-size:9px; top:0px; opacity: 0.8"></span> '.tw_get_views(get_the_ID());
						}
						else if($kemtheo == 'chuongcuoi'){
							echo last_update(true);
						}
						else if($kemtheo == 'chuyenmuc'){
							echo the_category(', ','',get_the_ID());
						}
						
						echo '</span></div>
                </div>
            </div>';
         $i++; endwhile;
        echo $after_widget;
    }
 
}
 
add_action( 'widgets_init', 'create_bt_bxh_widget' );
function create_bt_bxh_widget() {
    register_widget('BT_BXH');
}