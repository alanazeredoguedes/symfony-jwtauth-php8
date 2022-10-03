<?php
namespace App\Application\Project\UserBundle\Admin;

use App\Application\Project\AdminBundle\Service\AdminRoutesService;
use App\Application\Project\AdminBundle\Service\RolesIdentifierService;
use App\Application\Project\UserBundle\Entity\Group;
use Knp\Menu\ItemInterface;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class GroupAdmin extends AbstractAdmin
{

    private RolesIdentifierService $rolesIdentifierService;
    protected AdminRoutesService $routesService;

    public function __construct(RolesIdentifierService $rolesIdentifierService, AdminRoutesService $routesService)
    {
        $this->rolesIdentifierService = $rolesIdentifierService;
        $this->routesService = $routesService;

        parent::__construct();
    }

    public function toString(object $object): string
    {
        return $object instanceof Group ? $object->getId() : '';
    }

    protected function generateBaseRoutePattern(bool $isChildAdmin = false): string
    {
        return 'group';
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {

        $collection->add('listAllRoles');

        $user = $this->getModelManager()->find('App\Application\Project\UserBundle\Entity\User', 1);

        $routesRemove = $this->routesService->RoutesNotAccessible($user, $this->baseControllerName);

       /* if($routesRemove){
            foreach ($routesRemove as $rm) {
                $collection->remove($rm);
            }
        }*/

        parent::configureRoutes($collection); // TODO: Change the autogenerated stub

    }

    protected function configureFormFields(FormMapper $form): void
    {

        //$adminRoles = $this->rolesIdentifierService->getGroupRoles();


        $adminRoles = $this->rolesIdentifierService->getAdminRoles();
        $apiRoles = $this->rolesIdentifierService->getApiRoles();

        $choicesAdminRoles = $choicesApiRoles =[];

        foreach ($adminRoles as $role) {
            $choicesAdminRoles[] = [ $role['role'] => $role['role'] ];
        }

        foreach ($apiRoles as $role) {
            $choicesApiRoles[] = [ $role['role'] => $role['role'] ];
        }


        $form->tab('Geral');
            $form->with('Informações Do Grupo');

                $form->add('name', TextType::class,[
                    'label' => 'Nome do Grupo:',
                    'required' => true,

                ]);
                $form->add('description', TextareaType::class,[
                    'label' => 'Descrição do Grupo:',
                    'required' => false,

                ]);

            $form->end();
        $form->end();

        $form->tab('Admin');
            $form->with('Permissões Administrativas');

                $form->add('adminRoles', ChoiceType::class, [
                    'label' => ' ',
                    'required' => false,
                    'multiple' => true,
                    'expanded'=> false,
                    'choices' => $choicesAdminRoles,
                    'attr' => [
                        'class' => 'div-select-admin-roles',
                        //'style' => 'display:none;'
                    ],
                ]);

            $form->end();
        $form->end();

        $form->tab('Api');
            $form->with('Permissões Api');

        $form->add('apiRoles', ChoiceType::class, [
            'label' => ' ',
            'required' => false,
            'multiple' => true,
            'expanded'=> false,
            'choices' => $choicesApiRoles,
            'attr' => [
                'class' => 'div-select-api-roles',
                //'style' => 'display:none;'
            ],
        ]);

            $form->end();
        $form->end();


    }

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid->add('name');
        $datagrid->add('description');
        $datagrid->add('adminRoles');
        $datagrid->add('apiRoles');
    }

    protected function configureListFields(ListMapper $list): void
    {

        $this->setListMode('list');
        #unset($this->listModes['mosaic']);

        $list->addIdentifier('name');
        $list->addIdentifier('description');
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
        $show->add('name', null,[
            'label' => 'Nome do Grupo:',
        ]);
        $show->add('description', null,[
            'label' => 'Descrição:',
        ]);
        $show->add('adminRoles', null,[
            'label' => 'Permissões Administrativas:',
        ]);
        $show->add('apiRoles', null,[
            'label' => 'Permissões API:',
        ]);
    }
}