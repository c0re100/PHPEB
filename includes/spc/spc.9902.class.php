<?php
//
// 9902 of Set Spec Class
// Requirements: sfo.class, spc.superclass <some may require obattle.ext.php>
// Modifications Required: 
// 1. �� "sSpc_9902" ��W�� "sSpc_<�s��>", <�s��> �۩w, ���୫��; �@4�B�ݧ�� (Class Name x2, Constructor x2)
// 2. �]�ݭn���U Phase ���� Code
//     - �i�H�ϥΩҦ� sfo.class �� variables, �Φ]�ݭn�M�� obattle.ext �� variables
//

class sSpc_9902 extends setSpecSuperClass{
	
	const cName = 'sSpc_9902';

	// Class Variables - �ϥΪ��ܼ�
	var $Rq_MS;
	var $Rq_Wep;

	// System Variables - sfo.class/obattle.ext ���ܼ�
	var $Pl;
	var $Op;

	// Constructors
	function __construct($Pl, $Op){
		$this->sSpc_9902($Pl, $Op);
	}
	
	function sSpc_9902($Pl, $Op){
		$this->Activated = false;
		$this->Rq_MS = '9902';        // �ݭnMS ID
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
		if($this->Op){
			$this->Op->Eq['A']['hit'] = floor($this->Op->Eq['A']['hit'] * 1);
		}
		if($this->Activated){
			$this->removeReqStat();
			$this->Pl->Eq['A']['atk'] += 0;
			$this->Pl->Eq['A']['rd']  += 0;
			$this->Pl->Eq['A']['enc'] += 0;
			$this->Pl->Eq['A']['spec'] .= ' , CostSP<1>, AntiPDef, DamB';
			if($this->Op){
				$this->Pl->SP_Cost += 1;
				$this->Op->SP_Cost += 0;
			}
		}
	}

}

?>