print("hello world")
# This example uses Python 2.7 and the python-request library.

from requests import Request, Session
from requests.exceptions import ConnectionError, Timeout, TooManyRedirects
import json

url = 'https://sandbox-api.coinmarketcap.com/v1/cryptocurrency/listings/latest'
parameters = {
    'start': '1',
    'limit': '5000',
    'convert': 'USD'
}
headers = {
    'Accepts': 'application/json',
    'X-CMC_PRO_API_KEY': 'b54bcf4d-1bca-4e8e-9a24-22ff2c3d462c',
}

session = Session()
session.headers.update(headers)

try:
    response = session.get(url, params=parameters)
    data = json.loads(response.text)
    print(data)
except (ConnectionError, Timeout, TooManyRedirects) as e:
    print(e)

    {
        "data": {
            "1": {
                "urls": {
                    "website": [
                        "https://bitcoin.org/"
                    ],
                    "technical_doc": [
                        "https://bitcoin.org/bitcoin.pdf"
                    ],
                    "twitter": [],
                    "reddit": [
                        "https://reddit.com/r/bitcoin"
                    ],
                    "message_board": [
                        "https://bitcointalk.org"
                    ],
                    "announcement": [],
                    "chat": [],
                    "explorer": [
                        "https://blockchain.coinmarketcap.com/chain/bitcoin",
                        "https://blockchain.info/",
                        "https://live.blockcypher.com/btc/"
                    ],
                    "source_code": [
                        "https://github.com/bitcoin/"
                    ]
                },
                "logo": "https://s2.coinmarketcap.com/static/img/coins/64x64/1.png",
                "id": 1,
                "name": "Bitcoin",
                "symbol": "BTC",
                "slug": "bitcoin",
                "description": "Bitcoin (BTC) is a consensus network that enables a new payment system and a completely digital currency. Powered by its users, it is a peer to peer payment network that requires no central authority to operate. On October 31st, 2008, an individual or group of individuals operating under the pseudonym",
