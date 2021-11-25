<?php
	$options = get_option('my_option_name');
?>
<!DOCTYPE html>
<html lang="vi">
    <head>
    	<meta charset="UTF-8"/>
    	<meta name="viewport" content="width=device-width, initial-scale=1"/>
    	<title><?php wp_title(); /*if (is_home()) { bloginfo('name'); echo ' - '; bloginfo('description'); } elseif (is_tax('tac-gia')) {echo 'Tác giả: '; single_tag_title();} elseif (is_singular('chap')) { echo get_the_title($post->post_parent); echo ' - '; the_title();} else wp_title('');*/?></title>
    	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />	
        <link href="<?php bloginfo('template_url')?>/style.css?<?php echo wp_get_theme()->get('Version'); ?>" rel="stylesheet" media="all"/>
        <link href="<?php bloginfo('template_url')?>/styles.css?<?php echo wp_get_theme()->get('Version'); ?>" rel="stylesheet" media="all"/>
        <link rel="pingback" href="<?php bloginfo('pingback_url');?>" />
        <?php wp_head();?>

        <?php echo $options['google_analytics']; ?>
        

        <script type="text/javascript">
        var site = '<?php echo home_url()?>';
        (function() {
            var po = document.createElement('script');
            po.type = 'text/javascript'; po.async = true;
            po.src = 'https://apis.google.com/js/plusone.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(po, s);
        })();
        </script>
    </head>

    <body id="body_truyen">

    	<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = 'https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.12&appId=<?php echo $options['fb_app_id']; ?>&autoLogAppEvents=1';
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
		</script>

    	<div id="wrap">
            <div class="navbar navbar-default navbar-static-top" role="navigation" id="nav">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Hiện menu</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
				<?php
					$custom_logo_id = get_theme_mod( 'custom_logo' );
					$logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
					if ( has_custom_logo() ) {
						if (is_home()) {
					        echo '<h1><a href="'.get_home_url().'" title="'.get_bloginfo('name').'"><img src="'. esc_url( $logo[0] ) .'" class="head-logo"/></a></h1>';
						} else {
							echo '<a href="'.get_home_url().'" title="'.get_bloginfo('name').'"><img src="'. esc_url( $logo[0] ) .'" class="head-logo"/></a>';
						}
					} else {
						if (is_home()) {
					        echo '<h1><a class="header-logo" href="'.get_home_url().'" title="'.get_bloginfo('name').'">'. get_bloginfo( 'name' ).'</a></h1>';
					} else {
							echo '<a class="header-logo" href="'.get_home_url().'" title="'.get_bloginfo('name').'">'. get_bloginfo( 'name' ).'</a>';
						}
					}
				?>
                    </div>
                    <div class="navbar-collapse collapse" itemscope itemtype="http://schema.org/WebSite">
                        <meta itemprop="url" content="<?php echo home_url()?>"/>
                        <ul class="control nav navbar-nav">
                            <li class="dropdown">
                                <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                                    <span class="glyphicon glyphicon-list"></span> Danh sách <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
					<?php wp_nav_menu( array( 'theme_location' => 'danh-sach' ) ); ?>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-list"></span> Thể loại <span class="caret"></span></a>
                                <div class="dropdown-menu multi-column">
                                    <div class="row">
                                        <?php
                                        $categories = get_categories('hide_empty=0&depth=1&type=post');
                                        $i = 1;
                                        ?>
                                        <div class="col-md-4">
                                            <ul class="dropdown-menu">
                                            <?php foreach($categories as $category):?>
                                                <li><a href="<?php echo get_category_link($category)?>" title="<?php echo $category->cat_name?>"><?php echo$category->cat_name?></a></li>
                                            <?php if($i % 6 == 0 && $i < count($categories)):?>
                                            </ul>
                                        </div>
                                        <div class="col-md-4">
                                            <ul class="dropdown-menu">
                                            <?php endif;?>
                                        <?php ++$i?>
                                            <?php endforeach;?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <!-- CHAP_OPTIONS -->
                <li class="header-menu"><?php wp_nav_menu( array( 'theme_location' => 'header-menu' ) ); ?></li>
                        </ul>
                         <form class="navbar-form navbar-right" action="<?php echo home_url()?>" role="search" itemprop="potentialAction" itemscope itemtype="http://schema.org/SearchAction">
                                <div class="input-group">
                                    <meta itemprop="target" content="<?php echo home_url()?>/?s={s}"/>
                                    <input class="form-control" type="text" name="s" placeholder="Tìm kiếm..." value="" onkeydown="event.stopPropagation();" itemprop="query-input" required>
                                    <div class="input-group-btn">
                                        <button class="btn btn-default" type="submit">
                                            <span class="glyphicon glyphicon-search"></span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <div class="navbar-social navbar-right visible-md visible-lg">
				<?php wp_nav_menu( array( 'theme_location' => 'social-2' ) ); ?>
                                </div>
                            <div class="navbar-social navbar-right visible-md visible-lg">
				<?php wp_nav_menu( array( 'theme_location' => 'social-1' ) ); ?>
                               </div>
                    </div>
                </div>
                <div class="navbar-breadcrumb">
                    <div class="container breadcrumb-container"><?php the_breadcrumb()?></div>
                </div>
            </div>