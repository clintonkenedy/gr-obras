import { api } from "src/boot/axios";

class ProfesionesService {
    static async getData(params) {
        return (await api.get('/api/obras/profesion',params)).data;
    }

    static async get(id) {
        return (await api.get(`/api/obras/profesion/${id}`)).data;
    }

    static async delete(id) {
        return (await api.delete(`/api/obras/profesion/${id}`));
    }

    static async save(reg) {
        if (reg.id === undefined || reg.id === null) {
            return (await api.post("/api/obras/profesion", reg)).data;
        } else {
            return (await api.put(`/api/obras/profesion/${reg.id}`, reg)).data;
        }
    }
}

export default ProfesionesService;
