<?php

function register_widget_areas() {
	$options = get_option('my_option_name');
	register_sidebar( array(
		'name'          => __( 'Trang chủ: Full 1', 'boxtruyen' ),
		'id'            =>'trang-chu-full-1',
		'description'   => __( '', 'boxtruyen' ),
		'before_widget' => '<div class="list list-side list-truyen col-xs-12 col-sm-12 col-md-8 col-truyen-main col-truyen-main-full col-main-3" id="truyen-slide" style="margin-bottom: 15px;box-shadow: 0 1px 2px rgba(0, 0, 0, .1);">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="h2-custom-col">',
		'after_title' => '</h2>', ) );

	register_sidebar( array(
		'name'          => __( 'Trang chủ: Main 1', 'boxtruyen' ),
		'id'            =>'trang-chu-main-1',
		'description'   => __( '', 'boxtruyen' ),
		'before_widget' => '<div class="list list-side list-truyen col-xs-12 col-sm-12 col-md-8 col-truyen-main col-main-1" id="truyen-slide" style="margin-bottom: 15px;box-shadow: 0 1px 2px rgba(0, 0, 0, .1);">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="h2-custom-col">',
		'after_title' => '</h2>', ) );
		
	register_sidebar( array(
		'name'          => __( 'Trang chủ: 50% Trái', 'boxtruyen' ),
		'id'            =>'trang-chu-50-trai',
		'description'   => __( '', 'boxtruyen' ),
		'before_widget' => '<div class="list list-truyen list-side col-xs-12 custom-col">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="h2-custom-col">',
		'after_title' => '</h2>', ) );
		
	register_sidebar( array(
		'name'          => __( 'Trang chủ: 50% Phải', 'boxtruyen' ),
		'id'            =>'trang-chu-50-phai',
		'description'   => __( '', 'boxtruyen' ),
		'before_widget' => '<div class="list list-truyen list-side col-xs-12 custom-col">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="h2-custom-col">',
		'after_title' => '</h2>', ) );

	register_sidebar( array(
		'name'          => __( 'Trang chủ: Main 2', 'boxtruyen' ),
		'id'            =>'trang-chu-main-2',
		'description'   => __( '', 'boxtruyen' ),
		'before_widget' => '<div class="list list-side list-truyen col-xs-12 col-sm-12 col-md-8 col-truyen-main col-main-2" id="truyen-slide" style="margin-bottom: 15px;box-shadow: 0 1px 2px rgba(0, 0, 0, .1);">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="h2-custom-col">',
		'after_title' => '</h2>', ) );
		
	register_sidebar( array(
		'name'          => __( 'Trang chủ: Full 2', 'boxtruyen' ),
		'id'            =>'trang-chu-full-2',
		'description'   => __( '', 'boxtruyen' ),
		'before_widget' => '<div class="list list-side list-truyen col-xs-12 col-sm-12 col-md-8 col-truyen-main col-truyen-main-full col-main-3" id="truyen-slide" style="margin-bottom: 15px;box-shadow: 0 1px 2px rgba(0, 0, 0, .1);">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="h2-custom-col">',
		'after_title' => '</h2>', ) );
		
	register_sidebar( array(
		'name'          => __( 'Trang chủ: Sidebar', 'boxtruyen' ),
		'id'            =>'trang-chu-sidebar',
		'description'   => __( '', 'boxtruyen' ),
		'before_widget' => '<div class="list list-truyen list-side col-xs-12">',
		'after_widget' => '</div>',
		'before_title' => '<div class="title-list"><h4>',
		'after_title' => '</h4></div>', ) );
		
	register_sidebar( array(
		'name'          => __( 'Trang: Full 1', 'boxtruyen' ),
		'id'            =>'trang-full-1',
		'description'   => __( '', 'boxtruyen' ),
		'before_widget' => '<div class="list list-side list-truyen col-xs-12 col-sm-12 col-md-8 col-truyen-main col-truyen-main-full col-main-3" id="truyen-slide" style="margin-bottom: 15px;">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="h2-custom-col">',
		'after_title' => '</h2>', ) );

	register_sidebar( array(
		'name'          => __( 'Trang: Main 1', 'boxtruyen' ),
		'id'            =>'trang-main-1',
		'description'   => __( '', 'boxtruyen' ),
		'before_widget' => '<div class="list list-side list-truyen col-xs-12 col-sm-12 col-md-8 col-truyen-main col-main-2" id="truyen-slide" style="margin-bottom: 15px;box-shadow: 0 1px 2px rgba(0, 0, 0, .1);">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="h2-custom-col">',
		'after_title' => '</h2>', ) );

	register_sidebar( array(
		'name'          => __( 'Trang: Main 2', 'boxtruyen' ),
		'id'            =>'trang-main-2',
		'description'   => __( '', 'boxtruyen' ),
		'before_widget' => '<div class="list list-side list-truyen col-xs-12 col-sm-12 col-md-8 col-truyen-main col-main-2" id="truyen-slide" style="margin-bottom: 15px">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="h2-custom-col">',
		'after_title' => '</h2>', ) );
		
	register_sidebar( array(
		'name'          => __( 'Trang: Full 2', 'boxtruyen' ),
		'id'            =>'trang-full-2',
		'description'   => __( '', 'boxtruyen' ),
		'before_widget' => '<div class="list list-side list-truyen col-xs-12 col-sm-12 col-md-8 col-truyen-main col-truyen-main-full col-main-3" id="truyen-slide" style="margin-bottom: 15px;box-shadow: 0 1px 2px rgba(0, 0, 0, .1);">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="h2-custom-col">',
		'after_title' => '</h2>', ) );
		
	register_sidebar( array(
		'name'          => __( 'Trang: Sidebar', 'boxtruyen' ),
		'id'            =>'trang-sidebar',
		'description'   => __( '', 'boxtruyen' ),
		'before_widget' => '<div class="list list-truyen list-side col-xs-12">',
		'after_widget' => '</div>',
		'before_title' => '<div class="title-list"><h4>',
		'after_title' => '</h4></div>', ) );
		
	register_sidebar( array(
		'name'          => __( 'Chuyên mục: Full 1', 'boxtruyen' ),
		'id'            =>'chuyen-muc-full-1',
		'description'   => __( '', 'boxtruyen' ),
		'before_widget' => '<div class="list list-side list-truyen col-xs-12 col-sm-12 col-md-8 col-truyen-main col-truyen-main-full col-main-3" id="truyen-slide" style="margin-bottom: 15px;box-shadow: 0 1px 2px rgba(0, 0, 0, .1);">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="h2-custom-col">',
		'after_title' => '</h2>', ) );

	register_sidebar( array(
		'name'          => __( 'Chuyên mục: Main 1', 'boxtruyen' ),
		'id'            =>'chuyen-muc-main-1',
		'description'   => __( '', 'boxtruyen' ),
		'before_widget' => '<div class="list list-side list-truyen col-xs-12 col-sm-12 col-md-8 col-truyen-main col-main-2" id="truyen-slide" style="margin-bottom: 15px;box-shadow: 0 1px 2px rgba(0, 0, 0, .1);">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="h2-custom-col">',
		'after_title' => '</h2>', ) );

	register_sidebar( array(
		'name'          => __( 'Chuyên mục: Main 2', 'boxtruyen' ),
		'id'            =>'chuyen-muc-main-2',
		'description'   => __( '', 'boxtruyen' ),
		'before_widget' => '<div class="list list-side list-truyen col-xs-12 col-sm-12 col-md-8 col-truyen-main col-main-2" id="truyen-slide" style="margin-bottom: 15px">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="h2-custom-col">',
		'after_title' => '</h2>', ) );
		
	register_sidebar( array(
		'name'          => __( 'Chuyên mục: Full 2', 'boxtruyen' ),
		'id'            =>'chuyen-muc-full-2',
		'description'   => __( '', 'boxtruyen' ),
		'before_widget' => '<div class="list list-side list-truyen col-xs-12 col-sm-12 col-md-8 col-truyen-main col-truyen-main-full col-main-3" id="truyen-slide" style="margin-bottom: 15px;box-shadow: 0 1px 2px rgba(0, 0, 0, .1);">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="h2-custom-col">',
		'after_title' => '</h2>', ) );
		
	register_sidebar( array(
		'name'          => __( 'Chuyên mục: Sidebar', 'boxtruyen' ),
		'id'            =>'chuyen-muc-sidebar',
		'description'   => __( '', 'boxtruyen' ),
		'before_widget' => '<div class="list list-truyen list-side col-xs-12">',
		'after_widget' => '</div>',
		'before_title' => '<div class="title-list"><h4>',
		'after_title' => '</h4></div>', ) );
		
	register_sidebar( array(
		'name'          => __( $options['breadcrumb'] ? $options['breadcrumb'] : 'Truyện'.': Full 1', 'boxtruyen' ),
		'id'            =>'truyen-full-1',
		'description'   => __( '', 'boxtruyen' ),
		'before_widget' => '<div class="list list-side list-truyen col-xs-12 col-sm-12 col-md-8 col-truyen-main col-truyen-main-full col-main-3" id="truyen-slide" style="margin-bottom: 15px;box-shadow: 0 1px 2px rgba(0, 0, 0, .1);">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="h2-custom-col">',
		'after_title' => '</h2>', ) );

	register_sidebar( array(
		'name'          => __( $options['breadcrumb'] ? $options['breadcrumb'] : 'Truyện'.': Main 1', 'boxtruyen' ),
		'id'            =>'truyen-main-1',
		'description'   => __( '', 'boxtruyen' ),
		'before_widget' => '<div class="list list-side list-truyen col-xs-12 col-sm-12 col-md-8 col-truyen-main col-main-2" id="truyen-slide" style="margin-bottom: 15px;box-shadow: 0 1px 2px rgba(0, 0, 0, .1);">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="h2-custom-col">',
		'after_title' => '</h2>', ) );

	register_sidebar( array(
		'name'          => __( $options['breadcrumb'] ? $options['breadcrumb'] : 'Truyện'.': Main 2', 'boxtruyen' ),
		'id'            =>'truyen-main-2',
		'description'   => __( '', 'boxtruyen' ),
		'before_widget' => '<div class="list list-side list-truyen col-xs-12 col-sm-12 col-md-8 col-truyen-main col-main-2" id="truyen-slide" style="margin-bottom: 15px;box-shadow: 0 1px 2px rgba(0, 0, 0, .1);">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="h2-custom-col">',
		'after_title' => '</h2>', ) );
		
	register_sidebar( array(
		'name'          => __( $options['breadcrumb'] ? $options['breadcrumb'] : 'Truyện'.': Full 2', 'boxtruyen' ),
		'id'            =>'truyen-full-2',
		'description'   => __( '', 'boxtruyen' ),
		'before_widget' => '<div class="list list-side list-truyen col-xs-12 col-sm-12 col-md-8 col-truyen-main col-truyen-main-full col-main-3" id="truyen-slide" style="margin-bottom: 15px;box-shadow: 0 1px 2px rgba(0, 0, 0, .1);">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="h2-custom-col">',
		'after_title' => '</h2>', ) );
		
	register_sidebar( array(
		'name'          => __( $options['breadcrumb'] ? $options['breadcrumb'] : 'Truyện'.': Sidebar', 'boxtruyen' ),
		'id'            =>'truyen-sidebar',
		'description'   => __( '', 'boxtruyen' ),
		'before_widget' => '<div class="list list-truyen list-side col-xs-12">',
		'after_widget' => '</div>',
		'before_title' => '<div class="title-list"><h4>',
		'after_title' => '</h4></div>', ) );
		
		// TRUYỆN NGẮN
		
	register_sidebar( array(
		'name'          => __( $options['breadcrumb_ngan'] ? $options['breadcrumb_ngan'] : 'Truyện ngắn'.': Full 1', 'boxtruyen' ),
		'id'            =>'truyen-ngan-full-1',
		'description'   => __( '', 'boxtruyen' ),
		'before_widget' => '<div class="list list-side list-truyen col-xs-12 col-sm-12 col-md-8 col-truyen-main col-truyen-main-full col-main-3" id="truyen-slide" style="margin-bottom: 15px;box-shadow: 0 1px 2px rgba(0, 0, 0, .1);">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="h2-custom-col">',
		'after_title' => '</h2>', ) );

	register_sidebar( array(
		'name'          => __( $options['breadcrumb_ngan'] ? $options['breadcrumb_ngan'] : 'Truyện ngắn'.': Main 1', 'boxtruyen' ),
		'id'            =>'truyen-ngan-main-1',
		'description'   => __( '', 'boxtruyen' ),
		'before_widget' => '<div class="list list-side list-truyen col-xs-12 col-sm-12 col-md-8 col-truyen-main col-main-2" id="truyen-slide" style="margin-bottom: 15px;box-shadow: 0 1px 2px rgba(0, 0, 0, .1);">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="h2-custom-col">',
		'after_title' => '</h2>', ) );

	register_sidebar( array(
		'name'          => __( $options['breadcrumb_ngan'] ? $options['breadcrumb_ngan'] : 'Truyện ngắn'.': Main 2', 'boxtruyen' ),
		'id'            =>'truyen-ngan-main-2',
		'description'   => __( '', 'boxtruyen' ),
		'before_widget' => '<div class="list list-side list-truyen col-xs-12 col-sm-12 col-md-8 col-truyen-main col-main-2" id="truyen-slide" style="margin-bottom: 15px;box-shadow: 0 1px 2px rgba(0, 0, 0, .1);">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="h2-custom-col">',
		'after_title' => '</h2>', ) );
		
	register_sidebar( array(
		'name'          => __( $options['breadcrumb_ngan'] ? $options['breadcrumb_ngan'] : 'Truyện ngắn'.': Full 2', 'boxtruyen' ),
		'id'            =>'truyen-ngan-full-2',
		'description'   => __( '', 'boxtruyen' ),
		'before_widget' => '<div class="list list-side list-truyen col-xs-12 col-sm-12 col-md-8 col-truyen-main col-truyen-main-full col-main-3" id="truyen-slide" style="margin-bottom: 15px;box-shadow: 0 1px 2px rgba(0, 0, 0, .1);">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="h2-custom-col">',
		'after_title' => '</h2>', ) );
		
	register_sidebar( array(
		'name'          => __( $options['breadcrumb_ngan'] ? $options['breadcrumb_ngan'] : 'Truyện ngắn'.': Sidebar', 'boxtruyen' ),
		'id'            =>'truyen-ngan-sidebar',
		'description'   => __( '', 'boxtruyen' ),
		'before_widget' => '<div class="list list-truyen list-side col-xs-12">',
		'after_widget' => '</div>',
		'before_title' => '<div class="title-list"><h4>',
		'after_title' => '</h4></div>', ) );
		
		// TRUYỆN NGẮN
		
	register_sidebar( array(
		'name'          => __( 'Chương: Full 2', 'boxtruyen' ),
		'id'            =>'chuong-full-2',
		'description'   => __( '', 'boxtruyen' ),
		'before_widget' => '<div class="list list-side list-truyen col-xs-12 col-sm-12 col-md-8 col-truyen-main col-truyen-main-full col-main-3" id="truyen-slide" style="margin-bottom: 15px;box-shadow: 0 1px 2px rgba(0, 0, 0, .1);">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="h2-custom-col">',
		'after_title' => '</h2>', ) );

	register_sidebar( array(
		'name'          => __( 'Footer 1', 'boxtruyen' ),
		'id'            =>'col-1',
		'description'   => __( '', 'boxtruyen' ),
		'before_widget' => '<div class="custom-col">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="h2-custom-col">',
		'after_title' => '</h2>', ) );

	register_sidebar( array(
		'name'          => __( 'Footer 2', 'boxtruyen' ),
		'id'            =>'col-2',
		'description'   => __( '', 'boxtruyen' ),
		'before_widget' => '<div class="custom-col">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="h2-custom-col">',
		'after_title' => '</h2>', ) );

	register_sidebar( array(
		'name'          => __( 'Footer 3', 'boxtruyen' ),
		'id'            =>'col-3',
		'description'   => __( '', 'boxtruyen' ),
		'before_widget' => '<div class="custom-col">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="h2-custom-col">',
		'after_title' => '</h2>', ) );

	register_sidebar( array(
		'name'          => __( 'Footer Chap List', 'boxtruyen' ),
		'id'            =>'col-footer-chap-list',
		'description'   => __( '', 'boxtruyen' ),
		'before_widget' => '<div class="l-chapter">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="l-title"><span class="glyphicon glyphicon-fire"></span> ',
		'after_title' => '</h3>', ) );
}
add_action( 'widgets_init','register_widget_areas' );