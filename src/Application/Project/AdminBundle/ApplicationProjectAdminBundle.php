<?php  
         
namespace App\Application\Project\AdminBundle;
                
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ApplicationProjectAdminBundle extends Bundle
{
    /** {@inheritdoc} */
    public function getParent()
    {
        return 'ApplicationProjectAdminBundle';
    }
}