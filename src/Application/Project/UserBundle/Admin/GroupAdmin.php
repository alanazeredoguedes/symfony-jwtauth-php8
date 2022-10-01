<?php
namespace App\Application\Project\UserBundle\Admin;

use App\Application\Project\AdminBundle\Service\RolesIdentifierService;
use App\Application\Project\UserBundle\Entity\Group;
use Sonata\AdminBundle\Admin\AbstractAdmin;
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

    public function __construct(RolesIdentifierService $rolesIdentifierService, ?string $code = null, ?string $class = null, ?string $baseControllerName = null)
    {
        $this->rolesIdentifierService = $rolesIdentifierService;
        parent::__construct($code, $class, $baseControllerName);

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
        //$adminRoles = $this->rolesIdentifierService->getAdminRoles();

        /*$collection->add('login');
        $collection->add('logout');*/
        //$collection->remove('batch');

    }

    protected function configureFormFields(FormMapper $form): void
    {

        $adminRoles = $this->rolesIdentifierService->getAdminRoles();
        $apiRoles = $this->rolesIdentifierService->getApiRoles();

        $choicesAdminRoles = $choicesApiRoles =[];

        foreach ($adminRoles as $group) {
            foreach ($group['routes'] as $roles){
                $choicesAdminRoles[] = [ $roles['role'] => $roles['role'] ];
            }
        }

        foreach ($apiRoles as $group) {
            foreach ($group['routes'] as $roles){
                $choicesApiRoles[] = [ $roles['role'] => $roles['role'] ];
            }
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