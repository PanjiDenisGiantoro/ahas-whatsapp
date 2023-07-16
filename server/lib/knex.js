require('dotenv').config()

const knex = require('knex')({
    client: 'mysql2',
    connection: {
      host     : process.env.DB_HOST,
      user     : process.env.DB_USERNAME,
      password : process.env.DB_PASSWORD,
      database : process.env.DB_DATABASE,
      port     : process.env.DB_PORT,
      multipleStatements: true 
    },
    pool: { min: 0, max: 5000 },
    acquireConnectionTimeout: 10000,
    log: {
      warn(message) {
          console.log('warn :  '+message);
      },
      error(message) {
          console.log('error :  '+message);
      },
      deprecate(message) {
          console.log('deprecated :  '+message);
      },
      debug(message) {
          console.log('debug :  '+message);
      },
    } 
  });
  
  module.exports = knex