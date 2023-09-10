const db = require('./lib/db');
const gateApi = require('./lib/gate-api');

const timeout = 3000;
db.getAllSymbols().then((symbols) => {
    setInterval(() => {
        gateApi.getTickers()
            .then((prices) => {
                prices.forEach((price) => {
                    let symbol = symbols.find((symbol) => {
                        let symbolName = price.currency_pair.replace('_', '');
                        return symbol.name === symbolName;
                    });
                    if (symbol) {
                        db.updatePrice(process.env.GATEIO_ID, symbol.id, parseFloat(price.last));
                    }
                });
            })
            .catch((error) => {
                console.error(error);
            })
            .finally(() => {
                console.log(`gateio:`, `prices updated at ${new Date().toLocaleString()}`);
            });
    }, timeout);
}).catch((error) => {
    console.error(error);
});
