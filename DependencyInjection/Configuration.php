<?php

namespace remiii\MandrillMailerBundle\DependencyInjection ;

use Symfony\Component\Config\Definition\Builder\TreeBuilder ;
use Symfony\Component\Config\Definition\ConfigurationInterface ;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder ( )
    {
        $treeBuilder = new TreeBuilder ( ) ;
        $rootNode = $treeBuilder -> root ( 'remiii_mandrill_mailer' ) ;

        $rootNode
            -> children ( )
            -> scalarNode ( 'api_key' )
                -> isRequired ( )
                -> info ( 'Mandrill API Key' )
                -> example ( 'qwertyqwerty' )
                -> end ( )
            -> scalarNode ( 'async' )
                -> defaultFalse ( )
                -> info ( 'Background sending mode that is optimized for bulk sending' )
                -> example ( false )
                -> end ( )
            -> end ( ) ;

        return $treeBuilder ;
    }
}
