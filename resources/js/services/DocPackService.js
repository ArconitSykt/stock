import Api from './Api'

export default {
    index(data) {
        Api().post('trans_report', data, {
            responseType: "blob" 
        })
    }
}
