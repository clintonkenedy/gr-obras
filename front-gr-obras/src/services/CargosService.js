import { api } from "src/boot/axios";

class CargosService {
    static async getData(params) {
        return (await api.get('/api/obras/cargo', params)).data;
    }

    static async get(id) {
        return (await api.get(`/api/obras/cargo/${id}`)).data;
    }

    static async save(row) {
        if (row.id === undefined || row.id === null) {
            return (await api.post("/api/obras/cargo", row)).data;
        } else {
            return (await api.put(`/api/obras/cargo/${row.id}`, row)).data;
        }
    }

    static async delete(id) {
        return (await api.delete(`/api/obras/cargo/${id}`));
    }
}

export default CargosService;