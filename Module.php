<?php
/**
 * MwEntityCollection
 */

namespace MwEntityCollection;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;

/**
 * Module Setup
 */
class Module implements AutoloaderProviderInterface
{
    /**
     * Set Autoloader Configuration
     *
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
