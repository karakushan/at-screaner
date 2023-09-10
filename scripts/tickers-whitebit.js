const db = require('./lib/db');
const whitebitApi = require('./lib/whitebit-api');

const timeout = 3000;


whitebitApi.getTickers().then((prices) => {
    console.log(prices);
})
