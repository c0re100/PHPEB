//battle again?
setTimeout (function(){
        document.getElementById('battle_submit').disabled = true;
},1000);

var countdownNum = 2;
incTimer();

function incTimer(){
     setTimeout (function(){
         if(countdownNum > 0){
			document.getElementById('battle_submit').value = '追擊目標 (' + countdownNum + ')';
			countdownNum--;
            incTimer();
         } else if(countdownNum == 0){
			document.getElementById('battle_submit').value = '追擊目標';
			document.getElementById('battle_submit').disabled = false;
         }
     },1000);
}