#Setup
1. Download git repo
2. `composer install`
3. setup database setup string in `.env` file
    `DATABASE_URL=mysql://username:password@127.0.0.1:3306/database?serverVersion=5.7`
    
4. run `bin/console doc:mig:mig`

5. symfony `server:start` (symfony cli required) *

6. Login with username `admin` password `admin`

$argon2id$v=19$m=65536,t=4,p=1$kWIRlvEGgyemV56YCEioIw$AZkW/d4pCrWY2YkF0Rzq3k+N+xIq7jD9GlHZwH7ZKM8


* visit https://symfony.com/download for symfony download and install

