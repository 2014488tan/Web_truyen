<?php
	$options = get_option('my_option_name');
		$so_truyen_cung_tac_gia = $options['so_truyen_cung_tac_gia'];
		$so_truyen_dang_hot = $options['so_truyen_dang_hot'];
?>
		<?php if (is_single()){ 
		if( has_term($ID_parent, 'tac-gia')) { ?>
		<div class="list list-truyen col-xs-12">
			<div class="title-list"><h4><span class="glyphicon glyphicon-list"></span> Cùng tác giả</h4></div>
			<?php
				$term = get_the_terms($ID_parent, 'tac-gia');
				foreach($term as $t){
					$search = $t->slug;
				}
				$args = array(
					'post_type'      => 'post',
					'post_status'    => 'publish',
					'posts_per_page' => $so_truyen_cung_tac_gia,
					'post__not_in'   => array($ID_parent),
					'ignore_sticky_posts' => -1,
					'order'          => 'rand',
					'tax_query'      => array(
						array(
							'taxonomy' => 'tac-gia',
							'field' => 'slug',
							'terms' => $search
							)
						),
					);
				$list = new wp_query($args);
			?>
			<?php while($list->have_posts()):?>
			<?php 
			$list->the_post();
			?>
			<div class="row">
				<div class="col-xs-12">
					<span class="glyphicon glyphicon-chevron-right"></span>
					<a href="<?php the_permalink()?>" title="<?php the_title()?>"><?php the_title()?></a>
				</div>
			</div>
			<?php endwhile;?>
		</div>
		<?php }
		}
		elseif(is_home()){ ?>
			<div class="list list-truyen list-cat col-xs-12">
            <div class="title-list"><h4><span class="glyphicon glyphicon-list"></span> Thể loại</h4></div>
            <div class="row">
                <?php $categories = get_categories('hide_empty=0&depth=1&type=post');?>
                <?php foreach($categories as $cat):?>
                <div class="col-xs-6">
                    <a href="<?php echo get_category_link($cat)?>" title="<?php echo $cat->cat_name?>"><?php echo $cat->cat_name; ?></a>
                </div>
                <?php endforeach;?>
            </div>
        </div>
		<?php }
		else { ?>
			<div class="panel cat-desc text-left">
            <div class="panel-body">
                <?php if(is_page('hoan-thanh')){echo "Danh sách các truyện đã hoàn thành, ra đủ chương."; }
				elseif(is_page('xem-nhieu')){echo "Danh sách các truyện đang hot, có nhiều người đọc và quan tâm nhất."; }
				elseif(is_page('moi-cap-nhat')){echo "Danh sách các truyện được cập nhật (vừa ra mắt, thêm chương mới, sửa nội dung,..) gần đây. ";}
				elseif(is_search()){echo 'Danh sách các truyện liên quan tới "'.$s.'"';}
				elseif(is_tax('tac-gia')){echo "Giới thiệu về tác giả và danh sách các tác phẩm của tác giả "; single_tag_title();}
				else{ echo category_description();}
				?>
            </div>
        </div>
        <div class="list list-truyen list-cat col-xs-12">
            <div class="title-list"><h4><span class="glyphicon glyphicon-list"></span> Thể loại</h4></div>
            <div class="row">
                <?php $categories = get_categories('hide_empty=0&depth=1&type=post');?>
                <?php foreach($categories as $cat):?>
                <div class="col-xs-6">
                    <a href="<?php echo get_category_link($cat)?>" title="<?php echo $cat->cat_name?>"><?php echo $cat->cat_name; ?></a>
                </div>
                <?php endforeach;?>
            </div>
        </div>
		<?php }	?>
		<div class="ads-300-250"><?php dynamic_sidebar('qc-300x250'); ?></div>
        <div class="list list-truyen list-side col-xs-12">
            <div class="title-list">
                <h4><span class="glyphicon glyphicon-list"></span> Bảng xếp hạng</h4>
            </div>
            <?php 
		$i=1;
                $args = array(
                    'post_type'      => 'post',
                    'post_status'    => 'publish',
                    'posts_per_page' => $so_truyen_dang_hot,
                    'post__not_in'   => array($ID_parent),
                    'orderby'        => 'meta_value_num',
                    'meta_key'       => 'tw_views_post',
    'ignore_sticky_posts' => -1,
                    'order'          => 'DESC'
                    );
                $list = new wp_query($args);
            ?>
            <?php while($list->have_posts()):?>
            <?php $list->the_post();?>
			<div class="row top-item" itemscope="" itemtype="http://schema.org/Book">
                <div class="col-xs-12">
					<div class="top-num top-<?php echo $i;?>"><?php echo $i;?></div>
					<div class="s-title">
						<h3 itemprop="name">
							<a href="<?php the_permalink()?>" itemprop="url" title="<?php the_title()?>"><?php the_title()?></a>
						</h3>
					</div>
					<div>
						<?php the_category(', ', true )?>
					</div>
                </div>
            </div>
            <?php $i++; endwhile;?>
        </div>
        <div class="ads-300-600"><?php dynamic_sidebar('qc-300x600'); ?></div>
	<?php dynamic_sidebar('widget'); ?>