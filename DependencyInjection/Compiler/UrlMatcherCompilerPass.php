<?php

namespace Jb\SimpleForumBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class UrlMatcherCompilerPass implements CompilerPassInterface
{
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
                'addRouter',
                array(new Reference($id))
            );
        }
    }
}