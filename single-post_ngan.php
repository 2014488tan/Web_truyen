<?php get_header(); ?>
<?php if(have_posts()):?>
<?php while (have_posts()):?>
<?php
	the_post();
	$ID_parent = get_the_ID();
	tw_views($ID_parent);
?>
<?php
	function get_info($id,$info){
		$result = get_post($id);
		$result = $result->$info;
		return $result;
	}
?>
<input id="id_post" type="hidden" value="<?php echo $ID_parent?>">

<div class="container col-main-full" id="truyen-slide">
		<?php dynamic_sidebar('truyen-ngan-full-1'); ?>
</div>

<div class="container" id="truyen">

    <div class="hidden-xs hidden-sm col-md-3 text-center col-truyen-side">
       <?php dynamic_sidebar('truyen-ngan-sidebar');?>
    </div>
    
    <?php dynamic_sidebar('truyen-ngan-main-1'); ?>
    
    <div class="col-xs-12 col-sm-12 col-md-9 col-truyen-main" style="margin-bottom: 10px">
        <div class="row">
            <div class="col-xs-12 col-info-desc" itemscope itemtype="http://schema.org/Book">
                <div class="title-list"><h2><span class="glyphicon glyphicon-info-sign"></span> <?php echo get_info($ID_parent,'post_title')?></h2></div>
                <div class="col-xs-12" style="padding: 0px;">
                    Đăng bởi: <span class="fix_color">
                    <?php
                    	if(get_the_terms($ID_parent,'tac-gia')){
	                    		$tacgia = get_the_terms($ID_parent,'tac-gia');
	                    		$last_key = end(array_keys($tacgia));
	                    		foreach($tacgia as $key => $tacgia){
	                    			if($key == $last_key){ echo '<a href="'.get_site_url().'/tac-gia/'.$tacgia->slug.'" title="'.$tacgia->name.'">'.$tacgia->name.'</a>'; }
	                    			else { echo '<a href="'.get_site_url().'/tac-gia/'.$tacgia->slug.'" title="'.$tacgia->name.'">'.$tacgia->name.'</a>, '; }
	                    		}
	                    	} else {
                    		echo get_the_author($ID_parent);
                    	};
                    ?>
                    	      </span> - lúc: <span class="fix_color"><?php echo get_the_time('H:i:s -
 d/m/Y',$ID_parent);?>
 			      </span> - tại: <span class="fix_color"><?php $category = get_the_category($ID_parent); $last_key = end(array_keys($category)); foreach($category as $key => $cd){ if($key == $last_key){ echo $cd->cat_name; } else { echo $cd->cat_name.', '; } } ?></span>
		<br/>
		Đọc: <?php echo tw_get_views($ID_parent)?>
		<div class="single_ngan_tien_to"><?php get_tien_to_2($ID_parent); ?></div>
                    <img class="image_ngan" src="<?php echo tw_get_thumbnail($ID_parent)?>" alt="<?php the_title()?>" itemprop="image"/>
                    <div class="content_ngan">
                    	<?php
                    		$contents = get_info($ID_parent,'post_content');
	                        $contents = preg_replace('/\n/','<br/>',$contents);
	                        echo $contents;
                    	?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php dynamic_sidebar('truyen-ngan-main-2'); ?>
</div>

<div class="container col-main-full" id="truyen-slide">
		<?php dynamic_sidebar('truyen-ngan-full-2'); ?>
</div>

<div class="container" id="truyen-slide">
		<div class="col-duoi">
			<div class="in-col-duoi col-duoi-2">
				<?php dynamic_sidebar('col-1'); ?>
			</div>
			<div class="in-col-duoi col-duoi-3">
				<?php dynamic_sidebar('col-2'); ?>
			</div>
			<div class="in-col-duoi col-duoi-4">
				<?php dynamic_sidebar('col-3'); ?>
			</div>
		</div>
</div>
<?php endwhile;?>
<?php endif;?>
<?php get_footer(); ?>