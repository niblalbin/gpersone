import { IoClose } from 'react-icons/io5';

// eslint-disable-next-line react/prop-types
function Modal({ children, onClose }) {
    return (
        <div className="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 overflow-hidden">
        <div className="bg-gray-900 text-white rounded-lg w-full max-w-4xl max-h-[90vh] p-6 relative overflow-y-auto scrollbar-thin scrollbar-thumb-dark scrollbar-track-dark">
          <button
            onClick={onClose}
            className="absolute p-2 bg-gray-700 rounded right-5 text-gray-500 hover:text-gray-700"
          >
            <IoClose size={20} />
          </button>
          {children}
        </div>
      </div>
    );
  }
  
  export default Modal;
  