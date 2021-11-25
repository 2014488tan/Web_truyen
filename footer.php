</div>
<div class="footer">
	<div class="container">
		<div class="hidden-xs col-sm-6 foot-gioithieu">
			<?php $options = get_option('my_option_name');  echo $options['foot_left'];?>
		</div>
		<ul class="col-xs-12 col-sm-6 list-unstyled">
			<li class="text-right pull-right">
			<?php echo $options['foot_right'];?>
			</li>
			<li class="hidden-xs" style="display:<?php echo $options['select_middle_foot'];?>"><?php
                $args = array(
                  'orderby'       => 'DESC',
                  'post_type'     => 'post',
    		  'ignore_sticky_posts' => -1,
                  'showposts'     => $options['select_middle_foot_count'],
                  'cache_results' => true
                );
                $my_query = new wp_query($args);
                while($my_query->have_posts()){
                  $my_query->the_post();
                  ?>
        <a href="<?php the_permalink()?>" style="font-size:12px">
        <?php the_title('', ', ');?>
        </a>
        <?php }?>
		</li>
		</ul>
	</div>
</div>
<script>siteurl = '<?php echo get_site_url();?>';</script>
<script src="<?php bloginfo('template_url')?>/js/main.js"></script>
<?php wp_footer(); ?>
</body>
</html>