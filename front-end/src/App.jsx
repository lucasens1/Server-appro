import { useState } from "react";
import MyHeader from './components/common/Header.jsx';
import "./assets/styles/App.css";

function App() {
  return (
    <>
      <h1 className="text-center pt-2">Gestionale</h1>
      <div className="container">
        <section>
          <MyHeader/>
        </section>
      </div>
    </>
  );
}

export default App;
