<?php

namespace App\Application\Project\ContentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\JsonException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultAbstractController extends AbstractController
{








    protected function transformParametersToObject($parameters): object
    {
        $stdClass = (object) $parameters;
        foreach ($stdClass as $index => $property) {
            $stdClass->$index = (object) $property;
        }
        return $stdClass;
    }

    protected function validateJsonRequestBody($requestBody, $parameters): bool|JsonResponse
    {
        $parameters = $this->transformParametersToObject($parameters);

        foreach ($parameters as $parameterName => $parameter){

            $propertyExist = property_exists($requestBody, $parameterName);

            /** Valida se a propriedade existe e se é requisitada  */
            if( !$propertyExist && $parameter->required )
                return $this->createResponseStatus(message: "Invalid content, this property { $parameterName } is required");


            /** Valida se a propriedade existe e pode ser nula ou vazia  */
            if( $propertyExist && !$parameter->nullable && ( $requestBody->$parameterName === "" || $requestBody->$parameterName === null ) )
                return $this->createResponseStatus(message: "Invalid content, this property { $parameterName } can't be empty");


            /** Valida se a propriedade existe possui o tipo requisitado  */
            if( $propertyExist && ( gettype($requestBody->$parameterName) !== $parameter->type ) )
                return $this->createResponseStatus(message: "Invalid content, this property { $parameterName } must be the type { $parameter->type }");




            /*if( property_exists($requestBody, $parameterName) && $requestBody->$parameter === '')
                return $this->createStatusResponse(400,"Invalid content, [" . $parameter . '] is empty');*/
        }

        return false;

    }

    protected function createResponseStatus(string $message, array $extra = [], int $statusCode = 406): JsonResponse
    {
        $array['code'] = $statusCode;
        $array['message'] = $message;
        $array = array_merge( $array, $extra );
        return new JsonResponse($array, $statusCode);
    }



    /**
     * Validate access as routes
     * @param string $role
     * @return void
     */
    public function validateAccess(string $role): void
    {
        if($this->isGranted("ROLE_SUPER_ADMIN"))
            return;

        if($role)
            $this->denyAccessUnlessGranted($role);
    }

}