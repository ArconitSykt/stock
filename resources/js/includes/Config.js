class Config {
    constructor() {
        this.baseURL = ""
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