<?php

namespace App\Application\Project\AdminBundle\Attributes;


#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD)]
class AuthRouterRegister
{

    public function __construct(
        ?string $groupName = null,
        ?string $routerName = null,
        ?string $description = null,
        ?string $role = null,
    ){

    }





}