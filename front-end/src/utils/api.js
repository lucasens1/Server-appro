// File per API
const API_BASE_URL = "http://localhost:8000";

export const fetchData = async (stringaDaFineAPI) => {
    try{
        const response = await fetch(`${API_BASE_URL}${stringaDaFineAPI}`);
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