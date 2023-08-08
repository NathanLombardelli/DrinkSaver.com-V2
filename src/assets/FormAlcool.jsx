import {useEffect} from 'react';


export const FormAlcool = () => {

    useEffect(() => {

        //get param url (error or success message).
        const urlParams = new URLSearchParams(window.location.search);
        if(urlParams.has('result')){
            if(urlParams.get('result') === '1'){
                document.getElementsByClassName('SuccessMessage')[0].style.display = 'inline';
            }else{
                document.getElementsByClassName('ErrorMessage')[0].style.display = 'inline';
            }
        }



    });



    return (
        <>
            <h2 className={'SuccessMessage'}>Success</h2>
            <h2 className={'ErrorMessage'}>Error</h2>

            <form method={'POST'} action={'https://drinksaver.be/php/addAlcools.php'}>
                <label>Selection du bar</label>
                <input list="select-bar" id="barInput" autoComplete="off" />
                <datalist id="select-bar">

                </datalist>

                <label>Selection du produit</label>
                <div>
                    <input list="select-products" id="productsInput" autoComplete="off" />
                    <datalist id="select-products"></datalist>

                    <label>Prix</label>
                    <input type={'text'} />

                </div>
                <input type="submit" value="Submit"/>
            </form>
        </>
    );


};

