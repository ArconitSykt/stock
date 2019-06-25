import Api from './Api'

export default {
    get(data) {
        return Api().get('barcode/' + data)
    },
}
