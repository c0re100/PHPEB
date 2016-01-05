<?php
//
// Hi-nu Gundam Set Spec Class
// Requirements: sfo.class, spc.superclass
//

class sSpc_9915 extends setSpecSuperClass{
	
	const cName = 'sSpc_9915';

	// Class Variables - �ϥΪ��ܼ�
	var $Rq_MS;
	var $Rq_Wep;

	// System Variables - sfo.class/obattle.ext ���ܼ�
	var $Pl;
	var $Op;

	// Constructors
	function __construct($Pl, $Op){
		$this->sSpc_9915($Pl, $Op);
	}
	
	function sSpc_9915($Pl, $Op){
		$this->Activated = false;
		$this->Rq_MS = '9915';        // �ݭnMS ID
		$this->Rq_Wep['A'] = '';  // �ݭn�D�Z�� ID, �]�� false �h������
		$this->Rq_Wep['B'] = '';  // �ݭn�ƥ� 1 ID, �P�W
		$this->Rq_Wep['C'] = '';  // �ݭn�ƥ� 2 ID, �P�W
		$this->Rq_Wep['D'] = '';  // �ݭn���U�˳� ID, �P�W
		$this->Pl = $Pl;
		$this->Op = $Op;
	}

	// Check Set Activation - �򥻱����˴�
	// Checks whether MS and Equipment match required.
	public function checkSetActivation(){
		$this->Activated = true;
		if($this->Pl->MS['id'] != $this->Rq_MS) $this->Activated = false;
		elseif($this->Pl->Player['typech'] != 'nt' && $this->Pl->Player['typech'] != 'enh') $this->Activated = false;
		else {
			foreach(array('A','B','C','D') as $v){
				if(!$this->Rq_Wep[$v]) continue;
				if ($this->Pl->Eq[$v]['id'] != $this->Rq_Wep[$v]){
					$this->Activated = false;
					break;
				}
			}
		}
	}

	// Prephase Modifications
	public function prephase(){
		$this->Tactics['spec'] .= " AllWepStirke";
		if($this->Activated){
			$this->removeReqStat();
			//$this->Pl->Player['level']
			//$this->Pl->Player['typech']
			$this->Pl->Eq['A']['atk'] += 0;
			$this->Pl->Eq['A']['rd']  += 0;
			$this->Pl->Eq['A']['enc'] += 0;
			$this->Pl->Eq['A']['spec'] .= ' TarC, ';
			$this->Pl->MS['atf'] += 0;
		}
	}

	// Metaphase Modifications
	public function metaphase(){
		if(strpos($this->Pl->Specs,'Mob') !== false){
			$this->Pl->MS['taf'] += 4;
			if($this->Op){
				$this->Pl->Eq['A']['hit'] = floor($this->Pl->Eq['A']['hit'] * 1.3);
			}
		}
	}

}

?>