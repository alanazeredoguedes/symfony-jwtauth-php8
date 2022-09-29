<?php

namespace App\Application\Project\UserBundle\Controller;

use Laminas\Code\Reflection\ClassReflection;
use Laminas\Code\Reflection\FunctionReflection;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class GroupAdminController extends CRUDController
{

    public function createAction(Request $request): Response
    {
        return parent::createAction($request);
    }

    public function editAction(Request $request): Response
    {

        $this->getClassAnnotations('UserApiController.php');


        return parent::editAction($request);
    }

    public function listAction(Request $request): Response
    {

        return parent::listAction($request);
    }


    /**
     * @throws \ReflectionException
     */
    private function getClassAnnotations($class)
    {
        $projectRoot = $this->getParameter('kernel.project_dir');
        $classDir = $projectRoot . '/src/Controller/';

        $apiController = new UserApiController();
        $adminController = new UserAdminController();

        $reflector = new ClassReflection($adminController);

       // dump($reflector);

        $actionMethods = $this->getActionMethods($reflector->getMethods());

        foreach ($actionMethods as $actionMethod) {
            dump($actionMethod->getName());
        }


    }

    private function getActionMethods($classMethods){
        $methods = [];

        foreach ($classMethods as $method){
            if(str_contains( $method->getName(),'Action')){
                $methods[] = $method;
            }
        }

        return $methods;
    }







}