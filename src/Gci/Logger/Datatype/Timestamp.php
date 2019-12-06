<?php

namespace Gci\Logger\Datatype;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * Type that maps an SQL TIME to a PHP DateTime object.
 */
class Timestamp extends Type {

    const TIMESTAMP = 'timestamp'; // modify to match your type name

    /**
     * {@inheritdoc}
     */
    public function getSqlDeclaration(array $fieldDeclaration, AbstractPlatform $platform) {
        $fieldDeclaration['length'] = intval($fieldDeclaration['length']);
        if(!empty($fieldDeclaration['nullable'])) {
            $nullOrNotNull = $fieldDeclaration['nullable'] === 'false' ? 'NOT NULL' : 'NULL';
        }
        if(empty($nullOrNotNull)) {
            $nullOrNotNull = 'NULL';
        }
        if (!empty($fieldDeclaration['length'])) {
            return sprintf("%s(%d) %s", 
                    self::TIMESTAMP, 
                    $fieldDeclaration['length'], 
                    $nullOrNotNull
            );
        }
        return sprintf("%s %s ", 
                self::TIMESTAMP, 
                $nullOrNotNull
        );
    }

    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue($value, AbstractPlatform $platform) {
        if ($value === null) {
            return null;
        }
        $val = \DateTime::createFromFormat('Y-m-d H:i:s', $value);
        if (!$val) {
            throw ConversionException::conversionFailedFormat($value, $this->getName(), 'Y-m-d H:i:s');
        }
        return $val;
    }

    /**
     * {@inheritdoc}
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform) {
        // If the value of the field is NULL the method convertToDatabaseValue() is not called.
        // http://doctrine-orm.readthedocs.org/en/latest/cookbook/custom-mapping-types.html
        return $value->format('Y-m-d H:i:s');
    }

    /**
     * {@inheritdoc}
     */
    public function getName() {
        return self::TIMESTAMP; // modify to match your constant name
    }

}
