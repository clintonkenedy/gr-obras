import { api } from "src/boot/axios";

class UsuarioService {
  static async getData(params) {
    return (await api.get("api/v1/usuarios", params)).data;
  }

  static async get(id, permisos) {
    if (permisos) {
      return (
        await api.get(`api/v1/usuarios/${id}`, {
          params: { permisos: permisos },
        })
      ).data;
    } else {
      return (await api.get(`api/v1/usuarios/${id}`)).data;
    }
  }

  static async save(reg) {
    if (reg.id === undefined || reg.id === null) {
      return (await api.post("api/v1/usuarios", reg)).data;
    } else {
      return (await api.put(`api/v1/usuarios/${reg.id}`, reg)).data;
    }
  }

  static async updateUserPermisos(reg) {
    return (await api.put(`api/updateUserPermisos/${reg.id}`, reg)).data;
  }

  static async delete(id) {
    return (await api.delete(`api/v1/usuarios/${id}`)).data;
  }
}

export default UsuarioService;
