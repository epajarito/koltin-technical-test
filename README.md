# Koltin - Prueba tecnica


## Instalación

Usar composer para instalar dependencias de Laravel

```bash
composer install
```

## Crear archivo .env
```bash
cp .env.example .env
```
## Ejecutar el siguiente comando para generar el app key de la aplicación
```bash
php artisan key:generate
```

## Ejecutar el siguiente comando para generar secret key el paquete de JWT
```bash
php artisan jwt:secret
```
## Generar directorios de almacenamiento
```bash
cd storage/app/public
mkdir attachments images
```

## Generar enlace simbolico
```bash
php artisan storage:link
```
## Configurar base de datos (en este caso usa Mysql)
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tu-base-de-datos
DB_USERNAME=tu-usuario
DB_PASSWORD=tu-contraseña
```

## Configurar envio de email, en mi caso use mailhog (APLICA SOLO MODO LOCAL), dejo un ejemplo de configuración [MailHog](https://panjeh.medium.com/setup-mailhog-with-laravel-valet-localhost-or-laravel-sail-9d48895433e6)
```env
MAIL_MAILER=smtp
MAIL_HOST=localhost
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=no-reply@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

## Configurar variables de entorno para vue
```env
APP_URL=tu-host-local
```

## Ejecutar migraciones
```bash
php artisan migrate --seed #se genera tablas con datos ficticios
```
## Instalación de dependencias para el frontend
```bash
yarn install 
o
npm install
```
## Compilación de assets
```bash
yarn dev
o
npm run dev
```

## Levantar proyecto en local
```bash
php artisan serve --port=8081
```
## Ejecutar Queue para encolar envio de email
```bash
php artisan queue:work
```
## Ejecutar comando para el envio de email
```bash
php artisan chats:send-history-individual-chats
php artisan chats:send-history-daily-messages
```
acceder con las siguientes credenciales
```bash
email: demo@servicios-online.mx
password: password
```
