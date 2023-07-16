"use strict";

const {
    Boom
} = require('@hapi/boom'), {
    default: makeWASocket
    , makeWALegacySocket
    , downloadContentFromMessage
} = require('@whiskeysockets/baileys'), {
    fetchLatestBaileysVersion
    , useMultiFileAuthState
    , makeCacheableSignalKeyStore
} = require('@whiskeysockets/baileys'), {
    DisconnectReason
} = require('@whiskeysockets/baileys'), QRCode = require('qrcode'), fs = require('fs');

let conn = null

function connectToWhatsApp()
{
    if(conn != null)
        return conn

    return new Promise(async (resolve) => {
        const { state, saveCreds } = await useMultiFileAuthState('auth_info_baileys')
        conn = makeWASocket({ 
            printQRInTerminal: true,
            auth: state 
        })
        conn.ev.on ('creds.update', saveCreds)
    
        conn.ev.on('connection.update', async (update) => {
            const { connection, lastDisconnect } = update
            if(connection === 'close') {
                const shouldReconnect = (lastDisconnect.error)?.output?.statusCode !== DisconnectReason.loggedOut
                console.log('connection closed due to ', lastDisconnect.error, ', reconnecting ', shouldReconnect)
                // reconnect if not logged out
                if(shouldReconnect) {
                    await connectToWhatsApp()
                    resolve(conn)
                }
            } else if(connection === 'open') {
                console.log('opened connection')
                resolve(conn)
            }
        })
    })
}

async function isExists(number)
{
    // Validasi nomor bermasalah disini variable conn manggil auth lagi, saya check di connectToWhatsApp().conn variable let conn masih null jadi manggil authnya lagi
    const conn = await connectToWhatsApp()
    const id = number + '@s.whatsapp.net'
    const [result] = await conn.onWhatsApp(id)
    console.log({result})
    if (result?.jid != null)
        return true
    else
        return false
    // return true
}

module.exports = {
    connectToWhatsApp, isExists
}