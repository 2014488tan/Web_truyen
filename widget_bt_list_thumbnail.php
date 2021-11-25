<?php

class BT_Truyen_2 extends WP_Widget {
 
    function __construct() {
        parent::__construct(
            'bt_truyen_2',
            'BT List Thumbnail',
            array( 'description'  =>  'Widget hiển thị danh sách các truyện (có thumbnail)' )
        );
    }
 
    function form( $instance ) {
	$options = get_option('my_option_name');
	$hoanthanh = $options['trangthai_hoanthanh'] ? $options['trangthai_hoanthanh'] : 'Hoàn thành';
        $default = array(
            'title'       => '',
            'post_number' => 5,
            'loai'        => 'post',
            'order'       => 'moi',
            'tiento'      => false,
            'trangthai'   => false,
            'url'         => '',
            'glyphicon'   => '',
        );
        $instance = wp_parse_args( (array) $instance, $default );
        $title = esc_attr($instance['title']);
        $post_number = esc_attr($instance['post_number']);
        $loai = esc_attr($instance['loai']);
        $order = esc_attr($instance['order']);
        $tiento = esc_attr($instance['tiento']);
        $trangthai = esc_attr($instance['trangthai']);
        $url = esc_attr($instance['url']);
        $glyphicon = esc_attr($instance['glyphicon']);
        
        echo '<p>Tiêu đề <input type="text" class="widefat" name="'.$this->get_field_name('title').'" value="'.$title.'"/></p>';
        echo '<p>Số lượng <input type="number" class="widefat" name="'.$this->get_field_name('post_number').'" value="'.$post_number.'" placeholder="'.$post_number.'" max="30" /></p>';
        
        echo '<p>Loại <select class="widefat" name="'.$this->get_field_name('loai').'">'; ?>
        <option value="post" <?php if($loai == 'post') echo 'selected="selected"';?> ><?php echo $options['breadcrumb'] ? $options['breadcrumb'] : 'Truyện'; ?></option>
        <option value="post_ngan" <?php if($loai == 'post_ngan') echo 'selected="selected"';?> ><?php echo $options['breadcrumb_ngan'] ? $options['breadcrumb_ngan'] : 'Truyện ngắn'; ?></option>
        <option value="chap" <?php if($loai == 'chap') echo 'selected="selected"';?> >Chương</option>
        <?php echo '</select></p>';
        
        echo '<p>Sắp xếp <select class="widefat" name="'.$this->get_field_name('order').'">'; ?>
        <option value="moi" <?php if($order == 'moi') echo 'selected="selected"';?> >Mới</option>
        <option value="rand" <?php if($order == 'rand') echo 'selected="selected"';?> >Ngẫu nhiên</option>
        <option value="moi_cap_nhat" <?php if($order == 'moi_cap_nhat') echo 'selected="selected"';?> >Mới cập nhật</option>
        <option value="xem_nhieu" <?php if($order == 'xem_nhieu') echo 'selected="selected"'; if($loai == 'chap') echo 'style="display:none"';?> >Xem nhiều</option>
        <option value="hoan_thanh" <?php if($order == 'hoan_thanh') echo 'selected="selected"'; if($loai == 'chap'||$loai == 'post_ngan') echo 'style="display:none"';?> ><?php echo $hoanthanh; ?></option>
        <option value="de_cu" <?php if($order == 'de_cu') echo 'selected="selected"';?> >Đề cử</option>
        <option value="cung_tac_gia" <?php if($order == 'cung_tac_gia') echo 'selected="selected"'; if($loai == 'chap') echo 'style="display:none"';?> >Cùng tác giả</option>
        <option value="cung_chuyen_muc" <?php if($order == 'cung_chuyen_muc') echo 'selected="selected"'; if($loai == 'chap') echo 'style="display:none"';?> >Cùng chuyên mục</option>
        <?php echo '</select></p>';
        
        echo '<p>'; ?>
        Tiền tố <input type="checkbox" <?php checked( $instance[ 'tiento' ], 'on' ); ?> name="<?php echo $this->get_field_name('tiento');?>"/>
        Hoàn thành <input type="checkbox" <?php checked( $instance[ 'trangthai' ], 'on' ); ?> name="<?php echo $this->get_field_name('trangthai');?>"/>
        <?php echo '</p>';
        
        echo '<p>URL <input type="text" class="widefat" name="'.$this->get_field_name('url').'" value="'.$url.'" placeholder="http://"/></p>';
        
        echo '<p>Glyphicon <input type="text" class="widefat" name="'.$this->get_field_name('glyphicon').'" value="'.$glyphicon.'" placeholder="glyphicon-list"/></p>';
        
        if($title) $title = ': '.$title;
        echo '<script> $(".widget-title h3").last().html("BT List Thumbnail'.$title.'"); </script>';
 
    }
 
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['post_number'] = strip_tags($new_instance['post_number']);
        $instance['loai'] = strip_tags($new_instance['loai']);
        $instance['order'] = strip_tags($new_instance['order']);
        $instance['tiento'] = $new_instance['tiento'];
        $instance['trangthai'] = $new_instance['trangthai'];
        $instance['url'] = strip_tags($new_instance['url']);
        $instance['glyphicon'] = strip_tags($new_instance['glyphicon']);
        return $instance;
    }
 
    function widget( $args, $instance ) {
	$options = get_option('my_option_name');
	$hoanthanh = $options['trangthai_hoanthanh'] ? $options['trangthai_hoanthanh'] : 'Hoàn thành';
        extract($args);
        $title = apply_filters( 'widget_title', $instance['title'] ).$title;
        $post_number = $instance['post_number'];
        $loai = $instance['loai'];
        $order = $instance['order'];
        $tiento = $instance['tiento'];
        $trangthai = $instance['trangthai'];
        $url = $instance['url'];
        $glyphicon = $instance['glyphicon'];
 
        echo $before_widget;
        echo $before_title.'<span class="glyphicon '.$glyphicon.'"></span>&nbsp;'.$title.$after_title;
        
        global $wp_query;
        if($order == 'xem_nhieu'){
        	$args = array(
                    'post_type'            => $loai,
                    'post_status'          => 'publish',
                    'posts_per_page'       => $post_number,
                    'orderby'              => 'meta_value_num',
                    'meta_key'             => 'tw_views_post',
    		    'ignore_sticky_posts'  => -1,
                    'order'                => 'DESC'
                    );
        }
        if($order == 'hoan_thanh'){
        	$args = array(
                    'post_type'           => $loai,
                    'post_status'         => 'publish',
                    'showposts'           => $post_number,
                    'orderby'             => 'modified',
		    'ignore_sticky_posts' => -1,
		    'meta_query' => array(
        		array(
            			'key'     => 'tw_status',
            			'value'   => $hoanthanh
            		),
        	    ),
                    'order'               => 'DESC'
                );
        }
        if($order == 'de_cu'){
        	$sticky = get_option('sticky_posts');
            	$args = array(
	                'post_type'           => $loai,
	                'post__in'            => $sticky,
	                'ignore_sticky_posts' => 1,
                    	'orderby'             => 'modified',
	                'showposts'           => $post_number
            	);
        }
        if($order == 'moi_cap_nhat'){
        	$args = array(
		    'post_type'       => $loai,
		    'orderby'         => 'modified',
		    'order'           => 'DESC',
		    'ignore_sticky_posts' => -1,
		    'posts_per_page'      => $post_number,
		);
        }
        if($order == 'moi'){
        	$args = array(
		    'post_type'       => $loai,
		    'orderby'         => 'date',
		    'order'           => 'DESC',
		    'ignore_sticky_posts' => -1,
		    'posts_per_page'      => $post_number,
		);
        }
        if($order == 'cung_chuyen_muc'){
        	$thisID = $wp_query->post->ID;
        	$args = array(
		    'post_type'           => $loai,
		    'ignore_sticky_posts' => -1,
		    'posts_per_page'      => $post_number,
		    'post__not_in'        => array($thisID),
                    'orderby'             => 'rand',
                    'cat'                 => wp_get_post_categories($thisID),
		);
        }
        if($order == 'cung_tac_gia'){
        	$thisID = $wp_query->post->ID;
        	$tacgia_array = [];
		$tg = get_the_terms($thisID,'tac-gia');
		foreach($tg as $key => $tacgia){
			$tacgia_array[] = $tacgia->slug;
		}
        	$args = array(
		    'post_type'           => $loai,
		    'ignore_sticky_posts' => -1,
		    'posts_per_page'      => $post_number,
		    'post__not_in'        => array($thisID),
                    'orderby'             => 'rand',
                    'tax_query' => array(
			    'relation' => 'AND',
			      array(
			        'taxonomy' => 'tac-gia',
			        'field' => 'slug',
			        'terms' => $tacgia_array,
			        'include_children' => true,
			        'operator' => 'IN'
			      )
		     ),
		);
        }
        
        $query = new WP_Query($args);
 
        if ($query->have_posts()):
        echo '<div class="row">
		<div class="col-xs-4 col-md-2 more" style="position: absolute;right: 12px;top: 11px;height: auto!important;border: none;padding: 0px!important;">
			<a href="'.$url.'" title="'.$title.'" style="text-transform:none">Xem thêm</a>
	      	</div>
	     </div>
		<div class="list list-thumbnail col-xs-12" style="padding:0px;">
		<div class="row" style="background:#fff;padding-top:5px;margin-bottom:10px;">';
            while( $query->have_posts() ) :
                $query->the_post(); ?>

                <div id="tt" class="col-xs-4 col-sm-3 col-md-2 col-main-1-moi-cap-nhat col-main-1-truyen-full">
				<a href="<?php the_permalink()?>" title="<?php the_title()?>">
				<?php if($tiento == true){get_tien_to_2(get_the_ID());}?>
                		<div class="each_truyen">
					<img src="<?php echo tw_get_thumbnail(get_the_ID())?>" alt="<?php the_title()?>"/>
					<?php if($trangthai == true){get_trangthai_2(get_the_ID());}?>
						<div class="caption">
							<h3>
								<?php
									if($loai !== 'chap'){the_title();}
									else{echo get_the_title(wp_get_post_parent_id(get_the_ID()));}
								?>
							</h3>
							<?php
								if($loai == 'post'){
									echo '<small class="btn-xs label-primary">';
									last_update(true);
									echo '</small>';
								}
								if($loai == 'chap'){
									echo '<small class="btn-xs label-primary">';
									the_title();
									echo '</small>';
								}
							?>
						</div>
					</div>
					</a>
				</div>
 
            <?php endwhile;
        echo '</div></div>';
        endif;
        echo $after_widget;
    }
 
}
 
add_action( 'widgets_init', 'create_bt_truyen_2_widget' );
function create_bt_truyen_2_widget() {
    register_widget('BT_Truyen_2');
}