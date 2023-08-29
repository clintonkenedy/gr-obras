import { api } from "src/boot/axios";

class TrabajadoresService {
    static async getData(params) {
        return (await api.get('/api/obras/trabajador', params)).data;
    }

    static async get(id) {
        return (await api.get(`/api/obras/trabajador/${id}`)).data;
    }

    static async save(row) {
        if (row.id === undefined || row.id === null) {
            return (await api.post("/api/obras/trabajador", row)).data;
        } else {
            return (await api.put(`/api/obras/trabajador/${row.id}`, row)).data;
        }
    }

    static async delete(id) {
        return (await api.delete(`/api/obras/trabajador/${id}`));
    }
}

export default TrabajadoresService;