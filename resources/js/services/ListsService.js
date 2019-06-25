import Api from './Api'

export default {
    list(data) {
        return Api().get('list/' + data)
    },
}
