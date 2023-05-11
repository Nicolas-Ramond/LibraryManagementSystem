<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 29/06/2018
 * Time: 11:23
 */

namespace App\Factory;

use App\Entity\Book;
use App\Entity\BookGroup;
use App\Entity\Booking;

class BookFactory
{

    static function createBooksFromArray(array $array): array
    {
        $bookGroups = [];

        foreach ( $array as $book ){
            $bookGroup = new BookGroup();
            $bookGroup->setBook($book[0]);
            $bookGroup->setCount($book[1]);
            $bookGroups[] = $bookGroup;
        }

//        print_r($bookGroups);

        uasort($bookGroups, function ($a, $b) {
            if($a->getCount() == $b->getCount()) {
                return 0;
            }
            return ($a->getCount() > $b->getCount()) ? -1 : 1;
        });

        return $bookGroups;
    }
}
