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