"use strict";

window.onload = init;

var continents = [];
var paisos = [];

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
            let response = JSON.parse(xhr.responseText);
            let destins = response.destinacions;
            let llista = document.getElementById("datalistOptions");

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


