import { api } from "src/boot/axios";
import axios from 'axios';
import { stringify } from "postcss";
class CronogramasService {
    static async getData(params) {
        return (await api.get('/api/obras/cronograma', params)).data;
    }

    static async get(id) {
        return (await api.get(`/api/obras/cronograma/${id}`)).data;
    }

    static async delete(id) {
        return (await api.delete(`/api/obras/cronograma/${id}`));
    }

    static async save(reg) {
        if (reg.id === undefined || reg.id === null) {
            return (await api.post("/api/obras/cronograma", reg, {
                headers: {
                    "Content-Type": "multipart/form-data"
                }
            })).data;
        } else {
            var formData = new FormData();
            formData.append('_method', 'put');
            formData.append('data', JSON.stringify(reg));
            formData.append('file1', reg.arch_cronograma);
            formData.append('file2', reg.requerimientos);
            return (await api.post(`/api/obras/cronograma/${reg.id}`, formData, {
                headers: {
                    "Content-Type": "multipart/form-data"
                }
            })).data;
        }
    }
}

export default CronogramasService;
