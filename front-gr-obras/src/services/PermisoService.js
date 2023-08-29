import { api } from "src/boot/axios";

class PermisoService {
    static async getData(params) {
        return (await api.get('/api/v1/permisos',params)).data;
    }

    static async get(id) {
        return (await api.get(`/api/v1/permisos/${id}`)).data;
    }

    static async delete(id) {
        return (await api.delete(`/api/v1/permisos/${id}`));
    }

    static async save(reg) {
        if (reg.id === undefined || reg.id === null) {
            return (await api.post("/api/v1/permisos", reg)).data;
        } else {
            return (await api.put(`/api/v1/permisos/${reg.id}`, reg)).data;
        }
    }
}

export default PermisoService;
