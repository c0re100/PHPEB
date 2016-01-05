<?php
//
// Template of Set Spec Class
// Requirements: sfo.class, spc.superclass <some may require obattle.ext.php>
// Modifications Required: 
// 1. �� "sSpc_template" ��W�� "sSpc_<�s��>", <�s��> �۩w, ���୫��; �@4�B�ݧ�� (Class Name x2, Constructor x2)
// 2. �]�ݭn���U Phase ���� Code
//     - �i�H�ϥΩҦ� sfo.class �� variables, �Φ]�ݭn�M�� obattle.ext �� variables
//

class sSpc_template extends setSpecSuperClass{
	
	const cName = 'sSpc_template';

	// Class Variables - �ϥΪ��ܼ�
	var $Rq_MS;
	var $Rq_Wep;

	// System Variables - sfo.class/obattle.ext ���ܼ�
	var $Pl;
	var $Op;

	// Constructors
	function __construct($Pl, $Op){
		$this->sSpc_template($Pl, $Op);
	}
	
	function sSpc_template($Pl, $Op){
		$this->Activated = false;
		$this->Rq_MS = 'template';        // �ݭnMS ID
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
		// Insert Code Here
		if($this->Activated){
			$this->removeReqStat();
		}
	}

	// Metaphase Modifications
	public function metaphase(){
		// Insert Code Here
	}

	// Battle Phase (Outer) Modifications
	public function battlephase(){
		// Insert Code Here
	}

}

?>