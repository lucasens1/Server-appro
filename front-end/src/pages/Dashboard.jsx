import { useNavigate } from "react-router-dom";
import MyHeader from "../components/common/Header";
import { fetchUserActivities } from "../utils/api";
import { useEffect, useState } from "react";

const getUser = () => {
  const user = JSON.parse(localStorage.getItem("user"));
  return user;
};

function Dashboard() {
  const navi = useNavigate();
  const user = getUser();
  const [activitiesU, setUActivities] = useState([]);
  const [error, setError] = useState(null); // Stato per gestire gli errori
  const [isFetch, setIsFetch] = useState(false);

  useEffect(() => {
    const getUserActivities = async () => {
      if (user && !isFetch) {
        try {
            console.log(user.id);
          const data = await fetchUserActivities(user.id);
          console.log('Attività utente:', data); // Log per verificare i dati
          if (Array.isArray(data)) {
            setUActivities(data);
            setIsFetch(true);
          } else if (data.error) { // Controllo se ci sono errori
            setError(data.error);
          }
        } catch (error) {
          console.error('Errore nel recupero delle attività:', error);
          setError('Si è verificato un errore nel recupero delle attività.'); // Imposta un messaggio di errore
        }
      } else {
        return;
      }
    };

    getUserActivities();
  }); // Usa 'user' come dipendenza

  return (
    <>
      <h2 className="text-center">Dashboard</h2>
      <div className="container ms_bg-1">
        <section>
          <MyHeader />
        </section>
        <section className="p-2 fc-w callout d-flex w-100">
          {error && <p className="ms_error-message">{error}</p>} 
          <div className="d-flex gap-1 pt-1 w-100">
          {activitiesU.length > 0 ? (
            activitiesU.map(activity => (
              <div key={activity.id} className={activitiesU.length === 1 ? 'col-12' : 'col-6'}>
              <div  className="callout ms_bg-w p-2 justify-space-evenly text-center">
                <h4> <strong>{activity.title}</strong> </h4> 
                <p>{activity.description}</p>
                <p>{activity.created_at}</p>
              </div>   
            </div>
            
            ))
          ) : (
            !error && <p>Nessuna attività trovata. <br /> <strong>Aggiungi!</strong></p>
          )}
          </div>
        </section>
      </div>
    </>
  );
}

export default Dashboard;
