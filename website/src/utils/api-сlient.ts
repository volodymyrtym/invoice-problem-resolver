import axios, { AxiosInstance } from 'axios';

export class ApiClient {
    private client: AxiosInstance;

    constructor() {
        this.client = axios.create({
            baseURL: 'http://dfdf.loc',
            timeout: 5000,
        });
    }

    async post<T>(auth: boolean, url: string, data: any): Promise<T> {
        try {
            const response = await this.client.post<T>(url, data);
            return response.data;
        } catch (error) {
            console.error('API Request Error:', error);
            throw error;
        }
    }

    async put<T>(auth: boolean, url: string, data: any): Promise<T> {
        try {
            const response = await this.client.put<T>(url, data);
            return response.data;
        } catch (error) {
            console.error('API Request Error:', error);
            throw error;
        }
    }

    async get<T>(auth: boolean, url: string, params?: any): Promise<T> {
        try {
            const response = await this.client.get<T>(url, { params });
            return response.data;
        } catch (error) {
            console.error('API Request Error:', error);
            throw error;
        }
    }
}

