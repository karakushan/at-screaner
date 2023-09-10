const axios = require('axios');
class GateApi {
    constructor(props) {

    }

    async getTickers() {
        return new Promise(async (resolve, reject) => {
                try {
                    const response = await axios.get('https://api.gateio.ws/api/v4/spot/tickers');
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

module.exports = new GateApi();
