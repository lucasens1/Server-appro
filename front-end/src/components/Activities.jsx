import { useEffect, useState } from "react";
import { fetchData } from "../utils/api";

function Activities() {
  const [activities, setActivities] = useState([]); // Inizialmente un array vuoto
  const [error, setError] = useState(null); // Inizialmente null

  const getActivities = async () => {
    try {
      const data = await fetchData("/activities");
      setActivities(data);
    } catch (err) {
      setError(err.message);
    }
  };

  useEffect(() => {
    getActivities();
  }, []);

  // Gestione dell'errore
  if (error) {
    return <div>Error: {error}</div>;
  }

  return (
    <>
      <small className="ms_bg-w"><i>{error ? error : "Connessione stabilita correttamente"}</i></small>
      <h3>ATTIVITA' IN EVIDENZA</h3>
      <p>Lista di Attività che provengono dalla Chiamata API</p>
      {activities.length > 0 ? (
        <div className="d-flex gap-1 pt-1 h-100">
          {activities.map((activity) => (
            <div key={activity.id} className="col-6">
              <div  className="callout ms_bg-w p-2 justify-space-evenly">
                <h4> <strong>{activity.title}</strong> </h4> 
                <p>{activity.description}</p>
                <h4> <strong>Email Proprietario:</strong></h4> 
                <p>{activity.email}</p>
              </div>   
            </div>
          ))}
        </div>
      ) : (
        <div>
          <i>Caricamento Attività ..</i>
        </div>
      )}
    </>
  );
}

export default Activities;
