import Api from './Api'

export default {
    index() {
        return Api().get('users')
    },
    raw() {
        return Api().get('raw/users')
    },
    update(data) {
        return Api().post('update/user', data)
    },
    create(data) {
        return Api().post('create/user', data)
    },
    delete(data) {
        return Api().post('delete/user', data)
    },
    get(data) {
        return Api().get('users/' + data)
    },
    getItems(data) {
        return Api().get('items/user/' + data)
    },
    list(data) {
        return Api().get('list/' + data)
    },
}
