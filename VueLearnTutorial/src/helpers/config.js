export const BASE_URL = 'http://127.0.0.1:8000/api'


export const headersConfig = (token) => {
    const config = {
        headers: {
            "Authorization": `Bearer ${token}`,
            "Content-type": "application/json"
        }
    }
    return config
}