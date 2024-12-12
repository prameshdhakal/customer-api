import "./styles.css";
import CustomerList from "./pages/customers/CustomerList";
import LoginPage from "./pages/LoginPage";
import { Routes, Route } from "react-router-dom";
import ProtectedRoute from "./components/ProtectedRoute";

function App() {
  return (
    <Routes>
      <Route path="/" element={<LoginPage />} />
      <Route
        path="/customer-list"
        element={
          <ProtectedRoute>
            <CustomerList />
          </ProtectedRoute>
        }
      />
    </Routes>
  );
}

export default App;
