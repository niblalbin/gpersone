import { BrowserRouter as Router, Routes, Route, Navigate } from 'react-router-dom';
import AnagraficheList from './pages/anagrafiche/anagraficheList';
import NucleoList from './pages/nucleo/nucleo';
import NucleiList from './pages/nucleo/nuclei';
import LoginPage from './pages/login/login';
import Dashboard from './pages/dashboard/dashboard';
import { AuthProvider, useAuth } from './context/AuthProvider';
import ProtectedRoute from './components/ProtectedRoute';
import { ToastContainer } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import { QueryClient, QueryClientProvider } from '@tanstack/react-query';

const queryClient = new QueryClient();

function App() {
  return (
    <QueryClientProvider client={queryClient}>
      <AuthProvider>
        <Router>
          <div className="bg-gray-900 text-gray-100 min-h-screen">
            <Routes>
              <Route
                path="/"
                element={<HomeRedirect />}
              />
              <Route
                path="/login"
                element={<LoginPageWrapper />}
              />
              <Route
                path="/dashboard"
                element={
                  <ProtectedRoute>
                    <Dashboard />
                  </ProtectedRoute>
                }
              />
              <Route
                path="/anagrafiche"
                element={
                  <ProtectedRoute allowedRoles={[1]}>
                    <AnagraficheList />
                  </ProtectedRoute>
                }
              />
              <Route
                path="/nucleo"
                element={
                  <ProtectedRoute allowedRoles={[2]}>
                    <NucleoList />
                  </ProtectedRoute>
                }
              />
              <Route
                path="/nuclei"
                element={
                  <ProtectedRoute allowedRoles={[1]}>
                    <NucleiList />
                  </ProtectedRoute>
                }
              />
              <Route path="*" element={<Navigate to="/" replace />} />
            </Routes>
          </div>
        </Router>
      </AuthProvider>
      <ToastContainer 
        position="bottom-right" 
        autoClose={5000} 
        hideProgressBar={false} 
        newestOnTop={false} 
        closeOnClick 
        rtl={false} 
        pauseOnFocusLoss 
        draggable 
        pauseOnHover
      />
    </QueryClientProvider>
  );
}

const HomeRedirect = () => {
  const { isAuthenticated, loading } = useAuth();

  if (loading) {
    return <div className="flex items-center justify-center min-h-screen bg-gray-900 text-white">Caricamento...</div>;
  }

  return isAuthenticated ? <Navigate to="/dashboard" replace /> : <Navigate to="/login" replace />;
};

const LoginPageWrapper = () => {
  const { isAuthenticated, loading } = useAuth();

  if (loading) {
    return <div className="flex items-center justify-center min-h-screen bg-gray-900 text-white">Caricamento...</div>;
  }

  return !isAuthenticated ? <LoginPage /> : <Navigate to="/dashboard" replace />;
};

export default App;