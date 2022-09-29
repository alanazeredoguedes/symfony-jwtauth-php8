<?php  
         
namespace App\Application\Project\MediaBundle;
                
use Symfony\Component\HttpKernel\Bundle\Bundle;
                
class ApplicationProjectMediaBundle extends Bundle
{
    /** {@inheritdoc} */
    public function getParent()
    {
        return 'ApplicationProjectMediaBundle';
    }
}