let csrfToken: string | null = null;

const getCsrfToken = (): string | null => {
    if (csrfToken) return csrfToken;

    const match = document.cookie.match(/XSRF-TOKEN=([^;]+)/);
    csrfToken = match ? decodeURIComponent(match[1]) : null;
    return csrfToken;
};

const ensureCsrfToken = async (): Promise<void> => {
    if (!getCsrfToken()) {
        await fetch('/sanctum/csrf-cookie', {
            method: 'GET',
            credentials: 'include',
        });
        const match = document.cookie.match(/XSRF-TOKEN=([^;]+)/);
        csrfToken = match ? decodeURIComponent(match[1]) : null;
    }
};

export const apiFetch = async (url: string, options: RequestInit = {}) => {
    await ensureCsrfToken();

    const token = getCsrfToken();

    return fetch(`/api${url}`, {
        credentials: 'include',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-XSRF-TOKEN': token || '',
            ...options.headers,
        },
        ...options,
    });
};
