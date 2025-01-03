const API_URL = "http://localhost:8080";

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

    let json_response = await response.json();

    if (!response.ok || !json_response.token) {
      const errorData = json_response.detail;
      throw new Error(errorData || "Errore di rete");
    }

    // Restituisce il token e la data di scadenza
    return json_response;
  } catch (error) {
    console.log("Errore durante il login:", error);
    throw error;
  }
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
  window.location.href = '/';
}

export const anagraficheService = {
  fetchAll: async () => {
    const response = await fetch(`${API_URL}/anagrafiche`, {
      headers: {
        "Content-Type": "application/json",
        Authorization: `${localStorage.getItem("authToken")}`,
      },
    });
    if (!response.ok) {
      throw new Error("Errore nel recupero anagrafiche");
    }
    return response.json();
  },
  create: async (data) => {
    const response = await fetch(`${API_URL}/anagrafiche`, {
      method: "POST",
      headers: { 
        "Content-Type": "application/json",
        Authorization: `${localStorage.getItem("authToken")}`,
      },
      body: JSON.stringify(data),
    });
    if (!response.ok) {
      throw new Error("Errore nella creazione anagrafica");
    }
    return response.json();
  },
  fetch: async () => {
    const response = await fetch(`${API_URL}/anagrafiche`, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        Authorization: `${localStorage.getItem("authToken")}`,
      },
    });
    if (!response.ok) {
      throw new Error("Errore nel recupero dell'anagrafica");
    }
    return response.json();
  },
  update: async (id, data) => {
    const response = await fetch(`${API_URL}/anagrafiche/${id}`, {
      method: "PUT",
      headers: {
        "Content-Type": "application/json",
        Authorization: `${localStorage.getItem("authToken")}`,
      },
      body: JSON.stringify(data),
    });
    if (!response.ok) {
      throw new Error("Errore nell'aggiornamento dell'anagrafica");
    }
    return response.json();
  },
  delete: async (id) => {
    const response = await fetch(`${API_URL}/anagrafiche/${id}`, {
      method: "DELETE",
      headers: {
        "Content-Type": "application/json",
        Authorization: `${localStorage.getItem("authToken")}`,
      },
    });
    if (!response.ok) {
      throw new Error("Errore nell'eliminazione dell'anagrafica");
    }
    return 'anagrafica eliminata';
  },
};

export const loadSession = () => {
  const token = localStorage.getItem("authToken");
  const expires_at = localStorage.getItem("expiresAt");
  return { token, expires_at };
};

export const clearSession = () => {
  localStorage.removeItem("authToken");
  localStorage.removeItem("expiresAt");
};

export async function verifyToken(token) {
  try {
    const response = await fetch(`${API_URL}/session`, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        Authorization: `${token}`,
      },
    });

    if (response.ok) {
      const data = await response.json();
      return data.isValid;
    } else {
      throw new Error("Errore nella verifica del token");
    }
  } catch (error) {
    console.error("Errore nella verifica del token:", error);
    return false;
  }
}

export const nucleiService = {
  fetchAll: async () => {
    const response = await fetch(`${API_URL}/nuclei`, {
      headers: {
        "Content-Type": "application/json",
        Authorization: `${localStorage.getItem("authToken")}`,
      },
    });
    if (!response.ok) {
      throw new Error("Errore nel recupero dei nuclei");
    }
    return response.json();
  },
  create: async (data) => {
    const response = await fetch(`${API_URL}/nuclei`, {
      method: "POST",
      headers: { 
        "Content-Type": "application/json",
        Authorization: `${localStorage.getItem("authToken")}`,
      },
      body: JSON.stringify(data),
    });
    if (!response.ok) {
      throw new Error("Errore nella creazione del nucleo");
    }
    return response.json();
  },
  fetch: async () => {
    const response = await fetch(`${API_URL}/nuclei`, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        Authorization: `${localStorage.getItem("authToken")}`,
      },
    });
    if (!response.ok) {
      throw new Error("Errore nel recupero del nucleo");
    }
    return response.json();
  }
};