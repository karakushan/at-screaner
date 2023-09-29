const db = require('./lib/db');
const whitebitApi = require('./lib/whitebit-api');


const timeout = 3000;
db.getAllSymbols().then((symbols) => {
    setInterval(() => {
        whitebitApi.getTickers()
            .then((prices) => {
                for (let key in prices) {
                    let symbol = symbols.find((symbol) => {
                        let symbolName = key.replace('_', '');
                        return symbol.name === symbolName;
                    });
                    if (symbol) {

                        db.findPrice(process.env.WHITEBIT_ID, symbol.id)

                        // if(db.findPrice(process.env.WHITEBIT_ID, symbol.id)){
                        //     db.updatePrice(process.env.WHITEBIT_ID, symbol.id, parseFloat(prices[key]['last_price']));
                        // }

                    }
                }
            })
            .catch((error) => {
                console.error(error);
            })
            .finally(() => {
                console.log(`whitebit:`, `prices updated at ${new Date().toLocaleString()}`);
            });
    }, timeout);
}).catch((error) => {
    console.error(error);
});
