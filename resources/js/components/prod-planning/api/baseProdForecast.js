export const getMatBalanceData = async(payload) => {
    try {
        const res = await axios.get(payload.url)
        return res.data
    } catch (error) {
        console.log(error)
    }
}