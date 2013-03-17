<?php

namespace Jb\SimpleForumBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Jb\SimpleForumBundle\DependencyInjection\Compiler\UrlMatcherCompilerPass;

class SimpleForumBundle extends Bundle 
{
    public function build(ContainerBuilder $container) 
    {
        parent::build($container);

        $container->addCompilerPass(new UrlMatcherCompilerPass());
    }
}
