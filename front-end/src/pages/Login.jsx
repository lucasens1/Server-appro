import { useState } from "react";
import MyHeader from "../components/common/Header";
import { loginUser } from "../utils/api";
import { useNavigate } from "react-router-dom";
function LoginPage() {
    const navigate = useNavigate();
    const [formData, setFormData] = useState({
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
            const response = await loginUser('/login', 'POST', formData);
            console.log(response);
            navigate('/')
        } catch (error) {
            console.log(error);
        }
    }
  return (
    <>
      <h2 className="text-center">Pagina di Login!</h2>
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
            <label htmlFor="email">Mail : </label>
            <input
              type="text"
              name="email"
              id="email"
              value={formData.email}
              onChange={handleChange}
            />

            <label htmlFor="password">Password : </label>
            <input
              type="password"
              name="password"
              id="password"
              value={formData.password}
              onChange={handleChange}
            />

            <button type="submit" className="mg-1 MyLoginBtn">
              Login
            </button>
          </form>
          <div className="col-6 callout text-center p-2">
            <h3>Bentornato!</h3>
          </div>
        </section>
      </div>
    </>
  );
}

export default LoginPage;
