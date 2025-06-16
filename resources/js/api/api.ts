import { plainInstance } from './axios-api'

export class api {
    getPackages() {
        return plainInstance.get("/api/packages");
    }
}