<?php get_header();?>
<?php if(have_posts()):?>

<div class="container col-main-full" id="truyen-slide">
		<?php dynamic_sidebar('trang-full-1'); ?>
</div>

<div class="container" id="truyen-slide">
    <div class="hidden-xs hidden-sm col-md-3 text-center col-truyen-side">
        <?php dynamic_sidebar('trang-sidebar');?>
    </div>
    
    <?php dynamic_sidebar('trang-main-1'); ?>

    <div class="col-xs-12 col-sm-12 col-md-9 col-truyen-main" style="margin-bottom: 15px">
        <div class="row">
            <div class="list list-thumbnail col-xs-12">
                <div class="row" style="background:#fff;text-align: left;text-transform: uppercase;">
                    <div class="col-xs-12" style="border-bottom: 1px solid #DDD !important;"><h2 style="text-align: left;text-transform: uppercase;width: 100%;"><span class="glyphicon glyphicon-list"></span> Từ khóa: <?php echo $s?></h2></div>
                </div>
                <div class="row" style="background:#fff">
                <?php while($wp_query->have_posts()):?>
                <?php $wp_query->the_post();?>
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
        </div>
        <div class="row category">
            <div class="col-xs-12">
                <div class="row" style="text-align:center;">
                    <?php pagination();?>
                </div>
            </div>
        </div>
    </div>
    
    <?php dynamic_sidebar('trang-main-2'); ?>
    
</div>

<div class="container col-main-full" id="truyen-slide">
		<?php dynamic_sidebar('trang-full-2'); ?>
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
<?php endif;?>
<?php get_footer(); 