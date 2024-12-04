import React from 'react';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';
import Navbar from '../Navbar';
import ProductPage from './ProductPage';
import CategoryPage from './CategoryPage';

const HomePage: React.FC = () => {
    return (
        <Router>
                <Navbar />
                <Routes>
                    <Route path="/products" element={<ProductPage />} />
                    <Route path="/categories" element={<CategoryPage />} />
                </Routes>
        </Router>
    );
};

export default HomePage;