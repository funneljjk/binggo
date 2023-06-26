<?php
/*
* Users
* @link https://www.cosmosfarm.com/
* @copyright Copyright 2023 Cosmosfarm. All rights reserved.
*/

class Users {
	
	var $obj;
	var $id;
	
	public function __construct($id=0){
		$this->obj = new stdClass();
		if($id){
			$this->init($id);
		}
		
		$this->admin_post();
	}
	
	public function __get($name){
		if($this->obj && isset($this->obj->{$name})){
			return $this->obj->{$name};
		}
		return '';
	}
	
	public function __set($name, $value){
		$this->obj->{$name} = $value;
	}
	
	public function init($id){
		$id = intval($id);
		if($id){
			$this->obj = get_user_by('id', $id);
			if($this->obj && $this->obj->ID){
				$this->id = $this->obj->ID;
			}
		}
	}
	
	public function admin_post(){
		add_action('admin_post_binggo_request', array($this, 'request'), 10, 1);
		add_action('admin_post_nopriv_binggo_request', array($this, 'request'), 10, 1);
		
		add_action('admin_post_binggo_user_request_end', array($this, 'user_request_end'), 10, 1);
		add_action('admin_post_nopriv_binggo_user_request_end', array($this, 'user_request_end'), 10, 1);
		
		add_action('admin_post_binggo_user_quotes_check', array($this, 'user_quotes_check'), 10, 1);
		add_action('admin_post_nopriv_binggo_user_quotes_check', array($this, 'user_quotes_check'), 10, 1);
		
		add_action('admin_post_binggo_user_quotes_construct_request', array($this, 'user_quotes_construct_request'), 10, 1);
		add_action('admin_post_nopriv_binggo_user_quotes_construct_request', array($this, 'user_quotes_construct_request'), 10, 1);
		
		add_action('admin_post_binggo_user_construct_complete', array($this, 'user_construct_complete'), 10, 1);
		add_action('admin_post_nopriv_binggo_user_construct_complete', array($this, 'user_construct_complete'), 10, 1);
		
		add_action('admin_post_binggo_user_re_construct_request', array($this, 'user_re_construct_request'), 10, 1);
		add_action('admin_post_nopriv_binggo_user_re_construct_request', array($this, 'user_re_construct_request'), 10, 1);
	}
	
	public function request(){
		$user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
		if(!$user_id){
			wp_die('잘못된 경로입니다.');
		}
		
		$expert_id  = isset($_GET['expert_id'])  ? intval($_GET['expert_id']) : 0;
		if($expert_id && !get_user_meta($expert_id, 'is_expert', true)){
			wp_die('잘못된 경로입니다.');
		}
		
		check_ajax_referer('binggo_security_request_'.$user_id, 'binggo_nonce');
		
		/**
		 * 의뢰 입력 시작
		 */
		$data = Binggo::sanitize_data($_POST['request']);
		
		$request_id = isset($_POST['request_id']) ? intval($_POST['request_id']) : 0;
		if($request_id){
			$arr = array(
				'ID'           => $request_id,
				'post_title'   => $data->location.' '.$data->location2.' '.$data->location3,
				'post_content' => $data->content,
			);
			wp_update_post($arr);
		}
		else{
			$arr = array(
				'post_title'   => $data->first_name.'-'.$data->location.' '.$data->location2.' '.$data->location3,
				'post_author'  => $user_id,
				'post_status'  => 'publish',
				'post_content' => $data->content,
				'post_type'    => 'binggo_request',
			);
			$request_id = wp_insert_post($arr);
			update_post_meta($request_id, 'request_status', 'wait'); // 의뢰 처음
			update_post_meta($request_id, 'expert_id', $expert_id);
		}
		
		foreach($data as $key=>$value){
			if(in_array($key, array('content'))){
				continue;
			}
			
			if(in_array($key, array('first_name', 'billing_phone'))){
				update_user_meta($user_id, $key, $value);
			}
			
			update_post_meta($request_id, $key, $value);
		}
		
		/**
		 * 이미지 입력 시작
		 */
		$request_image_array = array(
			'scene'      => array(),
			'floor_plan' => array(),
			'etc'        => array()
		);
		$request_images          = get_post_meta($request_id, 'request_images', true);
		$request_images          = $request_images ? $request_images : array();
		$uploaded_request_images = isset($_POST['uploaded_request_images']) ? $_POST['uploaded_request_images'] : array();
		$delete_image_array      = array();
		$request_image_default   = array_merge($request_image_array, $request_images);
		
		foreach($request_image_default as $key=>$images){
			if(isset($uploaded_request_images[$key])){
				$diff = array_merge(array_diff($uploaded_request_images[$key], $images), array_diff($images, $uploaded_request_images[$key]));
				
				$delete_image_array[$key] = $diff;
				
				$remain = array_intersect($uploaded_request_images[$key], $images);
				$uploaded_request_images[$key] = $remain;
			}
			else{
				$delete_image_array[$key] = $images;
			}
		}
		
		$files = Binggo::sanitize_image($_FILES['request_images']);
		
		if($files){
			$image_ids = $request_image_array;
			
			require_once(ABSPATH . 'wp-admin/includes/image.php');
			require_once(ABSPATH . 'wp-admin/includes/file.php');
			require_once(ABSPATH . 'wp-admin/includes/media.php');
			
			foreach($files as $key=>$values){
				foreach($values as $idx=>$image){
					$file = array();
					
					foreach($image as $name=>$value){
						$file[$name] = $value;
					}
					
					$upload_overrides = array('test_form' => false);
					$upload           = wp_handle_upload($file, $upload_overrides);
					
					$filename = isset($upload['file']) ? $upload['file'] : '';
					if(!$filename){
						continue;
					}
					
					$filetype      = wp_check_filetype(basename($filename), null);
					$wp_upload_dir = wp_upload_dir();
					
					$attachment = array(
						'guid'           => $wp_upload_dir['url'] . '/' . basename($filename),
						'post_mime_type' => $filetype['type'],
						'post_title'     => preg_replace('/\.[^.]+$/', '', basename($filename)),
						'post_status'    => 'inherit'
					);
					$image_id = wp_insert_attachment($attachment, $filename, $request_id);
					
					$image_ids[$key][] = $image_id;
				}
			}
			
			$upload_request_image_ids = array();
			foreach($image_ids as $key=>$array){
				if(!isset($uploaded_request_images[$key])){
					$upload_request_image_ids[$key] = $array;
				}
				else{
					$upload_request_image_ids[$key] = array_merge($array, $uploaded_request_images[$key]);
				}
				
			}
			
			update_post_meta($request_id, 'request_images', $upload_request_image_ids);
			
			foreach($delete_image_array as $d_array){
				foreach($d_array as $id){
					wp_delete_attachment($id, true);
				}
			}
		}
		
		wp_redirect(site_url('/고객-의뢰서-접수-완료/'));
		exit;
	}
	
	public function user_request_end(){
		print_r($_GET);
		
		$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
		if(!$user_id){
			wp_die('잘못된 경로입니다.');
		}
		
		check_ajax_referer('binggo_security_request_'.$user_id, 'binggo_nonce');
	}
	
	/**
	 * 견적 상세보기
	 */
	public function user_quotes_check(){
		$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
		if(!$user_id){
			wp_die('잘못된 경로입니다.');
		}
		
		check_ajax_referer('binggo_security_quotes_'.$user_id, 'binggo_nonce');
		
		$quotes_id = isset($_GET['quotes_id']) ? intval($_GET['quotes_id']) : 0;
		$quotes = get_post($quotes_id);
		if($quotes->post_type != 'expert_quotes'){
			wp_die('잘못된 경로입니다.');
		}
		
		$request_id = $quotes->post_parent;
		update_post_meta($request_id, 'quotes_id', $quotes_id);
		
		wp_redirect(add_query_arg('quotes_id', $quotes_id, site_url('/고객-공사요청/')));
	}
	
	/**
	 * 
	 */
	public function user_quotes_construct_request(){
		$user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
		if(!$user_id){
			wp_die('잘못된 경로입니다.');
		}
		
		check_ajax_referer('binggo_security_request_'.$user_id, 'binggo_nonce');
		
		$quotes_id = isset($_POST['quotes_id']) ? intval($_POST['quotes_id']) : 0;
		$quotes = get_post($quotes_id);
		if($quotes->post_type != 'expert_quotes'){
			wp_die('잘못된 경로입니다.');
		}
		
		$data = Binggo::sanitize_data($_POST['user_construct_request']);
		
		$request_id = $quotes->post_parent;
		update_post_meta($request_id, 'request_status', 'construct_request');
		foreach($data as $key=>$value){
			update_post_meta($request_id, $key, $value);
			update_user_meta($user_id, $key, $value);
		}
		
		wp_redirect(add_query_arg('request', 'construct', site_url('/고객-의뢰서-접수-완료/')));
	}
	
	/**
	 * 공사 완료 확정, 리뷰 등록
	 */
	public function user_construct_complete(){
		$user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
		if(!$user_id){
			wp_die('잘못된 경로입니다.');
		}
		
		check_ajax_referer('binggo_security_'.$user_id, 'binggo_nonce');
		
		$request_id = isset($_POST['request_id']) ? intval($_POST['request_id']) : 0;
		$request    = new Binggo_Request($request_id);
		
		update_post_meta($request_id, 'request_status', 'construct_confirm');
		
		$data = Binggo::sanitize_data($_POST['review']);
		if($data){
			update_post_meta($request_id, 'review', $data->content);
			update_post_meta($request_id, 'review_star', $data->content);
		}
		
		if(isset($_FILES['review_images']) && $_FILES['review_images']){
			/**
			 * 이미지 입력 시작
			 */
			$review_image_array = array(
				'review_images' => array(),
			);
			$review_images          = get_post_meta($request_id, 'review_images', true);
			$review_images          = $review_images ? $review_images : array();
			$uploaded_review_images = isset($_POST['uploaded_review_images']) ? $_POST['uploaded_review_images'] : array();
			$delete_image_array      = array();
			$review_image_default   = array_merge($review_image_array, $review_images);
			
			foreach($review_image_default as $key=>$images){
				if(isset($uploaded_review_images[$key])){
					$diff = array_merge(array_diff($uploaded_review_images[$key], $images), array_diff($images, $uploaded_review_images[$key]));
					
					$delete_image_array[$key] = $diff;
					
					$remain = array_intersect($uploaded_review_images[$key], $images);
					$uploaded_review_images[$key] = $remain;
				}
				else{
					$delete_image_array[$key] = $images;
				}
			}
			
			$files = Binggo::sanitize_image($_FILES['review_images']);
			
			if($files){
				$image_ids = $review_image_array;
				
				require_once(ABSPATH . 'wp-admin/includes/image.php');
				require_once(ABSPATH . 'wp-admin/includes/file.php');
				require_once(ABSPATH . 'wp-admin/includes/media.php');
				
				foreach($files as $key=>$values){
					foreach($values as $idx=>$image){
						$file = array();
						
						foreach($image as $name=>$value){
							$file[$name] = $value;
						}
						
						$upload_overrides = array('test_form' => false);
						$upload           = wp_handle_upload($file, $upload_overrides);
						
						$filename = isset($upload['file']) ? $upload['file'] : '';
						if(!$filename){
							continue;
						}
						
						$filetype      = wp_check_filetype(basename($filename), null);
						$wp_upload_dir = wp_upload_dir();
						
						$attachment = array(
							'guid'           => $wp_upload_dir['url'] . '/' . basename($filename),
							'post_mime_type' => $filetype['type'],
							'post_title'     => preg_replace('/\.[^.]+$/', '', basename($filename)),
							'post_status'    => 'inherit'
						);
						$image_id = wp_insert_attachment($attachment, $filename, $request_id);
						
						$image_ids[$key][] = $image_id;
					}
				}
				
				$upload_review_image_ids = array();
				foreach($image_ids as $key=>$array){
					if(!isset($uploaded_review_images[$key])){
						$upload_review_image_ids[$key] = $array;
					}
					else{
						$upload_review_image_ids[$key] = array_merge($array, $uploaded_review_images[$key]);
					}
					
				}
				
				update_post_meta($request_id, 'review_images', $upload_review_image_ids);
				
				foreach($delete_image_array as $d_array){
					foreach($d_array as $id){
						wp_delete_attachment($id, true);
					}
				}
			}
		}
		
		wp_redirect(site_url('/고객-의뢰내역-견적as/'));
	}
	
	/**
	 * 재시공 요청
	 */
	public function user_re_construct_request(){
		$user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
		if(!$user_id){
			wp_die('잘못된 경로입니다.');
		}
		
		check_ajax_referer('binggo_security_'.$user_id, 'binggo_nonce');
		
		$request_id = isset($_POST['request_id']) ? intval($_POST['request_id']) : 0;
		$request    = new Binggo_Request($request_id);
		
		update_post_meta($request_id, 'request_status', 're_construct_start');
		
		$data = Binggo::sanitize_data($_POST['re_construct']);
		
		$re_construct_request = array();
		foreach($data as $key=>$item){
			foreach($item as $idx=>$value){
				$re_construct_request[$idx][$key] = $value;
			}
		}
		
		if($re_construct_request){
			update_post_meta($request_id, 're_construct_request', $re_construct_request);
		}
		
		if(isset($_FILES['re_construct_images']) && $_FILES['re_construct_images']){
			/**
			 * 이미지 입력 시작
			 */
			$re_construct_image_array = array(
				're_construct_images' => array(),
			);
			$re_construct_images          = get_post_meta($request_id, 're_construct_images', true);
			$re_construct_images          = $re_construct_images ? $re_construct_images : array();
			$uploaded_re_construct_images = isset($_POST['uploaded_re_construct_images']) ? $_POST['uploaded_re_construct_images'] : array();
			$delete_image_array           = array();
			$re_construct_image_default   = array_merge($re_construct_image_array, $re_construct_images);
			
			foreach($re_construct_image_default as $key=>$images){
				if(isset($uploaded_re_construct_images[$key])){
					$diff = array_merge(array_diff($uploaded_re_construct_images[$key], $images), array_diff($images, $uploaded_re_construct_images[$key]));
					
					$delete_image_array[$key] = $diff;
					
					$remain = array_intersect($uploaded_re_construct_images[$key], $images);
					$uploaded_re_construct_images[$key] = $remain;
				}
				else{
					$delete_image_array[$key] = $images;
				}
			}
			
			$files = Binggo::sanitize_image($_FILES['re_construct_images']);
			
			if($files){
				$image_ids = $re_construct_image_array;
				
				require_once(ABSPATH . 'wp-admin/includes/image.php');
				require_once(ABSPATH . 'wp-admin/includes/file.php');
				require_once(ABSPATH . 'wp-admin/includes/media.php');
				
				foreach($files as $key=>$values){
					foreach($values as $idx=>$image){
						$file = array();
						
						foreach($image as $name=>$value){
							$file[$name] = $value;
						}
						
						$upload_overrides = array('test_form' => false);
						$upload           = wp_handle_upload($file, $upload_overrides);
						
						$filename = isset($upload['file']) ? $upload['file'] : '';
						if(!$filename){
							continue;
						}
						
						$filetype      = wp_check_filetype(basename($filename), null);
						$wp_upload_dir = wp_upload_dir();
						
						$attachment = array(
							'guid'           => $wp_upload_dir['url'] . '/' . basename($filename),
							'post_mime_type' => $filetype['type'],
							'post_title'     => preg_replace('/\.[^.]+$/', '', basename($filename)),
							'post_status'    => 'inherit'
						);
						$image_id = wp_insert_attachment($attachment, $filename, $request_id);
						
						$image_ids[$key][] = $image_id;
					}
				}
				
				$upload_re_construct_image_ids = array();
				foreach($image_ids as $key=>$array){
					if(!isset($uploaded_re_construct_images[$key])){
						$upload_re_construct_image_ids[$key] = $array;
					}
					else{
						$upload_re_construct_image_ids[$key] = array_merge($array, $uploaded_re_construct_images[$key]);
					}
					
				}
				
				update_post_meta($request_id, 're_construct_images', $upload_re_construct_image_ids);
				
				foreach($delete_image_array as $d_array){
					foreach($d_array as $id){
						wp_delete_attachment($id, true);
					}
				}
			}
		}
		
		wp_redirect(add_query_arg('request_id', $request_id, site_url('/고객-재시공-요청-as-요청-내역/')));
	}
	
	/**
	 * 전문가 위시리스트
	 */
	public function user_wishlist(){
		print_r($_GET);
		
		$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
		if(!$user_id){
			wp_die('잘못된 경로입니다.');
		}
		
		check_ajax_referer('binggo_security_'.$user_id, 'binggo_nonce');
	}
}

