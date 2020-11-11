<?php

// ---------------
// Analytics Class
// ---------------

class adminAnalytics {
	
	// Exportar informações Totais
	function get_total() {
		
		$obj = file_read("data_analytics/status.json");
		if ($obj == false) { $obj = new stdClass(); $obj->acessos = 0; $obj->users = 0; }
		return $obj;
		
	}
	
	// Exportar informações de uma pagina
	function get_page($p) {
		
		$master = $this->get_total();
		
		if ($p == 0) {
			return file_read("data_analytics/".ceil($master->acessos/1000).".json");
		} else if (ceil($master->acessos/1000)>=$p) {
			return file_read("data_analytics/".$p.".json");
		} else {
			return false;
		}
		
	}
	
	// Exportar informações de um usuário
	function get_user_data($u) {
		
		$master = $this->get_total();
		
		if ($master->users>=$u) {
			
			$userInfo = [];
			
			for ($x = ceil($master->acessos/1000); $x > 0; $x--) {
				
				$obj = $this->get_page($x);
				if (!$obj == false) {
					
					for ($y = count($obj->acessos)-1;$y >= 0;$y--) {
						if ($obj->acessos[$y][1] == $u) {
							$userInfo[$obj->acessos[$y][2]][] = $obj->acessos[$y];
						}
					}
					
				}
				
			}
			
			return $userInfo;
			
		} else {
			return false;
		}
		
	}
	
}

?>