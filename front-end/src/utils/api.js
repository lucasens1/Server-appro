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
                'Content-type' : 'application/json'
            },
            // Spread del body e diventa JSON, che poi viene decodificato nel Back
            ...(body && {body: JSON.stringify(body)})
        }
        const response = await fetch(`${API_BASE_URL}${stringaDaFineAPI}`, options);

        if(!response.ok){
            const errorData = await response.json();
            console.log('Login fallito:', errorData);
            throw new Error(errorData.error || 'Login fallito');
        }
        const data = await response.json();
        console.log(data.message, data.user);
        let userData = JSON.stringify(data.user); 
        localStorage.setItem('user', userData);
        return data;
    } catch (error) {
        throw error;
    }
}

export const fetchUserActivities = async (userId) => {
    const stringaDaFineAPI = `/activities/user/${userId}`; // Costruisci la stringa finale con l'ID utente
    try {
        const options = {
            method: "GET",
            headers: {
                'Content-type': 'application/json'
            },
        };
        
        const response = await fetch(`${API_BASE_URL}${stringaDaFineAPI}`, options);

        if (!response.ok) {
            const errorData = await response.json();
            console.log('Fetch attività utente fallito', errorData);
            throw new Error(errorData.error || 'Fetch KO');
        }
        
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Si è verificato un errore durante il recupero delle attività:', error);
        throw error; // Potresti voler lanciare di nuovo l'errore per gestirlo in modo superiore
    }
};