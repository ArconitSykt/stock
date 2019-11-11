class Config {
    constructor() {
        this.baseURL = "http://192.168.0.22/stock2.0/public/"
    }

    /**
     * Для генерации штрихкодов не по складам
     * Не понял, как взять этот линк из других мест
     */
    getURL() {
        return this.baseURL
    }
}

export default {
    getURL() {
        return new Config().getURL()
    }
}