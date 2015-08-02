# PKI Authenticator Client

Currently no documentation is provided, since project is in development and not ready to use by general public.   
This is a just proof-of-concept for interacting with [PkiAuthenticator server](https://github.com/kiler129/PkiAuthenticator) - not an ready to use library!

## NEVER EVER USE SAMPLE KEYS IN PRODUCTION ENVIRONMENT!
To get your own just use openssl:
```
openssl genrsa -out private_key.pem 4096
openssl rsa -pubout -in private_key.pem -out public_key.pem
```
Keep in mind client should store it's **private** key and server **public** keys (never private ones!). However it's not a security risk to store server public key within keys folder.
