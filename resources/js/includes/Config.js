class Config {
    constructor() {
        this.baseURL = "http://192.168.0.232/stock2.0/public/"
    }

    getURL() {
        return this.baseURL
    }
}

export default {
    getURL() {
        return new Config().getURL()
    }
}