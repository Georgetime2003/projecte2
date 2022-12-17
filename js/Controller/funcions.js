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
    xhr.open("GET", "php_rest/api/destinacions/read.php?read=ALL", true);
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
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "php_rest/api/destinacions/read.php?read=ALL", true);
    xhr.onload = function () {
        if (xhr.status == 200) {
            let destins = JSON.parse(xhr.responseText);
            let llista = document.getElementById("datalistOptions");
            llista.innerHTML = "";
            for (let i = 0; i < destins.destinacions.length; i++) {
                let option = document.createElement("option");
                option.value = destins[i].pais;
                llista.appendChild(option);
            }
        }
    }
    xhr.send();
}


