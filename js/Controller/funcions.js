"use strict";

window.onload = init;

var continents, paisos, continents, pais;

function init() {
    document.getElementById("ofertes").addEventListener("click", loadOfertes);
    document.getElementById("reserves").addEventListener("click", loadReserves);
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

function llistarContinents(){
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

function llistarPaisos(){
    if (document.getElementById("Continent").value == "null") {
        document.getElementById("paisos").innerHTML = "<option value='null' default>No has seleccionat cap continent</option>";
        } else {
        let xhr = new XMLHttpRequest();
        xhr.open("GET", "php_rest/api/destinacions/read.php?read=ALL", true);
        xhr.onload = function () {
            if (xhr.status == 200) {
                let destins = JSON.parse(xhr.responseText);
                let llista = document.getElementById("Pais");
                llista.innerHTML = "";
                if(document.getElementById("Continent").value == "0"){
                    llista.innerHTML = "<option value='0'>No has seleccionat cap continent</option>"
                } else {
                    destins.destinacions = destins.destinacions.filter(destin => destin.continent == document.getElementById("Continent").value);
                    for (let i = 0; i < destins.destinacions.length; i++) {
                        let option = document.createElement("option");
                        option.value = destins.destinacions[i].pais;
                        option.innerHTML = destins.destinacions[i].pais;
                        llista.appendChild(option);
                    }
                    if (destins.destinacions.length == 0) {
                        llista.innerHTML = "<option value='0'>No hi ha paisos disponibles</option>"
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

    function mostrarOfertes(){
        let xhr = new XMLHttpRequest();
        xhr.open("GET", "php_rest/api/ofertes/read.php", true);
        xhr.onload = function () {
            if (xhr.status == 200) {
                let ofertes = JSON.parse(xhr.responseText);
                let taula = document.getElementById("ofertes");
                taula.innerHTML = "";
                if(document.getElementById("Pais").value == "0"){
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
