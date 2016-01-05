<?php
//
// V2AB Set Spec Sub-system
// Requirement Level: sfo.class
//

class sSpc_9904 extends setSpecSuperClass{
	
	const cName = 'sSpc_9904';

	// Class Variables - �ϥΪ��ܼ�
	var $Rq_MS;
	var $Rq_Wep;

	// System Variables - sfo.class/obattle.ext ���ܼ�
	var $Pl;
	var $Op;

	// Constructors
	function __construct($Pl, $Op){
		$this->sSpc_9904($Pl, $Op);
	}
	
	function sSpc_9904($Pl, $Op){
		$this->Activated = false;
		$this->Rq_MS = '9904';        // �ݭnMS ID
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
		if($this->Activated){
			$this->removeReqStat();
			$this->Pl->Eq['A']['atk'] += 0;
			$this->Pl->Eq['A']['rd']  += 0;
			$this->Pl->Eq['A']['enc'] += 0;
		}
	}

	// Metaphase Modifications
	public function metaphase(){
		if(strpos($this->Pl->Specs,'Mob') !== false){
			$this->Pl->MS['ref'] += 6;
			if($this->Op){
				$this->Op->Eq['A']['hit']  = floor($this->Op->Eq['A']['hit'] * 0.85);
			}
		}
	}

}
?>