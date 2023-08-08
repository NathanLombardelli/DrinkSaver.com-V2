import {useEffect} from 'react';


export const FormBars = () => {

    useEffect(() => {
        // get lat and long from maps url
            document.getElementById('barsMapUrlInput').addEventListener('change',(event)=>{
            let mapsUrl = event.target.value; // ex https://www.google.com/maps/place/Le+Pot+au+Lait,+Rue+Soeurs-de-Hasque+9,+4000+Liège/@50.643252,5.5734209,16z/data=!4m6!3m5!1s0x47c0fa0f9cd88837:0x4da5119b47d37815!8m2!3d50.64043!4d5.5733313!16s%2Fg%2F1tcxyznk
            let cutStart = mapsUrl.substring(mapsUrl.indexOf('/@')+2);
            let Lat = cutStart.substring(0,cutStart.indexOf(','));
            let Long = cutStart.substring(cutStart.indexOf(',')+1,cutStart.lastIndexOf(',')); // changer
            document.getElementById('barsLatInput').value = Lat;
            document.getElementById('barsLongInput').value = Long;
        });

            // see image
            document.getElementById('barsImageInput').addEventListener("change", (event) =>{
                document.getElementById('Image').src = event.target.value;
            });

    });


    return (
        <>
            <form method={'POST'} action={'https://drinksaver.be/php/addBar.php'}>
                <label>Bars Name</label>
                <input type='text' id='barsNameInput' name={'Name'}/>
                <label>Maps Url</label>
                <input type='text' id='barsMapUrlInput' name={'MapsUrl'}/>

                <label>Latitude<span> * autocomplétion avec url google map (mais pas très précis)</span></label>
                <input type='text' id='barsLatInput' name={'Latitude'}/>
                <label>Longitude<span> * autocomplétion avec url google map (mais pas très précis)</span></label>
                <input type='text' id='barsLongInput' name={'Longitude'}/>


                <label>Url Image</label>
                <input type='text' id='barsImageInput' name={'Image'}/>
                <img id={'Image'}/>
                <label>Min card</label>
                <input type='text' id='barsMinCardInput' name={'MinCard'}/>
                <label>Ouverture</label>
                <input type='time' id='barsOpenInput' name={'Ouverture'}/>
                <label>Fermeture</label>
                <input type='time' id='barsCloseInput' name={'Fermeture'}/>
                <label>happy Hour</label>
                <input type='text' id='barsHpHrInput' name={'happyHour'}/>

                <div id={'checkBoxsBar'}>
                    <label>Exterieur</label>
                    <input type='checkbox' id='barsExtInput' name={'Exterieur'}/>
                    <label>Interieur</label>
                    <input type='checkbox' id='barsIntInput' name={'Interieur'}/>
                    <label>Espace Fumeur</label>
                    <input type='checkbox' id='barsFumInput' name={'Fumeur'}/>
                    <label>Toilettes</label>
                    <input type='checkbox' id='barsWcInput' name={'Toilettes'}/>
                    <label>Toilettes payantes</label>
                    <input type='checkbox' id='barsWcPayInput' name={'ToilettesPayante'}/>
                    <label>Wifi</label>
                    <input type='checkbox' id='barsWifiPayInput' name={'Wifi'}/>
                    <label>Manger</label>
                    <input type='checkbox' id='barsEatInput' name={'manger'}/>
                    <label>Jeux de fléchettes</label>
                    <input type='checkbox' id='barsDartInput' name={'dart'}/>
                    <label>Jeux de billard</label>
                    <input type='checkbox' id='barsBillardInput' name={'billard'}/>
                    <label>Kicker</label>
                    <input type='checkbox' id='barsKickerInput' name={'kicker'}/>
                </div>
                <input type="submit" value="Submit"/>
            </form>
        </>
    );


};

