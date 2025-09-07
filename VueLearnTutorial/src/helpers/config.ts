// helpers/config.ts

export const BASE_URL = 'http://127.0.0.1:8000/api'

export const headersConfig = (token: string) => {
    const config = {
        headers: {
            "Authorization": `Bearer ${token}`,
            "Content-type": "application/json"
        }
    }
    return config
}
