import { useEffect } from 'react';
import $ from "jquery";

export const Select  = () => {

    useEffect(() => {

        /* boucle tab produit bd */
        let produits = [];

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
        produits.forEach(p => {
            let newOption = new Option(p.name);
            $('#select-products').append(newOption);
        });
    });




    return (

        <>
            <input list="select-products" id="productInput" autoComplete="off" />
            <datalist id="select-products">

            </datalist>
        </>
    );


};