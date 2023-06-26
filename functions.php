<?php
define('BG_THEME_VER', '1.0');
define('BG_THEME_DIR', get_stylesheet_directory());
define('BG_THEME_URL', get_stylesheet_directory_uri());

include_once BG_THEME_DIR.'/functions/Binggo.class.php';
include_once BG_THEME_DIR.'/functions/Binggo_Request.class.php';
include_once BG_THEME_DIR.'/functions/Binggo_Admin.class.php';
include_once BG_THEME_DIR.'/functions/Binggo_Expert.class.php';
include_once BG_THEME_DIR.'/functions/Binggo_Users.class.php';

add_action('template_redirect', function(){
	if(get_the_ID() == '990'){
		if(is_user_logged_in()){
			wp_redirect(site_url('/고객-메인/'));
		}
	};
});

add_action('init', function(){
	show_admin_bar(false);
	expert_register();
	
	new Experts();
	new Users();
});

add_action('after_setup_theme', function(){
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);
	
	add_theme_support('woocommerce');
}, 10, 1);

add_action('wp_enqueue_scripts', function(){
	wp_enqueue_style('binggo-style', BG_THEME_URL . '/css/style.css', array(), uniqid());
	wp_enqueue_script('binggo-script', BG_THEME_URL . '/js/script.js', array('jquery'), uniqid(), true);
	
	wp_enqueue_style('bootstrap-style', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css', array(), uniqid());
	wp_enqueue_script('bootstrap-script', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js', array('jquery'), uniqid(), true);
	
	wp_enqueue_style('bootstrap-style', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css', array(), uniqid());
	
	wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', array(), uniqid());
	wp_enqueue_style('googleapis', 'https://fonts.googleapis.com/icon?family=Material+Icons', array(), uniqid());
	
	wp_enqueue_script('swiper-script', 'https://cdn.jsdelivr.net/npm/swiper@9/swiper-element-bundle.min.js', array('jquery'), uniqid(), true);
	
	$localization = array(
		'admin_url' => admin_url('admin-post.php'),
		'ajax_url'  => admin_url('admin-ajax.php'),
	);
	wp_localize_script('binggo-script', 'binggo_script', $localization);
});

add_action('wp_head', function(){
	echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">';
});

function expert_register(){
	$labels = array(
		'name'               => '포트폴리오',
		'singular_name'      => '포트폴리오',
		'menu_name'          => '포트폴리오',
		'add_new'            => '포트폴리오 추가',
		'add_new_item'       => '포트폴리오 추가',
		'edit_item'          => '포트폴리오 수정',
		'new_item'           => '새 포트폴리오',
		'view_item'          => '포트폴리오 보기',
		'search_items'       => '포트폴리오 검색',
		'not_found'          => '포트폴리오가 없습니다.',
		'not_found_in_trash' => '포트폴리오가 없습니다.',
	);
	$args = array(
		'labels'              => $labels,
		'public'              => true,
		'publicly_queryable'  => true,
		'has_archive'         => true,
		'show_ui'             => false,
		'query_var'           => true,
		'rewrite'             => false,
		'capability_type'     => 'post',
		'hierarchical'        => true,
		'exclude_from_search' => false,
		'menu_position'       => 30,
		'menu_icon'           => 'dashicons-calendar',
		'supports'            => array('title','thumbnail')
	);
	register_post_type('expert_portfolio', $args);
	
	$labels = array(
		'name'               => '빙고 의뢰',
		'singular_name'      => '빙고 의뢰',
		'menu_name'          => '의뢰',
		'add_new'            => '의뢰 추가',
		'add_new_item'       => '의뢰 추가',
		'edit_item'          => '의뢰 수정',
		'new_item'           => '새 의뢰',
		'view_item'          => '의뢰 보기',
		'search_items'       => '의뢰 검색',
		'not_found'          => '의뢰가 없습니다.',
		'not_found_in_trash' => '의뢰가 없습니다.',
	);
	$args = array(
		'labels'              => $labels,
		'public'              => true,
		'publicly_queryable'  => true,
		'has_archive'         => false,
		'show_ui'             => true,
		'query_var'           => true,
		'rewrite'             => false,
		'capability_type'     => 'post',
		'hierarchical'        => false,
		'exclude_from_search' => true,
		'menu_position'       => 30,
		'menu_icon'           => 'dashicons-format-aside',
		'supports'            => array()
	);
	register_post_type('binggo_request', $args);
	
	$labels = array(
		'name'               => '빙고 견적서',
		'singular_name'      => '빙고 견적서',
		'menu_name'          => '견적서',
		'add_new'            => '견적서 추가',
		'add_new_item'       => '견적서 추가',
		'edit_item'          => '견적서 수정',
		'new_item'           => '새 견적서',
		'view_item'          => '견적서 보기',
		'search_items'       => '견적서 검색',
		'not_found'          => '견적서가 없습니다.',
		'not_found_in_trash' => '견적서가 없습니다.',
	);
	$args = array(
		'labels'              => $labels,
		'public'              => true,
		'publicly_queryable'  => true,
		'has_archive'         => false,
		'show_ui'             => true,
		'query_var'           => true,
		'rewrite'             => false,
		'capability_type'     => 'post',
		'hierarchical'        => false,
		'exclude_from_search' => true,
		'menu_position'       => 30,
		'menu_icon'           => 'dashicons-format-aside',
		'supports'            => array()
	);
	register_post_type('expert_quotes', $args);
}