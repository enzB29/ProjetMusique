<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerAmU3REx\App_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerAmU3REx/App_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerAmU3REx.legacy');

    return;
}

if (!\class_exists(App_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerAmU3REx\App_KernelDevDebugContainer::class, App_KernelDevDebugContainer::class, false);
}

return new \ContainerAmU3REx\App_KernelDevDebugContainer([
    'container.build_hash' => 'AmU3REx',
    'container.build_id' => '0950fb3e',
    'container.build_time' => 1741179090,
    'container.runtime_mode' => \in_array(\PHP_SAPI, ['cli', 'phpdbg', 'embed'], true) ? 'web=0' : 'web=1',
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerAmU3REx');
