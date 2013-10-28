<?php

namespace Netgusto\Baikal\AdminBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware {

    public function adminMenu(FactoryInterface $factory, array $options) {

        $menu = $factory->createItem('root', array('childrenAttributes' => array('class' => 'nav navbar-nav')));

        $menu->addChild('Users+Data', array('route' => 'netgusto_baikal_admin_user_list'));
        $menu->addChild('Settings', array('route' => 'netgusto_baikal_admin_settings'));

        return $menu;
    }
}