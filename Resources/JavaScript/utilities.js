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
