import { useEffect, useState } from "react";
import { anagraficheService } from "../services/api";

function AnagraficheList() {
  const [anagrafiche, setAnagrafiche] = useState([]);
  const [loading, setLoading] = useState(true);
  const [errore, setErrore] = useState(null);

  useEffect(() => {
    // Forza la modalità scura
    document.documentElement.classList.add('dark');

    (async () => {
      try {
        const data = await anagraficheService.fetchAll();
        setAnagrafiche(data?._embedded?.anagrafiche || []);
      } catch (error) {
        setErrore("Impossibile recuperare le anagrafiche");
      } finally {
        setLoading(false);
      }
    })();
  }, []);

  if (loading) {
    return <div className="text-center text-gray-600 dark:text-gray-300 mt-8">Caricamento in corso...</div>;
  }

  if (errore) {
    return <div className="text-center text-red-500 dark:text-red-300 mt-8">{errore}</div>;
  }

  return (
    <div className="max-w-4xl mx-auto mt-8 bg-white dark:bg-gray-800 rounded shadow p-6 text-gray-700 dark:text-gray-200">
      <h2 className="text-2xl font-bold mb-4 text-gray-700 dark:text-gray-100">Lista Anagrafiche</h2>
      {anagrafiche.length === 0 ? (
        <p className="text-gray-500 dark:text-gray-400">Nessuna anagrafica disponibile.</p>
      ) : (
        <ul className="divide-y divide-gray-100 dark:divide-gray-600">
          {anagrafiche.map((item) => (
            <li
              key={item.id}
              className="py-2 flex flex-col sm:flex-row sm:justify-between sm:items-center"
            >
              <span className="font-medium text-gray-700 dark:text-gray-100">
                {item.nome} {item.cognome}
              </span>
              <span className="text-sm text-gray-500 dark:text-gray-300">CF: {item.cod_fiscale}</span>
            </li>
          ))}
        </ul>
      )}
    </div>
  );
}

export default AnagraficheList;
