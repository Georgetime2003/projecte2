"use strict";

window.onload = init;

var continents, paisos;

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

function llistarDestins(){
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "php_rest/api/destinacions/read.php?read=ALL", true);
    xhr.onload = function () {
        if (xhr.status == 200) {
            let destins = JSON.parse(xhr.responseText);
            let llista = document.getElementById("datalistOptions");
            llista.innerHTML = "";
            destins.forEach(desti => {
                let option = document.createElement("option");
                option.value = desti.id;
                option.innerHTML = desti.continent;
                llista.appendChild(option);
            });
        }
    }
    xhr.send();
}


