import { useEffect, useState } from "react";
import { fetchData } from "../utils/api";

function Activities() {
    const [activities, setActivities] = useState([]); // Inizialmente un array vuoto
    const [error, setError] = useState(null); // Inizialmente null

    const getActivities = async () => {
        try {
            const data = await fetchData('/activities');
            console.log(data);
            setActivities(data);
        } catch (err) {
            setError(err.message);
        }
    };

    useEffect(() => {
        getActivities();
    }, []);

    // Gestione dell'errore
    if (error){
        return <div>Error: {error}</div>;
    }

    return (
        <>
            <h1>{error ? error : 'OK'}</h1>
            <h3>ATTIVITA' IN EVIDENZA</h3>
            <p>Lista di Attività che provengono dalla Chiamata API</p>
            {activities.length > 0 ? (
                <ul>
                    {activities.map((activity) => (
                        <li key={activity.id}>
                            {activity.title} - {activity.description} - {activity.email}
                        </li>
                    ))}
                </ul>
            ) : (
                <div><i>Caricamento Attività ..</i></div>
            )}
        </>
    );
}

export default Activities;
