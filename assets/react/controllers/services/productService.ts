import { fetchData, postData, putData, deleteData } from './api';
import { Category } from './categoryService';


export interface Product {
    id: number;
    name: string;
    description: string;
    price: number;
    category: Category;
}

const PRODUCT_API_URL = '/products';

// Fonction pour récupérer la liste des produits
export const getProducts = async (): Promise<Product[]> => {
    return fetchData<Product[]>(PRODUCT_API_URL);
};

// Fonction pour récupérer un produit spécifique
export const getProduct = async (id: number): Promise<Product> => {
    return fetchData<Product>(`${PRODUCT_API_URL}/${id}`);
};

// Fonction pour créer un produit
export const createProduct = async (product: Product): Promise<Product> => {
    return postData(PRODUCT_API_URL, product);
};

// Fonction pour mettre à jour un produit
export const updateProduct = async (id: number, product: Product): Promise<Product> => {
    return putData(PRODUCT_API_URL + `/${id}`, product);
};

// Fonction pour supprimer un produit
export const deleteProduct = async (id: number): Promise<void> => {
    return deleteData(PRODUCT_API_URL + `/${id}`);
};
