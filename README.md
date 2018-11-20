# Installation

## Requirements

- Install PHP 7.2 and Sqlite
- Install PHP extensions and following extensions: OpenSSL, PDO, Mbstring, Tokenizer, XML, Ctype, JSON, Sqlite

```bash
sudo apt install php7.2-extension-name # you can find it easily on the internet, but I'm sure you need at least php7.2-mbstring php7.2-xml php7.2-zip php7.2-sqlite
```

- Install [composer](https://getcomposer.org/)
- Install Node 10.2.0 (see [Node Version Manager](https://github.com/creationix/nvm))

## Installing dependencies

```bash
git clone https://github.com/lakazcreole/website.git
cd lakazcreole
composer install
yarn
cp .env.example .env # edit values as needed
php artisan key:generate
touch ./path/to/dabase.sqlite
php artisan migrate:fresh --seed # running migrations
```

## Running in development

```bash
cd lakazcreole
php artisan serve # Running the server
yarn dev # Building assets for development
```
