import $ from 'jquery';
import {createConnection} from "./dbConnection.js";
/**************************  Search ***********************/

createConnection().connect(function(err) {
    if (err) throw err;
    console.log("Connected!");
});

/* selectize */
$(document).ready(function() {


    var selectedValue = "";

    /* selection produits */
    let resultList = $("#resultList");
    let barsProx = [
        {name:'Pots au lait',
            latitude:50.6404338673672,
            longitude:5.573335305493846,
            mapurl:'https://goo.gl/maps/CoLmbzDcK88bDzFc8',
            image:'potaulait.png',
            minCardPrix:'10€',
            ouverture:'16',
            fermeture:'2',
            exterieur:true,
            interieur:true,
            fumeur:true,
            toilettes:true,
            wifi:true,
            toilettesPayante:true,
            manger:true,
            happyHour:'20h',
            carte:[
                {name:'Jupiler 25cl',prix:1.80},
                {name:'Jupiler 33cl',prix:2.10},
                {name:'Captain morgan',prix:2.50},
                {name:'Chouffe',prix:3.20},
            ]
        },
        {name:'Rock\'n roses',
            latitude:50.641429076396086,
            longitude:5.5687777457183865,
            mapurl:'https://goo.gl/maps/YiX2bBFCanMxhobK8',
            image:'RockNRosses.jpg',
            minCardPrix:'5€',
            ouverture:'17',
            fermeture:'3',
            exterieur:false,
            interieur:true,
            fumeur:false,
            toilettes:false,
            wifi:false,
            toilettesPayante:false,
            manger:false,
            happyHour:'20h',
            carte:[
                {name:'Jupiler 25cl',prix:2.40},
                {name:'Jupiler 33cl',prix:2.90},
                {name:'Bestiale blonde',prix:4.40},
                {name:'Val dieu triple',prix:5.20},
            ]
        }];


    // return '<div class="option">' +
    //     '<span class="image"><img src="img/' + data.value + '.png"  alt=" ' + data.text + ' " /></span>' +
    //     '<span class="textSelect">' + data.text + '</span>' +
    //     '</div>';

        // $('#select-products').selectize({
        //     render: {
        //         option: function (data) {
        //             return '<div class="option">' +
        //                 '<span class="image"><img src="img/' + data.value + '.png"  alt=" ' + data.text + ' " /></span>' +
        //                 '<span class="textSelect">' + data.text + '</span>' +
        //                 '</div>';
        //         }
        //     },
        //     sortField: 'text',
        //     maxOptions: 9999,
        //     onInitialize: function () {
        //         this.trigger('change', this.getValue(), true);
        //     },
        //     onChange: function () {
        //         selectedValue = $("#select-products option:selected").val();
        //         UpdateBars(resultList,barsProx);
        //     },
        //     dropdownParent: 'body'
        // });



/**************************  set list options ***********************/

let select = $('#productInput');
select.on('input',()=>{
    selectedValue = $("#productInput").val();
    UpdateBars(resultList,barsProx);
});


var produits = [];

/* boucle tab produit bd */

produits.push({name: 'Jupiler 25cl', image: 'jupiler'});
produits.push({name: 'Jupiler 33cl', image: 'jupiler33'});
produits.push({name: 'Captain morgan', image: 'captain-morgan'});
produits.push({name: 'Chouffe', image: 'chouffe'});
produits.push({name: 'Val dieu triple', image: 'Val-dieu-triple'});
produits.push({name: 'Bestiale blonde', image: 'Bestiale-blonde'});
produits.push({name: 'Cuvée des trolls', image: 'cuvee-des-trolls'});
produits.push({name: 'Cubanisto', image: 'Cubanisto'});
produits.push({name: 'Belle-vue kriek', image: 'Belle-vue-kriek'});
produits.push({name: 'Bestiale blonde', image: 'Bestiale-blonde'});
produits.push({name: 'Carlsberg', image: 'Carlsberg'});
produits.push({name: 'Chimay bleue', image: 'Chimay-bleue'});
produits.push({name: 'Bestiale légère', image: 'Bestiale-légère'});
produits.push({name: 'Chimay blonde', image: 'Chimay-blonde'});
produits.push({name: 'Corona', image: 'corona'});
produits.push({name: 'Curtius smash', image: 'Curtius-smash'});
produits.push({name: 'Despérados', image: 'Desperados'});
produits.push({name: 'Duvel', image: 'Duvel'});


/* boucle creation options */
produits.forEach(p =>{
    let newOption = new Option(p.name);
    newOption.addEventListener('click',()=>{
        selectedValue = p.name;
        UpdateBars(resultList,barsProx);
    });

    $('#select-products').append(newOption);
});



/**************************  position ***********************/


var position;

var options = {
    enableHighAccuracy: true,
    timeout: 5000,
    maximumAge: 0
};


function success(pos) {
    let Loading = $("#Loading");
    Loading.text("Position chargée");
    Loading.css('color',"green");
    position = pos.coords;

    console.log('Votre position actuelle est :');
    console.log(`Latitude : ${position.latitude}`);
    console.log(`Longitude : ${position.longitude}`);
    console.log(`La précision est de ${position.accuracy} mètres.`);
}

function error(err) {
    console.warn(`ERREUR (${err.code}): ${err.message}`);
}

// Vérifier si la permission est accordée
navigator.permissions.query({ name: 'geolocation' }).then(function(result) {
    if (result.state === 'granted') {
        // La permission est déjà accordée, obtenir la position actuelle
        navigator.geolocation.getCurrentPosition(success, error, options);
    } else if (result.state === 'prompt') {
        // La permission n'est pas encore accordée, afficher la demande de permission
        navigator.geolocation.getCurrentPosition(success, error, options);
    } else if (result.state === 'denied') {
        // La permission est refusée, afficher un message d'erreur ou une alternative
        console.warn('La permission de localisation est refusée.');
    }
});


//navigator.geolocation.watchPosition(success, error, options);




// var bars= [];


var TriToilettesVar = false;
var TriZoneFumeurVar= false;
var TriOuvertVar= true;
var TriInterieurVar= false;

let TriToilettes = $('#Toilettes');
let TriZoneFumeur = $('#ZoneFumeur');
let TriOuvert = $('#Ouvert');
let TriInterieur = $('#Interieur');


//on = addEventListener for JQuery.

TriToilettes.on("change",()=>{
    TriToilettesVar = !TriToilettesVar;
    UpdateBars(resultList,barsProx);
});

TriZoneFumeur.on("change",()=>{
    TriZoneFumeurVar = !TriZoneFumeurVar;
    UpdateBars(resultList,barsProx);
});

TriOuvert.on("change",()=>{
    TriOuvertVar = !TriOuvertVar;
    UpdateBars(resultList,barsProx);
});

TriInterieur.on("change",()=>{
    TriInterieurVar = !TriInterieurVar;
    UpdateBars(resultList,barsProx);
});

function UpdateBars(resultList,barsProx) {

    $("#resultList").empty(); /* Remise a zero list bars */

    barsProx.forEach(bar=>{
        bar.carte.every(prod=>{

            if(selectedValue === ""){
                return false;
            }

            if(TriToilettesVar && !bar.toilettes){
                return false;
            }

            if(TriInterieurVar && !bar.interieur){
                return false;
            }

            if(TriZoneFumeurVar && !bar.fumeur){
                return false;
            }
            let current = new Date();
            if(TriOuvertVar && bar.ouverture > current.getHours() && bar.fermeture < current.getHours()){
                return false;
            }

            if(prod.name === selectedValue){
                CreateBarInfos(bar, prod);
                return false;
            }

        });

    });


}

function CreateBarInfos(bar, prod) {
    let elem = document.createElement("div");
    elem.setAttribute("id", bar.name); // id = name bar
    elem.setAttribute("class", "result"); // calss = result

    let link = document.createElement("a");
    link.setAttribute("href", bar.mapurl);

    let infos = document.createElement("div");
    infos.setAttribute("class", "infos"); // id = name bar

    let img = document.createElement("img");
    img.setAttribute("src", "../../src/img/" + bar.image);

    let barName = document.createElement("p");
    barName.setAttribute("class", "barName");
    barName.innerText = bar.name;

    let prix = document.createElement("p");
    prix.setAttribute("class", "prix");
    prix.innerText = prod.prix + "€";

    let distance = document.createElement("p");
    distance.setAttribute("class", "distance");
    distance.innerText = getDistance(bar.latitude, bar.longitude);

    let icons = document.createElement("div");
    icons.setAttribute("class", "icons");

    let minCardDiv = document.createElement("div");

    let minCard = document.createElement("i");
    minCard.setAttribute("class", "fa-solid fa-money-check-dollar");
    let minCardPrix = document.createElement("p");

    minCardDiv.style.display = "flex";
    minCardDiv.appendChild(minCard);
    minCardDiv.appendChild(minCardPrix);


    minCardPrix.innerText = bar.minCardPrix;
    minCardPrix.style.fontSize = "2em";

    let horraireDiv = document.createElement("div");

    let horaire = document.createElement("i");
    horaire.setAttribute("class", "fa-regular fa-clock");

    let horaireText = document.createElement("p");
    horaireText.innerText = bar.ouverture + 'h' + '-' +  bar.fermeture + 'h';
    horaireText.style.fontSize = "2em";

    horraireDiv.style.display = "flex";
    horraireDiv.appendChild(horaire);
    horraireDiv.appendChild(horaireText);

    let fumeur = document.createElement("i");
    if (bar.fumeur) {
        fumeur.setAttribute("class", "fa-solid fa-smoking");
    } else {
        fumeur.setAttribute("class", "fa-solid fa-ban-smoking");
    }

    let wifi = document.createElement("i");
    wifi.setAttribute("class", "fa-solid fa-wifi");
    if (bar.wifi) {
        wifi.style.color = "green";
    } else {
        wifi.style.color = "red";
    }

    wifi.setAttribute("class", "fa-solid fa-wifi");

    let toiletDiv = document.createElement("div");
    let toilet = document.createElement("i");
    let toiletPay = document.createElement("i");
    toilet.setAttribute("class", "fa-solid fa-restroom");
    if (bar.toilettes) {
        toilet.style.color = 'green';
        if (bar.toilettesPayante) {
            toiletPay.setAttribute("class", "fa-solid fa-coins");
            toiletPay.setAttribute("alt", "toilettes payantes");
        }
    } else {
        toilet.style.color = 'red';
    }
    toiletDiv.appendChild(toilet);
    toiletDiv.appendChild(toiletPay);
    toiletDiv.style.display = "flex";

    let manger = document.createElement("i");
    manger.setAttribute("class", "fa-solid fa-utensils");
    if (bar.manger) {
        manger.style.color = 'green';
    } else {
        manger.style.color = 'red';
    }

    let interieur = document.createElement("i");
    interieur.setAttribute("class", "fa-sharp fa-solid fa-person-shelter");
    if (bar.interieur) {
        interieur.style.color = 'green';
    } else {
        interieur.style.color = 'red';
    }

    icons.appendChild(interieur);
    icons.appendChild(manger);
    icons.appendChild(toiletDiv);
    icons.appendChild(fumeur);
    icons.appendChild(wifi);
    icons.appendChild(horraireDiv);
    icons.appendChild(minCardDiv);

    infos.appendChild(barName);
    infos.appendChild(prix);
    infos.appendChild(distance);
    infos.appendChild(icons);

    link.appendChild(infos);
    link.appendChild(img);

    elem.appendChild(link);

    $("#resultList").append(elem);
}

function getDistance(barLatitude,barLongitude) {

    const R = 6371; // rayon de la Terre en km
    const dLat = deg2rad(position.latitude - barLatitude);
    const dLon = deg2rad(position.longitude  - barLongitude);
    const a =
        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(deg2rad(position.latitude)) *
        Math.cos(deg2rad(barLatitude)) *
        Math.sin(dLon / 2) *
        Math.sin(dLon / 2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    const d = R * c * 1000; // distance en mètres

    if (d < 1000) {
        return `${d.toFixed(0)}m`;
    } else {
        return `${(d / 1000).toFixed(2)}km`;
    }

}

function deg2rad(deg) {
    return deg * (Math.PI / 180);
}

});