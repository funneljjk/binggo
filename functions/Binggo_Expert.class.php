<?php
/*
* Experts
* @link https://www.cosmosfarm.com/
* @copyright Copyright 2023 Cosmosfarm. All rights reserved.
*/

class Experts {
	
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
				
				 // 고용 횟수
				$this->hire_count               = get_user_meta($this->id, 'hire_count', true);
				// 별점
				$this->star                     = get_user_meta($this->id, 'star', true);
				// 이름
				$this->first_name               = get_user_meta($this->id, 'first_name', true);
				// 서비스 가능 장소
				$this->location                 = get_user_meta($this->id, 'location', true);
				// 가능한 서비스
				$this->available_service        = get_user_meta($this->id, 'available_service', true);
				// 경력
				$this->career                   = get_user_meta($this->id, 'career', true);
				// 직원수
				$this->staff                    = get_user_meta($this->id, 'staff', true);
				// 설명
				$this->service_description      = get_user_meta($this->id, 'service_description', true);
				// 연락 가능 시간 시작
				$this->can_contact_time_start   = get_user_meta($this->id, 'can_contact_time_start', true);
				// 연락 가능 시간 종료
				$this->can_contact_time_end     = get_user_meta($this->id, 'can_contact_time_end', true);
				// 은행
				$this->bank                     = get_user_meta($this->id, 'bank', true);
				// 예금주
				$this->bank_owner               = get_user_meta($this->id, 'bank_owner', true);
				// 계좌번호
				$this->bank_account             = get_user_meta($this->id, 'bank_account', true);
				// 주소
				$this->addr1                    = get_user_meta($this->id, 'addr1', true);
				// 상세주소
				$this->addr2                    = get_user_meta($this->id, 'addr2', true);
				// 세금계산서 발급 가능 여부
				$this->is_billing_tax           = get_user_meta($this->id, 'is_billing_tax', true);
				// 전문가 인증
				$this->is_expert_confirm        = get_user_meta($this->id, 'is_expert_confirm', true);
				// 연락처
				$this->billing_phone            = get_user_meta($this->id, 'billing_phone', true);
				// 사업자등록증 번호
				$this->business_license_number  = get_user_meta($this->id, 'business_license_number', true);
				// 이미지들
				$this->experts_images           = get_user_meta($this->id, 'experts_images', true);
				// 평점
				$this->star                     = get_user_meta($this->id, 'star', true);
				$this->star                     = $this->star ? $this->star : 0;
				
				$this->hire_count               = $this->hire_count        ? $this->hire_count        : 0;
				$this->location                 = $this->location          ? $this->location          : array();
				$this->available_service        = $this->available_service ? $this->available_service : array();
				
				$this->business_license = isset($this->experts_images['business_license']) ? $this->experts_images['business_license'] : array();
				$this->logo             = isset($this->experts_images['logo'])             ? $this->experts_images['logo']             : array();
				$this->background       = isset($this->experts_images['background'])       ? $this->experts_images['background']       : array();
				$this->etc              = isset($this->experts_images['etc'])              ? $this->experts_images['etc']              : array();
				$this->license          = isset($this->experts_images['license'])          ? $this->experts_images['license']          : array();
				
				$this->images = array_merge($this->logo, $this->background, $this->etc);
				
				global $wpdb;
				$this->portfolio = $wpdb->get_results("SELECT * FROM `wp_posts` WHERE `post_author` = '{$this->id}' AND `post_type` LIKE 'expert_portfolio' AND `post_status` LIKE 'publish'");
			}
		}
	}
	
	public function admin_post(){
		add_action('admin_post_binggo_expert_profile', array($this, 'expert_profile'), 10, 1);
		add_action('admin_post_nopriv_binggo_expert_profile', array($this, 'expert_profile'), 10, 1);
		
		add_action('admin_post_binggo_expert_portfolio', array($this, 'expert_portfolio'), 10, 1);
		add_action('admin_post_nopriv_binggo_expert_portfolio', array($this, 'expert_portfolio'), 10, 1);
		
		add_action('admin_post_binggo_expert_quotes', array($this, 'expert_quotes'), 10, 1);
		add_action('admin_post_nopriv_binggo_expert_quotes', array($this, 'expert_quotes'), 10, 1);
		
		add_action('admin_post_binggo_expert_construct_start', array($this, 'expert_construct_start'), 10, 1);
		add_action('admin_post_nopriv_binggo_expert_construct_start', array($this, 'expert_construct_start'), 10, 1);
		
		add_action('admin_post_binggo_expert_phone_certify', array($this, 'expert_phone_certify'), 10, 1);
		add_action('admin_post_nopriv_binggo_expert_phone_certify', array($this, 'expert_phone_certify'), 10, 1);
		
		add_action('admin_post_binggo_expert_phone_confirm', array($this, 'expert_phone_confirm'), 10, 1);
		add_action('admin_post_nopriv_binggo_expert_phone_confirm', array($this, 'expert_phone_confirm'), 10, 1);
		
		add_action('admin_post_binggo_expert_complete', array($this, 'expert_complete'), 10, 1);
		add_action('admin_post_nopriv_binggo_expert_complete', array($this, 'expert_complete'), 10, 1);
	}
	
	/**
	 * 프로필 정보를 입력한다.
	 */
	public function expert_profile(){
		$user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
		if(!$user_id){
			wp_die('잘못된 경로입니다.');
		}
		
		check_ajax_referer('binggo_security_'.$user_id, 'binggo_nonce');
		
		/**
		 * 프로필 정보 입력 시작
		 */
		$experts = Binggo::sanitize_data($_POST['experts']);
		foreach($experts as $key=>$val){
			if($key == 'location'){
				$val = array_filter(explode('-', $val));
			}
			
			update_user_meta($user_id, $key, $val);
			update_user_meta($user_id, 'is_expert', 1);
		}
		
		/**
		 * 이미지 입력 시작
		 */
		$experts_image_array = array(
			'business_license' => array(),
			'logo'             => array(),
			'background'       => array(),
			'etc'              => array(),
			'license'          => array(),
		);
		$experts_images         = get_user_meta($user_id, 'experts_images', true);
		$uploaded_experts_images = isset($_POST['uploaded_experts_images']) ? $_POST['uploaded_experts_images'] : array();
		$delete_image_array     = array();
		$experts_image_default  = array_merge($experts_image_array, $experts_images);
		foreach($experts_image_default as $key=>$images){
			if(isset($uploaded_experts_images[$key])){
				$diff = array_merge(array_diff($uploaded_experts_images[$key], $images), array_diff($images, $uploaded_experts_images[$key]));
				$delete_image_array[$key] = $diff;
				
				$remain = array_intersect($uploaded_experts_images[$key], $images);
				$uploaded_experts_images[$key] = $remain;
			}
			else{
				$delete_image_array[$key] = $images;
			}
		}
		
		$files = Binggo::sanitize_image($_FILES['experts_images']);
		
		if($files){
			$image_ids = $experts_image_array;
			
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
					
					if(isset($upload['error'])){
						continue;
					}
					
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
						'post_content'   => '',
						'post_status'    => 'inherit'
					);
					$image_id = wp_insert_attachment($attachment, $filename, $user_id);
					
					$image_ids[$key][] = $image_id;
				}
			}
			
			$upload_epxerts_image_ids = array();
			foreach($image_ids as $key=>$array){
				if(!isset($uploaded_experts_images[$key])){
					$upload_epxerts_image_ids[$key] = $array;
				}
				else{
					$upload_epxerts_image_ids[$key] = array_merge($array, $uploaded_experts_images[$key]);
				}
			}
			
			update_user_meta($user_id, 'experts_images', $upload_epxerts_image_ids);
			
			foreach($delete_image_array as $d_array){
				foreach($d_array as $id){
					wp_delete_attachment($id, true);
				}
			}
		}
		
		wp_redirect(wp_get_referer());
		exit;
	}
	
	/**
	 * 포트폴리오 정보를 입력한다.
	 */
	public function expert_portfolio(){
		$user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
		if(!$user_id){
			wp_die('잘못된 경로입니다.');
		}
		
		check_ajax_referer('binggo_security_'.$user_id, 'binggo_nonce');
		
		/**
		 * 포트폴리오 입력 시작
		 */
		$data = Binggo::sanitize_data($_POST['portfolio']);
		
		$portfolio_id = isset($_POST['portfolio_id']) ? intval($_POST['portfolio_id']) : 0;
		if($portfolio_id){
			$arr = array(
				'ID'           => $portfolio_id,
				'post_title'   => $data->title,
			);
			wp_update_post($arr);
		}
		else{
			$arr = array(
				'post_title'  => $data->title,
				'post_author' => $user_id,
				'post_status' => 'publish',
				'post_type'   => 'expert_portfolio',
			);
			$portfolio_id = wp_insert_post($arr);
		}
		
		foreach($data as $key=>$value){
			if(in_array($key, array('title'))){
				continue;
			}
			update_post_meta($portfolio_id, $key, $value);
		}
		
		/**
		 * 이미지 입력 시작
		 */
		$portfolio_image_array = array(
			'thumbnail' => array(),
			'images'    => array(),
		);
		$portfolio_images         = get_post_meta($portfolio_id, 'portfolio_images', true);
		$portfolio_images         = $portfolio_images ? $portfolio_images : array();
		$uploaded_portfolio_images = isset($_POST['uploaded_portfolio_images']) ? $_POST['uploaded_portfolio_images'] : array();
		$delete_image_array       = array();
		$portfolio_image_default  = array_merge($portfolio_image_array, $portfolio_images);
		
		foreach($portfolio_image_default as $key=>$images){
			if(isset($uploaded_portfolio_images[$key])){
				$diff = array_merge(array_diff($uploaded_portfolio_images[$key], $images), array_diff($images, $uploaded_portfolio_images[$key]));
				
				$delete_image_array[$key] = $diff;
				
				$remain = array_intersect($uploaded_portfolio_images[$key], $images);
				$uploaded_portfolio_images[$key] = $remain;
			}
			else{
				$delete_image_array[$key] = $images;
			}
		}
		
		$files = Binggo::sanitize_image($_FILES['portfolio_images']);
		
		if($files){
			$image_ids = $portfolio_image_array;
			
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
						'post_content'   => '',
						'post_status'    => 'inherit'
					);
					$image_id = wp_insert_attachment($attachment, $filename, $portfolio_id);
					
					$image_ids[$key][] = $image_id;
				}
			}
			
			$upload_portfolio_image_ids = array();
			foreach($image_ids as $key=>$array){
				if(!isset($uploaded_portfolio_images[$key])){
					$upload_portfolio_image_ids[$key] = $array;
				}
				else{
					$upload_portfolio_image_ids[$key] = array_merge($array, $uploaded_portfolio_images[$key]);
				}
				
			}
			
			update_post_meta($portfolio_id, 'portfolio_images', $upload_portfolio_image_ids);
			
			foreach($delete_image_array as $d_array){
				foreach($d_array as $id){
					wp_delete_attachment($id, true);
				}
			}
		}
		
		wp_redirect(site_url('/전문가-프로필/'));
		exit;
	}
	
	/**
	 * 견적서를 작성한다.
	 */
	public function expert_quotes(){
		$user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
		if(!$user_id){
			wp_die('잘못된 경로입니다.');
		}
		
		check_ajax_referer('binggo_security_quotes_'.$user_id, 'binggo_nonce');
		
		$data       = Binggo::sanitize_data($_POST['quotes']);
		$first_name = get_user_meta($user_id, 'first_name', true);
		
		$option = [];
		foreach($data as $key=>$value){
			foreach($value as $idx=>$item){
				$option['option'][$idx][$key] = $item;
			}
			
			if($key == 'option_price'){
				$option['price'] = $value;
			}
		}
		
		$request_id = isset($_POST['request_id']) ? intval($_POST['request_id']) : 0;
		if($request_id){
			$arr = array(
				'post_title'   => "전문가 {$first_name}님 견적서",
				'post_author'  => $user_id,
				'post_status'  => 'publish',
				'post_content' => $data->content,
				'post_parent'  => $request_id,
				'post_type'    => 'expert_quotes',
			);
			$quotes_id = wp_insert_post($arr);
			
			if($quotes_id){
				foreach($option as $key=>$value){
					if($key == 'price'){
						delete_post_meta($quotes_id, 'price');
						
						foreach($value as $val){
							add_post_meta($quotes_id, 'price', $val);
						}
					}
					else{
						update_post_meta($quotes_id, $key, $value);
					}
				}
				
				update_post_meta($request_id, 'request_status', 'quotes_request');
			}
		}
		
		$url = site_url('/전문가-의뢰찾기/');
		if(!$request_id){
			$url = wp_get_referer();
		}
		wp_redirect($url);
	}
	
	public function expert_construct_start(){
		$user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
		if(!$user_id){
			wp_die('잘못된 경로입니다.');
		}
		
		check_ajax_referer('binggo_security_'.$user_id, 'binggo_nonce');
		$arr = array(
			'success' => false,
		);
		
		$request_id = isset($_POST['request_id']) ? intval($_POST['request_id']) : 0;
		$update = update_post_meta($request_id, 'request_status', 'construct_start');
		if($update){
			$arr = array(
				'success' => true,
			);
		}
		
		wp_send_json($arr);
	}
	
	public function expert_phone_certify(){
		$result = array(
			'success' => false,
			'msg'     => '에러가 발생했습니다.\n잠시후 다시 시도해주세요.',
		);
		
		wp_send_json($result);
	}
	
	public function expert_phone_confirm(){
		$result = array(
			'success' => false,
			'msg'     => '에러가 발생했습니다.\n잠시후 다시 시도해주세요.',
		);
		
		wp_send_json($result);
	}
	
	/**
	 * 공사 완료 요청
	 */
	public function expert_complete(){
		$user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
		if(!$user_id){
			wp_die('잘못된 경로입니다.');
		}
		
		check_ajax_referer('binggo_security_'.$user_id, 'binggo_nonce');
		
		$expert_id  = isset($_POST['expert_id'])  ? intval($_POST['expert_id'])  : 0;
		$request_id = isset($_POST['request_id']) ? intval($_POST['request_id']) : 0;
		$request    = new Binggo_Request($request_id);
		if($expert_id != $request->expert_id){
			wp_die('잘못된 경로입니다.');
		}
		
		
		$data = Binggo::sanitize_data($_POST['complete']);
		if($request->request_status == 'construct_start'){
			update_post_meta($request_id, 'request_status', 'construct_end');
		}
		elseif($request->request_status == 're_construct_start'){
			update_post_meta($request_id, 'request_status', 're_construct_end');
		}
		elseif($request->request_status == 'as_start'){
			update_post_meta($request_id, 'request_status', 'as_end');
		}
		
		if($data->complete_content){
			update_post_meta($request_id, 'construct_complete_content', $data->construct_complete_content);
		}
		elseif($data->complete_content){
			update_post_meta($request_id, 're_construct_complete_content', $data->re_construct_complete_content);
		}
		elseif($data->complete_content){
			update_post_meta($request_id, 'as_complete_content', $data->as_complete_content);
		}
		
		$complete_image_array = array(
			'construct_complete'    => array(),
			're_construct_complete' => array(),
			'as_complete'           => array(),
		);
		$complete_images          = get_post_meta($request_id, 'complete_images', true);
		$complete_images          = $complete_images ? $complete_images : array();
		$uploaded_complete_images = isset($_POST['uploaded_complete_images']) ? $_POST['uploaded_complete_images'] : array();
		$delete_image_array        = array();
		$complete_image_default   = array_merge($complete_image_array, $complete_images);
		
		foreach($complete_image_default as $key=>$images){
			if(isset($uploaded_complete_images[$key])){
				$diff = array_merge(array_diff($uploaded_complete_images[$key], $images), array_diff($images, $uploaded_complete_images[$key]));
				
				$delete_image_array[$key] = $diff;
				
				$remain = array_intersect($uploaded_complete_images[$key], $images);
				$uploaded_complete_images[$key] = $remain;
			}
			else{
				$delete_image_array[$key] = $images;
			}
		}
		
		$files = Binggo::sanitize_image($_FILES['complete_images']);
		if($files){
			$image_ids = $complete_image_array;
			
			require_once(ABSPATH.'wp-admin/includes/image.php');
			require_once(ABSPATH.'wp-admin/includes/file.php');
			require_once(ABSPATH.'wp-admin/includes/media.php');
			
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
						'post_content'   => '',
						'post_status'    => 'inherit'
					);
					$image_id = wp_insert_attachment($attachment, $filename, $request_id);
					
					$image_ids[$key][] = $image_id;
				}
			}
			
			$upload_complete_image_ids = array();
			foreach($image_ids as $key=>$array){
				if(!isset($uploaded_complete_images[$key])){
					$upload_complete_image_ids[$key] = $array;
				}
				else{
					$upload_complete_image_ids[$key] = array_merge($array, $uploaded_complete_images[$key]);
				}
				
			}
			
			update_post_meta($request_id, 'complete_images', $upload_complete_image_ids);
			
			foreach($delete_image_array as $d_array){
				foreach($d_array as $id){
					wp_delete_attachment($id, true);
				}
			}
		}
		
		
		$url = site_url('/전문가-시공-완료/');
		if(!$request_id){
			$url = wp_get_referer();
		}
		wp_redirect($url);
	}
}