import { Link, useNavigate } from "react-router-dom";

const getUser = () => {
  const user = JSON.parse(localStorage.getItem("user"));
  return user;
};



function MyHeader() {
  const navigate = useNavigate();
  const loggedUser = getUser();

  const logoutUser = () => {
    localStorage.removeItem('user');
    navigate('/');
  }

  return (
    <>
      <header className="p-2 d-flex justify-space-between align-center ms_header">
        <div className="d-flex gap-1 align-center">
          <Link to="/" className="ms_link">
            <h2>ACTIVIX</h2>
          </Link>
        </div>

        <div >
          {loggedUser ? (
            <div className="d-flex gap-1 align-center">
              <span className="mr-1">Benvenuto, {loggedUser.username }</span>
              <Link to="/dashboard" className="ms_link"><button className="ms_dashbtn">Dashboard</button></Link>
              <button className="MyLoginBtn" onClick={logoutUser}>Logout</button>
            </div>
          ) : (
            <div>
              <Link to="/login">
                <button className="MyLoginBtn">Login</button>
              </Link>
              <Link to="/register">
                <button className="MyRegBtn">Registrati</button>
              </Link>
            </div>
          )} 
        </div>
      </header>
    </>
  );
}

export default MyHeader;
