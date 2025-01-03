/* eslint-disable no-unused-vars */
import { useState, useMemo } from "react";
import { useQuery, useQueryClient } from "@tanstack/react-query";
import { anagraficheService, nucleiService } from "../../services/api";
import Header from "../../components/Header";
import { IoAdd, IoPencil, IoTrash, IoEye } from "react-icons/io5";
import { useAuth } from "../../context/AuthProvider";
import { toast } from 'react-toastify';
import Modal from "../../components/Modal";
import AnagraficaForm from "../../components/AnagraficaForm";

function NucleoList() {
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [modalType, setModalType] = useState('add');
  const [selectedAnagrafica, setSelectedAnagrafica] = useState(null);
  const [searchTerm, setSearchTerm] = useState('');
  const [currentPage, setCurrentPage] = useState(1);
  const itemsPerPage = 10;
  const { user } = useAuth();
  const queryClient = useQueryClient();

  const { data, isLoading, error } = useQuery({
    queryKey: ['nucleo'],
    queryFn: nucleiService.fetchAll,
    staleTime: 5 * 60 * 1000,
    cacheTime: 30 * 60 * 1000,
  });

  const anagrafiche = data?._embedded?.nuclei || [];

  const filteredAnagrafiche = useMemo(() => {
    return anagrafiche.filter(item =>
      Object.values(item)
        .some(value =>
          String(value)
            .toLowerCase()
            .includes(searchTerm.toLowerCase())
        )
    );
  }, [anagrafiche, searchTerm]);
  

  const paginatedAnagrafiche = useMemo(() => {
    const startIndex = (currentPage - 1) * itemsPerPage;
    return filteredAnagrafiche.slice(startIndex, startIndex + itemsPerPage);
  }, [filteredAnagrafiche, currentPage, itemsPerPage]);

  const totalPages = Math.ceil(filteredAnagrafiche.length / itemsPerPage);

  const handleAdd = () => {
    setModalType('add');
    setSelectedAnagrafica(null);
    setIsModalOpen(true);
  };

  const handleEdit = (anagrafica) => {
    setModalType('edit');
    setSelectedAnagrafica(anagrafica);
    setIsModalOpen(true);
  };

  const handleView = (anagrafica) => {
    setModalType('view');
    setSelectedAnagrafica(anagrafica);
    setIsModalOpen(true);
  };

  const handleDelete = async (id) => {
    if (!window.confirm("Sei sicuro di voler eliminare questa anagrafica?")) return;
    try {
      await anagraficheService.delete(id);
      queryClient.invalidateQueries({ queryKey: ['anagrafiche'] });
      toast.success("Anagrafica eliminata con successo!");
    } catch (error) {
      toast.error("Errore nell'eliminazione dell'anagrafica.");
    }
  };

  const handleModalSubmit = async (anagrafica) => {
    try {
      if (modalType === 'add') {
        await anagraficheService.create(anagrafica);
        toast.success("Anagrafica aggiunta con successo!");
      } else if (modalType === 'edit') {
        await anagraficheService.update(selectedAnagrafica.id, anagrafica);
        toast.success("Anagrafica aggiornata con successo!");
      }
      setIsModalOpen(false);
      queryClient.invalidateQueries({ queryKey: ['anagrafiche'] });
    } catch (error) {
      toast.error("Errore durante l'operazione.");
    }
  };

  if (isLoading) {
    return (
      <>
        <Header />
        <div className="text-center text-gray-600 dark:text-gray-300 mt-8">Caricamento in corso...</div>
      </>
    );
  }

  if (error) {
    return (
      <>
        <Header />
        <div className="text-center text-red-500 mt-8">Impossibile recuperare le anagrafiche</div>
      </>
    );
  }

  return (
    <>
      <Header />
      <div className="max-w-6xl mx-auto mt-8 bg-white dark:bg-gray-800 rounded p-6 text-gray-700 dark:text-gray-200">
        <div className="flex justify-between items-center mb-4">
          <h2 className="text-2xl font-bold">Lista membri nucleo familiare</h2>
          {user?.id_ruolo === 1 && (
            <button
              onClick={handleAdd}
              className="flex items-center bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded"
            >
              <IoAdd size={20} className="mr-2" /> Aggiungi
            </button>
          )}
        </div>

        <div className="mb-4">
          <input
            type="text"
            placeholder="Cerca..."
            value={searchTerm}
            onChange={(e) => { setSearchTerm(e.target.value); setCurrentPage(1); }}
            className="w-full p-2 border rounded bg-gray-700 border-gray-600"
          />
        </div>

        {filteredAnagrafiche.length === 0 ? (
          <p className="text-gray-500 dark:text-gray-400">Nessuna anagrafica disponibile.</p>
        ) : (
          <>
            <div className="overflow-x-auto">
              <table className="min-w-full bg-white dark:bg-gray-700 rounded">
                <thead>
                  <tr>
                    <th className="py-2 px-4 border-b border-b-gray-500">Nome</th>
                    <th className="py-2 px-4 border-b border-b-gray-500">Cognome</th>
                    <th className="py-2 px-4 border-b border-b-gray-500">Codice Fiscale</th>
                    <th className="py-2 px-4 border-b border-b-gray-500">Parentela</th>
                    <th className="py-2 px-4 border-b border-b-gray-500">Azioni</th>
                  </tr>
                </thead>
                <tbody>
                  {paginatedAnagrafiche.map((item) => (
                    <tr key={item.id} className="hover:bg-gray-100 dark:hover:bg-gray-600">
                      <td className="py-2 px-4 border-b border-b-gray-600 text-center">{item.nome}</td>
                      <td className="py-2 px-4 border-b border-b-gray-600 text-center">{item.cognome}</td>
                      <td className="py-2 px-4 border-b border-b-gray-600 text-center">{item.cod_fiscale}</td>
                      <td className="py-2 px-4 border-b border-b-gray-600 text-center">{item.grado_parentela}</td>
                      <td className="py-2 px-4 border-b border-b-gray-600">
                        {user?.id_ruolo === 1 ? (
                          <div className="flex space-x-2 justify-center">
                            <button
                              onClick={() => handleEdit(item)}
                              className="flex items-center bg-blue-500 hover:bg-blue-600 text-white py-1 px-2 rounded"
                            >
                              <IoPencil size={16} className="mr-1" /> Modifica
                            </button>
                            <button
                              onClick={() => handleDelete(item.id)}
                              className="flex items-center bg-red-500 hover:bg-red-600 text-white py-1 px-2 rounded"
                            >
                              <IoTrash size={16} className="mr-1" /> Elimina
                            </button>
                          </div>
                        ) : (
                            <div className="flex justify-center">
                                <button
                                    onClick={() => handleView(item)}
                                    className="flex items-center bg-gray-500 hover:bg-gray-600 text-white py-1 px-2 rounded"
                                >
                                    <IoEye size={16} className="mr-1" /> Visualizza
                                </button>
                            </div>
                        )}
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>

            {/* Paginazione */}
            <div className="flex justify-center mt-4 space-x-2">
              <button
                onClick={() => setCurrentPage(prev => Math.max(prev - 1, 1))}
                disabled={currentPage === 1}
                className={`py-1 px-3 rounded ${currentPage === 1 ? 'bg-gray-600' : 'bg-blue-500 text-white hover:bg-blue-600'}`}
              >
                Precedente
              </button>
              <span className="py-1 px-3">
                Pagina {currentPage} di {totalPages}
              </span>
              <button
                onClick={() => setCurrentPage(prev => Math.min(prev + 1, totalPages))}
                disabled={currentPage === totalPages}
                className={`py-1 px-3 rounded ${currentPage === totalPages ? 'bg-gray-600' : 'bg-blue-500 text-white hover:bg-blue-600'}`}
              >
                Successiva
              </button>
            </div>
          </>
        )}
      </div>

      {isModalOpen && (
        <Modal onClose={() => setIsModalOpen(false)}>
          <AnagraficaForm
              type={modalType}
              initialData={selectedAnagrafica}
              onSubmit={handleModalSubmit}
              onCancel={() => setIsModalOpen(false)}
            />
        </Modal>
      )}
    </>
  );
}

export default NucleoList;
