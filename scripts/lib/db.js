const mysql = require("mysql2");
require("dotenv").config();
class DB {
    constructor() {
        this.connection = mysql.createConnection({
            host: process.env.DB_HOST,
            user: process.env.DB_USERNAME,
            password: process.env.DB_PASSWORD,
            database: process.env.DB_DATABASE
        });
    }

    getExchange(slug = null) {
        return new Promise((resolve, reject) => {
            this.connection.query(
                "SELECT * FROM `exchanges` WHERE `slug` = ?", [slug],
                (error, results, fields) => {
                    if (error) {
                        reject(error);
                    }
                    resolve(results);
                }
            );
        });
    }

    async getAllSymbols() {
        return new Promise((resolve, reject) => {
            this.connection.query(
                "SELECT * FROM `symbols`",
                (error, results, fields) => {
                    if (error) {
                        reject(error);
                    }
                    resolve(results);
                }
            );
        });
    }

    updatePrice(exchangeId, symbolId, price) {
        return new Promise((resolve, reject) => {
            this.connection.query(
                "UPDATE `symbol_prices` SET `price` = ?, `updated_at` = NOW() WHERE `exchange_id` = ? AND `symbol_id` = ?", [price, exchangeId, symbolId],
                (error, results, fields) => {
                    if (error) {
                        reject(error);
                    }
                    resolve(results);
                }
            );
        });
    }
}

module.exports = new DB();
