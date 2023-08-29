import { api } from "src/boot/axios";

class ArchivosService {
    static async getData(params) {
        return (await api.get('/api/obras/archivo', params)).data;
    }

    static async get(id) {
        return (await api.get(`/api/obras/archivo/${id}`)).data;
    }

    static async delete(id) {
        return (await api.delete(`/api/obras/archivo/${id}`));
    }

    static async save(reg) {
        var formData = new FormData();
        formData.append('file', reg.nombre);
        if (reg.id === undefined || reg.id === null) {
            return (await api.post("/api/obras/archivo", formData, {
                headers: {
                    "Content-Type": "multipart/form-data"
                }
            })).data;
        } else {
            formData.append('_method', 'put');
            return (await api.post(`/api/obras/archivo/${reg.id}`, formData, {
                headers: {
                    "Content-Type": "multipart/form-data"
                }
            })).data;
        }
    }
}

export default ArchivosService;
