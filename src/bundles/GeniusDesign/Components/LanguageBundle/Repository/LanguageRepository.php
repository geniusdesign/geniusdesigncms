<?php

namespace GeniusDesign\Components\LanguageBundle\Repository;

use Doctrine\ORM\EntityRepository;
use GeniusDesign\CommonBundle\Repository\MainRepository;

/**
 * Repository class for languages
 * 
 * @author Paweł Cichoń <cichonpawelhd@gmail.com>
 * @copyright GeniusDesign
 */
class LanguageRepository extends MainRepository {
    
    /**
     * Returns language by given language code
     * @param string $languageCode The language code
     * @return Language 
     */
    public function getLanguageByCode($languageCode){
        $criteria = array(
            'language_code' => $languageCode
        );

        return $this->getEffect($criteria, array(), 0, 0, false);
    }

    /**
     * Returns default language
     * @return Language 
     */
    public function getDefaultLanguage() {
        $criteria = array(
            'is_default' => true
        );

        return $this->getEffect($criteria, array(), 0, 0, false);
    }

}
