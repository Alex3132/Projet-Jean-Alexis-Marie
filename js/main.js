
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
var IDREGION;

function changeRegion() {
    var modifregion = document.getElementById('modifregion');
    var bt = document.getElementById('btModifRegion');

    if (IDREGION === modifregion.value) {
        bt.setAttribute('disabled', '');
    } else {
        bt.removeAttribute('disabled');
    }
}

function setListDep(xmlr, idregion) {
    if (xhr.status >= 200 && xhr.status < 400) {
        document.getElementById("listdep").innerHTML = xhr.responseText;
        var modifregion = document.getElementById('modifregion');
        modifregion.value = idregion;
        document.getElementById("divmodifregion").classList.remove('hidden');
    }
}

function selectionregion(url) {
    var selectregion = document.getElementsByName('selectregion');
    var rate_value;
    var idregion;
    var nomregion;
    var form = document.getElementById("changeregion");
    for (var i = 0; i < selectregion.length; i++) {
        if (selectregion[i].checked) {
            idregion = selectregion[i].value;
            document.getElementById("idregion").value = idregion;
            nomregion = selectregion[i].nextSibling.innerHTML;
            document.getElementById("nomregion").value = nomregion;
            IDREGION = idregion;
            break;
        }
    }

    if (xhr && xhr.readyState != 0) {
        xhr.abort(); // On annule la requête en cours !
    }

    xhr = new XMLHttpRequest()
    xhr.open('POST', url);
    var formdata = new FormData();
    xhr.addEventListener('load', function(){setListDep(xhr, idregion);}); 

    formdata.append('idregion', idregion);
    xhr.send(formdata);
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