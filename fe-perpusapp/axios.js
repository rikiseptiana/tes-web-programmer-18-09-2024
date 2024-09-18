import axios from "axios";

const customApi = axios.create({
  baseURL: "http://localhost:8000/",
});

export default customApi;
