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
            return (await api.post("/api/obras/obra", reg, {
                headers: {
                    "Content-Type": "multipart/form-data"
                }
            })).data;
        } else {
            var formData = new FormData();
            formData.append('_method', 'put');
            formData.append('data', JSON.stringify(reg));
            formData.append('file1', reg.resolucion);
            formData.append('file2', reg.kmz);
            return (await api.post(`/api/obras/obra/${reg.id}`, formData, {
                headers: {
                    "Content-Type": "multipart/form-data"
                }
            })).data;
        }
    }
}

export default ObrasService;
