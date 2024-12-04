import React from 'react';
import { Provider } from 'react-redux';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';
import NotFound from './components/pages/NotFound';
import Navbar from './components/Navbar';
import HomePage from './components/pages/HomePage';
import ProductPage from './components/pages/ProductPage';
import CategoryPage from './components/pages/CategoryPage';

const App = () => {
    return (
            <Router>
                <Navbar />
                <Routes>
                    <Route path="/" element={<HomePage />} />
                    <Route path="/products" element={<ProductPage />} />
                    <Route path="/categories" element={<CategoryPage />} />
                    <Route path="*" element={<NotFound />} />
                </Routes>
            </Router>
    );
};

export default App;