export const BASE_URL = 'http://localhost/api'


export const headersConfig = (token) => {
    const config = {
        headers: {
            "Authorization": `Bearer ${token}`,
            "Content-type": "application/json"
        }
    }
    return config
}