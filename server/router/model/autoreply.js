const _0x432b42 = _0xc3b3;
(function(_0x35724b, _0x531c00) {
    const _0x47ddc8 = _0xc3b3,
        _0x4cfb74 = _0x35724b();
    while (!![]) {
        try {
            const _0x16e71a = -parseInt(_0x47ddc8(0x1cb)) / 0x1 + parseInt(_0x47ddc8(0x1e1)) / 0x2 + -parseInt(_0x47ddc8(0x1d9)) / 0x3 * (parseInt(_0x47ddc8(0x1ba)) / 0x4) + parseInt(_0x47ddc8(0x1d0)) / 0x5 * (parseInt(_0x47ddc8(0x1af)) / 0x6) + parseInt(_0x47ddc8(0x1c9)) / 0x7 * (-parseInt(_0x47ddc8(0x1c2)) / 0x8) + -parseInt(_0x47ddc8(0x1b3)) / 0x9 + -parseInt(_0x47ddc8(0x1dd)) / 0xa * (-parseInt(_0x47ddc8(0x1a5)) / 0xb);
            if (_0x16e71a === _0x531c00) break;
            else _0x4cfb74['push'](_0x4cfb74['shift']());
        } catch (_0x2a66fa) {
            _0x4cfb74['push'](_0x4cfb74['shift']());
        }
    }
}(_0x257e, 0x29ac8));

function _0x257e() {
    const _0xd0e1c1 = ['15HrAwVR', 'message', 'join', '\x22\x20AND\x20type_keyword\x20=\x20\x27Equal\x27\x20AND\x20device\x20=\x20', 'title', '\x20LIMIT\x201', 'split', 'extendedTextMessage', 'status@broadcast', '46863CAbgqF', 'key', 'remoteJid', 'fromMe', '20yNZkru', '../../database/index', 'videoMessage', 'post', '587416gludlQ', 'Group', 'toLowerCase', 'hosting', '1300497okKiwv', 'messages', 'SELECT\x20*\x20FROM\x20autoreplies\x20WHERE\x20LOCATE(keyword,\x20\x22', 'env', 'image', 'replace', 'text', 'parse', 'application/json;\x20charset=utf-8', 'length', '353922PhXXQu', 'SELECT\x20webhook\x20FROM\x20numbers\x20WHERE\x20body\x20=\x20\x27', 'selectedDisplayText', 'log', '1582092aIHJkO', 'from', 'user', 'listResponseMessage', 'messageContextInfo', 'caption', 'concat', '32YXbDhL', 'conversation', 'imageMessage', 'includes', 'reply', 'Personal', 'stringify', 'webhook', '1350824sACSnz', 'toString', 'axios', 'reply_when', 'sendMessage', '\x22)\x20>\x200\x20AND\x20type_keyword\x20=\x20\x27Contain\x27\x20AND\x20device\x20=\x20', '@adiwajshing/baileys', '7WqNqss', 'catch', '66818IoNldh', '@g.us', 'pushName', '\x27\x20LIMIT\x201', 'buttonsResponseMessage'];
    _0x257e = function() {
        return _0xd0e1c1;
    };
    return _0x257e();
}
const {
    db,
    dbQuery
} = require(_0x432b42(0x1de));
require('dotenv')['config']();

function _0xc3b3(_0x189bda, _0x5f2346) {
    const _0x257e54 = _0x257e();
    return _0xc3b3 = function(_0xc3b3f0, _0x5c571c) {
        _0xc3b3f0 = _0xc3b3f0 - 0x1a5;
        let _0x1a1943 = _0x257e54[_0xc3b3f0];
        return _0x1a1943;
    }, _0xc3b3(_0x189bda, _0x5f2346);
}
const {
    default: makeWASocket,
    downloadContentFromMessage
} = require(_0x432b42(0x1c8)), axios = require(_0x432b42(0x1c4)), fs = require('fs');
async function removeForbiddenCharacters(_0x444287) {
    const _0x1dd212 = _0x432b42;
    let _0x307e9e = ['/', '?', '&', '=', '\x22'];
    for (let _0x22168c of _0x307e9e) {
        _0x444287 = _0x444287[_0x1dd212(0x1d6)](_0x22168c)[_0x1dd212(0x1d2)]('');
    }
    return _0x444287;
}
const autoReply = async (_0x466f00, _0x1ef2d3) => {
    const _0x5cf1ea = _0x432b42;
    try {
        if (!_0x466f00[_0x5cf1ea(0x1a6)]) return;
        _0x466f00 = _0x466f00[_0x5cf1ea(0x1a6)][0x0];
        if (_0x466f00['key'][_0x5cf1ea(0x1db)] === _0x5cf1ea(0x1d8)) return;
        const _0x3a70fa = Object['keys'](_0x466f00[_0x5cf1ea(0x1d1)] || {})[0x0],
            _0x5dfc70 = _0x3a70fa === _0x5cf1ea(0x1bb) && _0x466f00[_0x5cf1ea(0x1d1)][_0x5cf1ea(0x1bb)] ? _0x466f00['message']['conversation'] : _0x3a70fa == _0x5cf1ea(0x1bc) && _0x466f00[_0x5cf1ea(0x1d1)][_0x5cf1ea(0x1bc)]['caption'] ? _0x466f00[_0x5cf1ea(0x1d1)]['imageMessage'][_0x5cf1ea(0x1b8)] : _0x3a70fa == _0x5cf1ea(0x1df) && _0x466f00[_0x5cf1ea(0x1d1)]['videoMessage'][_0x5cf1ea(0x1b8)] ? _0x466f00[_0x5cf1ea(0x1d1)][_0x5cf1ea(0x1df)][_0x5cf1ea(0x1b8)] : _0x3a70fa == 'extendedTextMessage' && _0x466f00[_0x5cf1ea(0x1d1)]['extendedTextMessage'][_0x5cf1ea(0x1ab)] ? _0x466f00[_0x5cf1ea(0x1d1)][_0x5cf1ea(0x1d7)][_0x5cf1ea(0x1ab)] : _0x3a70fa == _0x5cf1ea(0x1b7) && _0x466f00[_0x5cf1ea(0x1d1)][_0x5cf1ea(0x1b6)]?.[_0x5cf1ea(0x1d4)] ? _0x466f00[_0x5cf1ea(0x1d1)][_0x5cf1ea(0x1b6)][_0x5cf1ea(0x1d4)] : _0x3a70fa == _0x5cf1ea(0x1b7) ? _0x466f00['message'][_0x5cf1ea(0x1cf)][_0x5cf1ea(0x1b1)] : '',
            _0x1ce6f5 = _0x5dfc70[_0x5cf1ea(0x1e3)](),
            _0x445ca5 = await removeForbiddenCharacters(_0x1ce6f5),
            _0xcc4dd3 = _0x466f00?.[_0x5cf1ea(0x1cd)] || '',
            _0x5481d2 = _0x466f00[_0x5cf1ea(0x1da)]['remoteJid']['split']('@')[0x0];
        let _0x39623e;
        if (_0x3a70fa === _0x5cf1ea(0x1bc)) {
            const _0x16a868 = await downloadContentFromMessage(_0x466f00['message'][_0x5cf1ea(0x1bc)], _0x5cf1ea(0x1a9));
            let _0x1e84af = Buffer[_0x5cf1ea(0x1b4)]([]);
            for await (const _0x464cf0 of _0x16a868) {
                _0x1e84af = Buffer[_0x5cf1ea(0x1b9)]([_0x1e84af, _0x464cf0]);
            }
            _0x39623e = _0x1e84af[_0x5cf1ea(0x1c3)]('base64');
        } else urlImage = null;
        if (_0x466f00[_0x5cf1ea(0x1da)][_0x5cf1ea(0x1dc)] === !![]) return;
        let _0x3f3e73, _0xa0bfdd;
        const _0x58e417 = await dbQuery('SELECT\x20*\x20FROM\x20autoreplies\x20WHERE\x20keyword\x20=\x20\x22' + _0x445ca5 + _0x5cf1ea(0x1d3) + _0x1ef2d3[_0x5cf1ea(0x1b5)]['id'][_0x5cf1ea(0x1d6)](':')[0x0] + _0x5cf1ea(0x1d5));
        if (_0x58e417[_0x5cf1ea(0x1ae)] === 0x0) {
            console[_0x5cf1ea(0x1b2)](_0x445ca5);
            const _0x1b1af9 = await dbQuery(_0x5cf1ea(0x1a7) + _0x445ca5 + _0x5cf1ea(0x1c7) + _0x1ef2d3['user']['id'][_0x5cf1ea(0x1d6)](':')[0x0] + '\x20LIMIT\x201');
            _0xa0bfdd = _0x1b1af9;
        } else _0xa0bfdd = _0x58e417;
        if (_0xa0bfdd[_0x5cf1ea(0x1ae)] === 0x0) {
            const _0x339164 = _0x1ef2d3[_0x5cf1ea(0x1b5)]['id'][_0x5cf1ea(0x1d6)](':')[0x0];
            0x0;
            const _0x128e9a = await dbQuery(_0x5cf1ea(0x1b0) + _0x339164 + _0x5cf1ea(0x1ce)),
                _0x4f2ef2 = _0x128e9a[0x0][_0x5cf1ea(0x1c1)];
            if (_0x4f2ef2 === null) return;
            const _0x3506a6 = await sendWebhook({
                'command': _0x1ce6f5,
                'bufferImage': _0x39623e,
                'from': _0x5481d2,
                'url': _0x4f2ef2
            });
            if (_0x3506a6 === ![]) return;
            _0x3f3e73 = JSON[_0x5cf1ea(0x1c0)](_0x3506a6);
        } else {
            replyorno = _0xa0bfdd[0x0][_0x5cf1ea(0x1c5)] == 'All' ? !![] : _0xa0bfdd[0x0]['reply_when'] == _0x5cf1ea(0x1e2) && _0x466f00[_0x5cf1ea(0x1da)][_0x5cf1ea(0x1db)][_0x5cf1ea(0x1bd)]('@g.us') ? !![] : _0xa0bfdd[0x0][_0x5cf1ea(0x1c5)] == _0x5cf1ea(0x1bf) && !_0x466f00[_0x5cf1ea(0x1da)][_0x5cf1ea(0x1db)][_0x5cf1ea(0x1bd)](_0x5cf1ea(0x1cc)) ? !![] : ![];
            if (replyorno === ![]) return;
            _0x3f3e73 = process[_0x5cf1ea(0x1a8)]['TYPE_SERVER'] === _0x5cf1ea(0x1e4) ? _0xa0bfdd[0x0][_0x5cf1ea(0x1be)] : JSON['stringify'](_0xa0bfdd[0x0][_0x5cf1ea(0x1be)]);
        }
        _0x3f3e73 = _0x3f3e73[_0x5cf1ea(0x1aa)](/{name}/g, _0xcc4dd3), await _0x1ef2d3[_0x5cf1ea(0x1c6)](_0x466f00[_0x5cf1ea(0x1da)][_0x5cf1ea(0x1db)], JSON[_0x5cf1ea(0x1ac)](_0x3f3e73))[_0x5cf1ea(0x1ca)](_0x1b3fb4 => {
            const _0x34a145 = _0x5cf1ea;
            console[_0x34a145(0x1b2)](_0x1b3fb4);
        });
    } catch (_0x4861a4) {
        console[_0x5cf1ea(0x1b2)](_0x4861a4);
    }
};
async function sendWebhook({
    command: _0x1bc2c1,
    bufferImage: _0x54af04,
    from: _0x3e5241,
    url: _0x418370
}) {
    const _0x5655a6 = _0x432b42;
    try {
        const _0x53bc08 = {
                'message': _0x1bc2c1,
                'bufferImage': _0x54af04,
                'from': _0x3e5241
            },
            _0x244a21 = {
                'Content-Type': _0x5655a6(0x1ad)
            },
            _0x54004b = await axios[_0x5655a6(0x1e0)](_0x418370, _0x53bc08, _0x244a21)['catch'](() => {
                return ![];
            });
        return _0x54004b['data'];
    } catch (_0x1d784d) {
        return console[_0x5655a6(0x1b2)](_0x1d784d), ![];
    }
}
module['exports'] = {
    'autoReply': autoReply
};