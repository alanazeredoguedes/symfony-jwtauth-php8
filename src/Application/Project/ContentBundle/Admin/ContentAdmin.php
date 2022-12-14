<?php
namespace App\Application\Project\ContentBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Sonata\AdminBundle\Show\ShowMapper;


final class ContentAdmin extends AbstractAdmin
{
    protected function generateBaseRoutePattern(bool $isChildAdmin = false): string
    {
        return '';
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        parent::configureRoutes($collection); // TODO: Change the autogenerated stub

        $collection->add('login');
        $collection->add('logout');
        $collection->add('accessDenied');

        $routesRemove = ['show', 'list', 'create', 'edit', 'delete', 'batch', 'export', 'history'];
        foreach ($routesRemove as $route){
            $collection->remove($route);
        }

    }


    protected function configureFormFields(FormMapper $form): void
    {}

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {}

    protected function configureListFields(ListMapper $list): void
    {}

    protected function configureShowFields(ShowMapper $show): void
    {}
}