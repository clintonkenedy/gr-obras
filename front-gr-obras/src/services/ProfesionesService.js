import axios from "axios";

class ProfesionesService {
    static async getData() {
        return (await axios.get('http://localhost:8000/api/obras/profesion')).data;
    }

    static async get(id) {
        return (await axios.get(`http://localhost:8000/api/obras/profesion/${id}`)).data;
    }
}

export default ProfesionesService;