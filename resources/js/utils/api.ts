export const apiFetch = async (url: string, options: RequestInit = {}) => {
    const token = localStorage.getItem('auth_token');

    const headers = {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        ...options.headers,
    };

    if (token) {
        (headers as any)['Authorization'] = `Bearer ${token}`;
    }

    return fetch(`/api${url}`, {
        ...options,
        headers,
    });
};
