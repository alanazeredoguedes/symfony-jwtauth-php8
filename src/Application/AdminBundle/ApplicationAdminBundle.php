<?php  
         
namespace App\Application\AdminBundle;
                
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ApplicationAdminBundle extends Bundle
{
    /** {@inheritdoc} */
    public function getParent()
    {
        return 'ApplicationAdminBundle';
    }
}