import axios from 'axios'
const service = axios.create({
    baseURL: process.env.MIX_MICROSERVICE_WELLS_DATA,
    headers: {
        'Access-Control-Allow-Origin' : '*',
        'Access-Control-Allow-Methods':'GET,PUT,POST,DELETE,PATCH,OPTIONS',
    },
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
        return Promise.reject({ error: error, color: 'danger', message: error.response.data })
    }
);

export default service
