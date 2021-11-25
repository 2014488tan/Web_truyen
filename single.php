<?php get_header(); ?>
<?php if(have_posts()):?>
<?php while (have_posts()):?>
<?php
	the_post();
	$ID_parent = get_the_ID();
	/*tw_views($ID_parent);*/
	$total_rate = tw_get_total_rate(get_the_ID());
	if($total_rate == 0)
	    $rate = 10;
	else
	    $rate = round((tw_get_rate(get_the_ID())/$total_rate), 1);
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
		<?php dynamic_sidebar('truyen-full-1'); ?>
</div>

<div class="container" id="truyen">
    <div class="hidden-xs hidden-sm col-md-3 text-center col-truyen-side">
       <?php dynamic_sidebar('truyen-sidebar');?>
    </div>
    
    <?php dynamic_sidebar('truyen-main-1'); ?>

    <div class="col-xs-12 col-sm-12 col-md-9 col-truyen-main col-truyen-main-single">
        <div class="row">
            <div class="col-xs-12 col-info-desc" itemscope itemtype="http://schema.org/Book">
                <div class="title-list"><h2 class="single_title"><span class="glyphicon glyphicon-info-sign"></span> <?php echo get_the_title($ID_parent);?></h2></div>
                <div class="col-xs-12 col-sm-4 col-md-4 info-holder">
                    <div class="books">
                        <div class="book">
                            <img src="<?php echo tw_get_thumbnail($ID_parent)?>" alt="<?php echo get_the_title($ID_parent);?>" itemprop="image">
                        </div>
                    </div>
                    <div class="info">
                        <div><h3>Tác giả:</h3><?php
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
                    	?></div>
                        <div><h3>Thể loại:</h3><?php the_category(', ')?></div>
                        <div><h3>Trạng thái:</h3><span class="text-primary"><?php echo get_post_meta($ID_parent, 'tw_status', true)?></span></div>
                        <div><h3>Lượt xem:</h3><span class="text-primary"><?php tw_views($ID_parent);?><?php echo tw_get_views(get_the_ID())?></span></div>
                        <div><?php echo get_the_tag_list('<h3 style="vertical-align: top;padding-top: 2px">Thẻ:</h3> <span class="text-primary" style="max-width:68%">',', ','</span>');?></div>
                        <div class="single_tien_to"><?php get_tien_to_2($ID_parent); ?></div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-8 col-md-8 desc">
                    <h3 class="title" itemprop="name"><?php the_title()?></h3>
                    <div class="rate">
                        <div class="rate-holder" data-score="<?php echo $rate?>"></div><em class="rate-text"></em>
                        <div class="small" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating"><em>Đánh giá: <strong><span itemprop="ratingValue"><?php echo $rate?></span></strong>/<span class="text-muted" itemprop="bestRating">10</span> từ <strong><span itemprop="ratingCount"><?php echo $total_rate?></span> lượt</strong></em></div>
                    </div>
                    <div class="desc-text" itemprop="about">
                        <?php if(get_post_meta($ID_parent, 'tw_multi_chap', true) != 1):?>
                        <?php
	                        $contents = mb_substr(get_info($ID_parent,'post_content'), 0, 600, 'utf-8');
	                        $contents = preg_replace('/\n/','<br/>',$contents);
	                        echo $contents.'...';
                        ?>
                    </div>
                        <?php else:?>
                        <?php
	                        $contents = get_info($ID_parent,'post_content');
	                        $contents = preg_replace('/\n/','<br/>',$contents);
	                        echo $contents;
                        ?>
                    </div>
                    <div class="showmore">
                        <a class="btn btn-default btn-xs hide" href="javascript:void(0)" title="Xem thêm">Xem thêm »</a>
                    </div>
                    <div class="l-chapter">
                        <h3 class="l-title">
                            <span class="glyphicon glyphicon-fire"></span> Các chương mới nhất</h3>
                        <ul class="l-chapters">
                            <?php
                            $args = array(
                                'post_type'      => 'chap',
                                'post_status'    => 'publish',
                                'ignore_sticky_posts' => -1,
                                'posts_per_page' => $so_chuong_moi,
                                'post_parent'    => $ID_parent,
                                'order'          => 'DESC'
                                );
                            $last_query = new wp_query($args);
                            while($last_query->have_posts()){
                                $last_query->the_post();
                            ?>
                            <li>
                                <span class="glyphicon glyphicon-certificate"></span>
                                <a href="<?php the_permalink()?>" title="<?php the_title()?>">
                                    <span class="chapter-text"><?php the_title()?></span>
                                </a>
                            </li>
                            <?php }?>
                        </ul>
                    </div>
                    <?php endif;?>
                    <?php dynamic_sidebar('col-footer-chap-list');?>
                </div>
            </div>
        </div>
        <div class="row text-center">
            <div class="hidden-xs hidden-sm hidden-md">
                <div class="ads-780-90"><?php dynamic_sidebar('qc-780x90');?></div>
            </div>
            <div class="hidden-lg">
                <div class="ads-320-100"><?php dynamic_sidebar('qc-320x100');?></div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12" id="list-chapter">
                <?php if(get_post_meta($ID_parent, 'tw_multi_chap', true) != 1):?>
                <div class="truyen_khong_chuong">
                	<?php
                		$contents = get_info($ID_parent,'post_content');
	                        $contents = preg_replace('/\n/','<br/>',$contents);
	                        echo $contents;
                	?>
                </div>
                <?php else:?>
                <div class="title-list"><h2><span class="glyphicon glyphicon-list"></span> Danh sách chương</h2></div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6" style="padding-bottom:15px">
                        <ul class="list-chapter">
                            <?php
                            $args = array(
                                'post_type'      => 'chap',
                                'post_status'    => 'publish',
                                'ignore_sticky_posts' => -1,
                                'posts_per_page' => $chapnum,
                                'post_parent'    => $ID_parent,
                                'order'          => 'ASC'
                                );
                            $wp_query = new wp_query($args);
                            $i = 1;
                            ?>
                            <?php while($wp_query->have_posts()):?>
                            <?php 
                            $wp_query->the_post();
                            ?>
                            <li>
                                <span class="glyphicon glyphicon-certificate"></span>
                                <a href="<?php the_permalink()?>" title="<?php the_title()?>">
                                    <span class="chapter-text"><?php the_title()?></span>
                                </a>
                            </li>
                            <?php ++$i?>
                            <?php if($i == ($chapnum+1)):?>
                        </ul>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <ul class="list-chapter">
                            <?php endif;?>
                            <?php endwhile;?>
                        </ul>
                    </div>
                </div>
                <div id="pagination"><?php pagination()?></div>
                <?php wp_reset_query();?>
                <?php endif;?>
            </div>
        </div>
    </div>
    <?php dynamic_sidebar('truyen-main-2'); ?>
</div>

<div class="container col-main-full" id="truyen-slide">
		<?php dynamic_sidebar('truyen-full-2'); ?>
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