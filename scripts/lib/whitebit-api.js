const axios = require('axios');

class WhitebitApi {
    constructor() {

    }

    async getTickers() {
        return new Promise(async (resolve, reject) => {
                try {
                    const response = await axios.get('https://whitebit.com/api/v1/public/tickers');
                    if (response.data.success && response.data.result) {
                        resolve(response.data.result);
                    }
                } catch (error) {
                    reject(error);
                }
            }
        );

    }
}

module.exports = new WhitebitApi();
