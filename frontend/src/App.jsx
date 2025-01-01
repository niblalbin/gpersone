import { useState } from "react";
import { BrowserRouter as Router, Routes, Route, Navigate } from "react-router-dom";
import AnagraficheList from "./components/AnagraficheList";
import AnagraficheForm from "./components/AnagraficheForm";
import LoginPage from "./components/login";

function App() {
  const [isAuthenticated, setIsAuthenticated] = useState(false);

  const handleLogin = (email, password) => {
    if (email === "admin@mail.com" && password === "admin") {
      setIsAuthenticated(true);
    } else {
      alert("Credenziali errate.");
    }
  };

  return (
    <Router>
      <div className="bg-gray-900 text-gray-100 min-h-screen">
        <div className="py-6">
          <Routes>
            <Route
              path="/"
              element={
                isAuthenticated ? (
                  <Navigate to="/anagrafiche" replace />
                ) : (
                  <>
                    {/* <AnagraficheForm /> */}
                    {/* <AnagraficheList />  */}
                    <LoginPage onLogin={handleLogin} />
                  </>
                  
                )
              }
            />

            <Route
              path="/anagrafiche"
              element={
                isAuthenticated ? <AnagraficheList /> : <Navigate to="/" replace />
              }
            />

            <Route
              path="/crea"
              element={
                isAuthenticated ? <AnagraficheForm /> : <Navigate to="/" replace />
              }
            />

            <Route path="*" element={<Navigate to="/" replace />} />
          </Routes>
        </div>
      </div>
    </Router>
  );
}

export default App;
