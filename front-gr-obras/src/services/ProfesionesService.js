import http from "src/utils/http";

class ProfesionesService {
    static async getData() {
        return (await http.get('/api/obras/profesion')).data;
    }

    static async get(id) {
        return (await http.get(`/api/obras/profesion/${id}`)).data;
    }

    static async delete(id) {
        return (await http.delete(`/api/obras/profesion/${id}`));
    }

    static async save(reg) {
        if (reg.id === undefined || reg.id === null) {
            return (await http.post("/api/obras/profesion", reg)).data;
        } else {
            return (await http.put(`/api/obras/profesion/${reg.id}`, reg)).data;
        }
    }
}

export default ProfesionesService;
