import React, { useState, useEffect } from 'react';
import { getProducts, deleteProduct, updateProduct, createProduct } from '../../services/productService';
import { Product, ModalType } from '../../types';
import { Modal } from '../Modal';
import { ProductForm } from './ProductForm';

const ProductList: React.FC = () => {
    const [products, setProducts] = useState<Product[]>([]);
    const [loading, setLoading] = useState<boolean>(true);
    const [error, setError] = useState<string | null>(null);
    const [success, setSuccess] = useState<string | null>(null);
    const [selectedProduct, setSelectedProduct] = useState<Product | null>(null);
    const [modalType, setModalType] = useState<ModalType>(null);

    useEffect(() => {
        getProducts()
            .then((data) => {
                setProducts(data);
                setLoading(false);
            })
            .catch((err) => {
                setError(err.message);
                setLoading(false);
            });
    }, []);

    const handleDelete = (id: number) => {
        deleteProduct(id)
            .then(() => {
                setProducts(products.filter((product) => product.id !== id));
                setSuccess('Product deleted successfully');
                setTimeout(() => { setSuccess(null) }, 3000);
            })
            .catch((err) => {
                setError(err.message);
                setTimeout(() => { setError(null) }, 3000);
            });
    };

    const handleModal = (type: ModalType, products?: Product) => {
        setModalType(type);
        setSelectedProduct(products || null);
    };

    const handleSubmit = async (categoryData: Product) => {
        try {

            if (modalType === 'create') {
                const newProduct = await createProduct(categoryData);
                setProducts([...products, newProduct]);
                setSuccess('Product created successfully');
                setTimeout(() => { setSuccess(null) }, 3000);
               
            } else {
                await updateProduct(categoryData.id, categoryData);
                setProducts(products.map(c =>
                    c.id === categoryData.id ? categoryData : c
                ));
                setSuccess('Product updated successfully');
                setTimeout(() => { setSuccess(null) }, 3000);
            }
            handleModal(null);
        } catch (err: any) {
            setError(err.message);
            setTimeout(() => { setError(null) }, 3000);
        }


    }


    if (loading) return <div>Loading...</div>;


    return (

        <>
        {success &&
                <div className="bg-[#005820d4] border border-green-800 text-white px-4 py-3 rounded-xl fixed bottom-0 left-1/2 transform -translate-x-1/2 mb-4 shadow-lg">
                    {success} </div>
            }
            {error && (
                <div
                    className="bg-[#7f0000c7] border border-red-600 text-white px-4 py-3 rounded-xl fixed bottom-0 left-1/2 transform -translate-x-1/2 mb-4 shadow-lg">
                    {error}
                </div>
            )}

            <div className='flex flex-col p-10 justify-center items-center'>
            <div className='flex flex-row justify-center items-center mb-4 gap-4'>
                    <h1 className=" text-xl font-semibold">Products List</h1>
                    <button
                        onClick={() => handleModal('create')}
                        className="bg-[#219CFF] py-2 px-4 rounded-full text-white border-2 border-slate-300/30 hover:bg-[#1e8fd1]"
                    >
                        <span>Create Product</span>
                    </button>
                </div>
                <div className='flex w-fit  border border-slate-500/30 rounded-xl overflow-hidden '>
                    <table className="min-w-fit table-auto ">
                        <thead>
                            <tr className="border-b">
                                <th className="px-4 py-2 text-left">Name</th>
                                <th className="px-4 py-2 text-left">Description</th>
                                <th className="px-4 py-2 text-left">Price</th>
                                <th className="px-4 py-2 text-left">Category</th>
                                <th className="px-4 py-2 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {products.map((product, index) => (
                                <tr key={product.id} className={`${index !== products.length - 1 ? 'border-b border-slate-500/30' : ''}`}>
                                    <td className="px-4 py-2 border-t border-r">{product.name}</td>
                                    <td className="px-4 py-2 border-t border-r">{product.description}</td>
                                    <td className="px-4 py-2 border-t border-r">{product.price}€</td>
                                    <td className="px-4 py-2 border-t border-r">{product.category.name}</td>
                                    <td className="px-4 py-2 flex flex-row gap-2">
                                        <button onClick={() => handleModal('update', product)} className="bg-green-800 py-1 px-4 rounded-full text-white border-2 border-slate-300/30 hover:bg-green-900">
                                            <span className='text-sm'>Modify</span>
                                        </button>
                                        <button onClick={() => handleDelete(product.id)} className="bg-red-500 py-1 px-4 rounded-full text-white border-2 border-slate-300/30 hover:bg-red-600 ">
                                            <span className='text-sm'>Deleted</span>
                                        </button>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            </div>
            <Modal
                isOpen={modalType !== null}
                onClose={() => {
                    handleModal(null);
                }}
                title={modalType === 'create' ? 'Create Product' : 'Update Product'}
            >
                <ProductForm
                    initialData={selectedProduct}
                    onCancel={() => {
                        handleModal(null);
                    }}
                    onSubmit={handleSubmit}
                />

            </Modal>
        </>
    );
};

export default ProductList;





