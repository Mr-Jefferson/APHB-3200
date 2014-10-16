/**
 * Method: Used to activate the "shadow" effect and bring focus to the pop up window
 * 
 * @param string, passed by html tag calling it
 * @returns {undefined}
 */

function display() {
    var shadow = document.getElementById('shadow');
    shadow.style.display = "block";
    shadow.style.zIndex = 7;
    document.body.style.display="fixed";
    
    document.getElementById('shadow_'+arguments[0]).style.display = "block";
}

/**
 * Method: Lopps through all known shadow pop ups and check if they exist, if they do then change the display status to none
 * @returns {undefined}
 */
function Hide() {
    var shadow = document.getElementById('shadow');
    shadow.style.display = "none";
    shadow.style.zIndex = 0;
    var shadowPopUps = ['add_student','add_marker','cohort_select','import','update_student', 'update_marker','error'];
    for(i =0;i <shadowPopUps.length;i++){
        shadow_variable = document.getElementById('shadow_'+shadowPopUps[i]);
        if( shadow_variable !== null){
            shadow_variable.style.display = "none";
        }
    }
}
/**
 * Method: function designed to result BUG_006, shadow div was too small when the window size became to small and the overflow attribute was activated.
 * 
 * @returns {undefined}
 */
window.onload= window.onresize = function adjust_shadow_height_width(){
    var body = document.body;
    var html = document.documentElement;
    var height = 0;

    if (typeof document.height !== 'undefined') {
        height = document.height 
    } else {
        height = Math.max( body.scrollHeight, body.offsetHeight,html.clientHeight, html.scrollHeight, html.offsetHeight );
    }
        
    document.getElementById('shadow').style.height= height + "px";
};

function checkInput(textbox) {
	var value = document.getElementById(textbox).value;
	if(textbox=="mk1"||textbox=="mk2"||textbox=="mk3"){
		if(value>10 || value<0 || isNaN(value)){
		  document.getElementById(textbox).style.border="1px solid red";
		  alert(value + " is not a number between 1 and 10.");
		}
		else{
		  document.getElementById(textbox).style.border="";
		}
	}
	else{
		var specialChars = "<>@!#$%^&*()_+[]{}?:;|'\"\\,./~`-= ";
		var flag=true;
		if((textbox=="ssd" || textbox=="ssd2")&& isNaN(value)){
			document.getElementById(textbox).style.border="1px solid red";
			alert("Must be a number.");
			flag=false;
		}
		for(i = 0; i < specialChars.length;i++){
			if(value.indexOf(specialChars[i]) > -1){
			  flag=false;
			}
		}
		if(flag){
			document.getElementById(textbox).style.border="";
		}
		else{
			document.getElementById(textbox).style.border="1px solid red";
			alert("can't contain special characters");
		}
	}

}
