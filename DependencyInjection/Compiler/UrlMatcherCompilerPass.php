<?php

/*
 * This file is part of the SimpleForumBundle
 *
 * (c) Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jb\SimpleForumBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Search services tagged simpleforum.urlmatcher and register them in the service simpleforum.router.urlmatcher_chain
 * 
 * @author Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 */
class UrlMatcherCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('simpleforum.router.urlmatcher_chain')) {
            return;
        }

        $definition = $container->getDefinition(
            'simpleforum.router.urlmatcher_chain'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'simpleforum.urlmatcher'
        );
        foreach ($taggedServices as $id => $attributes) {
            $definition->addMethodCall(
                'addMatcher',
                array(new Reference($id))
            );
        }
    }
}