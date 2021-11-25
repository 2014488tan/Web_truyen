<?php



//-----include file--------//

include_once('metabox.php');
require get_template_directory() . '/options/options.php';
require get_template_directory() . '/options/theme-options.php';
require get_template_directory() . '/options/core.php';
require get_template_directory() . '/options/fixurl/fixurl.php';
require get_template_directory() . '/options/update/update.php';

foreach(glob(get_template_directory() . "/core/*.php") as $file){
    require $file;
}

//-----theme custom-------//





add_theme_support('post-thumbnails', array('post', 'post_ngan'));
add_theme_support('post-thumbnails', array('post', 'chap'));
//add_image_size('image', 215, 322, true);
//set_post_thumbnail_size( 215, 322, true );
add_theme_support( 'custom-logo' );
add_filter('excerpt_length', 'custom_excerpt_length', 999 );
add_filter('wp_trim_excerpt', 'tw_excerpt_more' );
add_filter('parse_query', 'tw_add_filter');
add_filter('pre_get_posts', 'tw_search_filter');

add_action('init', 'tw_radio_post_type', 0);
add_action('init', 'tw_chap_post_type', 0);
add_action('init', 'error_report_type', 0);
add_action('init', 'tw_add_author', 0);
add_action('init', 'tw_add_prefix', 0);
add_action('wp_ajax_tw_ajax', 'tw_ajax');
add_action('wp_ajax_nopriv_tw_ajax', 'tw_ajax');
add_action('save_post', 'tw_save_post');
add_action('save_post', 'bt_save_post');

// xóa bộ lọc của wordpress
remove_filter( 'the_title', 'wptexturize' );





//-------function------//


function tw_show_post_type($query){
    if(!is_single() && !is_admin()){
        $post_type = array('post', 'page','post_ngan');
        $query->set('post_type', $post_type);
    }
    return $query;
}






function tw_search_filter( $query ) {
    
    if ( $query->is_search && $query->is_main_query() )
        $query->set('post_type', array('post', 'tac-gia','post_ngan'));
}






function tw_save_post($post_id){
    
    $chapterID = isset($_POST['tw_parent']) ? $_POST['tw_parent'] : false;
    if (!wp_is_post_revision($post_id) && $chapterID){
        remove_action('save_post', 'tw_save_post');
        $postdata = array(
            'ID' => $post_id,
            'post_parent' => $chapterID
        );
        wp_update_post( $postdata );
    }
}






function tw_add_filter($query){
    
    global $pagenow;
    if (is_admin() && $pagenow == 'edit.php' && isset($_GET['parent_chap']) && $_GET['parent_chap'] != '') {
        $query->query_vars['post_parent'] = $_GET['parent_chap'];
    }
}





// TW_GET_CHAP_OPTION
function tw_get_chap_option($id, $chap){
    
    $args = array(
            'post_type'      => 'chap',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'post_parent'    => $id,
            'order'          => 'ASC'
        );
    $wp_query = new wp_query($args);
    echo '<select id="chapter_jump" class="btn btn-success form-control" onchange="window.location.href=this.value">';
    while($wp_query->have_posts()){
        $wp_query->the_post();
        $title = explode(':', mb_substr(get_the_title() ,0, 23, 'utf-8'));
        echo '<option value="'.get_the_permalink().'"';
        if($chap == get_the_ID()) echo 'selected';
        echo '>'.$title[0].'</option>';
    }
    echo '</select>';
}





// TW_GET_NEXT_CHAP
function tw_get_next_chap($id){
    
    global $wpdb;
    $current_post_id = get_the_ID();
    $query = $wpdb->get_results("select * from  ".$wpdb->posts." where ID > '$current_post_id' AND post_type = 'chap' and post_parent = '$id' and post_status = 'publish' ORDER BY ID ASC LIMIT 1");
    if($query){
        foreach($query as $chap) {
            echo '<a class="btn btn-success" id="next_chap" href="'.get_the_permalink($chap->ID).'"><span class="glyphicon glyphicon-chevron-right"></span> <span class="hidden-xs">Chương</span> tiếp</a>';
        }
    }
    else
        echo '<a class="btn btn-success disabled" href="javascript:void(0)" title="Không hoặc chưa có chương tiếp theo" id="next_chap"><span class="hidden-xs">Chương</span> tiếp <span class="glyphicon glyphicon-chevron-right"></span></a>';
}





// TW_GET_PREV_CHAP
function tw_get_prev_chap($id){
    
    global $wpdb;
    $current_post_id = get_the_ID();
    $query = $wpdb->get_results("select * from  ".$wpdb->posts." where ID < '$current_post_id' AND post_type = 'chap' and post_parent = '$id' and post_status = 'publish' ORDER BY ID DESC LIMIT 1");
    if($query){
        foreach($query as $chap) {
            echo '<a class="btn btn-success" id="prev_chap" href="'.get_the_permalink($chap->ID).'"><span class="glyphicon glyphicon-chevron-left"></span> <span class="hidden-xs">Chương</span> trước</a>';
        }
    }
    else
        echo '<a class="btn btn-success disabled" href="javascript:void(0)" title="Không có chương trước" id="prev_chap"><span class="hidden-xs">Chương</span> trước <span class="glyphicon glyphicon-chevron-left"></span></a>';
}

function last_update($custom = false){
    $options = get_option('my_option_name');
    global $post;
    $args = array(
        'post_type'      => 'chap',
        'post_status'    => 'publish',
        'posts_per_page' => 1,
        'post_parent'    => $post->ID,
        'order'          => 'DESC'
    );
    $c_query = new wp_query($args);
    /* if (get_post_meta($post->ID, 'tw_status', true) == 'Hoàn Thành') {
        echo 'Full';
    }
    else { */
        if($c_query->have_posts()){
            while($c_query->have_posts()){
                $c_query->the_post();
                $title = get_the_title();
                /*preg_match_all("/([0-9]+)/", $title, $num);
                $title = str_replace($num[0], '</span>Chương <span class="chapter-text">'.$num[0].'', $title);*/
                $title = explode(':', get_the_title());
                if($custom){
                   echo $title[0];
                }
                else {
                    echo '<a title="'.get_the_title($post->post_parent).' - '.get_the_title().'" href="'.get_the_permalink().'"><span class="chapter-text"><span>'.$title[0].'</span></span></a>';
                }
            }
        }
        else {
        if(get_post_meta($post->ID,'tw_multi_chap',true) == 1){
            echo $options['chuaconoidung'] ? $options['chuaconoidung'] : 'Chưa có nội dung';
        } else {
            echo $options['chuaconoidung2'] ? $options['chuaconoidung2'] : 'Chưa có nội dung';
        }
        unset($c_query);
        }
    //}
}





// TIMEAGO
function timeago() {
    global $post;
    $date = get_post_time('G', false, $post);
    if (empty($date)) {
        return __('Pending Post');
    }
    $chunks = array(
        array(60 * 60 * 24 * 365, __('năm'), __('năm')),
        array(60 * 60 * 24 * 30, __('tháng'), __('tháng')),
        array(60 * 60 * 24 * 7, __('tuần'), __('tuần')),
        array(60 * 60 * 24, __('ngày'), __('ngày')),
        array(60 * 60, __('giờ'), __('giờ')),
        array(60, __('phút'), __('phút')),
        array(1, __('giây'), __('giây'))
    );

    if (!is_numeric($date)) {
        $time_chunks = explode(':', str_replace(' ', ':', $date));
        $date_chunks = explode('-', str_replace(' ', '-', $date));
        $date = gmmktime((int) $time_chunks[1], (int) $time_chunks[2], (int) $time_chunks[3], (int) $date_chunks[1], (int) $date_chunks[2], (int) $date_chunks[0]);
    }

    $current_time = current_time('mysql', $gmt = 0);
    $newer_date = strtotime($current_time);

    $since = $newer_date - $date;

    if (0 > $since)
        return __('sometime');
    for ($i = 0, $j = count($chunks); $i < $j; $i++) {
        $seconds = $chunks[$i][0];

        // Finding the biggest chunk (if the chunk fits, break)
        if (( $count = floor($since / $seconds) ) != 0)
            break;
    }
    // Set output var
    $output = ( 1 == $count ) ? '1 ' . $chunks[$i][1] : $count . ' ' . $chunks[$i][2];

    if (!(int) trim($output)) {
        $output = '0 ' . __('giây');
    }
    $output .= __(' trước');
    return $output;
}





// TW_AJAX
function tw_ajax(){

    switch($_POST['type']){
        case 'pagination':
            chap_pagination(intval($_POST['id']), intval($_POST['page']));
        break;
        case 'list_chap':
            tw_get_chap_option($_POST['id'], $_POST['chap']);
        break;
        default:
        case 'raty':
        $id   = $_POST['id'];
        $rate = $_POST['score'];
        echo tw_update_rate($id, $rate);
        break;
    }
    die();
}





// TW_GET_RATE
function tw_get_rate($postID){
    
    $count_key = 'tw_rate';
    $count     = get_post_meta($postID, $count_key, true);
    if($count == ''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "10";
    }
    return $count;

}





// TW_GET_TOTAL_RATE
function tw_get_total_rate($postID){
    
    $count_key = 'tw_total_rate';
    $count     = get_post_meta($postID, $count_key, true);
    if($count == ''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }
    return $count;

}





// TW_UPDATE_RATE
function tw_update_rate($postID, $rate) {
    
    //update rate
    $tw_rate = get_post_meta($postID, 'tw_rate', true);
    $tw_rate =  $tw_rate + $rate;
    update_post_meta($postID, 'tw_rate', $tw_rate);

    //update total rate
    $count     = get_post_meta($postID, 'tw_total_rate', true);
    $count++;
    update_post_meta($postID, 'tw_total_rate', $count);

    return json_encode(array('status' => 'success', 'rateCount' => $count, 'ratePoint' => ceil($tw_rate / $count)));
}





// TW_GET_VIEWS
function tw_get_views($postID){
    
    $count_key = 'tw_views_post';
    $count     = get_post_meta($postID, $count_key, true);
    if($count == ''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }
    return $count;

}





// TW_VIEWS
function tw_views($postID) {
    
    $count_key = 'tw_views_post';
    $count     = get_post_meta($postID, $count_key, true);
    if($count == ''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }
    else
    {
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}





// TW_GET_THUMBNAIL
function tw_get_thumbnail($id){

    global $post;
    if($id){
    	$post = get_post($id);
    }
    $thumbnail_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'image');
    $parent_thumbnail_src = wp_get_attachment_image_src(get_post_thumbnail_id(wp_get_post_parent_id($post->ID)), 'image');
    if($thumbnail_src)
        return $thumbnail_src[0];
    elseif($parent_thumbnail_src)
        return $parent_thumbnail_src[0];
    elseif(preg_match("/(http|https):\/\/[^\s]+(\.gif|\.jpg|\.jpeg|\.png)/is", $post->post_content, $thumb))
        return $thumb[0];
    else
        return bloginfo('template_url') . '/images/poster.png';
}





// REGISTER POST TYPE: ERROR_REPORT
function error_report_type(){
    
    $label = array(
        'name' => 'Báo lỗi',
    	'singular_name' => 'Báo lỗi',
    	'add_new' => 'Thêm báo lỗi',
    	'add_new_item' => 'Thêm báo lỗi mới',
    	'edit_item' => 'Chỉnh sửa báo lỗi',
    	'new_item' => 'Báo lỗi',
    	'view_item' => 'Xem báo lỗi',
    	'search_items' => 'Tìm báo lỗi',
    	'not_found' => 'Không có báo lỗi nào',
    	'not_found_in_trash' => 'Không có báo lỗi nào trong thùng rác',
    	'all_items' => 'Tất cả báo lỗi',
    	'menu_name' => 'Báo lỗi',
    	'name_admin_bar' => 'Báo lỗi',
    );
 
    $args = array(
        'labels'              => $label,
        'description'         => 'Tất cả báo lỗi',
        'supports'            => array( 'title', 'editor', 'parent', 'revisions', 'thumbnail',
                                ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true, 
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true, 
        'show_in_admin_bar'   => true,
        'menu_position'       => 3, 
        'menu_icon'           => 'dashicons-warning', 
        'can_export'          => true,
        'has_archive'         => false,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post'
    );
 
    register_post_type('error_report', $args);
 
}





// REGISTER POST TYPE: CHAP
function tw_chap_post_type(){
    
    $label = array(
        'name' => 'Chương',
    	'singular_name' => 'Chương',
    	'add_new' => 'Thêm chương mới',
    	'add_new_item' => 'Thêm chương mới',
    	'edit_item' => 'Chỉnh sửa chương',
    	'new_item' => 'Chương',
    	'view_item' => 'Xem chương',
    	'search_items' => 'Tìm chương',
    	'not_found' => 'Không có chương nào',
    	'not_found_in_trash' => 'Không có chương nào trong thùng rác',
    	'all_items' => 'Tất cả chương',
    	'menu_name' => 'Chương',
    	'name_admin_bar' => 'Chương',
    );
 
    $args = array(
        'labels'              => $label,
        'description'         => 'Tất cả chương',
        'supports'            => array( 'title', 'editor', 'parent', 'revisions', 'thumbnail', 'comments'
                                ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true, 
        'show_in_menu'        => false,
        'show_in_nav_menus'   => true, 
        'show_in_admin_bar'   => true,
        'menu_position'       => 5, 
        'menu_icon'           => '', 
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post'
    );
 
    register_post_type('chap', $args);
    flush_rewrite_rules();
 
}





// REGISTER TAXONOMY: TAC-GIA
function tw_add_author(){

    $args = array(
        'labels'            => array(
                                'name'      => 'Tác giả',
                                'singular'  => 'Tác giả',
                                'menu-name' => 'Tác giả',
				'all_items' => 'Tất cả tác giả',
				'edit_item' => 'Chỉnh sửa tác giả',
				'view_item' => 'Xem tác giả',
				'add_new_item' => 'Thêm tác giả',
				'new_item_name' => 'Tên tác giả',
				'parent_item' => 'Tác giả cha',
				'search_items' => 'Tìm tác giả',
				'popular_items' => 'Tác giả phổ biến',
				'separate_items_with_commas' => 'Phân tách các tác giả bằng dấu phẩy.',
				'add_or_remove_items' => 'Thêm hoặc xóa tác giả',
				'choose_from_most_used' => 'Chọn tác giả dùng nhiều nhất'
                                ),
        'hierarchical'      => false,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_tagcloud'     => true,
        'show_in_nav_menus' => true
        );

    register_taxonomy('tac-gia',array('post','post_ngan'), $args);

}





// REGISTER TAXONOMY: TIEN_TO
function tw_add_prefix(){

    $args = array(
        'labels'            => array(
                                'name'      => 'Tiền tố',
                                'singular'  => 'Tiền tố',
                                'menu-name' => 'Tiền tố',
				'all_items' => 'Tất cả tiền tố',
				'edit_item' => 'Chỉnh sửa tiền tố',
				'view_item' => 'Xem tiền tố',
				'add_new_item' => 'Thêm tiền tố',
				'new_item_name' => 'Tên tiền tố',
				'parent_item' => 'Tiền tố cha',
				'search_items' => 'Tìm tiền tố',
				'popular_items' => 'Tiền tố phổ biến',
				'separate_items_with_commas' => 'Phân tách các tiền tố bằng dấu phẩy.',
				'add_or_remove_items' => 'Thêm hoặc xóa tiền tố',
				'choose_from_most_used' => 'Chọn tiền tố dùng nhiều nhất'
                                ),
                               
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_tagcloud'     => true,
        'show_in_nav_menus' => true
        );

    register_taxonomy('tien_to',array('post','post_ngan'), $args);

}





// GET TIEN_TO AND TRANGTHAI
function get_tien_to($id){
	$tiento = get_the_terms($id,'tien_to');
	
	if(is_array($tiento)){
		foreach ($tiento as $e_tiento){
			$termid = $e_tiento->term_id;
			$name = $e_tiento->name;
			$slug = $e_tiento->slug;
			echo '<span class="tien_to tien_to_'.$slug.'">'.$name.'</span> ';
		}
	}
}

function get_trangthai($id){
	$trangthai = get_post_meta($id,'tw_status',true);
	$options = get_option('my_option_name');
	$hoanthanh = $options['trangthai_hoanthanh'] ? $options['trangthai_hoanthanh'] : 'Hoàn thành';
	if($trangthai == $hoanthanh){
		echo '<span class="tien_to trang_thai_full">'; echo $options['trangthai_hoanthanh'] ? $options['trangthai_hoanthanh'] : 'Hoàn thành'; echo '</span> ';
	}
}

function get_tien_to_2($id){
	$tiento = get_the_terms($id,'tien_to');
	
	if(is_array($tiento)){
		foreach ($tiento as $e_tiento){
			$termid = $e_tiento->term_id;
			$name = $e_tiento->name;
			$slug = $e_tiento->slug;
			echo '<span class="tien_to tien_to_2 tien_to_'.$slug.'">'.$name.'</span> ';
		}
	}
}

function get_trangthai_2($id){
	$trangthai = get_post_meta($id,'tw_status',true);
	$options = get_option('my_option_name');
	$hoanthanh = $options['trangthai_hoanthanh'] ? $options['trangthai_hoanthanh'] : 'Hoàn thành';
	if($trangthai == $hoanthanh){
		echo '<img src="'; echo bloginfo('template_url'); echo '/images/full-label.png" class="full_label"/>';
	}
}





// REGISTER POST TYPE: POST_NGAN
function tw_radio_post_type(){
    $options = get_option('my_option_name');
    $label = array(
        'name' => $options['breadcrumb_ngan'] ? $options['breadcrumb_ngan'] : 'Truyện ngắn',
    	'singular_name' => $options['breadcrumb_ngan'] ? $options['breadcrumb_ngan'] : 'Truyện ngắn',
    	'add_new' => 'Thêm '.strtolower($options['breadcrumb_ngan'] ? $options['breadcrumb_ngan'] : 'truyện ngắn').' mới',
    	'add_new_item' => 'Thêm '.strtolower($options['breadcrumb_ngan'] ? $options['breadcrumb_ngan'] : 'truyện ngắn').' mới',
    	'edit_item' => 'Chỉnh sửa '.strtolower($options['breadcrumb_ngan'] ? $options['breadcrumb_ngan'] : 'truyện ngắn'),
    	'new_item' => $options['breadcrumb_ngan'] ? $options['breadcrumb_ngan'] : 'Truyện ngắn',
    	'view_item' => 'Xem '.strtolower($options['breadcrumb_ngan'] ? $options['breadcrumb_ngan'] : 'truyện ngắn'),
    	'search_items' => 'Tìm '.strtolower($options['breadcrumb_ngan'] ? $options['breadcrumb_ngan'] : 'truyện ngắn'),
    	'not_found' => 'Không có '.strtolower($options['breadcrumb_ngan'] ? $options['breadcrumb_ngan'] : 'truyện ngắn').' nào',
    	'not_found_in_trash' => 'Không có '.strtolower($options['breadcrumb_ngan'] ? $options['breadcrumb_ngan'] : 'truyện ngắn').' nào trong thùng rác',
    	'all_items' => 'Tất cả '.strtolower($options['breadcrumb_ngan'] ? $options['breadcrumb_ngan'] : 'truyện ngắn'),
    	'menu_name' => $options['breadcrumb_ngan'] ? $options['breadcrumb_ngan'] : 'Truyện ngắn',
    	'name_admin_bar' => $options['breadcrumb_ngan'] ? $options['breadcrumb_ngan'] : 'Truyện ngắn',
    );
    
   
    
    $args = array(
        'labels'              => $label,
        'description'         => 'Tất cả '.strtolower($options['breadcrumb_ngan'] ? $options['breadcrumb_ngan'] : 'truyện ngắn'),
        'supports'            => array('title', 'editor', 'parent', 'thumbnail', 'author','revisions', 'comments'
                                ),
        'taxonomies'          => array('post_tag', 'category','tac-gia'),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true, 
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true, 
        'show_in_admin_bar'   => true,
        'menu_position'       => 5, 
        'menu_icon'           => 'dashicons-admin-post', 
        'can_export'          => true,
        'has_archive'         => false,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
	'rewrite'             => $rewrite,
        'capability_type'     => 'post'
		
    );
 
    register_post_type('post_ngan', $args);
    flush_rewrite_rules();
 
}





// EXPCERPT
function custom_excerpt_length($length){
    return 40;
}

function tw_excerpt_more( $excerpt ) {
    return str_replace( '[...]', '...', $excerpt );
}





// CHAP PAGINATION
function chap_pagination($ID_parent, $page) {
	$options = get_option('my_option_name');
	$chapnum = $options['number'];
    	$args = array(
        'post_type'      => 'chap',
        'post_status'    => 'publish',
        'posts_per_page' => $chapnum,
        'paged'          => $page,
        'post_parent'    => $ID_parent,
        'order'          => 'ASC'
        );
    $my_query = new wp_query($args);
    $html = '<div class="col-xs-12 col-sm-6 col-md-6"><ul class="list-chapter">';
    $i = 1;
    while($my_query->have_posts()){
        $my_query->the_post();
        if($i == ($chapnum+1))
            $html .= '</ul></div><div class="col-xs-12 col-sm-6 col-md-6"><ul class="list-chapter">';
        $html .= '<li>
        <span class="glyphicon glyphicon-certificate"></span>
        <a href="'.get_the_permalink().'" title="'.get_the_title($post->post_parent).' - '.get_the_title().'">
            <span class="chapter-text">'.get_the_title().'</span>
        </a>
        </li>';
        ++$i;
    }
    $html .= '</ul></div>';
    $pagination = preg_replace("/href=\"(.+?)\"/is", 'href="#"', pagination(true, $my_query->max_num_pages, $page));
    echo json_encode(array('list_chap' => $html, 'pagination' => $pagination));
}





// PAGINATION
function pagination($return = false, $max = false, $paged = false) {

    global $wp_query;

    if($wp_query->max_num_pages <= 1 && !$max)
        return 'Trang không tồn tại<br/><br/>';
    if(!$paged)
        $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
    $max   = (!$max) ? intval($wp_query->max_num_pages) : $max;
    $links[] = $paged;
    for($i = $paged; $i < $paged + 5; $i++){
        if($i <= $max && $i != $paged)
            $links[] = $i;
    }
    for($i = $paged; $i >= ($paged - 5);$i--){
        if($i >= 1 && $i != $paged)
            $links[] = $i;
    }
    $html = '<ul class="pagination pagination-sm">' . "\n";

    if ( ! in_array( 1, $links ) ) {
        $class = 1 == $paged ? ' class="active"' : '';
        $html .= '<li '.$class.'><a data-page="1" href="'.esc_url( get_pagenum_link( 1 ) ).'" title="1">Đầu</a></li>';

    }

    sort( $links );
    foreach ( (array) $links as $link ) {
        $class = $link == $paged ? ' class="active"' : '';
        $html .= '<li '.$class.'><a data-page="'.$link.'" href="'.esc_url( get_pagenum_link( $link ) ).'">'.$link.'</a></li>';
    }

    if ( ! in_array( $max, $links ) ) {
        $class = $paged == $max ? ' class="active"' : '';
        $html .= '<li '.$class.'><a data-page="'.$max.'" href="'.esc_url( get_pagenum_link( $max ) ).'" title="'.$max.'">Cuối</a></li>';
    }
    $html .= '<li class="dropup page-nav"><span href="javascript:void(0)" data-toggle="dropdown" style="cursor:pointer">Chọn trang <span class="caret"></span></span>
            <div class="dropdown-menu dropdown-menu-right" role="menu">
                <form action="." name="page_jump" id="page_jump" method="get">
                <div class="input-group">';
    if(is_category())
        $html .= '<input name="page_url" type="hidden" value="'.get_pagenum_link().'">';
    else
        $html .= '<input name="total-page" type="hidden" value="'.$max.'"><input name="page_url" type="hidden" value="'.get_pagenum_link().'">';
                    $html .= '<input class="form-control" name="page" type="number" placeholder="Số trang..." value="">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit">Đi</button>
                    </span>
                </div>
                </form>
            </div>
        </li>';
    $html .= '</ul>' . "\n";
    if($return)
        return $html;
    else
        echo $html;

}





// BREADCRUMB
function the_breadcrumb() {
    $options = get_option('my_option_name');
    $breadcrumb = $options['breadcrumb'] ? $options['breadcrumb'] : 'Truyện';
    $breadcrumb_ngan = $options['breadcrumb_ngan'] ? $options['breadcrumb_ngan'] : 'Truyện ngắn';
    global $post;
    if (!is_home()) {
        echo '<ol class="breadcrumb">';
        echo '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.get_option('home').'" accesskey="1"><span class="glyphicon glyphicon-home"></span></a><a href="'.get_option('home').'" title="Đặng Khánh Ly" itemprop="url"><span itemprop="title">Trang chủ</span></a></li>';
        if (is_single() && $post->post_type == 'post_ngan') {
            echo '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.get_option('home').'/ngan" title="'.$breadcrumb_ngan.'" itemprop="url"><span itemprop="title">'.$breadcrumb_ngan.'</span></a></li>';
            echo '<li class="active" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><h1>';
            the_title();
            echo '</h1></li>';
        }
        elseif (is_single() && $post->post_type != 'chap') {
            echo '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.get_option('home').'/moi-cap-nhat" title="'.$breadcrumb.'" itemprop="url"><span itemprop="title">'.$breadcrumb.'</span></a></li>';
            echo '<li class="active" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><h1>';
            the_title();
            echo '</h1></li>';
        }
        elseif (is_category()) {
            $cat = get_category(get_query_var('cat'), false);
            echo '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="#nav" title="Thể Loại" itemprop="url"><span itemprop="title">Thể loại</span></a></li>';
            echo '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><h1><a href="'.get_category_link($cat->term_id).'" title="'.$cat->cat_name.'" itemprop="url"><span itemprop="title">'.$cat->name.'</span></a></h1></li>';
            if(get_query_var('paged')){
                echo '<li class="active">Trang '.get_query_var('paged').'</li>';
            }
        }
        elseif (is_tax()) {
            $taxonomy = get_taxonomy(get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) )->taxonomy);
            $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); 
            echo '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="#nav" title="" itemprop="url"><span itemprop="title">'.$taxonomy->label.'</span></a></li>';
            echo '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><h1><a href="'.$term->slug.'" title="'.$term->name.'" itemprop="url"><span itemprop="title">'.$term->name.'</span></a></h1></li>';
        }
        elseif (is_tag()) {
            echo '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="#nav" title="" itemprop="url"><span itemprop="title">Thẻ</span></a></li>';
            echo '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><h1><a href="" title="'.get_queried_object()->name.'" itemprop="url"><span itemprop="title">'.get_queried_object()->name.'</span></a></h1></li>';
        }
        elseif($post->post_type == 'chap' && !is_search()){
            $id_parent = $post->post_parent;
            $parent    = get_post($id_parent);
            $title     = $parent->post_title;
            echo '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.get_option('home').'/moi-cap-nhat" title="'.$breadcrumb.'" itemprop="url"><span itemprop="title">'.$breadcrumb.'</span></a></li>';
            echo '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.get_permalink($parent).'" itemprop="url"><span itemprop="title"><h2>'.get_post($post->post_parent)->post_title.'</h2></span></a></li>';
            echo '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.get_permalink($post).'" itemprop="url"><span itemprop="title"><h1>'.$post->post_title.'</h1></span></a></li>';
        }
        elseif (is_page()) {
            echo '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="#nav" title="Thể Loại" itemprop="url"><span itemprop="title">Thể loại</span></a></li>';
            echo '<li class="active" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a title="'.get_the_title().'" itemprop="url"><span itemprop="title">'.get_the_title().'</span></a></li>';
            
        }
        elseif (is_search()) {
            global $s;
            echo '<li class="active" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a title="'.$s.'" href="/?s='.$s.'" itemprop="url"><span itemprop="title">'.$s.'</span></a></li>';
        }
        echo '</ol>';
    }
    else {
	$gioi_thieu = $options['gioi_thieu'];
        echo $gioi_thieu;
    }
}






//REWRITE URL
add_filter('post_type_link', 'tw_rewrite_chapter_link', 10, 3);
add_action('init', 'tw_add_new_rules');
function tw_rewrite_chapter_link($link, $post){
	$options = get_option('my_option_name'); $mo_rong = $options['mo_rong'];
    if($post->post_type == 'chap') {
        $parents = get_post_ancestors($post->ID);
        $parent_id = ($parents) ? $parents[count($parents) - 1] : 0;
        $parent = get_post($parent_id);
        $chapname = preg_replace('/'.$parent->post_name.'-/','',$post->post_name,1);
        $newlink = $parent->post_name . '/' . $chapname . $mo_rong;
        return home_url($newlink);
    }
    elseif($post->post_type == 'post_ngan') {
        $newlink = '/ngan/'.$post->post_name . $mo_rong;
        return home_url($newlink);
    }
    else {
        return $link;
    } 
}

function tw_add_new_rules() {
	$options = get_option('my_option_name'); $mo_rong = $options['mo_rong'];
	add_rewrite_rule('^ngan/([^/]+)'.$mo_rong.'$','index.php?post_type=post_ngan&name=$matches[1]', 'top');
	add_rewrite_rule('^tac-gia/([^/]+)'.$mo_rong.'$','index.php?tac-gia=$matches[1]', 'top');
	add_rewrite_rule('([^/]+)/([^/]+)'.$mo_rong.'$','index.php?post_type=chap&name=$matches[1]-$matches[2]', 'top');
}






// REGISTER MENU
function register_my_menu() {
  register_nav_menu('header-menu',__( 'Header: Menu trái' ));
  register_nav_menu('danh-sach',__( 'Header: Danh sách' ));
  register_nav_menu('social-1',__( 'Header: Social 1' ));
  register_nav_menu('social-2',__( 'Header: Social 2' ));
}
add_action( 'init', 'register_my_menu' );

add_filter('wp_nav_menu_args', 'prefix_nav_menu_args');
function prefix_nav_menu_args($args = ''){
    $args['container'] = false;
    return $args;
}






// CHANGE POST MENU LABEL
function revcon_change_post_label() {
    $options = get_option('my_option_name');
    global $menu;
    global $submenu;
    $menu[5][0] = $options['breadcrumb'] ? $options['breadcrumb'] : 'Truyện';
    $submenu['edit.php'][5][0] = 'Tất cả '.strtolower($options['breadcrumb'] ? $options['breadcrumb'] : 'truyện');
    $submenu['edit.php'][10][0] = 'Thêm '.strtolower($options['breadcrumb'] ? $options['breadcrumb'] : 'truyện').' mới';
}

function revcon_change_post_object() {
    $options = get_option('my_option_name');
    global $wp_post_types;
    $labels = &$wp_post_types['post']->labels;
    $labels->name = $options['breadcrumb'] ? $options['breadcrumb'] : 'Truyện';
    $labels->singular_name = $options['breadcrumb'] ? $options['breadcrumb'] : 'Truyện';
    $labels->add_new = 'Thêm '.strtolower($options['breadcrumb'] ? $options['breadcrumb'] : 'truyện').' mới';
    $labels->add_new_item = 'Thêm '.strtolower($options['breadcrumb'] ? $options['breadcrumb'] : 'truyện').' mới';
    $labels->edit_item = 'Chỉnh sửa '.strtolower($options['breadcrumb'] ? $options['breadcrumb'] : 'truyện');
    $labels->new_item = $options['breadcrumb'] ? $options['breadcrumb'] : 'Truyện';
    $labels->view_item = 'Xem '.strtolower($options['breadcrumb'] ? $options['breadcrumb'] : 'truyện');
    $labels->search_items = 'Tìm '.strtolower($options['breadcrumb'] ? $options['breadcrumb'] : 'truyện');
    $labels->not_found = 'Không có '.strtolower($options['breadcrumb'] ? $options['breadcrumb'] : 'truyện').' nào';
    $labels->not_found_in_trash = 'Không có '.strtolower($options['breadcrumb'] ? $options['breadcrumb'] : 'truyện').' nào trong thùng rác';
    $labels->all_items = 'Tất cả '.strtolower($options['breadcrumb'] ? $options['breadcrumb'] : 'truyện');
    $labels->menu_name = $options['breadcrumb'] ? $options['breadcrumb'] : 'Truyện';
    $labels->name_admin_bar = $options['breadcrumb'] ? $options['breadcrumb'] : 'Truyện';
}
 
add_action( 'admin_menu', 'revcon_change_post_label' );
add_action( 'init', 'revcon_change_post_object' );






// ADD ALL CHAP MENU
add_action('admin_menu', 'add_custom_link_into_post_menu');
function add_custom_link_into_post_menu() {
    global $submenu;
    $permalink = get_site_url().'/wp-admin/edit.php?post_type=chap';
    $submenu['edit.php'][] = array( 'Tất cả chương', 'manage_options', $permalink);
}






// UPDATE NEW CHAP THEN SORT THE STORY FIRST
function bt_save_post($post_id){
    if(get_post_type( $post_id ) == 'chap'){
    	if(wp_get_post_parent_id($post_id) > 0){
	        $my_post = array(
		      	'ID'           => wp_get_post_parent_id($post_id),
	  	);
	  	wp_update_post( $my_post );
	  	if(!get_post_thumbnail_id($post_id)){
	  		set_post_thumbnail($post_id,get_post_thumbnail_id(wp_get_post_parent_id($post_id)));
	  	}
  	}
    }
}




?>