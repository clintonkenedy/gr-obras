import axios from 'axios'
import { Cookies } from 'quasar'

var sessionToken = Cookies.get('token');

const http = axios.create({
  baseURL: import.meta.env.VITE_APP_API_URL,
  headers: {
    Authorization: sessionToken
  }
});

export default http;