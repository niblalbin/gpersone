import  { useState } from "react";
import { useAuth } from "../../context/AuthProvider";
import { useNavigate } from "react-router-dom";
import FormInput from "../../components/FormInput";
import Button from "../../components/Button";
import Alert from "../../components/Alert";
import { toast } from "react-toastify";
import { login } from "../../services/api";

const LoginPage = () => {
  const { setSession } = useAuth();
  const navigate = useNavigate();
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [error, setError] = useState("");
  const [loading, setLoading] = useState(false);

  const handleLogin = async (event) => {
    event.preventDefault();
    setError("");
    setLoading(true);

    try {
      const { token, expires_at } = await login(email, password);
      await setSession(token, expires_at);
      toast.success("Login effettuato con successo!");
      navigate("/dashboard");
    } catch (error) {
      setError(error.message || "Errore durante il login.");
      toast.error(error.message || "Errore durante il login.");
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="flex items-center justify-center min-h-screen bg-gray-900">
      <form
        onSubmit={handleLogin}
        className="max-w-sm w-full bg-gray-800 p-8 rounded"
      >
        <h2 className="text-2xl font-bold mb-6 text-gray-100">Accedi</h2>
        {error && <Alert message={error} type="error" />}
        <FormInput
          label="Email"
          type="email"
          value={email}
          onChange={(e) => setEmail(e.target.value)}
          placeholder="esempio@mail.com"
          required
        />
        <FormInput
          label="Password"
          type="password"
          value={password}
          onChange={(e) => setPassword(e.target.value)}
          placeholder="********"
          required
        />
        <Button type="submit" className="w-full" disabled={loading}>
          {loading ? "Caricamento..." : "Accedi"}
        </Button>
      </form>
    </div>
  );
};

export default LoginPage;
