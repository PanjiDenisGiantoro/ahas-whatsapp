'use strict';

function _0x5a42(_0x30d8e1, _0x59ef51) {
    const _0x26fb91 = _0x26fb();
    return _0x5a42 = function (_0x5a4253, _0xfc8676) {
        _0x5a4253 = _0x5a4253 - 0x9b;
        let _0x4c962b = _0x26fb91[_0x5a4253];
        return _0x4c962b;
    }, _0x5a42(_0x30d8e1, _0x59ef51);
}
const _0x55ef3e = _0x5a42;
(function (_0x52085d, _0xea7972) {
    const _0x480728 = _0x5a42
        , _0x20ad1f = _0x52085d();
    while (!![]) {
        try {
            const _0x192e10 = -parseInt(_0x480728(0xb5)) / 0x1 * (parseInt(_0x480728(0xae)) / 0x2) + parseInt(_0x480728(0xaa)) / 0x3 + parseInt(_0x480728(0xb4)) / 0x4 + parseInt(_0x480728(0xa8)) / 0x5 + parseInt(_0x480728(0xab)) / 0x6 + parseInt(_0x480728(0x9b)) / 0x7 * (-parseInt(_0x480728(0xac)) / 0x8) + parseInt(_0x480728(0xb9)) / 0x9;
            if (_0x192e10 === _0xea7972) break;
            else _0x20ad1f['push'](_0x20ad1f['shift']());
        } catch (_0x387f7c) {
            _0x20ad1f['push'](_0x20ad1f['shift']());
        }
    }
}(_0x26fb, 0x40117));

function _0x26fb() {
    const _0x31b634 = ['/backend-send-template', '2966256ABmSLU', '38829irSkuS', 'join', 'Router', '/backend-generate-qr', './model/routes', '/backend-send-text', 'sendMedia', 'createInstance', 'sendText', 'get', 'deleteCredentials', '/backend-send-list', 'express', '1453780nXDaGB', 'sendFile', '23058bmEOcd', '49776RkmLzr', '432FvdKjT', 'exports', '2fsSbOY', 'AUTH', '/backend-getgroups', '/backend-send-button', '../../public/index.html', '/backend-initialize', '1512284ROJpXE', '452432TlddPj', 'post', './model/store'];
    _0x26fb = function () {
        return _0x31b634;
    };
    return _0x26fb();
}
const express = require(_0x55ef3e(0xa7))
    , router = express[_0x55ef3e(0x9d)]()
    , wa = require(_0x55ef3e(0x9f))
    , store = require(_0x55ef3e(0xb7))
    , {
        initialize
    } = require('./model/whatsapp')
    , CryptoJS = require('crypto-js')
    , validation = process['env'][_0x55ef3e(0xaf)];
router[_0x55ef3e(0xa4)]('/', (_0x441f21, _0xfbfa99) => {
    const _0x304258 = _0x55ef3e
        , _0x3f77cc = require('path');
    _0xfbfa99[_0x304258(0xa9)](_0x3f77cc[_0x304258(0x9c)](__dirname, _0x304258(0xb2)));
}), router[_0x55ef3e(0xb6)]('/backend-logout', wa[_0x55ef3e(0xa5)]), router[_0x55ef3e(0xb6)](_0x55ef3e(0x9e), wa[_0x55ef3e(0xa2)]), router[_0x55ef3e(0xb6)](_0x55ef3e(0xb3), initialize), router[_0x55ef3e(0xb6)](_0x55ef3e(0xa6), wa['sendListMessage']), router[_0x55ef3e(0xb6)](_0x55ef3e(0xb8), wa['sendTemplateMessage']), router[_0x55ef3e(0xb6)](_0x55ef3e(0xb1), wa['sendButtonMessage']), router[_0x55ef3e(0xb6)]('/backend-send-media', wa[_0x55ef3e(0xa1)]), router[_0x55ef3e(0xb6)](_0x55ef3e(0xa0), wa[_0x55ef3e(0xa3)]), router[_0x55ef3e(0xb6)](_0x55ef3e(0xb0), wa['fetchGroups']), router[_0x55ef3e(0xb6)]('/backend-blast', wa['blast']), router[_0x55ef3e(0xb6)]('/backend-check-valid-number', wa['checkNumberWaValid']), module[_0x55ef3e(0xad)] = router;
