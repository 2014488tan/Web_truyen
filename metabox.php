<?php
class tw_metabox {
	
	public function __construct() {
		add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
		add_action('save_post', array($this, 'save_meta_boxes'));
	}
	
	public function add_meta_boxes() {
		$this->add_meta_box('form', 'Chương', 'post');
		$this->add_meta_box('form2', 'Chương', 'chap');
		$this->add_meta_box('page', 'Tùy chọn hiển thị', 'page');
	}
	
	public function add_meta_box($id, $label, $post_type) {
	add_meta_box( 
	    'tw_' . $id,
	    $label,
	    array($this, $id),
	    $post_type
	 );
	}
	
	public function save_meta_boxes($post_id)
	{
		if(defined( 'DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return;
		}
		
		foreach($_POST as $key => $value) {
			if(strstr($key, 'tw_')) {
				if(!$value){ $value = 0;}
				update_post_meta($post_id, $key, $value);
			}
		}
		
		if($_POST['show_tien_to']){
			update_post_meta($post_id, 'show_tien_to', 1);
		} else {
			update_post_meta($post_id, 'show_tien_to', 0);
		}
		
		if($_POST['show_trangthai']){
			update_post_meta($post_id, 'show_trangthai', 1);
		} else {
			update_post_meta($post_id, 'show_trangthai', 0);
		}
	}
	
	public function form() {

		global $post;
		$tw_multi_chap = get_post_meta($post->ID, 'tw_multi_chap', true);
		$tw_status = get_post_meta($post->ID, 'tw_status', true);
		$options = get_option('my_option_name');

		echo'<div class="tw_custom" style="line-height: 30px;">
		        <input type="radio" name="tw_multi_chap" value="1" ';
		        if($tw_multi_chap == 1)
		            echo 'checked="checked"';
		echo'> Có chương<br/>';
		echo'<input type="radio" name="tw_multi_chap" value="0" ';
		        if($tw_multi_chap == 0)
		            echo 'checked="checked"';
		echo'> Không chương<br/>';
		echo '<b>Trạng thái</b>: <select name="tw_status">';
		$hoanthanh = $options['trangthai_hoanthanh'] ? $options['trangthai_hoanthanh'] : 'Hoàn thành';
		if($tw_status == $hoanthanh){
			echo '<option selected="selected">';
			echo $options['trangthai_hoanthanh'] ? $options['trangthai_hoanthanh'] : 'Hoàn thành'; 
			echo '</option><option>'; 
			echo $options['trangthai_dangcapnhat'] ? $options['trangthai_dangcapnhat'] : 'Đang cập nhật'; 
			echo '</option>';
		}
		else {
			echo '<option>';
			echo $options['trangthai_hoanthanh'] ? $options['trangthai_hoanthanh'] : 'Hoàn thành';
			echo '</option><option selected="selected">';
			echo $options['trangthai_dangcapnhat'] ? $options['trangthai_dangcapnhat'] : 'Đang cập nhật';
			echo '</option>';
		}
		echo '</select><div style="padding:5px"></div>';
		if($tw_multi_chap == 1){
			echo '<a href="post-new.php?post_type=chap&id_story='.$post->ID.'" class="button button-primary button-large">Thêm chương</a>';
			echo '<span style="float:right;"><a href="edit.php?post_type=chap&parent_chap='.$post->ID.'" class="button button-primary button-large">Danh sách</a></span>';
		}
		echo '</div>';
	}


	public function form2() {

		$id_story = abs(intval($_GET['id_story']));
		if($id_story == 0){
			global $post;
			$id_story = $post->post_parent;
		}
	        $story = get_post($id_story);
	        echo '<div class="tw_custom">';
	        echo '<input type="hidden" name="tw_parent" value="'.$id_story.'"/>';
	        echo '<b>Truyện chính</b> : <a href="/?p='.$id_story.'" target="_blank"><span style="color:green;font-style:bold;">'.$story->post_title.'</span> </a> <a style="margin-left:10px;" class="button button-small" href="post.php?post='.$id_story.'&action=edit"> Chỉnh sửa</a>';
	        echo '</div>';
	        echo '<a href="post-new.php?post_type=chap&id_story='.$id_story.'" class="button button-primary button-large">Thêm chương</a>';
	        echo '<span style="float:right;"><a href="edit.php?post_type=chap&parent_chap='.$id_story.'" class="button button-primary button-large">Danh sách</a></span>';
	        ?>
	        <script type="text/javascript">
	        var parent = "<?php echo $story->post_title?>";
	        document.getElementById('title').addEventListener('keyup', tw_set_slug_chap, false);
	        function tw_set_slug_chap(){
	        	var tw_url = document.getElementById('title').value;
	        	document.getElementById('post_name').value = parent + "-" + tw_url;
	        }
			$('#publish').click(function(){
	        	var parent = "<?php echo $story->post_title?>";
	        	var tw_url = document.getElementById('title').value;
	        	document.getElementById('post_name').value = parent + "-" + tw_url;
			});
	        </script>
        <?php
	}
	
	public function page() {
		global $post;
		$show_tien_to = get_post_meta($post->ID, 'show_tien_to', true);
		echo '<input type="checkbox" value="1" name="show_tien_to"'; if($show_tien_to == '1') echo 'checked="checked"'; echo '/> Tiền tố';
		$show_trangthai = get_post_meta($post->ID, 'show_trangthai', true);
		echo '<span style="padding:0px 20px;"></span><input type="checkbox" value="1" name="show_trangthai"'; if($show_trangthai == '1') echo 'checked="checked"'; echo '/> Hoàn thành';
		
	}

}

$metaboxes = new tw_metabox;
?>