<?php get_header(); ?>
<?php if(have_posts()) : while (have_posts()) : the_post();?>
<?php
	$parent = $post->post_parent;
	$story  = get_post($parent);
	$ID = get_the_ID();
	tw_views($parent);
	tw_views($post->ID);
?>

<div class="container chapter" style="margin-bottom:5px;">
    <div class="row">
        <div class="col-xs-12">
            <button type="button" class="btn btn-responsive btn-success toggle-nav-open"><span class="glyphicon glyphicon-menu-up"></span></button>
            <a class="truyen-title" href="<?php echo get_the_permalink($story)?>" title="<?php echo $story->post_title?>"><?php echo $story->post_title?></a>
            <h2 style="margin-bottom:10px"><a class="chapter-title" href="<?php the_permalink()?>" title="<?php echo $story->post_title?> - <?php the_title()?>"><?php the_title()?></a></h2>
			<div class="chapter-nav">
				<div class="btn-group">
					<?php tw_get_prev_chap($parent)?>
					<div class="chap_options btn btn-success"><?php require get_template_directory() . '/options/chap_options.php'; ?></div>
					<?php tw_get_next_chap($parent)?>
				</div>
			</div>
            <hr class="chapter-start"/>
            <div class="chapter-content">
                <?php the_content()?>
            </div>
            <hr class="chapter-end"/>
            <div class="chapter-nav">
                <input type="hidden" id="id_post" value="<?php echo $parent?>">
                <input type="hidden" id="chapter-id" value="<?php echo get_the_ID()?>">
                <input type="hidden" id="chapter-num" value="<?php echo get_the_ID()?>">
                <div class="btn-group">
                    <?php tw_get_prev_chap($parent)?>
                    <button type="button" class="btn btn-success" id="chapter_jump"><span class="glyphicon glyphicon-list-alt"></span></button>
                    <?php tw_get_next_chap($parent)?>
                </div>
                <button type="button" class="btn btn-warning" id="chapter_error"><span class="glyphicon glyphicon-exclamation-sign"></span> Báo lỗi chương</button>
                <div class="bg-info text-center visible-md visible-lg box-notice">Bạn có thể dùng phím mũi tên để lùi/sang chương. Các phím WASD cũng có chức năng tương tự như các phím mũi tên.</div>
            </div>
        </div>
    </div>
</div>

<div class="container col-main-full" id="truyen-slide">
		<?php dynamic_sidebar('chuong-full-2'); ?>
</div>

<?php endwhile;?>
<?php endif;?>
<?php

	if(isset($_POST["type"])){
		$my_post = array(
		  'post_title'    => $_POST["title"],
		  'post_content'  => 'ID: '.$_POST["id"].' - '.$_POST["message"],
		  'post_status'   => 'publish',
		  'post_type'     => 'error_report'
		);
		wp_insert_post($my_post);
	}
?>
<?php get_footer(); ?>