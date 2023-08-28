import { api } from "src/boot/axios";

class PersonasService {
    static async getData(params) {
        return (await api.get('/api/obras/persona', params)).data;
    }

    static async get(id) {
        return (await api.get(`/api/obras/persona/${id}`)).data;
    }

    static async save(row) {
        if (row.id === undefined || row.id === null) {
            return (await api.post("/api/obras/persona", row)).data;
        } else {
            return (await api.put(`/api/obras/persona/${row.id}`, row)).data;
        }
    }

    static async delete(id) {
        return (await api.delete(`/api/obras/persona/${id}`));
    }
}

export default PersonasService;