
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

var xhr = null;

function selectionregion(url) {
    var rates = document.getElementsByName('selectregion');
    var rate_value;
    var form = document.getElementById("changeregion");
    for (var i = 0; i < rates.length; i++) {
        if (rates[i].checked) {
            var idregion = rates[i].value;
            //document.getElementById("nomregion").value = rates[i].value;
            document.getElementById("idregion").value = idregion;
            var nomregion = rates[i].nextSibling.innerHTML;

            document.getElementById("nomregion").value = nomregion;
        }
    }

    //if (xhr && xhr.readyState != 0) {
    //    xhr.abort(); // On annule la requête en cours !
    //}

    //xhr.open(POST, url);
    //var formdata = new FormData();
    //xhr.addEventListener('load', function () {
    //    if (xhr.status >= 200 && xhr.status < 400) {
    //        console.log(xhr.responseText);
    //    }
    //});

    //formdata.append('idregion', idregion);
    //xhr.send(formdata);
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