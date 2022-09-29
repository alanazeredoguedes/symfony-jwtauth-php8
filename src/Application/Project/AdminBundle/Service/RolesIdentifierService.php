<?php

namespace App\Application\Project\AdminBundle\Service;

use Laminas\Code\Reflection\ClassReflection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RolesIdentifierService extends AbstractController
{
    public function __construct()
    {
        //dump('dsa');

    }

    public function getAllRoles(){


//        $ref = new \ReflectionClass('App\Controller\HomeController');
//        dump($ref);

        $adminControllers = $this->getControllerPath('AdminController');
        $apiControllers = $this->getControllerPath('ApiController');
        $allControllers = array_merge($adminControllers, $apiControllers);

        dump($allControllers);



    }

    /**
     * @throws \ReflectionException
     */
    public function getAdminRoles(){
        $adminControllers = $this->getControllerPath('AdminController');


        $reflection = new ClassReflection($adminControllers[count($adminControllers)-3]);
        dump($reflection->name);

        foreach ($reflection->getMethods() as $method) {
            if(str_contains($method->name, 'Action'))
                dump($method->name);

        }

        /*foreach ($adminControllers as $controller){


        }*/

    }

    public function getApiRoles(){

    }












    private function getControllerPath($prefix)
    {
        $bundles = $this->getParameter('kernel.bundles');
        $controllers = [];
        foreach ($bundles as $bundle) {
            //dump($bundle);
            $reflection = new \ReflectionClass($bundle);// "App\Application\Project\AdminBundle\ApplicationProjectAdminBundle"
            $controllerDirectory = dirname($reflection->getFileName()) . '/Controller';
            if (file_exists($controllerDirectory)) {
                $d = dir($controllerDirectory);
                while (false !== ($entry = $d->read())) {
                    if (preg_match("/^([A-Z0-9-_]+Controller).php/i", $entry, $matches)) {
                        if(str_contains($entry, $prefix)){
                            //$controllers[] = ['fileName' => $controllerDirectory. '/'. $entry, 'class' => $reflection->getNamespaceName() . '\Controller\\' . $matches[1]];
                            $controllers[] = $reflection->getNamespaceName() . '\Controller\\' . $matches[1];

                        }
                    }
                }
                $d->close();
            }
        }

        return array_merge($controllers,  $this->getControllerDefaultPath($prefix));
    }

    private function getControllerDefaultPath($prefix){
        $controllerDirectory = $this->getParameter('kernel.project_dir').'/src/Controller';

        $controllers = [];

        if (file_exists($controllerDirectory)) {
            $d = dir($controllerDirectory);
            while (false !== ($entry = $d->read())) {
                if (preg_match("/^([A-Z0-9-_]+Controller).php/i", $entry, $matches)) {
                    if(str_contains($entry, $prefix)){
                        $controllers[] = "App\Controller\\" . str_replace('.php','',$entry);
                    }
                }
            }
            $d->close();
        }
        return $controllers;
    }


}