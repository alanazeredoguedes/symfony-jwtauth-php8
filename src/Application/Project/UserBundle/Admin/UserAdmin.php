<?php
namespace App\Application\Project\UserBundle\Admin;

use App\Application\Project\AdminBundle\Service\AdminRoutesService;
use App\Application\Project\UserBundle\Entity\Group;
use App\Application\Project\UserBundle\Entity\User;
use Knp\Menu\ItemInterface;
use Psr\Container\ContainerInterface;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Bundle\SecurityBundle\Security\UserAuthenticator;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;

final class UserAdmin extends AbstractAdmin
{

    protected AdminRoutesService $routesService;

    public function __construct(AdminRoutesService $routesService)
    {
        parent::__construct();

        $this->routesService = $routesService;
        //$this->removeRoutes = $this->routesService->RoutesNotAccessible();

    }

    public function toString(object $object): string
    {
        return $object instanceof User ? $object->getId() : '';
    }


    protected function generateBaseRoutePattern(bool $isChildAdmin = false): string
    {
        return 'user';
    }

   protected function configureRoutes(RouteCollectionInterface $collection): void
   {

       $user = $this->getModelManager()->find('App\Application\Project\UserBundle\Entity\User', 1);

       $routesRemove = $this->routesService->RoutesNotAccessible($user, $this->baseControllerName);

       //dump($routesRemove);

       $collection->add('login');
       $collection->add('logout');

       /*if($routesRemove){
           foreach ($routesRemove as $rm) {
               $collection->remove($rm);
           }
       }*/

       parent::configureRoutes($collection); // TODO: Change the autogenerated stub

   }

    protected function configureFormFields(FormMapper $form): void
    {

        $form->add('username', TextType::class);
        $form->add('email', TextType::class);
        //$form->add('roles', TextType::class);
        $form->add('groups', ModelType::class,[
            'class' => Group::class,
            'property' => 'name',
            'label' => 'Grupos',
            'required' => false,
            'expanded' => false,
            'btn_add' => false,
            'multiple' => true,
        ]);

    }

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid->add('username');
        $datagrid->add('email');
        $datagrid->add('roles');
    }

    protected function configureListFields(ListMapper $list): void
    {
        $this->setListMode('list');
        unset($this->getListModes()['mosaic']);

        $list->addIdentifier('username');
        $list->addIdentifier('email');
        //$list->addIdentifier('roles');
        $list->add('groups', null, [
            'label' => 'Grupos',
            'associated_property' => 'name',
        ]);
        $list->add(ListMapper::NAME_ACTIONS, ListMapper::TYPE_ACTIONS, [
            'actions' => [
                'show' => [],
                'edit' => [],
                'delete' => [],
            ]
        ]);
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show->add('username');
        $show->add('email');
        $show->add('groups', null, [
            'associated_property' => 'name',
            'label' => 'Grupo:',
        ]);
        $show->add('roles');
    }
}