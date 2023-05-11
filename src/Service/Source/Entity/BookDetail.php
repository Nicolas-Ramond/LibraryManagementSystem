<?php
/**
 * Created by PhpStorm.
 * User: moulaye
 * Date: 07/08/18
 * Time: 11:39
 */

namespace App\Service\Source\Entity;

class BookDetail
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
     * @return BookDetail
     */
    public function setName(String $name): BookDetail
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
     * @return BookDetail
     */
    public function setValue(String $value): BookDetail
    {
        $this->value = $value;
        return $this;
    }
}
