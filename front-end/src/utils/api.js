// File per API
const API_BASE_URL = "http://localhost:8000";

export const fetchData = async (stringaDaFineAPI, method = "GET", body = null) => {
    try{
        const options = {
            method,
            headers: {
                'Content-Type' : 'application/json'
            }
        };
        const response = await fetch(`${API_BASE_URL}${stringaDaFineAPI}`, options);
        // Log della risposta per debugging crea problema di already read stream
        /* const responseText = await response.text(); 
        console.log("Risposta dal server:", responseText);  */
        if(!response.ok){
            throw new Error('Connessione fallita.');
        }
        const data = await response.json(); // Salvo i dati ottenuti
        return data;
    } catch (error){
        console.error(error);
        throw error;
    }
}

export const registerUser = async (stringaDaFineAPI, method = "POST", body) => {
    try {
        const options = {
            method,
            headers : {
                'Content-type' : 'application/json'
            },
            ...(body && {body: JSON.stringify(body)})
        }
        
        const response = await fetch(`${API_BASE_URL}${stringaDaFineAPI}`, options);

        if(!response.ok){
            throw new Error('Registrazione fallita!');
        }
        const data = await response.json(); // Restituisci i dati della risposta
        console.log('Registrazione effettuata con successo', data);
        return data; // Restituisci i dati
    } catch (error) {
        console.error(error);
        throw error;
    }
}

export const loginUser = async (stringaDaFineAPI, method = 'POST', body) => {
    try{
        const options = {
            method,
            headers : {
                'Content-type' : 'application-json'
            },
            // Spread del body e diventa JSON, che poi viene decodificato nel Back
            ...(body && {body: JSON.stringify(body)})
        }
        const response = await fetch(`${API_BASE_URL}${stringaDaFineAPI}`, options);

        if(!response.ok){
            console.log('Login fallito');
        }
        const data = await response.json();
        console.log(data);
        return data;
    } catch (error) {
        throw error;
    }
}