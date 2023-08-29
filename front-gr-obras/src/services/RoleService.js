import { api } from "src/boot/axios";

class RoleService {
  static async getData(params) {
    return (await api.get("api/v1/roles", params)).data;
  }

  static async getPermissions() {
    return (await api.get("api/v1/permissions")).data;
  }

  static async get(id) {
    return (await api.get(`api/v1/roles/${id}`)).data;
  }

  static async save(reg) {
    if (reg.id === undefined || reg.id === null) {
      return (await api.post("api/v1/roles", reg)).data;
    } else {
      return (await api.put(`api/v1/roles/${reg.id}`, reg)).data;
    }
  }

  static async delete(id) {
    return await api.delete(`api/v1/roles/${id}`);
  }
}

export default RoleService;
