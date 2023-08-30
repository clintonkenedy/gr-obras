import { api } from "src/boot/axios";

class ProfesionesService {
    static async getData(params) {
        return (await api.get('/api/obras/profesion', params)).data;
    }

    static async get(id) {
        return (await api.get(`/api/obras/profesion/${id}`)).data;
    }

    static async save(row) {
        if (row.id === undefined || row.id === null) {
            return (await api.post("/api/obras/profesion", row)).data;
        } else {
            return (await api.put(`/api/obras/profesion/${row.id}`, row)).data;
        }
    }

    static async delete(id) {
        return (await api.delete(`/api/obras/profesion/${id}`));
    }
}

export default ProfesionesService;