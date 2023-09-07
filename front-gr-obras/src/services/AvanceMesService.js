import { api } from "src/boot/axios";

class AvanceMesService {
    static async getData(params) {
        return (await api.get('/api/obras/avance_mes', params)).data;
    }

    // static async get(id) {
    //     return (await api.get(`/api/obras/avance_mes/${id}`)).data;
    // }

    // static async delete(id) {
    //     return (await api.delete(`/api/obras/avance_mes/${id}`));
    // }

    static async save(reg) {
        if (reg.id === undefined || reg.id === null) {
            return (await api.post("/api/obras/avance_mes", reg, {
                headers: {
                    "Content-Type": "multipart/form-data"
                }
            })).data;
        } else {
            var formData = new FormData();
            formData.append('_method', 'put');
            formData.append('data', JSON.stringify(reg));
            reg.files.forEach(a => {
                formData.append('files[]', a);
            });
            return (await api.post(`/api/obras/avance_mes/${reg.id}`, formData, {
                headers: {
                    "Content-Type": "multipart/form-data"
                }
            })).data;
        }
    }
}

export default AvanceMesService;
