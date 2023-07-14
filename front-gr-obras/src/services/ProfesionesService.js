import axios from "axios";
import http from "src/utils/http";

class ProfesionesService {
    static async getData() {
        return (await html.get('/api/obras/profesion')).data;
    }

    static async get(id) {
        return (await html.get(`/api/obras/profesion/${id}`)).data;
    }

    static async delete(id) {
        return (await html.delete(`/api/obras/profesion/${id}`));
    }

    static async save(reg) {
        if (reg.id === undefined || reg.id === null) {
            return (await html.post("/api/obras/profesion", reg)).data;
        } else {
            return (await html.put(`/api/obras/profesion/${reg.id}`, reg)).data;
        }
    }
}

export default ProfesionesService;
