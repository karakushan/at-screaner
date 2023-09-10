const axios = require('axios');

class BybitApi {
    constructor() {
        this.exchangeID = 3;
    }

    async getTickers() {
        return new Promise(async (resolve, reject) => {
                try {
                    const response = await axios.get('https://api.bybit.com/v2/public/tickers');
                    if (response.data && response.data.result) {
                        resolve(response.data.result);
                    }
                } catch (error) {
                    reject(error);
                }
            }
        );

    }
}

module.exports = new BybitApi();
