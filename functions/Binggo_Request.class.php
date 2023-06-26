<?php
/*
* Binggo_Request
* @link https://www.cosmosfarm.com/
* @copyright Copyright 2023 Cosmosfarm. All rights reserved.
*/

class Binggo_Request {
	// 의뢰 상태 요약 ---
	// wait - admin_receive - quotes_request
	// construct_request - construct_start - construct_end
	// (re_construct_request) - re_construct_start - re_construct_end
	// (as_request) - as_start - as_end
	// construct_confirm
	// end
	// 의뢰 상태 요약 ---
	
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
			$this->obj = get_post($id);
			if($this->obj->post_type != 'binggo_request'){
				$this->obj->ID = 0;
			}
			
			if($this->obj && $this->obj->ID){
				$this->id = $this->obj->ID;
				
				// 주소1
				$this->location               = get_post_meta($id, 'location', true);
				// 주소2
				$this->location2              = get_post_meta($id, 'location2', true);
				// 상세주소
				$this->location3              = get_post_meta($id, 'location3', true);
				
				// 공사업종
				$this->construct_industry     = get_post_meta($id, 'construct_industry', true);
				// 공사업종 기타
				$this->construct_industry_etc = get_post_meta($id, 'construct_industry_etc', true);
				
				// 공사형태
				$this->construct_type         = get_post_meta($id, 'construct_type', true);
				// 공사형태 기타
				$this->construct_type_etc     = get_post_meta($id, 'construct_type_etc', true);
				
				// 담당자명
				$this->first_name             = get_post_meta($id, 'first_name', true);
				$this->first_name             = $this->first_name    ? $this->first_name    : get_user_meta($this->post_author, 'first_name', true);
				// 연락처
				$this->billing_phone          = get_post_meta($id, 'billing_phone', true);
				$this->billing_phone          = $this->billing_phone ? $this->billing_phone : get_user_meta($this->post_author, 'billing_phone', true);
				
				// 공사일정 시작
				$this->start_date             = get_post_meta($id, 'start_date', true);
				// 공사일정 종료
				$this->end_date               = get_post_meta($id, 'end_date', true);
				
				// 현장 방문 희망
				$this->field_visit_request    = get_post_meta($id, 'field_visit_request', true);
				// 현장 방문 요청 일
				$this->field_visit_date       = get_post_meta($id, 'field_visit_date', true);
				// 현장 방문 요청 시
				$this->field_visit_time       = get_post_meta($id, 'field_visit_time', true);
				
				// 요청사항
				$this->request_term           = get_post_meta($id, 'request_term', true);
				
				// 이미지
				$this->request_images         = get_post_meta($id, 'request_images', true);
				// 현장사진
				$this->scene                  = isset($this->request_images['scene'])      ? $this->request_images['scene']      : array();
				// 공사도면
				$this->floor_plan             = isset($this->request_images['floor_plan']) ? $this->request_images['floor_plan'] : array();
				// 기타사진
				$this->etc                    = isset($this->request_images['etc'])        ? $this->request_images['etc']        : array();
				// 이미지 array
				$this->images_list            = array_merge($this->scene, $this->floor_plan, $this->etc);
				
				// 공사 시작일
				$this->construct_start_date   = get_post_meta($id, 'construct_start_date', true);
				// 공사 종료일
				$this->construct_end_date     = get_post_meta($id, 'construct_end_date', true);
				// 공사 종료 확인일
				$this->construct_confirm_date = get_post_meta($id, 'construct_confirm_date', true);
				
				// 의뢰 상태
				$this->request_status         = get_post_meta($id, 'request_status', true);
				// 의뢰 요청 날짜
				$this->date                   = date('Y-m-d', strtotime($this->post_date));
				
				// 구매확정
				$this->purchase_confirmation = get_post_meta($id, 'purchase_confirmation', true);
				// 구매평작성
				$this->purchase_review       = get_post_meta($id, 'purchase_review', true);
				
				// 전문가 id
				$this->expert_id             = get_post_meta($id, 'expert_id', true);
				// 견적서 id
				$this->quotes_id             = get_post_meta($id, 'quotes_id', true);
				// 공사완료 전달 내용
				$this->complete_content      = get_post_meta($id, 'complete_content', true);
				// 공사완료 이미지
				$this->complete_images       = get_post_meta($id, 'complete_images', true);
				$this->complete_images       = $this->complete_images ? $this->complete_images : array();
				
				// 리뷰 내용
				$this->review_content        = get_post_meta($id, 'review_content', true);
				// 리뷰 이미지
				$this->review_images         = get_post_meta($id, 'review_content', true);
				$this->review_images         = $this->review_images ? $this->review_images : array();
				
				// 재시공 내용
				$this->re_construct_request  = get_post_meta($id, 're_construct_request', true);
				// 재시공 이미지
				$this->re_construct_images   = get_post_meta($id, 're_construct_images', true);
				$this->re_construct_images   = $this->re_construct_images ? $this->re_construct_images : array();
			}
		}
	}
	
	public function get_quotes(){
		global $wpdb;
		$quotes_list = $wpdb->get_results("SELECT * FROM `{$wpdb->prefix}posts` WHERE `post_type` LIKE 'expert_quotes' AND `post_parent` LIKE '{$this->id}' AND `post_status` = 'publish'");
		
		return $quotes_list;
	}
	
	public function get_quotes_count(){
		
		global $wpdb;
		$quotes_list = $wpdb->get_var("SELECT COUNT(*) FROM `{$wpdb->prefix}posts` WHERE `post_type` LIKE 'expert_quotes' AND `post_parent` LIKE '{$this->id}' AND `post_status` = 'publish'");
		
		return $quotes_list;
	}
	
	public function get_quotes_sum(){
		global $wpdb;
		
		$from  = "`{$wpdb->prefix}posts` AS `post` LEFT JOIN `{$wpdb->prefix}postmeta` AS `meta` ON `post`.`ID` = `meta`.`post_id`";
		$where = "`post_status` = 'publish' AND `post`.`post_type` = 'expert_quotes' AND `post_parent` = {$this->id} AND `meta_key` LIKE 'price'";
		
		$sum = $wpdb->get_var("SELECT SUM(`meta`.`meta_value`) FROM {$from} WHERE {$where}");
		$sum = $sum ? $sum : 0;
		return $sum;
	}
	
	public function get_quotes_rowst(){
		global $wpdb;
		
		
		$from  = "`{$wpdb->prefix}posts` AS `post` LEFT JOIN `{$wpdb->prefix}postmeta` AS `meta` ON `post`.`ID` = `meta`.`post_id`";
		$where = "`post_status` = 'publish' AND `post`.`post_type` = 'expert_quotes' AND `post_parent` = {$this->id} AND `meta_key` LIKE 'price'";
		
		$row = $wpdb->get_var("SELECT AVG(`meta`.`meta_value`) FROM {$from} WHERE {$where}");
		$row = $row ? $row : 0;
		return $row;
	}
	
	public function get_quotes_average(){
		global $wpdb;
		
		
		$from  = "`{$wpdb->prefix}posts` AS `post` LEFT JOIN `{$wpdb->prefix}postmeta` AS `meta` ON `post`.`ID` = `meta`.`post_id`";
		$where = "`post_status` = 'publish' AND `post`.`post_type` = 'expert_quotes' AND `post_parent` = {$this->id} AND `meta_key` LIKE 'price'";
		
		$avg = $wpdb->get_var("SELECT AVG(`meta`.`meta_value`) FROM {$from} WHERE {$where}");
		$avg = $avg ? $avg : 0;
		return $avg;
	}
	
	public function is_wrote_quotes($user_id){
		global $wpdb;
		
		$quotes = $wpdb->get_var("SELECT `ID` FROM `{$wpdb->prefix}posts` WHERE `post_type` LIKE 'expert_quotes' AND `post_parent` LIKE '{$this->id}' AND `post_author` LIKE '{$user_id}' AND `post_status` = 'publish'");
		
		return $quotes;
	}
	
	public function admin_post(){
		
	}
}