# Moto Price Scraper 🏍️💰

Mini CLI aplikace postavená v **Symfony**, která slouží ke scrapingu dat o cenách motocyklů z Bazoš.cz.

[Screencast From 2026-07-04 22-03-57.webm](https://github.com/user-attachments/assets/92d5ee73-1f5a-4fe3-976f-cd9322c1e567)

Dependencies (PHP, Symfony, Composer, Symfony CLI): 

sudo apt update && sudo apt upgrade -y
sudo apt install -y curl git unzip wget gnupg2 software-properties-common
sudo apt install -y php-cli php-common php-pgsql php-xml php-mbstring php-curl php-zip php-intl php-bcmath php-gd
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | sudo -E bash
sudo apt install symfony-cli -y
