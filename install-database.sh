# 
# Prepare for installation
# 
./clear-all.sh

# 
# Database creating and loading fixtures (simple, start data)
# 
php app/console doctrine:schema:update --force
php app/console doctrine:fixtures:load

# 
# Post-install
# 
./clear-all.sh
