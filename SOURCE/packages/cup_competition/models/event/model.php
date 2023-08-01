<?php
defined('C5_EXECUTE') or die(_("Access Denied."));

class CupCompetitionEvent extends Object {
	protected $fields = array(
						'id', 'name', 'category', 'type', 'form_config', 'qa_question',
						'start_time', 'end_time', 'max_submission', 'homepage_content', 
						'terms_and_conditions_content', 'config', 'modifiedAt', 'createdAt' 
					);
					
	protected $record = array();
	
	protected $errors = array();
	
	function __construct($id = false) {
		if($id){
			$db = Loader::db();
			$q = "select * from CupCompetitionEvent where id = ?";	
			$result = $db->getRow($q, array($id));
			
			if($result){
				$this->record	= $result;
				
				$form_config = json_decode($this->record['form_config'], true);
				if($form_config !== FALSE){
					$this->record['form_config'] = $form_config;
				}else{
					$this->record['form_config'] = array();
				}
				
				$qa_question = json_decode($this->record['qa_question'], true);
				if($qa_question !== FALSE){
					$this->record['qa_question'] = $qa_question;
				}else{
					$this->record['qa_question'] = array();
				}
				
				$config = json_decode($this->record['config'], true);
				if($config !== FALSE){
					$this->record['config'] = $config;
				}else{
					$this->record['config'] = array();
				}
			}
		}
	}
	
	public static function fetchByID($id){
		$object = new CupCompetitionEvent($id);
		if($object->id === FALSE){
			return FALSE;
		}else{
			return $object;
		}
	}
	
	public static function fetchByName($tmp_name){
		$db = Loader::db();
		$q = "select id from CupCompetitionEvent where name = ?";	
		$result = $db->getRow($q, array($tmp_name));
		
		if($result){
			return self::fetchByID($result['id']);
		}else{
			return false;
		}
	}
	
	public static function fetchOneByCategory($cat = 'HSC'){
		$db = Loader::db();
		$q = "select id from CupCompetitionEvent where category = ? ORDER BY id DESC";	
		$result = $db->getRow($q, array($cat));
		
		if($result){
			return self::fetchByID($result['id']);
		}else{
			return false;
		}
	}
	
	public function loadByID($id){
		if($id){
			$db = Loader::db();
			$q = "select * from CupCompetitionEvent where id = ?";	
			$result = $db->getRow($q, array($id));
			
			if($result){
				$this->record = $result;
				$form_config = json_decode($this->record['form_config'], true);
				if($form_config !== FALSE){
					$this->record['form_config'] = $form_config;
				}else{
					$this->record['form_config'] = array();
				}
				
				$qa_question = json_decode($this->record['qa_question'], true);
				if($qa_question !== FALSE){
					$this->record['qa_question'] = $qa_question;
				}else{
					$this->record['qa_question'] = array();
				}
				
				$config = json_decode($this->record['config'], true);
				if($config !== FALSE){
					$this->record['config'] = $config;
				}else{
					$this->record['config'] = array();
				}
			}
		}
	}
	
	public function __get($property) {
		if (isset($this->record[$property])) {
			return $this->record[$property];
		}else{
			return false;
		}
	}

	public function __set($property, $value) {
		if (in_array($property, $this->fields)) {
			$this->record[$property] = $value;
		}
		
		return $this;
	}
	
	public function setPost($post){
		/*
		foreach($post as $key => $value){
			if(in_array($key, $this->fields)){
				$this->record[$key] = $value;
			}
		}
		*/
		foreach($this->fields as $key){
			
			if(isset($post[$key])){
				$this->record[$key] = $post[$key];
			}elseif(!isset($this->record[$key])){
				$this->record[$key] = "";
			}
		}
		
		if(strcmp($this->record['type'], 'Photo') ==0){
			$this->record['qa_question'] = '';
		}
		
		if(isset($post['form_config_web'])){
			$form_config = array();
			foreach($post['form_config_web']['field_name'] as $idx => $value){
				$field_name = trim($value);
				$field_type = $post['form_config_web']['field_type'][$idx];
				$field_required = $post['form_config_web']['field_required'][$idx];
				$field_config = trim($post['form_config_web']['field_config'][$idx]);
				
				if(strlen($field_name) > 0){
					$form_config[] = array(
										'field_name' => $field_name,
										'field_type' => $field_type,
										'field_required' => $field_required,
										'field_config' => $field_config
									);
				}
			}
			
			$this->record['form_config'] = $form_config;
		}
		
		
		if(isset($post['form_qa'])){
			$qa_question = array();
			foreach($post['form_qa']['field_name'] as $idx => $value){
				$field_name = trim($value);
				$field_type = $post['form_qa']['field_type'][$idx];
				$field_required = $post['form_qa']['field_required'][$idx];
				$field_config = trim($post['form_qa']['field_config'][$idx]);
				
				if(strlen($field_name) > 0){
					$qa_question[] = array(
										'field_name' => $field_name,
										'field_type' => $field_type,
										'field_required' => $field_required,
										'field_config' => $field_config
									);
				}
			}
			
			$this->record['qa_question'] = $qa_question;
		}
	}
	
	public function getAssoc(){
		return $this->record;
	}
	
	public function save(){
		if($this->validation()){
		
			if(isset($this->record['id']) && $this->record['id'] > 0){	//update
				$this->record['modifiedAt'] = date('Y-m-d H:i:s');
				
				$db = Loader::db();
				$q = "update CupCompetitionEvent set name = ?, category = ?, type = ?, 
					form_config = ?, qa_question = ?, start_time = ?, end_time = ?, max_submission = ?,
					homepage_content = ?, terms_and_conditions_content = ?, config = ?,
					modifiedAt = ? WHERE id = ?";
				$v = array($this->record['name'], $this->record['category'], $this->record['type'], 
						json_encode($this->record['form_config']), json_encode($this->record['qa_question']), $this->record['start_time'], $this->record['end_time'], $this->record['max_submission'], 
						$this->record['homepage_content'], $this->record['terms_and_conditions_content'], json_encode($this->record['config']),
						$this->record['modifiedAt'], $this->record['id']);
				$r = $db->prepare($q);
				$res = $db->Execute($r, $v);
				if ($res) {
					$this->loadByID($this->id);
					return true;
				}else{
					return false;
				}
			}else{	//insert
				return $this->saveNew();
			}
		}else{
			return false;
		}
	}
	
	public function saveNew(){
		$this->record['createdAt'] = date('Y-m-d H:i:s');
		$this->record['modifiedAt'] = $this->record['createdAt'];
				
		$db = Loader::db();
		$q = "INSERT INTO CupCompetitionEvent (name, category, type, form_config, qa_question,
							start_time, end_time, max_submission, homepage_content,
							terms_and_conditions_content, config, modifiedAt, createdAt) 
						VALUES (?, ?, ?, ?, ?,
								?, ?, ?, ?,
								?, ?, ?, ?)";
		$v = array($this->record['name'], $this->record['category'], $this->record['type'], json_encode($this->record['form_config']), json_encode($this->record['qa_question']),
					$this->record['start_time'], $this->record['end_time'], $this->record['max_submission'], $this->record['homepage_content'],
					$this->record['terms_and_conditions_content'], json_encode($this->record['config']), $this->record['modifiedAt'], $this->record['createdAt']);
		$r = $db->prepare($q);
		$res = $db->Execute($r, $v);
		
		if ($res) {
			$this->loadByID($db->Insert_ID());
			return true;
		}else{
			return false;
		}
	}
	
	public function delete(){
		if($this->record['id'] > 0){
			$db = Loader::db();
			$q = "DELETE FROM CupCompetitionEventEntry WHERE eventID = ?";
			$result = $db->Execute($q, array($this->record['id']));
			if($result){
				$q = "DELETE FROM CupCompetitionEvent WHERE id = ?";
					
				$result = $db->Execute($q, array($this->record['id']));
				if($result){
					return true;
				}else{
					$this->errors[] = "Error occurs when deleting this event";
					return false;
				}
			}else{
				$this->errors[] = "Error occurs when deleting event entries";
				return false;
			}
		}else{
			$this->errors[] = "id is missing";
			return false;
		}
	}
	
	public function getErrors(){
		return $this->errors;
	}
	
	public function getEntryNumber($status = false){
		$db = Loader::db();
		$params = array($this->record['id']);
		$q = "SELECT count(id) as count FROM CupCompetitionEventEntry WHERE eventID = ?";
		if($status){
			$q .= ' AND status LIKE ?';
			$params[] = $status;
		}
		$result = $db->getRow($q, $params);
		return $result['count'];
	}
	
	public function validation(){
		$this->record['name'] = trim($this->record['name']);
	
		$this->errors = array();
		
		if(strlen($this->record['name']) < 1){
			$this->errors[] = "Name is required";
		}else{
			$db = Loader::db();
			$params = array($this->record['name']);
			$q = "select count(id) as count from CupCompetitionEvent WHERE name LIKE ?";
			if($this->record['id'] > 0){
				$q .= ' AND id <> ?';
				$params[] = $this->record['id'];
			}
			$db_result = $db->getRow($q, $params);
		
			if($db_result['count'] > 0){
				$this->errors[] = "Name has been used";
			}
		}
		
		$start_time = strtotime($this->record['start_time']);
		$end_time = strtotime($this->record['end_time']);
		
		if($start_time === false){
			$this->errors[] = "Start Time is required";
		}
		if($end_time === false){
			$this->errors[] = "End Time is required";
		}else if($start_time >= $end_time){
			$this->errors[] = "Start Time is later than End Time";
		}
		
		if(isset($this->record['form_config']) 
			&& is_array($this->record['form_config'])
				&& count($this->record['form_config']) > 0){
					
			foreach($this->record['form_config'] as $idx => $field){
				$fieldname = trim($field['field_name']);
				$this->record['form_config'][$idx]['field_name'] = $fieldname;
				if(strlen($fieldname) < 1){
					$this->errors[] = "Form Builder [{$idx}]: field name is required";
				}
				
				if(strcmp($field['field_type'], 'select') == 0 && count(explode("\n", $field['field_config'])) < 2){
					$this->errors[] = "Form Builder [{$idx}]: Select field require minimum 2 options";
				}elseif(strcmp($field['field_type'], 'checkbox') == 0 && strlen(trim($field['field_config'])) < 1){
					$this->errors[] = "Form Builder [{$idx}]: Checkbox field require minimum 1 option";
				}
			}
				
		}
		
		
		
		if(count($this->errors) > 0){
			return false;
		}
		
		return true;
	}
}
?>