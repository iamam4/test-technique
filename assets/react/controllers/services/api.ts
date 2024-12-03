const API_URL = '/api';

// Function to make GET calls
export const fetchData = async <T>(url: string): Promise<T> => {
    const response = await fetch(`${API_URL}${url}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        },
    });

    if (!response.ok) {
        throw new Error(`Erreur de chargement des données: ${response.statusText}`);
    }

    return response.json();
};

// Function to make POST calls
export const postData = async <T>(url: string, data: T): Promise<T> => {
    const response = await fetch(`${API_URL}${url}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    });

    if (!response.ok) {
        throw new Error(`Erreur lors de l'envoi des données: ${response.statusText}`);
    }

    return response.json();
};

// Function to make PUT calls
export const putData = async <T>(url: string, data: T): Promise<T> => {
    const response = await fetch(`${API_URL}${url}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    });

    if (!response.ok) {
        throw new Error(`Erreur lors de la mise à jour des données: ${response.statusText}`);
    }

    return response.json();
};

// Function to make DELETE calls
export const deleteData = async (url: string): Promise<void> => {
    const response = await fetch(`${API_URL}${url}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
        },
    });

    if (!response.ok) {
        throw new Error(`Erreur lors de la suppression des données: ${response.statusText}`);
    }
};