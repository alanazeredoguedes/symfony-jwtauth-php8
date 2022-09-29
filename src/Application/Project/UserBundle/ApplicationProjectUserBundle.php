<?php  
         
namespace App\Application\Project\UserBundle;
                
use Symfony\Component\HttpKernel\Bundle\Bundle;
                
class ApplicationProjectUserBundle extends Bundle
{
    /** {@inheritdoc} */
    public function getParent()
    {
        return 'ApplicationProjectUserBundle';
    }
}