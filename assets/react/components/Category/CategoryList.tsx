import React, { useState, useEffect } from 'react';
import { getCategories, updateCategory, deleteCategory, createCategory } from "../../services/categoryService";
import { Category, ModalType } from "../../types";
import { Modal } from '../Modal';
import { CategoryForm } from './CategoryForm';


const CategoryList: React.FC = () => {
    const [categories, setCategories] = useState<Category[]>([]);
    const [loading, setLoading] = useState<boolean>(true);
    const [error, setError] = useState<string | null>(null);
    const [success, setSuccess] = useState<string | null>(null);
    const [selectedCategory, setSelectedCategory] = useState<Category | null>(null);
    const [modalType, setModalType] = useState<ModalType>(null);


    useEffect(() => {
        getCategories()
            .then((data) => {
                setCategories(data);
                setLoading(false);
            })
            .catch((err) => {
                setError(err.message);
                setLoading(false);
            });
    }, []);

    const handleDelete = (id: number) => {
        deleteCategory(id)
            .then(() => {
                setCategories(categories.filter((category) => category.id !== id));
                setSuccess('Category deleted successfully');
                setTimeout(() => { setSuccess(null) }, 3000);
            })
            .catch((err) => {
                setError(err.message);
                setTimeout(() => { setError(null) }, 3000);
            });
    };


    const handleModal = (type: ModalType, category?: Category) => {
        setModalType(type);
        setSelectedCategory(category || null);
    };

    const handleSubmit = async (categoryData: Category) => {
        try {
            if (modalType === 'create') {
                const newCategory = await createCategory(categoryData);
                setCategories([...categories, newCategory]);
                setSuccess('Category created successfully');
            } else {
                await updateCategory(categoryData.id, categoryData);
                setCategories(categories.map(c =>
                    c.id === categoryData.id ? categoryData : c
                ));
                setSuccess('Category updated successfully');
            }
            handleModal(null);
        } catch (err: any) {
            setError(err.message);
            setTimeout(() => { setError(null) }, 3000);
        }
    };
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
                    <h1 className=" text-xl font-semibold">Categories List</h1>
                    <button
                        onClick={() => handleModal('create')}
                        className="bg-[#219CFF] py-2 px-4 rounded-full text-white border-2 border-slate-300/30 hover:bg-[#1e8fd1]"
                    >
                        <span>Create Category</span>
                    </button>
                </div>
                <div className='flex w-fit border border-slate-500/30 rounded-xl overflow-hidden '>
                    <table className="min-w-fit table-auto  ">
                        <thead>
                            <tr className="border-b">
                                <th className="px-4 py-2 text-left">Name</th>
                                <th className="px-4 py-2 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {categories.map((category, index) => (
                                <tr key={category.id} className={`${index !== categories.length - 1 ? 'border-b border-slate-500/30' : ''}`}>
                                    <td className="px-4 py-2 border-t border-r">{category.name}</td>
                                    <td className="px-4 py-2 flex flex-row gap-2">
                                        <button onClick={() => handleModal('update', category)} className="bg-green-800 py-1 px-4 rounded-full text-white border-2 border-slate-300/30 hover:bg-green-900">
                                            <span className='text-sm'>Modify</span>
                                        </button>
                                        <button onClick={() => handleDelete(category.id)} className="bg-red-500 py-1 px-4 rounded-full text-white border-2 border-slate-300/30 hover:bg-red-600">
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
                title={modalType === 'create' ? 'Create Category' : 'Update Category'}
            >
                <CategoryForm
                    initialData={selectedCategory}
                    onCancel={() => {
                        handleModal(null);
                    }}
                    onSubmit={handleSubmit}
                />

            </Modal>

        </>
    );

};

export default CategoryList;