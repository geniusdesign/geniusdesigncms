<?php

namespace GeniusDesign\CommonBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * Main repository class for bundles
 * 
 * @author Paweł Cichoń <cichonpawelhd@gmail.com>
 * @copyright GeniusDesign
 */
class MainRepository extends EntityRepository {

    /**
     * The default alias used by Query Builder
     * @var string
     */
    private $defaultAlias = 't';

    /**
     * The language code used by locale
     * @var string
     */
    private $languageCode = '';

    /**
     * If is set to true, translations of the default language are used when there is no translations for current language. Otherwise - not.
     * @var boolean
     */
    private $useTranslationsFallback = true;

    /**
     * Returns the default alias used by Query Builder
     * @return string
     */
    public function getDefaultAlias() {
        return $this->defaultAlias;
    }

    /**
     * Sets the default alias used by Query Builder
     * 
     * @param string $alias The default alias
     * @return \Meritoo\Component\CommonBundle\Repository\BaseRepository
     */
    public function setDefaultAlias($alias) {
        $this->defaultAlias = $alias;
        return $this;
    }
    
    /**
     * Returns name of the entity class
     * @return string
     */
    public function getEntityClassName() {
        return $this->getClassMetadata()->name;
    }

    /**
     * Sets the language code
     * 
     * @param string $languageCode The language code
     * @return \Meritoo\Component\CommonBundle\Repository\BaseRepository
     */
    public function setLanguageCode($languageCode) {
        $this->languageCode = $languageCode;
        return $this;
    }

    /**
     * Returns the language code
     * @return string
     */
    public function getLanguageCode() {
        return $this->languageCode;
    }

    /**
     * Returns data for given parameters.
     * It may be array or single result.
     * It may also return the query only.
     * 
     * @param [array $criteria = array()] The criteria used in WHERE clause. It may simple array with pairs key-value or an array of arrays where second element of subarray is the comparison operator. Example:
     *      $criteria = array(
     *          'created_at' => array(
     *              '2012-11-17 20:00',
     *              '<'
     *          ),
     *          'title' => array(
     *              '%test%',
     *              'like'
     *          ),
     *          'position' => 5
     *      );
     * @param [array $orderBy = array()] The parameters used in ORDER BY clause
     * @param [integer $limit = 0] Maximum amount of items
     * @param [integer $offset = 0] The start position, offset
     * @param [boolean $manyResults = true] If is set to true, many results are returned. Otherwise - one.
     * @param [boolean $returnQueryOnly = false] If is set to true, returns the builded query. Otherwise - array or object.
     * @return \Doctrine\ORM\Query | array | object
     */
    public function getEffect(array $criteria = array(), array $orderBy = array(), $limit = 0, $offset = 0, $manyResults = true, $returnQueryOnly = false) {
        /*
         * Getting the query builder
         */
        $builder = $this->getQueryBuilder($criteria, $orderBy, $limit, $offset);

        /*
         * Setting hints required for translations
         */
        $query = $this->setTranslationHints($builder->getQuery());

        /*
         * And finally returning the proper value
         */
        if ($returnQueryOnly) {
            return $query;
        }

        if ($manyResults) {
            return $query->getResult();
        }

        return $query->getOneOrNullResult();
    }

    /**
     * Returns one object / item for given parameters
     * 
     * @param [array $criteria = array()] The criteria used in WHERE clause. It may simple array with pairs key-value or an array of arrays where second element of subarray is the comparison operator. Example:
     *      $criteria = array(
     *          'created_at' => array(
     *              '2012-11-17 20:00',
     *              '<'
     *          ),
     *          'title' => array(
     *              '%test%',
     *              'like'
     *          ),
     *          'position' => 5
     *      );
     * @return object
     */
    public function getOneEffect(array $criteria = array()) {
        return $this->getEffect($criteria, array(), 0, 0, false);
    }

    /**
     * Sets hints required for translations
     * 
     * @param \Doctrine\ORM\Query $query The query
     * @return \Doctrine\ORM\Query $query
     */
    public function setTranslationHints(\Doctrine\ORM\Query $query) {
        $languageCode = $this->getLanguageCode();

        if (!empty($languageCode)) {
            $query->setHint(\Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER, 'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker')
                    ->setHint(\Gedmo\Translatable\TranslatableListener::HINT_TRANSLATABLE_LOCALE, $languageCode)
                    ->setHint(\Gedmo\Translatable\TranslatableListener::HINT_FALLBACK, (int) $this->areTranslationsFallbackUsed());
        }

        return $query;
    }

    /**
     * Returns information if translations of the default language are used when there is no translations for current language
     * @return boolean
     */
    public function areTranslationsFallbackUsed() {
        return $this->useTranslationsFallback;
    }

    /**
     * Sets the option that indicates if translations of the default language are used when there is no translations for current language
     * 
     * @param [boolean $use = true] The option's value
     * @return \Meritoo\Component\CommonBundle\Repository\BaseRepository
     */
    public function setUseTranslationsFallback($use = true) {
        $this->useTranslationsFallback = $use;
        return $this;
    }


    /**
     * Returns query builder for given parameters
     * 
     * @param [array $criteria = array()] The criteria used in WHERE clause. It may simple array with pairs key-value or an array of arrays where second element of subarray is the comparison operator. Example:
     *      $criteria = array(
     *          'created_at' => array(
     *              '2012-11-17 20:00',
     *              '<'
     *          ),
     *          'title' => array(
     *              '%test%',
     *              'like'
     *          ),
     *          'position' => 5
     *      );
     * @param [array $orderBy = array()] The parameters used in ORDER BY clause
     * @param [integer $limit = 0] Maximum amount of items
     * @param [integer $offset = 0] The start position, offset
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getQueryBuilder(array $criteria = array(), array $orderBy = array(), $limit = 0, $offset = 0) {
        $alias = $this->getDefaultAlias();

        /*
         * Creating the query builder
         */
        $builder = $this->getEntityManager()
                ->createQueryBuilder()
                ->select($alias)
                ->from($this->getEntityClassName(), $alias);

        /*
         * Setting the WHERE criteria
         */
        $builder = $this->setCriteria($builder, $criteria, $alias);

        /*
         * Setting the ORDER BY parameters
         */
        if (!empty($orderBy)) {
            foreach ($orderBy as $column => $order) {
                $column = sprintf('%s.%s', $alias, $column);
                $builder->addOrderBy($column, $order);
            }
        }

        /*
         * Setting the LIMIT and OFFSET (used by pagination)
         */
        if ($limit > 0) {
            $builder->setMaxResults($limit);
        }

        if ($offset > 0) {
            $builder->setFirstResult($offset);
        }

        return $builder;
    }
    
    
    /**
     * Sets the the WHERE criteria
     * 
     * @param QueryBuilder $builder The query builder
     * @param [array $criteria = array()] The criteria used in WHERE clause. It may simple array with pairs key-value or an array of arrays where second element of subarray is the comparison operator. Example:
     *      $criteria = array(
     *          'created_at' => array(
     *              '2012-11-17 20:00',
     *              '<'
     *          ),
     *          'title' => array(
     *              '%test%',
     *              'like'
     *          ),
     *          'position' => 5
     *      );
     * @param [string $alias = ''] Alias used in the query
     * @return QueryBuilder 
     */
    private function setCriteria(QueryBuilder $builder, array $criteria = array(), $alias = '') {
        if (!empty($criteria)) {
            $first = true;
            $queryParameters = array();

            foreach ($criteria as $column => $value) {
                $compareOperator = '=';

                if (is_array($value) && !empty($value)) {
                    if (count($value) == 2) {
                        $compareOperator = $value[1];
                    }

                    $value = $value[0];
                }

                $predicate = sprintf('%s.%s %s :%s', $alias, $column, $compareOperator, $column);

                if ($value === null) {
                    $predicate = sprintf('%s.%s is null', $alias, $column);
                    unset($criteria[$column]);
                } else {
                    $queryParameters[$column] = $value;
                }

                if ($first) {
                    $builder = $builder->where($predicate);
                    $first = false;
                } else {
                    $builder = $builder->andWhere($predicate);
                }
            }

            $builder->setParameters($queryParameters);
        }

        return $builder;
    }
    
    
    /**
     * Returns the row for given ID
     * 
     * @param integer $rowId Row ID
     * @return Entity
     */
    public function getRow($rowId) {
        $alias = $this->getDefaultAlias();

        $builder = $this->getEntityManager()
                ->createQueryBuilder();

        $builder->select($alias)
                ->from($this->getEntityClassName(), $alias)
                ->where('t.id = :id')
                ->setParameter('id', $rowId);

        $query = $builder->getQuery();

        return $this->setTranslationHints($query)
                        ->getOneOrNullResult();
    }

    /**
     * Returns all rows
     * @return Entity
     */
    public function getRows() {
        $alias = $this->getDefaultAlias();

        $builder = $this->getEntityManager()
                ->createQueryBuilder();

        $builder->select($alias)
                ->from($this->getEntityClassName(), $alias);

        return $this->setTranslationHints($builder->getQuery())
                        ->getResult();
    }

}