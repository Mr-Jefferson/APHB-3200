function display() {
    var shadow = document.getElementById('shadow');
    shadow.style.display = "block";
    shadow.style.zIndex = 7;

    document.getElementById('shadow_'+arguments[0]).style.display = "block";
    
}

function Hide() {
    var shadow = document.getElementById('shadow');
    shadow.style.display = "none";
    shadow.style.zIndex = 0;
    var shadow_variable = document.getElementById('shadow_add_student');
    if( shadow_variable !== null){
        shadow_variable.style.display = "none";
    }
    shadow_variable = document.getElementById('shadow_add_marker');
    if( shadow_variable !== null){
        shadow_variable.style.display = "none";
    }
    shadow_variable = document.getElementById('shadow_cohort_select');
    if( shadow_variable !== null){
        shadow_variable.style.display = "none";
    }
    shadow_variable = document.getElementById('shadow_import');
    if( shadow_variable !== null){
        shadow_variable.style.display = "none";
    }
    shadow_variable = document.getElementById('shadow_update_student');
    if( shadow_variable !== null){
        shadow_variable.style.display = "none";
    }
    shadow_variable = document.getElementById('shadow_update_marker');
    if( shadow_variable !== null){
        shadow_variable.style.display = "none";
    }
    
    shadow_variable = document.getElementById('shadow_error');
    if(shadow_variable !== null){
        shadow_variable.style.display = "none";
    }
    
    
}

window.onload= window.onresize = function adjust_shadow_height_width(){
    var body = document.window;
    var html = document.documentElement;
    var height;
    
    if(typeof document.height !== 'undefined'){
        height = document.height;
    }
    else{
        height = Math.max(body.scrollheight,body.offsetHeight, html.clientHeight, html.scrillHeight);
    }
    
    document.getElementById('hidden_form').style.height = height.concat("px");
}

function checkInput(textbox) {
	var value = document.getElementById(textbox).value;
	//alert(textbox+"  =  "+value);
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
		//alert("test1");
		if((textbox=="ssd" || textbox=="ssd2")&& isNaN(value)){
			document.getElementById(textbox).style.border="1px solid red";
			alert("Must be a number.");
			flag=false;
		}
		//alert("test2");
		for(i = 0; i < specialChars.length;i++){
			if(value.indexOf(specialChars[i]) > -1){
			  flag=false;
			}
		}
		//alert("test3");
		if(flag){
			document.getElementById(textbox).style.border="";
		}
		else{
			document.getElementById(textbox).style.border="1px solid red";
			alert("can't contain special characters");
		}
		//alert("test4");
	}
	/*if(value==""){
		document.getElementById(textbox).style.border="1px solid red";
		alert("Must include value.");
	}*/
}
