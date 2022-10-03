<?php
namespace App\Application\Project\ContentBundle\EventListener;

use Sonata\AdminBundle\Event\ConfigureMenuEvent;

/**
 * Class MenuBuilderListener
 * @package AdminBundle\EventListener
 */
final class MenuBuilderListener
{



    /**
     * @param ConfigureMenuEvent $event
     */
    public function addMenuItems(ConfigureMenuEvent $event): void
    {
        $menu = $event->getMenu();


        $child = $menu->addChild('user', [
            'label' => 'Usuarios',
            'route' => 'admin_project_user_user_list',
        ])->setExtras(['icon' => 'fas fa-user',]);

        dump($menu);

    }
}