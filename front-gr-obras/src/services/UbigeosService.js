import { api } from "src/boot/axios";

class UbigeosService {
    static async getDepartamentos() {
        return (await api.get("api/departamentos")).data;
    }

    static async getProvincias(departamento) {
        var lista = (await api.get("api/provincias")).data;
        return lista.filter((x) => x.ndep == departamento);
    }

    static async getDistritos(departamento, provincia) {
        var list = (await api.get("api/distritos")).data;
        return list.filter((x) => x.ndep == departamento && x.nprov == provincia);
    }
}

export default UbigeosService;