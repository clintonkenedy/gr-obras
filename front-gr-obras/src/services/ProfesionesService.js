import axios from "axios";

class ProfesionesService {
    static async getData() {
        return (await axios.get('http://localhost:8000/api/obras/profesion')).data;
    }

    static async get(id) {
        return (await axios.get(`http://localhost:8000/api/obras/profesion/${id}`)).data;
    }

    static async delete(id) {
        return (await axios.delete(`http://localhost:8000/api/obras/profesion/${id}`));
    }

    static async save(reg) {
        if (reg.id === undefined || reg.id === null) {
            return (await axios.post("http://localhost:8000/api/obras/profesion", reg)).data;
        } else {
            return (await axios.put(`http://localhost:8000/api/obras/profesion/${reg.id}`, reg)).data;
        }
    }
}

export default ProfesionesService;
