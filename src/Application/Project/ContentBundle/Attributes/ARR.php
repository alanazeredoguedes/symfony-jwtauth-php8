<?php

namespace App\Application\Project\ContentBundle\Attributes;

/**
 * Auth Router Register
 */
#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD | \Attribute::TARGET_PROPERTY)]
class ARR
{

    public function __construct(
        ?string $routerName = null,
        ?string $role = null,
        ?string $title = null,
        ?string $groupName = null,
        ?string $description = null,
    ){

    }





}