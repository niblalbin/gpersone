import  { useEffect, useState } from "react";
import { anagraficheService } from "../services/api";

function AnagraficheList() {
  const [anagrafiche, setAnagrafiche] = useState([]);
  const [loading, setLoading] = useState(true);
  const [errore, setErrore] = useState(null);

  useEffect(() => {
    (async () => {
      try {
        const data = await anagraficheService.fetchAll();
        setAnagrafiche(data);
      } catch (error) {
        setErrore("Impossibile recuperare le anagrafiche");
      } finally {
        setLoading(false);
      }
    })();
  }, []);

  if (loading) {
    return <div className="text-center text-gray-600 mt-8">Caricamento in corso...</div>;
  }

  if (errore) {
    return <div className="text-center text-red-500 mt-8">{errore}</div>;
  }

  return (
    <div className="max-w-4xl mx-auto mt-8 bg-white rounded shadow p-6">
      <h2 className="text-2xl font-bold mb-4 text-gray-700">Lista Anagrafiche</h2>
      {anagrafiche.length === 0 ? (
        <p className="text-gray-500">Nessuna anagrafica disponibile.</p>
      ) : (
        <ul className="divide-y divide-gray-100">
          {anagrafiche.map((item) => (
            <li key={item.id} className="py-2 flex flex-col sm:flex-row sm:justify-between sm:items-center">
              <span className="font-medium text-gray-700">
                {item.nome} {item.cognome}
              </span>
              <span className="text-sm text-gray-500">CF: {item.cod_fiscale}</span>
            </li>
          ))}
        </ul>
      )}
    </div>
  );
}

export default AnagraficheList;
