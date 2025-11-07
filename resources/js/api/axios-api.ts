import axios from "axios";

const APP_URL = import.meta.env.VITE_APP_URL;

const plainInstance = axios.create({
  baseURL: APP_URL,
});

plainInstance.interceptors.request.use(
  (config) => {
    if (config.data instanceof FormData) {
      delete config.headers["Content-Type"];
    } else {
      config.headers["Content-Type"] = "application/json";
    }
    
    config.headers["Accept"] = "application/json";
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

export { plainInstance };