/**
*
* @author: Sergi Triadó <s.triado@sapalomera.cat>
* @author: Jordi Palomino <j.palomino@sapalomera.cat>
*
*/

"use strict";

window.onload = init;

//Variables globals
var continents, paisos, continents, pais, formathora = false, preureserves, preuofertes;

function init() {
    rellotge();
    document.getElementById("ofertes").addEventListener("click", loadOfertes);
    document.getElementById("reserves").addEventListener("click", loadReserves);
}

/**
 * Funció que mostra el rellotge
 * @returns {undefined}
 */
function rellotge() {
    var data = new Date();
    var hora = data.getHours();
    var minuts = data.getMinutes();
    var segons = data.getSeconds();
    var dia = data.getDate();
    var mes = data.getMonth() + 1;
    var any = data.getFullYear();
    var diaSetmana = data.getDay();
    var textampm;
    if (formathora == false) {
        //format hora 24h
        if (hora < 10) {
            hora = "0" + hora;
        }
        if (minuts < 10) {
            minuts = "0" + minuts;
        }
        if (segons < 10) {
            segons = "0" + segons;
        } 
    }else {
        //Format AM/PM
        if (hora > 12) {
            hora = hora - 12;
            textampm = "PM";
        } else {
            textampm = "AM";
        }
        if (hora < 10) {
            hora = "0" + hora;
        }
        if (minuts < 10) {
            minuts = "0" + minuts;
        }
        if (segons < 10) {
            segons = "0" + segons;
        }
    }
    if (dia < 10) {
        dia = "0" + dia;
    }
    if (mes < 10) {
        mes = "0" + mes;
    }
    switch (diaSetmana) {
        case 0:
            diaSetmana = "Diumenge";
            break;
        case 1:
            diaSetmana = "Dilluns";
            break;
        case 2:
            diaSetmana = "Dimarts";
            break;
        case 3:
            diaSetmana = "Dimecres";
            break;
        case 4:
            diaSetmana = "Dijous";
            break;
        case 5:
            diaSetmana = "Divendres";
            break;
        case 6:
            diaSetmana = "Dissabte";
            break;
    }
    document.getElementById("data").innerHTML = diaSetmana + ", " + dia + "/" + mes + "/" + any + " " + hora + ":" + minuts + ":" + segons;
    document.getElementById("data").innerHTML += (textampm != null) ? " " + textampm : "";
    document.getElementById("data").addEventListener("dblclick", function () {
        formathora = !formathora;
    });
    setTimeout("rellotge()", 1000);
}
/**
 * Funció que carrega el formulari d'ofertes
 * @returns {undefined}
 */
function loadOfertes() {
    let formulari = document.getElementById("formulari");
    formulari.innerHTML = "";
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "templates/ofertes.html", true);
    xhr.onload = function () {
        if (xhr.status == 200) {
            formulari.innerHTML = xhr.responseText;
        }
    }
    xhr.send();
    mostrarOfertes();
}
/**
 * Funció que carrega el formulari de reserves
 * @returns {undefined}
 */
function loadReserves() {
    let formulari = document.getElementById("formulari");
    formulari.innerHTML = "";
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "templates/reserves.html", true);
    xhr.onload = function () {
        if (xhr.status == 200) {
            formulari.innerHTML = xhr.responseText;
        }
    }
    xhr.send();
    mostrarReserves();
}

function llistarContinents() {
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "php_rest/api/destinacions/read.php?read=continents", true);
    xhr.onload = function () {
        if (xhr.status == 200) {
            let destins = JSON.parse(xhr.responseText);
            let llista = document.getElementById("continents");
            llista.innerHTML = "";
            destins.destinacions.forEach(continent => {
                let option = document.createElement("option");
                option.innerHTML = continent.continent;
                llista.appendChild(option);
            });
        }
    }
    xhr.send();
}
/**
 * Funció que llista els països
 * @returns {undefined}
 */
function llistarPaisos() {
    if (document.getElementById("Continent").value == "null") {
        document.getElementById("Pais").innerHTML = "<option value='null' default>No has seleccionat cap continent</option>";
    } else {
        let xhr = new XMLHttpRequest();
        xhr.open("GET", "php_rest/api/destinacions/read.php?read=ALL", true);
        xhr.onload = function () {
            if (xhr.status == 200) {
                let destins = JSON.parse(xhr.responseText);
                let llista = document.getElementById("Pais");
                llista.innerHTML = "";
                if (document.getElementById("Continent").value == "0") {
                    llista.innerHTML = "<option value='0'>No has seleccionat cap continent</option>"
                } else {
                    destins.destinacions = destins.destinacions.filter(destin => destin.continent == document.getElementById("Continent").value);
                    for (let i = 0; i < destins.destinacions.length; i++) {
                        let option = document.createElement("option");
                        option.value = destins.destinacions[i].id;
                        option.id = destins.destinacions[i].pais;
                        option.innerHTML = destins.destinacions[i].pais;
                        llista.appendChild(option);
                    }
                    if (destins.destinacions.length == 0) {
                        llista.innerHTML = "<option value='0'>No hi ha paisos disponibles</option>"
                        document.getElementById("Pais").setAttribute("disabled", "disabled");
                        document.getElementById("intropais").removeAttribute("hidden");
                        document.getElementById("labintro").removeAttribute("hidden");
                    } else {
                        llista.removeAttribute("disabled");
                        document.getElementById("intropais").removeAttribute("hidden");
                        document.getElementById("labintro").removeAttribute("hidden");
                        let option = document.createElement("option");
                        option.value = "0";
                        option.innerHTML = "Selecciona un pais";
                        option.setAttribute("selected", "selected");
                        llista.insertBefore(option, llista.firstChild);
                    }
                }
            }
        }
        xhr.send();
    }
}
/**
 * Funció que comprova si el pais existeix a la base de dades
 * @returns {undefined}
 */
function comprovarPaisBD() {
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "php_rest/api/destinacions/read.php?read=ALL", true);
    xhr.onload = function () {
        if (xhr.status == 200) {
            let resultat = JSON.parse(xhr.responseText);
            return resultat.resultat;
        }
    }
    let data = {
        "pais": document.getElementById("Pais").value,
        "continent": document.getElementById("Continent").value,
    }
    xhr.send(JSON.stringify(data));
}

function afegirOferta() {
    let idpais = document.getElementById("Pais").value;
    if (idpais == 0) {
        afegirdestinacio();
        idpais = comprovarPaisBD();
    }
    
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php_rest/api/ofertes/create.php", true);
    xhr.onload = function () {
        if (xhr.status == 200) {
            let resultat = JSON.parse(xhr.responseText);
            if (resultat.resultat == "OK") {
                alert("Oferta creada correctament");
                mostrarOfertes();
            } else {
                alert("Error al crear la oferta");
            }
        }
    }

    let oferta = {
        "pais": document.getElementById("Pais").value,
        "titol": document.getElementById("titol").value,
        "intropais": document.getElementById("intropais").value,
        "preupersona": document.getElementById("preupersona").value,
        "datainici": document.getElementById("datainici").value,
        "datafinal": document.getElementById("datafinal").value,
    }
    xhr.send(JSON.stringify(oferta));
}
/**
 * Funció que mostra les ofertes
 * @returns {undefined}
 */
function mostrarOfertes() {
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "php_rest/api/ofertes/read.php?read=ALL", true);
    xhr.onload = function () {
        if (xhr.status == 200) {
            let ofertes = JSON.parse(xhr.responseText);
            let taula = document.getElementById("taulaofertes");
            taula.innerHTML = "";
            if (ofertes.ofertes.length == 0) {
                taula.innerHTML = "<h3>Encara no s'han creat ofertes</h3>"
            } else {
                for (let i = 0; i < ofertes.ofertes.length; i++) {
                    let tr = document.createElement("tr");
                    let td = document.createElement("td");
                    td.innerHTML = ofertes.ofertes[i].titol;
                    tr.appendChild(td);
                    td = document.createElement("td");
                    td.innerHTML = ofertes.ofertes[i].destinacio;
                    tr.appendChild(td);
                    td = document.createElement("td");
                    td.innerHTML = (ofertes.ofertes[i].preu_persona).toFixed(2) + "€";
                    tr.appendChild(td);
                    td = document.createElement("td");
                    td.innerHTML = ofertes.ofertes[i].data_inici;
                    tr.appendChild(td);
                    td = document.createElement("td");
                    td.innerHTML = ofertes.ofertes[i].data_fi;
                    tr.appendChild(td);
                    td = document.createElement("td");
                    td.innerHTML = "<button class='btn btn-danger' onclick='eliminarOferta(" + ofertes.ofertes[i].id + ")'>Eliminar</button>";
                    tr.appendChild(td);
                    taula.appendChild(tr);
                }
            }
        }
    }
    xhr.send();
}
/**
 * Funció que elimina una oferta
 * @param {undefined}
 */
function llistarOfertes(data, idpais){
    if (idpais != 0) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php_rest/api/ofertes/read.php?read=ALLNJ", true);
    xhr.onload = function () {
        if (xhr.status == 200) {
            let ofertes = JSON.parse(xhr.responseText);
            if (ofertes.ofertes.length == 0){
                document.getElementById("errorText").innerHTML = "No hi ha ofertes disponibles per aquesta data, consulta les ofertes disponibles per aquest pais i data";
                document.getElementById("error").removeAttribute("hidden");
            } else {
                document.getElementById("error").setAttribute("hidden", "hidden");
                let llistaofertes = document.getElementById("lliofertes");
                llistaofertes.innerHTML = "";
                preuofertes = [];
                let option = document.createElement("option");
                option.value = 0;
                option.innerHTML = "Selecciona una oferta";
                llistaofertes.appendChild(option);
                for(let i = 0; i < ofertes.ofertes.length; i++){
                    if (ofertes.ofertes[i].destinacio == document.getElementById("Pais").value){
                        let option = document.createElement("option");
                        option.value = ofertes.ofertes[i].id;
                        option.innerHTML = ofertes.ofertes[i].titol;
                        llistaofertes.appendChild(option);
                        preuofertes[ofertes.ofertes[i].id] = ofertes.ofertes[i].preu_persona;
                    }
                }
            }
        }
    }
    xhr.send();
    }
}

function setidoferta() {
    let idoferta = document.getElementById("lliofertes").value;
    document.getElementById("idoferta").value = idoferta;
    document.getElementById("preu").value = preuofertes[idoferta];
    preureserves = preuofertes[idoferta];
}

function multiplicarpreu() {
    let num = document.getElementById("npersones").value;
    document.getElementById("preu").value = preureserves * num;
}

function afegirReserva() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php_rest/api/reserves/create.php", true);
    xhr.onload = function () {
        if (xhr.status == 200) {
            let resultat = JSON.parse(xhr.responseText);
            if (resultat.success == true) {
                alert("Reserva creada correctament");
                mostrarReserves();
            } else {
                alert("Error al crear la reserva");
            }
        }
    }
    let dataavui = new Date();
    let reserva = {
        "idoferta": document.getElementById("idoferta").value,
        "nomclient": document.getElementById("nom").value,
        "telefon": document.getElementById("telefon").value,
        "npersones": document.getElementById("npersones").value,
        "descompte": document.getElementById("descompte").value,
        "datareserva": dataavui,
    }
    xhr.send(JSON.stringify(reserva));
}

function mostrarReserves() {
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "php_rest/api/reserves/read.php?read=ALL", true);
    xhr.onload = function () {
        if (xhr.status == 200) {
            let reserves = JSON.parse(xhr.responseText);
            let taula = document.getElementById("taulareserves");
            taula.innerHTML = "";
            if (reserves.reserves.length == 0) {
                taula.innerHTML = "<h3>Encara no s'han creat reserves</h3>"
            } else {
                for (let i = 0; i < reserves.reserves.length; i++) {
                    let tr = document.createElement("tr");
                    let td = document.createElement("td");
                    td.innerHTML = reserves.reserves[i].id;
                    tr.appendChild(td);
                    td = document.createElement("td");
                    td.innerHTML = reserves.reserves[i].client;
                    tr.appendChild(td);
                    td = document.createElement("td");
                    td.innerHTML = reserves.reserves[i].num_persones;
                    tr.appendChild(td);
                    td = document.createElement("td");
                    td.innerHTML = reserves.reserves[i].data_reserva;
                    tr.appendChild(td);
                    td = document.createElement("td");
                    td.innerHTML = reserves.reserves[i].oferta;
                    tr.appendChild(td);
                    td = document.createElement("td");
                    td.innerHTML = (reserves.reserves[i].descompte == 0) ? "No" : "Si";
                    tr.appendChild(td);
                    td = document.createElement("td");
                    td.innerHTML = "<button class='btn btn-danger' onclick='eliminarReserva(" + reserves.reserves[i].id + ")'>Eliminar</button>";
                    tr.appendChild(td);
                    taula.appendChild(tr);
                }
            }
        }
    }
    xhr.send();
}

function afegirdestinacio() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php_rest/api/destinacions/create.php", true);
    xhr.onload = function () {
        if (xhr.status == 200) {
        }
    }
    let data = {
        "pais": document.getElementById("intropais").value,
        "continent": document.getElementById("Continent").value,
    }
    xhr.send(JSON.stringify(data));
}

function eliminarOferta(id) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php_rest/api/ofertes/delete.php",true);
    xhr.onload = function () {
        if (xhr.status == 200) {
            let resultat = JSON.parse(xhr.responseText);
                alert("Oferta eliminada correctament");
                mostrarOfertes();
        }
    }
    let oferta = {
        "id": id
    }
    xhr.send(JSON.stringify(oferta));
}

