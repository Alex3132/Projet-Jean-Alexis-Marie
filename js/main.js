
function verifFormLogin(form) {
    
    var inputpseudo = form.pseudo;
    var inputppwd = form.pwd;
    var ret = true;
    if (!inputpseudo.value) {
        inputpseudo.classList.add("inputerror");
        ret = false;
    } else {
        inputpseudo.classList.remove("inputerror");
    }

    if (!inputppwd.value) {
        inputppwd.classList.add("inputerror");
        ret = false;
    } else {
        inputppwd.classList.remove("inputerror");
    }

    return ret;
}

//function verifFormInscription(form) {

//    var inputpseudo = form.pseudo;
//    var inputppwd = form.pwd;
//    var ret = true;
//    if (!inputpseudo.value) {
//        inputpseudo.classList.add("inputerror");
//        ret = false;
//    } else {
//        inputpseudo.classList.remove("inputerror");
//    }

//    if (!inputppwd.value) {
//        inputppwd.classList.add("inputerror");
//        ret = false;
//    } else {
//        inputppwd.classList.remove("inputerror");
//    }

//    return ret;
//}


function selectionregion() {
    var rates = document.getElementsByName('selectregion');
    var rate_value;
    for (var i = 0; i < rates.length; i++) {
        if (rates[i].checked) {
            document.getElementById("nomregion").value = rates[i].value;
        }
    }
}

//var pseudoOk = verifPseudo(f.pseudo);
//var mailOk = verifMail(f.email);
//var ageOk = verifAge(f.age);
   
//if(pseudoOk && mailOk && ageOk)
//    return true;
//else
//{
//    alert("Veuillez remplir correctement tous les champs");
//    return false;
//}