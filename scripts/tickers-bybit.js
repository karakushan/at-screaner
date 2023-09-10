const db = require('./lib/db');
const bybitApi = require('./lib/bybit-api');

const timeout = 3000;
db.getAllSymbols().then((symbols) => {
    setInterval(() => {
        let rowsUpdated = 0;
        bybitApi.getTickers()
            .then((prices) => {
                for (price of prices) {
                    let symbol = symbols.find((symbol) => {
                        return symbol.name === price.symbol;
                    });
                    if (symbol) {
                        db.updatePrice(bybitApi.exchangeID, symbol.id, parseFloat(price.last_price));
                    }
                }
            })
            .catch((error) => {
                console.error(error);
            })
            .finally(() => {
                console.log(`bybit:`, `prices updated at ${new Date().toLocaleString()}`);
            });
    }, timeout);
}).catch((error) => {
    console.error(error);
});
