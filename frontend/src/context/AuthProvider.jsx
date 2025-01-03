import { createContext, useContext, useState, useEffect } from 'react';
import { verifyToken, saveSession, clearSession, loadSession } from '../services/api';
import axios from 'axios';

const API_URL = "http://localhost:8080";

const AuthContext = createContext();

// eslint-disable-next-line react/prop-types
export const AuthProvider = ({ children }) => {
  const [isAuthenticated, setIsAuthenticated] = useState(false);
  const [loading, setLoading] = useState(true);
  const [user, setUser] = useState(null); // Informazioni sull'utente

  // Funzione per recuperare i dati utente
  const fetchUserData = async (token) => {
    try {
      const response = await axios.get(`${API_URL}/user`, {
        headers: { Authorization: `${token}` },
      });
      return response.data._embedded.user[0];
    } catch (error) {
      console.error('Errore nel recuperare i dati utente:', error);
      return null;
    }
  };

  // Funzione per gestire il login
  const setSession = async (token, expires_at) => {
    saveSession(token, expires_at);
    setIsAuthenticated(true);
    // Recupera i dati dell'utente
    const userData = await fetchUserData(token);
    setUser(userData);
  };

  // Funzione per gestire il logout
  const logout = () => {
    clearSession();
    setIsAuthenticated(false);
    setUser(null);
  };

  // Verifica il token al montaggio del componente
  useEffect(() => {
    const verifyUserToken = async () => {
      const session = loadSession();
      if (session && session.token) {
        try {
          const isValid = await verifyToken(session.token);
          if (isValid) {
            setIsAuthenticated(true);
            const userData = await fetchUserData(session.token);
            setUser(userData);
          } else {
            logout();
          }
        } catch (error) {
          console.error("Errore nella verifica del token:", error);
          logout();
        }
      }
      setLoading(false);
    };

    verifyUserToken();
  }, []);

  return (
    <AuthContext.Provider value={{ isAuthenticated, user, setSession, logout, loading }}>
      {children}
    </AuthContext.Provider>
  );
};

// Hook personalizzato per accedere al contesto
export const useAuth = () => useContext(AuthContext);