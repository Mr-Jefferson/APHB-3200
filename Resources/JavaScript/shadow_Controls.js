function display() {
    document.getElementById('shadow_add_student').style.display = "none";
    document.getElementById('shadow_add_marker').style.display = "none";

    document.getElementById('hidden_form').style.display = "block";
    document.getElementById('shadow_add_'+arguments[0]).style.display = "block";
}

function Hide() {
     document.getElementById('hidden_form').style.display = "none";
}
