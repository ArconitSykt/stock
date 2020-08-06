import Api from './Api'

export default {
    index() {
        return Api().get('items')
    },

    update(data) {
        return Api().post('update/item', data)
    },
    create(data) {
        return Api().post('create/item', data)
    },
    delete(data) {
        return Api().post('delete/item', data)
    },
    get(data) {
        return Api().get('items/' + data)
    },
    hystory(data) {
        return Api().get('hystory/' + data)
    },
    selectYear(data) {
        return Api().get('year/' + data)
    },
    filter(data) {
        return Api().get('items_filter/' + data)
    },


}
