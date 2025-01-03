import { NavLink } from "react-router-dom";
import { logout } from "../services/api";
import { IoHome, IoLogOut } from "react-icons/io5";
import { MdFamilyRestroom, MdManageAccounts } from "react-icons/md";
import { useAuth } from "../context/AuthProvider";
import { FaUser } from "react-icons/fa";

const Header = () => {
  const { user } = useAuth();

  const handleLogout = () => {
    logout();
  };

  const getLinkClass = ({ isActive }) =>
    `hover:text-gray-300 rounded p-2 flex items-center ${
      isActive ? "bg-slate-600" : "bg-slate-700"
    }`;

  return (
    <header className="bg-gray-800 text-white flex justify-between items-center p-3">
      <div className="flex space-x-4">
        <NavLink to="/dashboard" className={getLinkClass} end>
          <IoHome size={22} className="mr-2" /> Dashboard
        </NavLink>
        {/* Mostra il link "Anagrafiche" solo se il ruolo non è 2 */}
        {user?.id_ruolo !== 2 && (
          <NavLink to="/anagrafiche" className={getLinkClass}>
            <MdManageAccounts size={22} className="mr-2" /> Anagrafiche
          </NavLink>
        )}
        <NavLink to={user?.id_ruolo === 2 ? "/nucleo" : "/nuclei"} className={getLinkClass}>
          <MdFamilyRestroom size={22} className="mr-2" /> Nucleo familiare
        </NavLink>
      </div>
      <div className="flex">
        {user ? (
          <span className="font-semibold bg-gray-700 rounded p-2 flex mr-2">
            <FaUser size={22} className="mr-2" /> {user.nome} {user.cognome}
          </span>
        ) : (
          <span>Caricamento...</span>
        )}
        <button 
        onClick={handleLogout} 
        className="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded flex items-center"
      >
        <IoLogOut size={22} className="mr-2" /> Logout
      </button>
      </div>
      
    </header>
  );
};

export default Header;
