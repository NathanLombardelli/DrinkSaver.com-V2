import {useEffect} from 'react';


export const FormBars = () => {

    useEffect(() => {
            document.getElementById('barsMapUrlInput').addEventListener('change',(event)=>{
            let mapsUrl = event.target.value; // ex https://www.google.com/maps/place/Le+Pot+au+Lait,+Rue+Soeurs-de-Hasque+9,+4000+Liège/@50.643252,5.5734209,16z/data=!4m6!3m5!1s0x47c0fa0f9cd88837:0x4da5119b47d37815!8m2!3d50.64043!4d5.5733313!16s%2Fg%2F1tcxyznk
            let cutStart = mapsUrl.substring(mapsUrl.indexOf('/@')+2);
            let Lat = cutStart.substring(0,cutStart.indexOf(','));
            let Long = cutStart.substring(cutStart.indexOf(',')+1,cutStart.lastIndexOf(','));
            document.getElementById('barsLatInput').value = Lat;
            document.getElementById('barsLongInput').value = Long;
        });

            document.getElementById('barsImageInput').addEventListener("change", (event) =>{
                document.getElementById('Image').src = event.target.value;
            });

    });



    return (

            <form>
                <label>Bars Name</label>
                <input type='text' id='barsNameInput'/>
                <label>Maps Url</label>
                <input type='text' id='barsMapUrlInput'/>


                    <label>Latitude</label>
                    <input type='number' id='barsLatInput'/>
                    <label>Longitude</label>
                    <input type='number' id='barsLongInput'/>


                <label>Url Image</label>
                <input type='text' id='barsImageInput'/>
                <img id={'Image'}/>
                <label>Min card</label>
                <input type='text' id='barsMinCardInput'/>
                <label>Ouverture</label>
                <input type='time' id='barsOpenInput'/>
                <label>Fermeture</label>
                <input type='time' id='barsCloseInput'/>
                <label>happy Hour</label>
                <input type='text' id='barsHpHrInput'/>

                <div id={'checkBoxsBar'}>
                    <label>Exterieur</label>
                    <input type='checkbox' id='barsExtInput'/>
                    <label>Interieur</label>
                    <input type='checkbox' id='barsIntInput'/>
                    <label>Espace Fumeur</label>
                    <input type='checkbox' id='barsFumInput'/>
                    <label>Toilettes</label>
                    <input type='checkbox' id='barsWcInput'/>
                    <label>Toilettes payantes</label>
                    <input type='checkbox' id='barsWcPayInput'/>
                    <label>Wifi</label>
                    <input type='checkbox' id='barsWifiPayInput'/>
                    <label>Manger</label>
                    <input type='checkbox' id='barsEatInput'/>
                    <label>Jeux de fléchettes</label>
                    <input type='checkbox' id='barsDartInput'/>
                    <label>Jeux de billard</label>
                    <input type='checkbox' id='barsBillardInput'/>
                    <label>Kicker</label>
                    <input type='checkbox' id='barsKickerInput'/>
                </div>

                <button>Create</button>
            </form>
    );


};

