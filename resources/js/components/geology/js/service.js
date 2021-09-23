import axios from 'axios'

const service = axios.create({
    baseURL: process.env.MIX_API_URL
});

service.interceptors.request.use(
    config => {
        return config
    },
    error => {
        return Promise.reject(error)
    }
)

service.interceptors.response.use(
    response => {
        const res = response
        if (res.status !== 200) return ;//TODO Error message or action
        return res.data
    },
    error => {
        return Promise.reject({ error: error, color: 'danger', message: '' /* TODO Error message or action */ })
    }
);

export default service
