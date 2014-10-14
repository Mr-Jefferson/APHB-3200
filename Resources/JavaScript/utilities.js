function display() {
    document.getElementById('hidden_form').style.display = "block";
    document.getElementById('shadow_'+arguments[0]).style.display = "block";
}

function Hide() {
    document.getElementById('hidden_form').style.display = "none";
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
