import { api } from "src/boot/axios";

class AvancesService {
    static async getData(params) {
        return (await api.get('/api/obras/avance',params)).data;
    }

    static async get(id) {
        return (await api.get(`/api/obras/avance/${id}`)).data;
    }

    static async delete(id) {
        return (await api.delete(`/api/obras/avance/${id}`));
    }

    static async save(reg) {
        if (reg.id === undefined || reg.id === null) {
            return (await api.post("/api/obras/avance", reg)).data;
        } else {
            return (await api.put(`/api/obras/avance/${reg.id}`, reg)).data;
        }
    }
}

export default AvancesService;
