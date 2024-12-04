import { fetchData, postData, putData, deleteData } from './api';
import { Category } from '../types';

const CATEGORY_API_URL = '/categories';

// Function to get the list of categories
export const getCategories = async (): Promise<Category[]> => {
    return fetchData<Category[]>(CATEGORY_API_URL);
};

// Function to get a category by its id

export const getCategory = async (id: number): Promise<Category> => {
    return fetchData<Category>(`${CATEGORY_API_URL}/${id}`);
};

// Function to create a category

export const createCategory = async (category: Category): Promise<Category> => {
    return postData(CATEGORY_API_URL, category);
};

// Function to update a category

export const updateCategory = async (id: number, category: Category): Promise<Category> => {
    return putData(CATEGORY_API_URL + `/${id}`, category);
};

// Function to delete a category

export const deleteCategory = async (id: number): Promise<void> => {
    return deleteData(CATEGORY_API_URL + `/${id}`);
};

