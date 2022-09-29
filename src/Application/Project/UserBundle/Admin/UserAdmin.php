<?php
namespace App\Application\Project\UserBundle\Admin;

use App\Application\Project\UserBundle\Entity\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class UserAdmin extends AbstractAdmin
{

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
        $collection->add('login');
        $collection->add('logout');
    }

    protected function configureFormFields(FormMapper $form): void
    {

        $form->add('username', TextType::class);
        $form->add('email', TextType::class);
        //$form->add('roles', TextType::class);
        $form->add('roles', CollectionType::class, [
            // each entry in the array will be an "email" field
            //'entry_type' => EmailType::class,
            // these options are passed to each "email" type
            'entry_options' => [
                'attr' => ['class' => 'email-box'],
            ],
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
        #unset($this->listModes['mosaic']);

        $list->addIdentifier('username');
        $list->addIdentifier('email');
        $list->addIdentifier('roles');
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show->add('username');
        $show->add('email');
        $show->add('roles');
    }
}