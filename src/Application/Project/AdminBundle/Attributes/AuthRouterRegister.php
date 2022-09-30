<?php

namespace App\Application\Project\AdminBundle\Attributes;


#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD)]
class AuthRouterRegister
{

    public function __construct(
        ?string $routerName = null,
        ?string $role = null,
        ?string $groupName = null,
        ?string $description = null,
    ){

    }





}