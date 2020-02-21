import axios from "axios"
import router from "../router/"

// cria uma instância axios para requisições
const service = axios.create({
  baseURL: process.env.VUE_APP_BASE_API, // 
  timeout: 5000 // request timeout
})

export default service
