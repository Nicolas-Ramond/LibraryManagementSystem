<?php
/**
 * Created by PhpStorm.
 * User: moulaye
 * Date: 07/08/18
 * Time: 11:39
 */

namespace App\Service\Source\Entity;

class BookContrib
{
    /**
     * @var String
     */
    private $name;

    /**
     * @var String
     */
    private $value;

    /**
     * @return String
     */
    public function getName(): String
    {
        return $this->name;
    }

    /**
     * @param String $name
     *
     * @return BookContrib
     */
    public function setName(String $name): BookContrib
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return String
     */
    public function getValue(): String
    {
        return $this->value;
    }

    /**
     * @param String $value
     *
     * @return BookContrib
     */
    public function setValue(String $value): BookContrib
    {
        $this->value = $value;
        return $this;
    }
}
