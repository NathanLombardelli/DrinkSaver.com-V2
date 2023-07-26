export const Tris = () => {

    return (

        <ul className="rechercheTris">
            <li className="flex">
                <input className="tgl tgl-skewed" id="Toilettes" type="checkbox"/>
                <label className="tgl-btn" data-tg-off="NON" data-tg-on="OUI" htmlFor="Toilettes"></label>
                <p>Toilettes</p>
            </li>

            <li className="flex">
                <input className="tgl tgl-skewed" id="ZoneFumeur" type="checkbox"/>
                <label className="tgl-btn" data-tg-off="NON" data-tg-on="OUI" htmlFor="ZoneFumeur"></label>
                <p>Zone fumeur</p>
            </li>

            <li className="flex">
                <input className="tgl tgl-skewed" id="Ouvert" type="checkbox"/>
                <label className="tgl-btn" data-tg-off="NON" data-tg-on="OUI" htmlFor="Ouvert"></label>
                <p>Ouvert</p>
            </li>

            <li className="flex">
                <input className="tgl tgl-skewed" id="Interieur" type="checkbox"/>
                <label className="tgl-btn" data-tg-off="NON" data-tg-on="OUI" htmlFor="Interieur"></label>
                <p>Interieur</p>
            </li>

        </ul>

    );


};