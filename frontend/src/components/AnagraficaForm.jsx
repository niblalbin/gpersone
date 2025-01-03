import { useState, useEffect } from 'react';
import {
  FaUser,
  FaBirthdayCake,
  FaHome,
  FaEnvelope,
  FaUserShield,
} from 'react-icons/fa';

// eslint-disable-next-line react/prop-types
function AnagraficaForm({ type, initialData, onSubmit, onCancel }) {
  const [formData, setFormData] = useState({
    id: '',
    nome: '',
    cognome: '',
    sesso: '',
    nas_luogo: '',
    nas_regione: '',
    nas_prov: '',
    nas_cap: '',
    data_nascita: '',
    cod_fiscale: '',
    res_luogo: '',
    res_regione: '',
    res_prov: '',
    res_cap: '',
    indirizzo: '',
    telefono: '',
    email: '',
    pass_email: '',
    id_ruolo: 2,
  });

  useEffect(() => {
    if (initialData) {
      setFormData(initialData);
    }
  }, [initialData]);

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData((prev) => ({
      ...prev,
      [name]: name === 'sesso' ? mapSesso(value) : value,
    }));
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    onSubmit(formData);
  };

  const mapSesso = (val) => {
    if (val === 'Maschio') return 'M';
    if (val === 'Femmina') return 'F';
    return 'A';
  };

  const mapSessoFromDb = (val) => {
    if (val === 'M') return 'Maschio';
    if (val === 'F') return 'Femmina';
    return 'Altro';
  };

  return (
    <form onSubmit={handleSubmit} className="p-4">
      <h2 className="text-3xl font-bold mb-6">
        {type === 'add' ? 'Aggiungi Anagrafica' : type === 'edit' ? 'Modifica Anagrafica' : 'Dettagli Anagrafica'}
      </h2>

      {/* Informazioni Personali */}
      <div className="mb-6 p-3 rounded-lg bg-[#58585814]">
        <div className="flex items-center text-lg font-semibold mb-3">
          <FaUser className="mr-2 text-blue-500 " /> Informazioni Personali
        </div>
        <div className="grid grid-cols-2 gap-4">
          <div>
            <label className="block mb-1">Nome</label>
            <input
              type="text"
              name="nome"
              value={formData.nome}
              onChange={handleChange}
              disabled={type === 'view'}
              placeholder="Inserisci il nome"
              className="w-full p-2 border rounded bg-gray-700 border-gray-600"
              required
            />
          </div>
          <div>
            <label className="block mb-1">Cognome</label>
            <input
              type="text"
              name="cognome"
              value={formData.cognome}
              onChange={handleChange}
              disabled={type === 'view'}
              placeholder="Inserisci il cognome"
              className="w-full p-2 border rounded bg-gray-700 border-gray-600"
              required
            />
          </div>
          <div>
            <label className="block mb-1">Sesso</label>
            <select
              name="sesso"
              value={mapSessoFromDb(formData.sesso)}
              onChange={handleChange}
              disabled={type === 'view'}
              className="w-full p-2 border rounded bg-gray-700 border-gray-600"
            >
              <option value="Maschio">Maschio</option>
              <option value="Femmina">Femmina</option>
              <option value="Altro">Altro</option>
            </select>
          </div>
          <div>
            <label className="block mb-1">Codice Fiscale</label>
            <input
              type="text"
              name="cod_fiscale"
              value={formData.cod_fiscale}
              minLength={16}
              maxLength={16}
              onChange={handleChange}
              disabled={type === 'view'}
              placeholder="Inserisci il codice fiscale"
              className="w-full p-2 border rounded bg-gray-700 border-gray-600"
              required
            />
          </div>
        </div>
      </div>

      {/* Dati di Nascita */}
      <div className="mb-6 p-3 rounded-lg bg-[#58585814]">
        <div className="flex items-center text-lg font-semibold mb-3">
          <FaBirthdayCake className="mr-2 text-pink-500" /> Dati di Nascita
        </div>
        <div className="grid grid-cols-2 gap-4">
          <div>
            <label className="block mb-1">Luogo</label>
            <input
              type="text"
              name="nas_luogo"
              value={formData.nas_luogo}
              onChange={handleChange}
              disabled={type === 'view'}
              placeholder="Inserisci il luogo di nascita"
              className="w-full p-2 border rounded bg-gray-700 border-gray-600"
            />
          </div>
          <div>
            <label className="block mb-1">Regione</label>
            <input
              type="text"
              name="nas_regione"
              value={formData.nas_regione}
              onChange={handleChange}
              disabled={type === 'view'}
              placeholder="Inserisci la regione"
              className="w-full p-2 border rounded bg-gray-700 border-gray-600"
            />
          </div>
          <div>
            <label className="block mb-1">Provincia</label>
            <input
              type="text"
              name="nas_prov"
              value={formData.nas_prov}
              onChange={handleChange}
              disabled={type === 'view'}
              placeholder="Inserisci la provincia"
              className="w-full p-2 border rounded bg-gray-700 border-gray-600"
            />
          </div>
          <div>
            <label className="block mb-1">CAP</label>
            <input
              type="text"
              name="nas_cap"
              value={formData.nas_cap}
              onChange={handleChange}
              disabled={type === 'view'}
              placeholder="Inserisci il CAP"
              className="w-full p-2 border rounded bg-gray-700 border-gray-600"
            />
          </div>
          <div>
            <label className="block mb-1">Data di Nascita</label>
            <input
              type="date"
              name="data_nascita"
              value={formData.data_nascita}
              onChange={handleChange}
              disabled={type === 'view'}
              placeholder="Seleziona la data di nascita"
              className="w-full p-2 border rounded bg-gray-700 border-gray-600"
            />
          </div>
        </div>
      </div>

      {/* Dati di Residenza */}
      <div className="mb-6 p-3 rounded-lg bg-[#58585814]">
        <div className="flex items-center text-lg font-semibold mb-3">
          <FaHome className="mr-2 text-green-500" /> Dati di Residenza
        </div>
        <div className="grid grid-cols-2 gap-4">
          <div>
            <label className="block mb-1">Luogo</label>
            <input
              type="text"
              name="res_luogo"
              value={formData.res_luogo}
              onChange={handleChange}
              disabled={type === 'view'}
              placeholder="Inserisci il luogo di residenza"
              className="w-full p-2 border rounded bg-gray-700 border-gray-600"
            />
          </div>
          <div>
            <label className="block mb-1">Regione</label>
            <input
              type="text"
              name="res_regione"
              value={formData.res_regione}
              onChange={handleChange}
              disabled={type === 'view'}
              placeholder="Inserisci la regione"
              className="w-full p-2 border rounded bg-gray-700 border-gray-600"
            />
          </div>
          <div>
            <label className="block mb-1">Provincia</label>
            <input
              type="text"
              name="res_prov"
              value={formData.res_prov}
              onChange={handleChange}
              disabled={type === 'view'}
              placeholder="Inserisci la provincia"
              className="w-full p-2 border rounded bg-gray-700 border-gray-600"
            />
          </div>
          <div>
            <label className="block mb-1">CAP</label>
            <input
              type="text"
              name="res_cap"
              value={formData.res_cap}
              onChange={handleChange}
              disabled={type === 'view'}
              placeholder="Inserisci il CAP"
              className="w-full p-2 border rounded bg-gray-700 border-gray-600"
            />
          </div>
          <div>
            <label className="block mb-1">Indirizzo</label>
            <input
              type="text"
              name="indirizzo"
              value={formData.indirizzo}
              onChange={handleChange}
              disabled={type === 'view'}
              placeholder="Inserisci l'indirizzo"
              className="w-full p-2 border rounded bg-gray-700 border-gray-600"
            />
          </div>
        </div>
      </div>

      {/* Contatti */}
      <div className="mb-6 p-3 rounded-lg bg-[#58585814]">
        <div className="flex items-center text-lg font-semibold mb-3">
          <FaEnvelope className="mr-2 text-purple-500" /> Contatti
        </div>
        <div className="grid grid-cols-2 gap-4">
          <div>
            <label className="block mb-1">Telefono</label>
            <input
              type="text"
              name="telefono"
              value={formData.telefono}
              onChange={handleChange}
              disabled={type === 'view'}
              placeholder="Inserisci il numero di telefono"
              className="w-full p-2 border rounded bg-gray-700 border-gray-600"
            />
          </div>
          <div>
            <label className="block mb-1">Email</label>
            <input
              type="email"
              name="email"
              value={formData.email}
              onChange={handleChange}
              disabled={type === 'view'}
              placeholder="Inserisci l'email"
              className="w-full p-2 border rounded bg-gray-700 border-gray-600"
            />
          </div>
        </div>
      </div>

      {/* Ruolo Utente */}
      <div className="mb-6 p-3 rounded-lg bg-[#58585814]">
        <div className="flex items-center text-lg font-semibold mb-3">
          <FaUserShield className="mr-2 text-yellow-500" /> Ruolo Utente
        </div>
        <select
          name="id_ruolo"
          value={formData.id_ruolo}
          onChange={handleChange}
          disabled={type === 'view'}
          className="w-full p-2 border rounded bg-gray-700 border-gray-600"
        >
          <option value={1}>Admin</option>
          <option value={2}>Utente</option>
        </select>
      </div>

      {/* Pulsanti */}
      <div className="flex justify-center space-x-4">
        <button
          type="button"
          onClick={onCancel}
          className="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded w-48"
        >
          {type === 'view' ? 'Chiudi' : 'Annulla'}
        </button>
        {type !== 'view' && (
          <button
            type="submit"
            className="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded w-48"
          >
            {type === 'add' ? 'Aggiungi' : 'Aggiorna'}
          </button>
        )}
      </div>
    </form>
  );
}

export default AnagraficaForm;
