const API_URL = "http://127.0.0.1:8080";

// Funzione per il login
export async function login(email, password) {
  try {
    const response = await fetch(`${API_URL}/session`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ email, password }),
    });

    if (!response.ok) {
      const errorData = await response.json();
      throw new Error(errorData.detail || "Errore di rete");
    }

    // Restituisce il token e la data di scadenza
    return await response.json();
  } catch (error) {
    console.error("Errore durante il login:", error);
    throw error;
  }
}

// Funzione per verificare il token salvato
export function isLoggedIn() {
  const token = localStorage.getItem("authToken");
  const expiresAt = localStorage.getItem("expiresAt");

  if (!token || !expiresAt) {
    return false;
  }

  const now = new Date().toISOString();
  return now < expiresAt;
}

// Salva il token nel localStorage
export function saveSession(token, expiresAt) {
  localStorage.setItem("authToken", token);
  localStorage.setItem("expiresAt", expiresAt);
}

// Effettua il logout
export function logout() {
  localStorage.removeItem("authToken");
  localStorage.removeItem("expiresAt");
}

export const anagraficheService = {
  fetchAll: async () => {
    const response = await fetch(`${API_URL}/anagrafiche`);
    if (!response.ok) {
      throw new Error("Errore nel recupero anagrafiche");
    }
    return response.json();
  },
  create: async (data) => {
    const response = await fetch(`${API_URL}/anagrafiche`, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(data),
    });
    if (!response.ok) {
      throw new Error("Errore nella creazione anagrafica");
    }
    return response.json();
  },
  // update, delete...
};
