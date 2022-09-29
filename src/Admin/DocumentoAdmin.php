<?php
namespace App\Admin;

use App\Entity\Documento;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class DocumentoAdmin extends AbstractAdmin
{

    public function toString(object $object): string
    {
        return $object instanceof Documento ? $object->getId() : '';
    }


   /* protected function generateBaseRoutePattern(bool $isChildAdmin = false): string
    {
        return 'documento';
    }*/

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        //$collection->add('login');
        //$collection->add('logout');
    }

    protected function configureFormFields(FormMapper $form): void
    {

        $form->add('titulo', TextType::class);
        $form->add('subtitulo', TextType::class);
        $form->add('descricao', TextareaType::class);

    }

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid->add('titulo');
        $datagrid->add('subtitulo');
        $datagrid->add('descricao');
    }

    protected function configureListFields(ListMapper $list): void
    {
        $this->setListMode('list');
        #unset($this->listModes['mosaic']);

        $list->addIdentifier('titulo');
        $list->addIdentifier('subtitulo');
        $list->addIdentifier('descricao');
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show->add('titulo');
        $show->add('subtitulo');
        $show->add('descricao');
    }
}