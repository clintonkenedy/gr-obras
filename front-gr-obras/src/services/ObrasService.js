import { api } from "src/boot/axios";

class ObrasService {
    static async getData(params) {
        return (await api.get('/api/obras/obra',params)).data;
    }

    static async get(id) {
        return (await api.get(`/api/obras/obra/${id}`)).data;
    }

    static async delete(id) {
        return (await api.delete(`/api/obras/obra/${id}`));
    }

    static async save(reg) {
        if (reg.id === undefined || reg.id === null) {
            return (await api.post("/api/obras/obra", reg)).data;
        } else {
            return (await api.put(`/api/obras/obra/${reg.id}`, reg)).data;
        }
    }
}

export default ObrasService;
