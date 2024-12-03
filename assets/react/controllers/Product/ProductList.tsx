import React, { useState, useEffect } from 'react';
import { getProducts, deleteProduct } from '../services/productService';
import { Product } from '../services/productService';



const ProductList: React.FC = () => {
    const [products, setProducts] = useState<Product[]>([]);
    const [loading, setLoading] = useState<boolean>(true);
    const [error, setError] = useState<string | null>(null);

    useEffect(() => {
        // Récupérer les produits lors du montage du composant
        getProducts()
            .then((data) => {
                setProducts(data);
                setLoading(false);
            })
            .catch((err) => {
                setError('Erreur lors du chargement des produits');
                setLoading(false);
            });
    }, []);

    const handleDelete = (id: number) => {
        deleteProduct(id)
            .then(() => {
                // Met à jour l'état local après la suppression
                setProducts(products.filter((product) => product.id !== id));
            })
            .catch((err) => {
                console.error('Erreur lors de la suppression du produit:', err);
            });
    };

    if (loading) return <div>Loading...</div>;

    if (error) return <div>{error}</div>;

    return (
        <div className='flex flex-col'>
           <h1 className="mb-4 text-xl font-semibold">Liste des produits</h1>
            <table className="min-w-full table-auto border-collapse">
                <thead>
                    <tr className="border-b">
                        <th className="px-4 py-2 text-left">Nom</th>
                        <th className="px-4 py-2 text-left">Description</th>
                        <th className="px-4 py-2 text-left">Prix</th>
                        <th className="px-4 py-2 text-left">Catégorie</th>
                        <th className="px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    {products.map((product) => (
                        <tr key={product.id} className="border-b">
                            <td className="px-4 py-2">{product.name}</td>
                            <td className="px-4 py-2">{product.description}</td>
                            <td className="px-4 py-2">{product.price} €</td>
                            <td className="px-4 py-2">{product.category.name}</td>
                            <td className="px-4 py-2">
                                <button
                                    onClick={() => handleDelete(product.id)}
                                    className="bg-cyan-700 py-2 px-4 rounded-full text-white border border-gray-500 hover:bg-cyan-800"
                                >
                                    Supprimer
                                </button>
                            </td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
};

export default ProductList;
