<?php  
         
namespace App\Application\Project\ContentBundle;
                
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ApplicationProjectContentBundle extends Bundle
{
    /** {@inheritdoc} */
    public function getParent()
    {
        return 'ApplicationProjectContentBundle';
    }
}