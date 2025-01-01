import { useState } from "react";
import { anagraficheService } from "../services/api";

function AnagraficheForm() {
  const [nome, setNome] = useState("");
  const [cognome, setCognome] = useState("");
  const [codFiscale, setCodFiscale] = useState("");
  const [messaggio, setMessaggio] = useState(null);
  const [errore, setErrore] = useState(null);

  const onSubmit = async (e) => {
    e.preventDefault();
    setMessaggio(null);
    setErrore(null);

    try {
      await anagraficheService.create({
        nome,
        cognome,
        cod_fiscale: codFiscale,
      });
      setMessaggio("Anagrafica creata con successo!");
      setNome("");
      setCognome("");
      setCodFiscale("");
    } catch (err) {
      setErrore("Errore in creazione anagrafica");
    }
  };

  return (
    <div className="max-w-md mx-auto mt-8 bg-white rounded shadow p-6">
      <h2 className="text-2xl font-bold mb-4 text-gray-700">Crea Anagrafica</h2>
      {messaggio && <div className="mb-4 text-green-600">{messaggio}</div>}
      {errore && <div className="mb-4 text-red-600">{errore}</div>}
      <form onSubmit={onSubmit}>
        <div className="mb-4">
          <label className="block text-gray-600 mb-1">Nome</label>
          <input
            type="text"
            value={nome}
            onChange={(e) => setNome(e.target.value)}
            className="w-full border border-gray-300 rounded px-3 py-2"
          />
        </div>
        <div className="mb-4">
          <label className="block text-gray-600 mb-1">Cognome</label>
          <input
            type="text"
            value={cognome}
            onChange={(e) => setCognome(e.target.value)}
            className="w-full border border-gray-300 rounded px-3 py-2"
          />
        </div>
        <div className="mb-4">
          <label className="block text-gray-600 mb-1">Codice Fiscale</label>
          <input
            type="text"
            value={codFiscale}
            onChange={(e) => setCodFiscale(e.target.value)}
            className="w-full border border-gray-300 rounded px-3 py-2"
          />
        </div>
        <button
          type="submit"
          className="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
        >
          Crea
        </button>
      </form>
    </div>
  );
}

export default AnagraficheForm;
