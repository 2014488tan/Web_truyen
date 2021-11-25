<?php get_header(); ?>
<?php
	$pid = get_the_ID();
	function get_info($id,$info){
		$result = get_post($id);
		$result = $result->$info;
		return $result;
	}
?>
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
                    <div class="col-xs-12" style="border-bottom: 1px solid #DDD !important;"><h2 style="text-align: left;text-transform: uppercase;width: 100%;"><span class="glyphicon glyphicon-list"></span> <?php echo get_info($pid,'post_title');?></h2></div>
                </div>
                <div class="row" style="background:#fff">
                	<?php echo get_info($pid,'post_content');?>
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

<?php get_footer();?>