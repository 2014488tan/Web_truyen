<?php get_header(); ?>

<div class="container col-main-full" id="truyen-slide">
		<?php dynamic_sidebar('trang-chu-full-1'); ?>
</div>

<div class="container" id="list-index">

	<div class="visible-md-block visible-lg-block col-md-4 text-center col-truyen-side">
		<?php dynamic_sidebar('trang-chu-sidebar');?>
	</div>

	<?php dynamic_sidebar('trang-chu-main-1'); ?>

	<div class="list list-truyen col-xs-12 col-sm-12 col-md-8 col-truyen-main">

		<div class="col-tren">
			<div class="in-col-tren col-tren-1">
				<?php dynamic_sidebar('trang-chu-50-trai'); ?>
			</div>
			<div class="in-col-tren col-tren-2">
				<?php dynamic_sidebar('trang-chu-50-phai'); ?>
			</div>
		</div>
	</div>

	<?php dynamic_sidebar('trang-chu-main-2'); ?>

</div>



<div class="container col-main-full" id="truyen-slide">
		<?php dynamic_sidebar('trang-chu-full-2'); ?>
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

<?php get_footer(); ?>