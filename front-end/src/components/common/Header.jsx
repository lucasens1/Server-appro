import { Link } from "react-router-dom";
function MyHeader() {
  return (
    <>
      <header className="p-2 d-flex justify-space-between align-center ms_header">
        <div className="d-flex gap-1 align-center">
          <h2>ACTIVIX</h2>
          <p>
            <strong>Benvenuto nel Gestionale delle Attività</strong>
          </p>
        </div>
        <div className="d-flex gap-1">
          <Link to="/login">
            <button className="MyLoginBtn">Login</button>
          </Link>
          <Link to="/register">
            <button className="MyRegBtn">Registrati</button>
          </Link>
        </div>
      </header>
    </>
  );
}

export default MyHeader;
