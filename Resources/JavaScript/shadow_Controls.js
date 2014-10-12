function display() {
    document.getElementById('shadow_add_student').style.display = "none";
    document.getElementById('shadow_add_marker').style.display = "none";
    document.getElementById('shadow_cohort_select').style.display = "none";
    document.getElementById('shadow_import').style.display = "none";
    
    document.getElementById('hidden_form').style.display = "block";
    document.getElementById('shadow_'+arguments[0]).style.display = "block";
}

function Hide() {
     document.getElementById('hidden_form').style.display = "none";
}

function isInt_float(n){
    return n.toString().indexOf('.') != -1 || n == parseInt(n);
}

function check_int(ID){
    
    var value = document.getElementById(ID).value;
   
    if(value >10 || value < 0 || isInt(value) === false){
      document.getElementById(ID).style.border="1px solid red";
    }
    alert(ID + " is not a int/float");
    
    
}