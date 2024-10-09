import { useState } from "react";
import MyHeader from './components/common/Header.jsx';
import Activities from './components/Activities.jsx';
import "./assets/styles/App.css";


function App() {
  return (
    <>
      <h1 className="text-center p-2">Gestionale</h1>
      <div className="container ms_bg-1">
        <section>
          <MyHeader/>
        </section>
        <section className="p-2 fc-w">
          <Activities/>
        </section>
      </div>
    </>
  );
}

export default App;
