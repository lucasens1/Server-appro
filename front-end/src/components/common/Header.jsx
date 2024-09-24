function MyHeader() {
  return (
    <>
      <header className="p-2 d-flex justify-space-between align-center">
        <div className="d-flex gap-1 align-center">
          <h2>ACTIVIX</h2>
          <p>
            <strong>Benvenuto nel Gestionale delle Attività</strong>
          </p>
        </div>
        <div className="d-flex gap-1">
            <button className="MyLoginBtn">Login</button>
            <button className="MyRegBtn">Registrati</button>
        </div>
      </header>
    </>
  );
}

export default MyHeader;
