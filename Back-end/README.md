## Strutturazione di un Back-end in PHP Plain, per un sistema di Gestionale di attività

#### Note [Metodi , Costanti ...]:
- <code>pdo</code> -> Interfaccia che consente la connessione al DB
- <code>FETCH_ASSOC</code> -> Metodo della classe PDO, Restituisce un array indicizzato in base ai nomi delle colonne presenti nel DB, si usa con fetch / fetchAll
- <code>PASSWORD_BCRYPT</code> -> si usa con password_hash, genera Hash sicuro utilizzando BCrypt
- <code>UPLOAD_ERR_OK</code> -> Costante di PHP che rappresenta il valore 0 ossia upload di un file avvenuto con successo e senza errori
- <code>uniqid()</code> -> funzione PHP che genera un identificatore unico basato su ora corrente in ms (utile per nomi file)
- <code>basename()</code> -> supponendo un percorso <code>file = "/path/to/file.js" echo basename($file)</code> corrisponderà a file.js
- <code>move_uploaded_file()</code> -> è una funzione utilizzata per spostare file
- <code>ATTR_ERRMODE</code> -> Attributo di configurazione degli oggetti PDO, definisce come gli errori nel DB debbano essere gestiti, può essere utilizzato per eccezioni o avvisi
- <code>ERRMODE_EXCEPTION</code> -> Costante PDO utilizzata in coppia con ATTR_ERRMODE per indicare che gli errori vengano gestiti come eccezioni
- <code>FILTER_VALIDATE_EMAIL</code> -> Filtro PHP per validare se una stringa è un indirizzo email valido utilizzato in coppia con filter_var()
- <code>phpversion()</code> -> versione corrente di PHP installata su server
- <code>mail()</code> -> Funzione per inviare mail, <code>mail('hello@world.com', 'Oggetto', 'Corpo della Mail')</code>
- <code>filter_var()</code> -> funzione PHP utilizzata per filtrare variabili con specifici filtri, email, URL, numeri interi..
- <code>reg_match()</code> -> funzione che eseguo il controllo di una stringa tramite espressione regolare, restituisce 1 se trova una corrispondenza altrimenti 0