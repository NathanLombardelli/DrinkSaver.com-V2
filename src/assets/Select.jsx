export const Select = () => {

    return (

        <>
            <input type="text" id="productInput" list="select-products"/>
            <datalist id="select-products">
                <option value="">Sélectionnez un produit</option>
            </datalist>
        </>
    );


};