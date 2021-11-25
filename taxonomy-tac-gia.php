<?php get_header();
$options = get_option('my_option_name');
$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); 
?>

<div class="container" id="truyen-slide" style="margin-bottom:15px">
    <div class="col-xs-12 col-sm-12 col-md-9 col-truyen-main">
    
    	<!-- info -->
    	<div class="row">
            <div class="list list-thumbnail col-xs-12">
                <div class="row" style="background:#fff;text-align: left;text-transform: uppercase;">
                    <div class="col-xs-12" style="border-bottom: 1px solid #DDD !important;"><h2 style="text-align: left;text-transform: uppercase;width: 100%;"><span class="glyphicon glyphicon-user"></span> <?php single_tag_title()?></h2></div>
                </div>
                <div class="row" style="background:#fff">
	                <div class="info_tac_gia" style="line-height: normal;padding: 15px;text-align: unset;">
	                	<?php echo tag_description();?>
	                </div>
                </div>
            </div>
        </div>
        
        <div style="padding-bottom:15px"></div>
        <!-- end info -->
        
    	<!-- post -->
    	<?php if($_GET['type'] !== 'ngan'):?>
        <div class="row">
            <div class="list list-thumbnail col-xs-12">
                <div class="row" style="background:#fff;text-align: left;text-transform: uppercase;">
                    <div class="col-xs-12" style="border-bottom: 1px solid #DDD !important;">
                    	<a href="?type=post" style="float: right;position: relative;right: 5px;font-size: 12px;font-family: 'Roboto Condensed', sans-serif;top: 20px;">Tất cả</a>
                    	<h2 style="text-align: left;text-transform: uppercase;width: 100%;"><span class="glyphicon glyphicon-list"></span> <?php echo $options['breadcrumb'] ? $options['breadcrumb'] : 'Truyện'; ?></h2>
                    </div>
                </div>
                <div class="row" style="background:#fff">
                <?php
                	$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
                	$args = array(
                	    'tax_query' => array(
			            array(
			                'taxonomy' => 'tac-gia',
			                'field' => 'slug',
			                'terms' => $term->slug,
			            )
			    ),
			    'post_type'    => 'post',
	    		    'paged'        => $paged,
			);
			$wp_query = new wp_query($args);
                ?>
                <?php while($wp_query->have_posts()):?>
                <?php the_post();?>
                    <div class="col-md-3 col-sm-6 col-xs-6 home-truyendecu">
                        <a href="<?php the_permalink()?>" title="<?php the_title()?>">
                            <img src="<?php echo tw_get_thumbnail(get_the_ID())?>" alt="<?php the_title()?>">
                            <div class="caption">
                                <h3><?php the_title()?></h3>
                                <small class="btn-xs label-primary"><?php last_update(true)?></small>
                            </div>
                        </a>
                    </div>
                <?php endwhile;?>
                </div>
            </div>
            <?php if($_GET['type'] == 'post'):?>
            <div class="row category">
	            <div class="col-xs-12">
	                <div class="row" style="text-align:center;">
	                    <?php pagination();?>
	                </div>
	            </div>
	    </div>
	    <?php endif;?>
        </div>
        
        <div style="padding-bottom:15px"></div>
        <?php endif;?>
        <!-- end post -->
        
        <!-- post_ngan -->
        <?php if($_GET['type'] !== 'post'):?>
        <div class="row">
            <div class="list list-thumbnail col-xs-12">
                <div class="row" style="background:#fff;text-align: left;text-transform: uppercase;">
                    <div class="col-xs-12" style="border-bottom: 1px solid #DDD !important;">
                    	<a href="?type=ngan" style="float: right;position: relative;right: 5px;font-size: 12px;font-family: 'Roboto Condensed', sans-serif;top: 20px;">Tất cả</a>
                    	<h2 style="text-align: left;text-transform: uppercase;width: 100%;"><span class="glyphicon glyphicon-list"></span> <?php echo $options['breadcrumb_ngan'] ? $options['breadcrumb_ngan'] : 'Truyện ngắn'; ?></h2>
                    </div>
                </div>
                <div class="row" style="background:#fff">
                <?php
                	$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
                	$args = array(
			    'post_type' => 'post_ngan',
			    'tax_query' => array(
			            array(
			                'taxonomy' => 'tac-gia',
			                'field' => 'slug',
			                'terms' => $term->slug,
			            )
			    ),
	    		    'paged'        => $paged,
			);
			$wp_query = new wp_query($args);
                ?>
                <?php while($wp_query->have_posts()):?>
                <?php the_post();?>
                    <div class="col-md-3 col-sm-6 col-xs-6 home-truyendecu">
                        <a href="<?php the_permalink()?>" title="<?php the_title()?>">
                            <img src="<?php echo tw_get_thumbnail(get_the_ID())?>" alt="<?php the_title()?>">
                            <div class="caption">
                                <h3><?php the_title()?></h3>
                            </div>
                        </a>
                    </div>
                <?php endwhile;?>
                </div>
            </div>
            <?php if($_GET['type'] == 'ngan'):?>
            <div class="row category">
	            <div class="col-xs-12">
	                <div class="row" style="text-align:center;">
	                    <?php pagination();?>
	                </div>
	            </div>
	    </div>
	    <?php endif;?>
        </div>
        <?php endif;?>
        <!-- end post_ngan -->
        
    </div>
    <div class="hidden-xs hidden-sm col-md-3 text-center col-truyen-side">
       <?php dynamic_sidebar('trang-sidebar');?>
    </div>
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

<?php get_footer(); 