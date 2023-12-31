import './style.css'
import {Select} from "./assets/Select.jsx";
import {Tris} from "./assets/Tris.jsx";
import {Footer} from "./assets/Footer.jsx";
import {BrowserRouter, Routes, Route} from "react-router-dom";
import {GamePage} from "./assets/GamePage.jsx";
import {EventPage} from "./assets/EventPage.jsx";
import {FormBars} from "./assets/FormBars.jsx";
import {FormAlcool} from "./assets/FormAlcool.jsx";

function App() {



 return (
    <BrowserRouter>
        <Routes>
            <Route index path="/" element={
                <>
                    <div className="rechercheBar">
                        <Select></Select>
                        <Tris></Tris>
                    </div>
                    <p id="Loading">Recherche de votre position en cours, veuillez activé la localisation sur votre appareil</p>
                    <div id="resultList"></div>


                    <Footer/>

                </>
            }/>

            <Route path="/GamePage" element={
                <>
                    <GamePage/>
                    <Footer/>
                </>
            }/>

            <Route path="FormBars" element={
                <>
                    <FormBars/>
                    <Footer/>
                </>
            }/>

            <Route path="EventPage" element={
                <>
                    <EventPage/>
                    <Footer/>
                </>
            }/>

            <Route path="/FormAlcool" element={
                <>
                    <FormAlcool/>
                    <Footer/>
                </>
            }/>

        </Routes>
    </BrowserRouter>
  )
}

export default App
