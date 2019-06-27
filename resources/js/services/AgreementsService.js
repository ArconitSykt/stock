import Api from './Api'

export default {
    index() {
        return Api().get('agr')
    },
    search(data) {
        return Api().post('agreements/search', data)
    },
    add(data, config) {
        return Api().post('agreements/add', data)
    }
}
