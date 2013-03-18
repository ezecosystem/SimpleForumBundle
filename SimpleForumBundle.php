<?php

/*
 * This file is part of the SimpleForumBundle
 *
 * (c) Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jb\SimpleForumBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Jb\SimpleForumBundle\DependencyInjection\Compiler\UrlMatcherCompilerPass;

/**
 * SimpleForumBundle
 *
 * @author Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 */
class SimpleForumBundle extends Bundle 
{
    /**
     * Build the bundle
     * 
     * @param ContainerBuilder $container the framework container
     */
    public function build(ContainerBuilder $container) 
    {
        parent::build($container);

        /** Add a CompilerPass to manage service tagged simpleforum.urlmatcher */
        $container->addCompilerPass(new UrlMatcherCompilerPass());
    }
}
