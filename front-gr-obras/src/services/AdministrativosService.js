import { api } from "src/boot/axios";

class AdministrativosService {
    static async getData(params) {
        return (await api.get("api/administrativo", params)).data;
    }

    static async get(id, permisos) {
        if (permisos) {
            return (
                await api.get(`api/administrativo/${id}`, {
                    params: { permisos: permisos },
                })
            ).data;
        } else {
            return (await api.get(`api/administrativo/${id}`)).data;
        }
    }

    static async save(reg) {
        if (reg.id === undefined || reg.id === null) {
            return (await api.post("api/administrativo", reg)).data;
        } else {
            return (await api.put(`api/administrativo/${reg.id}`, reg)).data;
        }
    }

    static async updateUserPermisos(reg) {
        return (await api.put(`api/updateUserPermisos/${reg.id}`, reg)).data;
    }

    static async delete(id) {
        return (await api.delete(`api/administrativo/${id}`)).data;
    }
}

export default AdministrativosService;
