import { useState } from "react";
import { login, saveSession } from "../services/api"; // Importa la funzione di login

export default function LoginPage() {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [error, setError] = useState("");

  const handleLogin = async (event) => {
    event.preventDefault();
    setError("");

    try {
      const { token, expires_at } = await login(email, password);
      saveSession(token, expires_at);
      alert("Login effettuato con successo!");
    } catch (error) {
      setError(error.message);
    }
  };

  return (
    <div className="min-h-screen bg-gray-900 flex items-center justify-center">
      <div className="max-w-sm w-full bg-gray-800 p-8 rounded shadow-lg">
        <h2 className="text-2xl font-bold mb-6 text-gray-100">Accedi</h2>
        <form onSubmit={handleLogin}>
          {error && <div className="mb-4 text-red-500 text-sm">{error}</div>}
          <div className="mb-3">
            <label className="block text-gray-400 mb-1">Email</label>
            <input
              type="email"
              className="w-full border border-gray-700 rounded px-3 py-2 bg-gray-700 text-gray-100"
              value={email}
              onChange={(e) => setEmail(e.target.value)}
              placeholder="esempio@mail.com"
              required
            />
          </div>
          <div className="mb-8">
            <label className="block text-gray-400 mb-1">Password</label>
            <input
              type="password"
              className="w-full border border-gray-700 rounded px-3 py-2 bg-gray-700 text-gray-100"
              value={password}
              onChange={(e) => setPassword(e.target.value)}
              placeholder="********"
              required
            />
          </div>
          <button
            type="submit"
            className="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700"
          >
            Login
          </button>
        </form>
      </div>
    </div>
  );
}
