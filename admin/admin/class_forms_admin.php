<?php

// -----------
// Forms Class
// -----------

class adminForms {
	
	// Exportar informações Totais
	function get_total() {
		
		$obj = file_read("data_forms/status.json");
		if ($obj == false) { $obj = new stdClass(); $obj->total = 0; }
		
		return $obj;
		
	}
	
	// Exportar informações de uma pagina
	function get_page($p) {
		
		$master = $this->get_total();
		
		if ($p == 0) {
			return file_read("data_forms/".ceil($master->total/1000).".json");
		} else if (ceil($master->total/1000)>=$p) {
			return file_read("data_forms/".$p.".json");
		} else {
			return false;
		}
		
	}
	
	// Exportar informações de um usuário
	function get_user_data($u) {
		
		$analytics = new adminAnalytics();
		$masterA = $analytics->get_total();
		unset($analytics);
		
		if ($masterA->users>=$u) {
			
			$masterF = $this->get_total();
			
			if ($masterF->total>0) {
			
				$userInfo = [];
				
				for ($x = ceil($masterF->total/1000); $x > 0; $x--) {
					
					$obj = $this->get_page($x);
					if (!$obj == false) {
						
						for ($y = count($obj->submits)-1;$y >= 0;$y--) {
							if ($obj->submits[$y]->user == $u) {
								$userInfo[] = $obj->submits[$y];
							}
						}
						
					}
					
				}
			
				return $userInfo;
			
			} else {
				return false;
			}
			
		} else {
			return false;
		}
		
	}
	
	// Exportar um dado específico de um usuário
	function get_user_single_data($u,$d) {
		$data = $this->get_user_data($u);
		$value = "";
		if (!$data == false) {
			for ($x = 0; $x < count($data); $x++) {
				if (isset($data[$x]->$d)) {$value = $data[$x]->$d;}
			}
		}
		return $value;
	}
	
	// Exportar todos os usuários que enviaram formulários
	function get_user_list() {
			
		$master = $this->get_total();
			
		if ($master->total>0) {
		
			$userList = [];
			
			for ($x = ceil($master->total/1000); $x > 0; $x--) {
				
				$obj = $this->get_page($x);
				if (!$obj == false) {
					
					for ($y = count($obj->submits)-1;$y >= 0;$y--) {
						$userList[] = $obj->submits[$y]->user;
					}
					
				}
				
			}
			
			$userList = array_unique($userList);
			sort($userList);
			return $userList;
		
		} else {
			return false;
		}
		
	}
	
	/* Exportar todos os nomes de Formulários
	function get_forms_names() {
			
		$master = $this->get_total();
			
		if ($master->total>0) {
		
			$formsList = [];
			
			for ($x = ceil($master->total/1000); $x > 0; $x--) {
				
				$obj = $this->get_page($x);
				if (!$obj == false) {
					
					for ($y = count($obj->submits)-1;$y >= 0;$y--) {
						$formsList[] = $obj->submits[$y]->form;
					}
					
				}
				
			}
			
			$formsList = array_unique($formsList);
			sort($formsList);
			return $formsList;
		
		} else {
			return false;
		}
		
	}
	
	// Exportar Formulários de um tipo
	function get_forms_by_name($f) {
			
		$masterF = $this->get_total();
		
		if ($masterF->total>0) {
		
			$formName = [];
			
			for ($x = ceil($masterF->total/1000); $x > 0; $x--) {
				
				$obj = $this->get_page($x);
				if (!$obj == false) {
					
					for ($y = count($obj->submits)-1;$y >= 0;$y--) {
						if ($obj->submits[$y]->form == $f) {
							$formName[] = $obj->submits[$y];
						}
					}
					
				}
				
			}
		
			return $formName;
		
		} else {
			return false;
		}
		
	}
		
	*/	
	// Exportar dados de um formulario
	function get_form($f) {
		
		$master = $this->get_total();
			
		if ($master->total>=$f) {
		
			$obj = $this->get_page(ceil($f/1000));
			if (!$obj == false) {
					
				$index = $f-((ceil($f/1000)-1)*1000)-1;
				return $obj->submits[$index];
					
			}
		
		} else {
			return false;
		}
		
	}
	
}

?>