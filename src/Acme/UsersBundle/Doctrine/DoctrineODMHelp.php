<?php
namespace Acme\UsersBundle\Doctrine;


class DoctrineODMHelp
{
    static public function paginate( $paginator, $query, &$pageSize = 10, &$currentPage = 1){
        $pageSize = (int)$pageSize;
        $currentPage = (int)$currentPage;

        if( $pageSize < 1 ){
            $pageSize = 10;
        }

        if( $currentPage < 1 ){
            $currentPage = 1;
        }


        $pagination = $paginator->paginate($query, $currentPage, $pageSize);

        return $pagination;
    }
}