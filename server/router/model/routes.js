'use strict';
const _0x2fb305 = _0x4caa;
(function (_0x585604, _0xe562f6) {
    const _0x14c2fa = _0x4caa
        , _0x6be8c2 = _0x585604();
    while (!![]) {
        try {
            const _0x566843 = -parseInt(_0x14c2fa(0x189)) / 0x1 * (-parseInt(_0x14c2fa(0x19a)) / 0x2) + parseInt(_0x14c2fa(0x1a5)) / 0x3 * (-parseInt(_0x14c2fa(0x183)) / 0x4) + -parseInt(_0x14c2fa(0x185)) / 0x5 * (parseInt(_0x14c2fa(0x188)) / 0x6) + parseInt(_0x14c2fa(0x182)) / 0x7 + -parseInt(_0x14c2fa(0x1a0)) / 0x8 + -parseInt(_0x14c2fa(0x194)) / 0x9 * (-parseInt(_0x14c2fa(0x1a6)) / 0xa) + -parseInt(_0x14c2fa(0x18b)) / 0xb * (-parseInt(_0x14c2fa(0x199)) / 0xc);
            if (_0x566843 === _0xe562f6) break;
            else _0x6be8c2['push'](_0x6be8c2['shift']());
        } catch (_0x21a8e5) {
            _0x6be8c2['push'](_0x6be8c2['shift']());
        }
    }
}(_0x2a3d, 0x527da));

function _0x4caa(_0x31f723, _0xad68b7) {
    const _0x2a3d75 = _0x2a3d();
    return _0x4caa = function (_0x4caaa4, _0x2b9b2b) {
        _0x4caaa4 = _0x4caaa4 - 0x182;
        let _0x4bd09b = _0x2a3d75[_0x4caaa4];
        return _0x4bd09b;
    }, _0x4caa(_0x31f723, _0xad68b7);
}
const wa = require('./whatsapp')
    , lib = require(_0x2fb305(0x192))
    , {
        dbQuery
    } = require(_0x2fb305(0x190))
    , {
        asyncForEach
        , formatReceipt
    } = require('../helper')
    , createInstance = async (_0x24b002, _0x5e9e1f) => {
        const _0x561e5a = _0x2fb305
            , {
                token: _0x634ba
            } = _0x24b002['body'];
        if (_0x634ba) try {
            const _0x4917c4 = await wa[_0x561e5a(0x191)](_0x634ba, _0x24b002['io'])
                , _0x39efd4 = _0x4917c4?.[_0x561e5a(0x18a)]
                , _0x24eea0 = _0x4917c4?.['message'];
            return _0x5e9e1f[_0x561e5a(0x184)]({
                'status': _0x39efd4 ?? _0x561e5a(0x1a3)
                , 'qrcode': _0x4917c4?.[_0x561e5a(0x19c)]
                , 'message': _0x24eea0 ? _0x24eea0 : _0x561e5a(0x18d)
            });
        } catch (_0x17e39f) {
            return console[_0x561e5a(0x187)](_0x17e39f), _0x5e9e1f[_0x561e5a(0x184)]({
                'status': ![]
                , 'error': _0x17e39f
            });
        }
        _0x5e9e1f[_0x561e5a(0x18a)](0x193)[_0x561e5a(0x18e)](_0x561e5a(0x195));
    }, sendText = async (_0x38eb66, _0x1de92b) => {
        const _0x4342a6 = _0x2fb305
            , {
                token: _0x103fa1
                , number: _0x432448
                , text: _0x2634b9
            } = _0x38eb66[_0x4342a6(0x19f)];
        if (_0x103fa1 && _0x432448 && _0x2634b9) {
            let _0x434205 = await wa[_0x4342a6(0x18c)](_0x103fa1, formatReceipt(_0x432448));
            if (!_0x434205) return _0x1de92b[_0x4342a6(0x184)]({
                'status': ![]
                , 'message': _0x4342a6(0x1a1)
            });
            const _0x868fd6 = await wa['sendText'](_0x103fa1, _0x432448, _0x2634b9);
            if (_0x868fd6) return _0x1de92b[_0x4342a6(0x184)]({
                'status': !![]
                , 'data': _0x868fd6
            });
            return _0x1de92b['send']({
                'status': ![]
                , 'message': 'Check your whatsapp connection'
            });
        }
        _0x1de92b['send']({
            'status': ![]
            , 'message': _0x4342a6(0x197)
        });
    }, checkNumberWaValid = async (_0x40db1b, _0x11d8a0) => {
        const _0x53f515 = _0x2fb305
            , {
                token: _0x50c6dc
                , number: _0x1669d5
            } = _0x40db1b[_0x53f515(0x19f)];
        if (_0x50c6dc && _0x1669d5) {
        	try{
        		let _0x417d2d = await wa['isExist'](_0x50c6dc, formatReceipt(_0x1669d5));
	            if (!_0x417d2d){
	            	return _0x11d8a0[_0x53f515(0x184)]({
		                'status': ![]
		                , 'message': 'not_valid'
	            	});
	            }else{
	            	return _0x11d8a0[_0x53f515(0x184)]({
		                'status': ![]
		                , 'message': 'valid'
	            	});
	            }
        	}catch (_0x366aff) {
		        return ![];
		    }
        }
        _0x11d8a0[_0x53f515(0x184)]({
            'status': ![]
            , 'message': 'Check your parameter'
        });
    }, sendMedia = async (_0x40db1b, _0x11d8a0) => {
        const _0x53f515 = _0x2fb305
            , {
                token: _0x50c6dc
                , number: _0x1669d5
                , type: _0x2d002f
                , url: _0x131925
                , fileName: _0x5036f3
                , caption: _0x48dc96
            } = _0x40db1b[_0x53f515(0x19f)];
        if (_0x50c6dc && _0x1669d5 && _0x2d002f && _0x131925 && _0x48dc96) {
            let _0x417d2d = await wa['isExist'](_0x50c6dc, formatReceipt(_0x1669d5));
            if (!_0x417d2d) return _0x11d8a0[_0x53f515(0x184)]({
                'status': ![]
                , 'message': _0x53f515(0x1a1)
            });
            const _0x223649 = await wa[_0x53f515(0x19d)](_0x50c6dc, _0x1669d5, _0x2d002f, _0x131925, _0x5036f3, _0x48dc96);
            if (_0x223649) return _0x11d8a0['send']({
                'status': !![]
                , 'data': _0x223649
            });
            return _0x11d8a0[_0x53f515(0x184)]({
                'status': ![]
                , 'message': _0x53f515(0x1a8)
            });
        }
        _0x11d8a0[_0x53f515(0x184)]({
            'status': ![]
            , 'message': 'Check your parameter'
        });
    }, sendButtonMessage = async (_0x4f3487, _0x476367) => {
        const _0x2e3977 = _0x2fb305
            , {
                token: _0x5d09dc
                , number: _0x4b5b4a
                , button: _0x4b80e9
                , message: _0x3dd7b9
                , footer: _0x767df7
                , image: _0x9dd848
            } = _0x4f3487[_0x2e3977(0x19f)]
            , _0x402e12 = JSON[_0x2e3977(0x1a2)](_0x4b80e9);
        if (_0x5d09dc && _0x4b5b4a && _0x4b80e9 && _0x3dd7b9 && _0x767df7) {
            let _0x50f855 = await wa[_0x2e3977(0x18c)](_0x5d09dc, formatReceipt(_0x4b5b4a));
            if (!_0x50f855) return _0x476367[_0x2e3977(0x184)]({
                'status': ![]
                , 'message': 'The destination Number not registered in whatsapp or your sender not connected'
            });
            const _0x432600 = await wa[_0x2e3977(0x186)](_0x5d09dc, _0x4b5b4a, _0x402e12, _0x3dd7b9, _0x767df7, _0x9dd848);
            if (_0x432600) return _0x476367['send']({
                'status': !![]
                , 'data': _0x432600
            });
            return _0x476367[_0x2e3977(0x184)]({
                'status': ![]
                , 'message': 'Check your connection'
            });
        }
        _0x476367[_0x2e3977(0x184)]({
            'status': ![]
            , 'message': _0x2e3977(0x1a4)
        });
    }, sendTemplateMessage = async (_0x4befcb, _0x53bea8) => {
        const _0x582ac2 = _0x2fb305
            , {
                token: _0x25ff2e
                , number: _0x55d8e1
                , button: _0x2e6e20
                , text: _0x8446c7
                , footer: _0x1e3643
                , image: _0x397c9f
            } = _0x4befcb[_0x582ac2(0x19f)];
        if (_0x25ff2e && _0x55d8e1 && _0x2e6e20 && _0x8446c7 && _0x1e3643) {
            let _0x58f6b3 = await wa['isExist'](_0x25ff2e, formatReceipt(_0x55d8e1));
            if (!_0x58f6b3) return _0x53bea8[_0x582ac2(0x184)]({
                'status': ![]
                , 'message': _0x582ac2(0x1a1)
            });
            const _0x467884 = await wa['sendTemplateMessage'](_0x25ff2e, _0x55d8e1, JSON[_0x582ac2(0x1a2)](_0x2e6e20), _0x8446c7, _0x1e3643, _0x397c9f);
            if (_0x467884) return _0x53bea8[_0x582ac2(0x184)]({
                'status': !![]
                , 'data': _0x467884
            });
            return _0x53bea8[_0x582ac2(0x184)]({
                'status': ![]
                , 'message': _0x582ac2(0x1a8)
            });
        }
        _0x53bea8[_0x582ac2(0x184)]({
            'status': ![]
            , 'message': _0x582ac2(0x197)
        });
    }, sendListMessage = async (_0x520e49, _0x11d1cc) => {
        const _0x3de5ee = _0x2fb305
            , {
                token: _0x446017
                , number: _0x1c22c1
                , list: _0x376394
                , text: _0x350db0
                , footer: _0x1e08dd
                , title: _0x95eaa7
                , buttonText: _0xf805ca
            } = _0x520e49[_0x3de5ee(0x19f)];
        if (_0x446017 && _0x1c22c1 && _0x376394 && _0x350db0 && _0x1e08dd && _0x95eaa7 && _0xf805ca) {
            let _0x31c7cb = await wa[_0x3de5ee(0x18c)](_0x446017, formatReceipt(_0x1c22c1));
            if (!_0x31c7cb) return _0x11d1cc[_0x3de5ee(0x184)]({
                'status': ![]
                , 'message': _0x3de5ee(0x1a1)
            });
            const _0x2ff04f = await wa[_0x3de5ee(0x193)](_0x446017, _0x1c22c1, JSON[_0x3de5ee(0x1a2)](_0x376394), _0x350db0, _0x1e08dd, _0x95eaa7, _0xf805ca);
            if (_0x2ff04f) return _0x11d1cc['send']({
                'status': !![]
                , 'data': _0x2ff04f
            });
            return _0x11d1cc[_0x3de5ee(0x184)]({
                'status': ![]
                , 'message': _0x3de5ee(0x1a8)
            });
        }
        _0x11d1cc['send']({
            'status': ![]
            , 'message': _0x3de5ee(0x1a4)
        });
    }, fetchGroups = async (_0x520efe, _0x1dce3d) => {
        const _0x2994b2 = _0x2fb305
            , {
                token: _0x1bd8cd
            } = _0x520efe[_0x2994b2(0x19f)];
        if (_0x1bd8cd) {
            const _0x3c81e5 = await wa['fetchGroups'](_0x1bd8cd);
            if (_0x3c81e5) return _0x1dce3d[_0x2994b2(0x184)]({
                'status': !![]
                , 'data': _0x3c81e5
            });
            return _0x1dce3d['send']({
                'status': ![]
                , 'message': _0x2994b2(0x1a8)
            });
        }
        _0x1dce3d[_0x2994b2(0x184)]({
            'status': ![]
            , 'message': _0x2994b2(0x197)
        });
    }, blast = async (_0x21c203, _0x1d5318) => {
        const _0x861d5d = _0x2fb305
            , _0x1dbd04 = _0x21c203[_0x861d5d(0x19f)][_0x861d5d(0x19e)]
            , _0x327158 = JSON[_0x861d5d(0x1a2)](_0x1dbd04)
            , _0x593d8d = 0x1
            , _0x1fdbc4 = await wa[_0x861d5d(0x18c)](_0x327158[0x0][_0x861d5d(0x1a7)], formatReceipt(_0x327158[0x0][_0x861d5d(0x1a7)]));
        if (!_0x1fdbc4) return _0x1d5318[_0x861d5d(0x184)]({
            'status': ![]
            , 'message': 'Check your whatsapp connection'
        });
        let _0x14e474 = []
            , _0x1b7833 = [];
        
        function _0x447479(_0x309db2) {
            return new Promise(_0x4ef2c6 => {
                setTimeout(() => {
                    _0x4ef2c6('');
                }, _0x309db2);
            });
        }
        return await asyncForEach(_0x327158, async (_0x151801, _0x43e690) => {
            const _0x539381 = _0x861d5d
                , {
                    sender: _0x2869df
                    , receiver: _0x2f5e0c
                    , message: _0x456802
                    , campaign_id: _0x20844d
                } = _0x151801;
            if (_0x2869df && _0x2f5e0c && _0x456802) {
                const _0xca4d8a = await wa[_0x539381(0x19b)](_0x2869df, _0x2f5e0c, _0x456802);
                _0xca4d8a ? _0x14e474[_0x539381(0x196)](_0x2f5e0c) : _0x1b7833[_0x539381(0x196)](_0x2f5e0c);
            }
            await _0x447479(0x1 * 0x3e8);
        }), _0x1d5318['send']({
            'status': !![]
            , 'success': _0x14e474
            , 'failed': _0x1b7833
        });
    }, deleteCredentials = async (_0x1b4e4f, _0x23123b) => {
        const _0x7885d3 = _0x2fb305
            , {
                token: _0x681ca7
            } = _0x1b4e4f[_0x7885d3(0x19f)];
        if (_0x681ca7) {
            const _0x171451 = await wa[_0x7885d3(0x198)](_0x681ca7);
            if (_0x171451) return _0x23123b['send']({
                'status': !![]
                , 'data': _0x171451
            });
            return _0x23123b[_0x7885d3(0x184)]({
                'status': ![]
                , 'message': _0x7885d3(0x1a8)
            });
        }
        _0x23123b[_0x2a3d(0x184)]({
            'status': ![]
            , 'message': _0x7885d3(0x197)
        });
    };

function _0x2a3d() {
    const _0x29505c = ['200453CPuXxt', 'isExist', 'Processing', 'end', 'exports', '../../database', 'connectToWhatsApp', '../../lib', 'sendListMessage', '9cnOkPb', 'Token needed', 'push', 'Check your parameter', 'deleteCredentials', '120KkEyhe', '1774vwVSyp', 'sendMessage', 'qrcode', 'sendMedia', 'data', 'body', '4364824rzKOsl', 'not_register_number', 'parse', 'processing', 'Check your parameterr', '380193tvQSAV', '3933390eFRRPp', 'sender', 'Check your connection', '3375358yFQerz', '4oXxztW', 'send', '5DppjTb', 'sendButtonMessage', 'log', '2749368OJifxm', '463CoaYzF', 'status'];
    _0x2a3d = function () {
        return _0x29505c;
    };
    return _0x2a3d();
}
module[_0x2fb305(0x18f)] = {
    'createInstance': createInstance
    , 'sendText': sendText
    , 'sendMedia': sendMedia
    , 'sendButtonMessage': sendButtonMessage
    , 'sendTemplateMessage': sendTemplateMessage
    , 'sendListMessage': sendListMessage
    , 'deleteCredentials': deleteCredentials
    , 'fetchGroups': fetchGroups
    , 'blast': blast
    , 'checkNumberWaValid' : checkNumberWaValid
};
