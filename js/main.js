
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
    var form = document.getElementById("changeregion");
    for (var i = 0; i < rates.length; i++) {
        if (rates[i].checked) {
            var idregion = rates[i].value;
            //document.getElementById("nomregion").value = rates[i].value;
            document.getElementById("idregion").value = idregion;
            var nomregion = form.region;

            document.getElementById("nomregion").value = "titi";
        }
    }
}

function verifchangeregion() {
    if (!document.getElementById("nomregion").value) {
        alert("Le nom de la region ne peut pas être vide.");
        return false;
    }

    return true;
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