"use strict";

window.onload = init;

var continents, paisos, continents, pais, formathora = false;

function init() {
    rellotge();
    document.getElementById("ofertes").addEventListener("click", loadOfertes);
    document.getElementById("reserves").addEventListener("click", loadReserves);
}

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
        rellotge();
    });
    setTimeout("rellotge()", 1000);
}

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
}

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
                    }
                }
            }
        }
        xhr.send();
    }
}

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
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php_rest/api/ofertes/create.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onload = function () {
        if (xhr.status == 200) {
            let resposta = JSON.parse(xhr.responseText);
            if (resposta.status == "success") {
                alert("Oferta creada correctament");
                mostrarOfertes();
            } else {
                alert("Error al crear l'oferta");
            }
        }
    }
    let oferta = {
        "pais": document.getElementById("Pais").value,
        "preuperpersona": document.getElementById("Preu").value,
        "datainici": document.getElementById("DataInici").value,
        "datafi": document.getElementById("DataFinal").value,
    }
}

function mostrarOfertes() {
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "php_rest/api/ofertes/read.php", true);
    xhr.onload = function () {
        if (xhr.status == 200) {
            let ofertes = JSON.parse(xhr.responseText);
            let taula = document.getElementById("ofertes");
            taula.innerHTML = "";
            if (document.getElementById("Pais").value == "0") {
                taula.innerHTML = "<h3>Encara no s'han creat ofertes</h3>"
            } else {
                ofertes.ofertes = ofertes.ofertes.filter(oferta => oferta.pais == document.getElementById("Pais").value);
                for (let i = 0; i < ofertes.ofertes.length; i++) {
                    let tr = document.createElement("tr");
                    let td = document.createElement("td");
                    td.innerHTML = ofertes.ofertes[i].pais;
                    tr.appendChild(td);
                    td = document.createElement("td");
                    td.innerHTML = ofertes.ofertes[i].preu;
                    tr.appendChild(td);
                    td = document.createElement("td");
                    td.innerHTML = ofertes.ofertes[i].data_inici;
                    tr.appendChild(td);
                    td = document.createElement("td");
                    td.innerHTML = ofertes.ofertes[i].data_fi;
                    tr.appendChild(td);
                    td = document.createElement("td");
                    td.innerHTML = ofertes.ofertes[i].places;
                    tr.appendChild(td);
                    td = document.createElement("td");
                    td.innerHTML = ofertes.ofertes[i].places_disponibles;
                    tr.appendChild(td);
                    taula.appendChild(tr);
                }
            }
        }
    }
    xhr.send();
}

