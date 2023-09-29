const axios = require('axios');

class WhitebitApi {
    constructor() {
        this.urls = {
            tickers: 'https://whitebit.com/api/v4/public/ticker'
        }
    }

    async getTickers() {
        return new Promise(async (resolve, reject) => {
                try {
                    const response = await axios.get(this.urls.tickers);
                    if (response.data) {
                        resolve(response.data);
                    }
                } catch (error) {
                    reject(error);
                }
            }
        );

    }
}

module.exports = new WhitebitApi();
