import Header from "../../components/Header";
import { useAuth } from '../../context/AuthProvider';
import { FaUser, FaBirthdayCake, FaHome, FaEnvelope, FaUserShield } from 'react-icons/fa';

const Dashboard = () => {
  const { isAuthenticated, user, loading } = useAuth();

  if (loading) {
    return (
      <div className="flex items-center justify-center h-screen">
        <p className="text-xl">Caricamento...</p>
      </div>
    );
  }

  if (!isAuthenticated) {
    return (
      <div className="flex items-center justify-center h-screen">
        <p className="text-xl">Devi essere autenticato per visualizzare la dashboard.</p>
      </div>
    );
  }

  const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    const date = new Date(dateString);
    return date.toLocaleDateString(undefined, options);
  };

  return (
    <>
      <Header />
      <div className="max-w-6xl mx-auto my-8">
        {/* <h2 className="text-4xl font-extrabold text-gray-700 dark:text-gray-100 mb-8">Dashboard</h2> */}

        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          {[
            {
              icon: <FaUser className="text-blue-500 text-3xl" />,
              title: "Informazioni Personali",
              items: [
                { label: "Nome", value: user?.nome },
                { label: "Cognome", value: user?.cognome },
                { label: "Sesso", value: user?.sesso === "M" ? "Maschile" : "Femminile" },
                { label: "Codice Fiscale", value: user?.cod_fiscale },
              ],
            },
            {
              icon: <FaBirthdayCake className="text-pink-500 text-3xl" />,
              title: "Dati di Nascita",
              items: [
                { label: "Data di Nascita", value: user?.data_nascita ? formatDate(user.data_nascita) : "Non disponibile" },
                { label: "Luogo di Nascita", value: user?.nas_luogo },
                { label: "Provincia", value: user?.nas_prov },
                { label: "Regione", value: user?.nas_regione },
                { label: "CAP", value: user?.nas_cap },
              ],
            },
            {
              icon: <FaHome className="text-green-500 text-3xl" />,
              title: "Dati di Residenza",
              items: [
                { label: "Indirizzo", value: user?.indirizzo },
                { label: "Luogo di Residenza", value: user?.res_luogo },
                { label: "Provincia", value: user?.res_prov },
                { label: "Regione", value: user?.res_regione },
                { label: "CAP", value: user?.res_cap },
              ],
            },
            {
              icon: <FaEnvelope className="text-purple-500 text-3xl" />,
              title: "Contatti",
              items: [
                { label: "Telefono", value: user?.telefono },
                { label: "Email", value: user?.email },
              ],
            },
            {
              icon: <FaUserShield className="text-yellow-500 text-3xl" />,
              title: "Ruolo Utente",
              items: [
                {
                  label: "Ruolo",
                  value:
                    user?.id_ruolo === 1
                      ? "Amministratore"
                      : user?.id_ruolo === 2
                      ? "Utente Standard"
                      : "Non definito",
                },
              ],
            },
          ].map((section, index) => (
            <div key={index} className="bg-white dark:bg-gray-800 rounded-lg p-6">
              <div className="flex items-center mb-4">
                {section.icon}
                <h3 className="text-2xl font-semibold text-gray-700 dark:text-gray-100 ml-3">{section.title}</h3>
              </div>
              <div className="grid grid-cols-1 gap-4">
                {section.items.map((item, idx) => (
                  <div
                    key={idx}
                    className="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg text-gray-800 dark:text-gray-200"
                  >
                    <p className="text-sm font-semibold uppercase tracking-wide text-gray-600 dark:text-gray-400">
                      {item.label}
                    </p>
                    <p className="text-lg font-medium">{item.value || "Non disponibile"}</p>
                  </div>
                ))}
              </div>
            </div>
          ))}
        </div>
      </div>
    </>
  );
};

export default Dashboard;
