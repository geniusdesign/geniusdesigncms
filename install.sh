# 
# Prepare for installation
# 
mkdir -p app/cache app/logs web/upload/files
chmod -R 777 app/logs app/cache/ web/upload/

rm -r  app/cache/* app/logs/*
chmod -R 777 app/cache/ app/logs/

cp app/config/config.copy.install.yml app/config/config.yml
cp app/config/parameters.copy.yml app/config/parameters.yml

# 
# Let's start installation
# 
php composer.phar install

# 
# Installing assets (generating symlinks in the /web catalog)
# 
rm -r web/bundles
php app/console assets:install web/ --symlink

# 
# Post-install
# 
cp app/config/config.copy.full.yml app/config/config.yml
