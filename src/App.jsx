import './style.css'
import {Select} from "./assets/Select.jsx";
import {Tris} from "./assets/Tris.jsx";

function App() {

  return (
    <>
        <div className="rechercheBar">
            <Select></Select>
            <Tris></Tris>
        </div>
        <p id="Loading">Recherche de votre position en cours, veuillez activé la localisation sur votre appareil</p>

    </>
  )
}

export default App
