const knex = require('../lib/knex')

class Contact
{
    async getByTag(tag)
    {
        return await knex('contacts')
            .where('tag_id', tag)
            .then(result => result)
            .catch(err => [])
    }

    async updateValidStatus(id, status)
    {
		await knex('contacts')
			.where('id', id)
			.update({
                status_valid: status == true ? 'true' : 'false'
			})
			.then(result => result)
			.catch(err => [])
    }
}

module.exports = Contact