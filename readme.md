PeckaDesk
=========

Příprava pro vývoj:

```shell script 
$ cp docker-compose.override.example.yml docker-compose.override.yml
$ make build
$ docker-compose up
$ docker-compose -f docker-compose.yml -f docker-compose.override.yml -f docker-compose.xdebug.yml up
```

Sestavení na vývojovém prostředí:

```shell script
$ make build
$ docker build -t peckadesign/peckadesk:latest .
$ docker push peckadesign/peckadesk:latest
```

Spuštění na produkčním prostředí:

```shell script
$ docker pull peckadesign/peckadesk:latest
$ docker run -p X:80 -v "$(pwd)"/local.neon:/var/www/html/app/config/local.neon peckadesign/peckadesk:latest
```
