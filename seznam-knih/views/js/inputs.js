function poezieF() {
    let poezieDiv = document.getElementById('poezie-input');
    let poezieRadio = document.getElementById('poezie');
    poezieDiv.classList.toggle("showNone");
}

function prozaF() {

    let prozaRadio = document.getElementById('proza');
    let prozaDiv = document.getElementById('proza-input');
    prozaDiv.classList.toggle("showNone");
}

function dramaF() {

    let dramaDiv = document.getElementById('drama-input');
    let dramaRadio = document.getElementById('drama');
    dramaDiv.classList.toggle("showNone");
}