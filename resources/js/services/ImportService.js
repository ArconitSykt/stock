import Api from './Api'

export default {
    add(data, config) {
        return Api().post('upload_import_file', data)
    }
}
