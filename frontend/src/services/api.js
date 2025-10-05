import axios from 'axios';

const API_URL = process.env.REACT_APP_API_URL || 'http://localhost:8080/api';

const api = axios.create({
    baseURL: API_URL,
    headers: {
        'Content-Type': 'application/json',
    },
});

export const getReservations = () => api.get('/reservations');
export const createReservation = (data) => api.post('/reservations', data);
export const deleteReservation = (id) => api.delete(`/reservations/${id}`);

export default api;
