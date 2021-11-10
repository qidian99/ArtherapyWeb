<?php
 namespace MailPoetVendor\Symfony\Component\DependencyInjection\Compiler; if (!defined('ABSPATH')) exit; use MailPoetVendor\Symfony\Component\DependencyInjection\ContainerBuilder; use MailPoetVendor\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException; use MailPoetVendor\Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException; use MailPoetVendor\Symfony\Component\DependencyInjection\Reference; class ReplaceAliasByActualDefinitionPass extends AbstractRecursivePass { private $replacements; public function process(ContainerBuilder $container) { $seenAliasTargets = []; $replacements = []; foreach ($container->getAliases() as $definitionId => $target) { $targetId = (string) $target; if ('service_container' === $targetId) { continue; } if (isset($replacements[$targetId])) { $container->setAlias($definitionId, $replacements[$targetId])->setPublic($target->isPublic())->setPrivate($target->isPrivate()); } if (isset($seenAliasTargets[$targetId])) { continue; } $seenAliasTargets[$targetId] = \true; try { $definition = $container->getDefinition($targetId); } catch (ServiceNotFoundException $e) { if ('' !== $e->getId() && '@' === $e->getId()[0]) { throw new ServiceNotFoundException($e->getId(), $e->getSourceId(), null, [\substr($e->getId(), 1)]); } throw $e; } if ($definition->isPublic()) { continue; } $definition->setPublic(!$target->isPrivate()); $definition->setPrivate($target->isPrivate()); $container->setDefinition($definitionId, $definition); $container->removeDefinition($targetId); $replacements[$targetId] = $definitionId; } $this->replacements = $replacements; parent::process($container); $this->replacements = []; } protected function processValue($value, $isRoot = \false) { if ($value instanceof Reference && isset($this->replacements[$referenceId = (string) $value])) { $newId = $this->replacements[$referenceId]; $value = new Reference($newId, $value->getInvalidBehavior()); $this->container->log($this, \sprintf('Changed reference of service "%s" previously pointing to "%s" to "%s".', $this->currentId, $referenceId, $newId)); } return parent::processValue($value, $isRoot); } } 