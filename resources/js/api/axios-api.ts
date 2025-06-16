import axios from "axios";

const APP_URL = import.meta.env.VITE_APP_URL;

const plainInstance = axios.create({
  baseURL: APP_URL,
  headers: {
    "Content-Type": "application/json",
    Accept: "application/json",
  },
});

export { plainInstance };
