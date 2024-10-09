import { useState } from "react";
import MyHeader from "../components/common/Header";
import { registerUser } from "../utils/api";
import { useNavigate } from "react-router-dom";
function MyRegisterPage() {
    const navigate = useNavigate();
    const [formData, setFormData] = useState({
        username : '',
        email: '',
        password: ''
    });

    const handleChange = (e) => {
        const {name, value} = e.target;
        setFormData((prevData) =>({
            ...prevData,
            [name] : value
        }));
    }

    const handleSubmit = async (e) => {
        e.preventDefault();

        try {
            console.log(formData)
            const response = await registerUser('/users', 'POST', formData);
            console.log(response);

            navigate('/login')
        } catch (error) {
            console.log(error);
        }
    }

  return (
    <>
      <h2 className="text-center">Pagina di registrazione!</h2>
      <div className="container ms_bg-1">
        <section>
          <MyHeader />
        </section>
        <section className="p-2 fc-w callout d-flex">
          <form
            action=""
            className="p-2 callout col-6 d-flex flex-col align-center"
            onSubmit={handleSubmit}
          >
            <label htmlFor="username">Nome utente : </label>
            <input type="text" name="username" id="username" value={formData.username} onChange={handleChange} />

            <label htmlFor="email">Mail utente : </label>
            <input type="text" name="email" id="email" value={formData.email} onChange={handleChange} />

            <label htmlFor="password">Password utente : </label>
            <input type="password" name="password" id="password" value={formData.password} onChange={handleChange} />

            <button type="submit" className="mg-1 MyRegBtn">Registrati!</button>
          </form>
          <div className="col-6 callout text-center p-2">
            <h3>Registrati!</h3>
            <small>Entra e registra la tua attività!</small>
          </div>
        </section>
      </div>
    </>
  );
}

export default MyRegisterPage;
