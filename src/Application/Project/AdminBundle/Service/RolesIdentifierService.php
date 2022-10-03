<?php

namespace App\Application\Project\AdminBundle\Service;

use Laminas\Code\Reflection\ClassReflection;
use ReflectionClass;
use ReflectionException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RolesIdentifierService extends AbstractController
{
    private string $authRouterRegister = "App\Application\Project\AdminBundle\Attributes\ARR";

    public function __construct(){}

    /** @throws ReflectionException */
    public function getAdminGroupRoles(): array
    {
        return $this->getGroupRoles('AdminController');
    }

    /** @throws ReflectionException */
    public function getAdminRoles(): array
    {
        $routes = [];

        foreach ($this->getAdminGroupRoles() as $group) {
            $routes = array_merge($routes, $group['routes']);
        }
        return $routes;
    }

    /** @throws ReflectionException */
    public function getApiGroupRoles(): array
    {
        return $this->getGroupRoles('ApiController');
    }

    /** @throws ReflectionException */
    public function getApiRoles(): array
    {
        $routes = [];

        foreach ($this->getApiGroupRoles() as $group) {
            $routes = array_merge($routes, $group['routes']);
        }
        return $routes;
    }

    /** @throws ReflectionException */
    public function getAllGroupRoles(): array
    {
        return [
            'adminRoles' => $this->getGroupRoles('AdminController'),
            'apiRoles' => $this->getGroupRoles('ApiController'),
        ];
    }


    /** @throws ReflectionException */
    public function getAllRoles(): array
    {

        $adminRoles = $this->getAdminRoles();
        $apiRoles = $this->getApiRoles();

        return array_merge($adminRoles, $apiRoles);
    }

    /** @throws ReflectionException */
    public function getAllRolesByController($controllerName): array
    {
        $controllerName = explode('\\', $controllerName);

        $routes = $this->getGroupRoles(end($controllerName) );

        return $routes[0]['routes'];
    }


    /** @throws ReflectionException */
    public function getAllRolesClean(): array
    {

        $adminRoles = $this->getAdminRoles();
        $apiRoles = $this->getApiRoles();
        $allRolesGroup = array_merge($adminRoles, $apiRoles);

        $roles = [];
        foreach ($allRolesGroup as $roleGroup) {
            $roles[] =  $roleGroup['role'];
        }

        return $roles;
    }





    /** @throws ReflectionException */
    private function getGroupRoles(string $controllerPrefix): array
    {
        $adminControllers = $this->getControllerPath($controllerPrefix);


        $groups = [];

        /** Percorre Todas as Controladoras */
        foreach ($adminControllers as $adminController) {

            $reflection = new ReflectionClass($adminController);
            $classAttributes = $reflection->getAttributes();

            $group = $this->getAttributesARR($classAttributes);
            if( ($group === false) || empty($group['groupName']) )
                continue;


            /** Percorre Todas as Properties das Classes */
            foreach ($reflection->getProperties() as $method) {

                $methodAttributes = $method->getAttributes();
                $router = $this->getAttributesARR($methodAttributes);
                if( ($router === false) || empty($router['routerName']) || empty($router['role']) )
                    continue;

                $group['routes'][] = $router;
            }

            /** Percorre Todas os Methods da Classe */
            foreach ($reflection->getMethods() as $method) {

                $methodAttributes = $method->getAttributes();
                $router = $this->getAttributesARR($methodAttributes);
                if( ($router === false) || empty($router['routerName']) || empty($router['role']) )
                    continue;

                $group['routes'][] = $router;
            }




            $groups[] = $group;
        }


            return $groups;
    }


    public function getAttributesARR($attributes): bool|array
    {
        $config = [];

        foreach ($attributes as $attribute) {
            if($attribute->getName() === $this->authRouterRegister){

                $args = $attribute->getArguments();

                if( isset($args['routerName']) )
                    $config['routerName'] = $args['routerName'];

                if( isset($args['role']) )
                    $config['role'] = $args['role'];

                if( isset($args['title']) )
                    $config['title'] = $args['title'];

                if( isset($args['groupName']) )
                    $config['groupName'] = $args['groupName'];


                if( isset($args['description']) )
                    $config['description'] = $args['description'];

                return $config;
            }
        }
        return false;
    }






























    private function getControllerPath($prefix)
    {
        $bundles = $this->getParameter('kernel.bundles');
        $controllers = [];
        foreach ($bundles as $bundle) {
            //dump($bundle);
            $reflection = new ReflectionClass($bundle);// "App\Application\Project\AdminBundle\ApplicationProjectAdminBundle"
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