<?php
namespace App\Application\Project\UserBundle\Admin;

use App\Application\Project\ContentBundle\Service\AdminRoutesService;
use App\Application\Project\ContentBundle\Service\RolesIdentifierService;
use App\Application\Project\UserBundle\Entity\Group;
use App\Application\Project\UserBundle\Entity\User;
use ReflectionException;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


final class UserAdmin extends AbstractAdmin
{

    protected AdminRoutesService $routesService;

    private RolesIdentifierService $rolesIdentifierService;

    public function __construct(RolesIdentifierService $rolesIdentifierService)
    {
        parent::__construct();

        $this->rolesIdentifierService = $rolesIdentifierService;

    }

    public function toString(object $object): string
    {
        return $object instanceof User ? $object->getId()  . ' - ' . $object->getUsername() : '';
    }


    protected function generateBaseRoutePattern(bool $isChildAdmin = false): string
    {
        return 'user';
    }

   protected function configureRoutes(RouteCollectionInterface $collection): void
   {
       parent::configureRoutes($collection); // TODO: Change the autogenerated stub

   }

    /** @throws ReflectionException */
    protected function configureFormFields(FormMapper $form): void
    {
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

            $form->with('Informações Gerais', ['class' => 'col-md-8']);

                $form->add('username', TextType::class, [
                    'label' => 'Nome do Usuário:',
                    'required' => true,
                ]);

                $form->add('email', TextType::class, [
                    'label' => 'E-mail:',
                    'required' => true,
                ]);

            $form->end();

            $form->with('Grupos do Usuário', ['class' => 'col-md-4']);

                $form->add('groups', ModelType::class,[
                    'class' => Group::class,
                    'property' => 'name',
                    'label' => 'Grupos',
                    'required' => false,
                    'expanded' => true,
                    'btn_add' => false,
                    'multiple' => true,
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
        $datagrid->add('username');
        $datagrid->add('email');
        $datagrid->add('roles');
    }

    protected function configureListFields(ListMapper $list): void
    {
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