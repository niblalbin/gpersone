import PropTypes from 'prop-types';

const Alert = ({ message, type = 'error' }) => {
  const baseClasses = "px-4 py-2 rounded mb-4 text-sm";
  const typeClasses = {
    error: "bg-red-600 text-white",
    success: "bg-green-600 text-white",
    info: "bg-blue-600 text-white",
  };

  return (
    <div className={`${baseClasses} ${typeClasses[type]}`}>
      {message}
    </div>
  );
};

Alert.propTypes = {
  message: PropTypes.string.isRequired,
  type: PropTypes.oneOf(['error', 'success', 'info']),
};

Alert.defaultProps = {
  type: 'error',
};

export default Alert;
