import axios from "axios";

export const getTreeData = async (payload) => {
    try {
        const res = await axios.post(payload.url, payload.body);
        return res.data
    } catch (error) {
        console.log(error)
    }
}

export const postTreeData = async (payload) => {
    try {
        const res = await axios.post(payload.url, payload.body);
        return res.data
    } catch (error) {
        console.log(error)
    }
}

export const getTreeTable = async (payload) => {
    try {
        const res = await axios.post(payload.url, payload.body);
        return res.data
    } catch (error) {
        console.log(error)
    }
}

export const getTableWell = async (payload) => {
    try {
        const res = await axios.post(payload.url, payload.body);
        return res.data
    } catch (error) {
        console.log(error)
    }
}

export const createTreeBody = (action_type, date_range_model, org_struct, finder_model) => {
    return {
        action_type: action_type,
        date_range_model: date_range_model,
        org_struct: org_struct,
        finder_model: finder_model
    };
}