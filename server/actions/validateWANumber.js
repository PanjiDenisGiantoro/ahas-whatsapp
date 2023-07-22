"use strict";

const Contact = require('../entities/Contact')
const wa = require('../lib/whatsapp')

const _delay = (time) => {
    return new Promise((resolve) => {
        setTimeout(() => {resolve()}, time)
    })
}

module.exports = async (socket, tag_id) => {
    let contactEntity = new Contact;
    let contacts = await contactEntity.getByTag(tag_id)
    let contactCount = contacts.length

    try {
        for(let i = 0; i < contactCount; i++){
            socket.emit('validateNumberProgress', {
                total: contactCount,
                progress: parseInt(i) + 1
            })
            
            let isValidNumber = await wa.isExists(contacts[i].number)
            await contactEntity.updateValidStatus(contacts[i].id, isValidNumber)
        }
    } catch (error) {
        socket.emit('validateNumberError')
    }

    socket.emit('validateNumberDone')
}