<?php

namespace Modules\Opx\Breadcrumbs;

use Core\Foundation\Module\BaseModule;
use Modules\Opx\Breadcrumbs\Interfaces\Breadcrumbs as BreadcrumbsInterface;

class Breadcrumbs extends BaseModule
{
    /** @var string  Module name */
    protected $name = 'opx_breadcrumbs';

    /** @var string  Module path */
    protected $path = __DIR__;

    public function make($model, $currentAsH1 = false, $classPrefix = 'breadcrumbs'): ?string
    {
        if (!$model instanceof BreadcrumbsInterface) {
            return null;
        }

        $nodes = $this->getNode($model, $this->config('current'), $this->config('link'));

        if ($this->config('home') && $model->link() !== '/') {
            $nodes = array_merge(
                [[
                    'link' => '/',
                    'title' => trans('opx_breadcrumbs::locale.homepage'),
                    'current' => false,
                ]],
                $nodes
            );
        }

        return $this->render($nodes, $classPrefix, $currentAsH1);
    }

    /**
     * Build nodes for breadcrumbs.
     *
     * @param BreadcrumbsInterface $model
     * @param boolean $show
     * @param boolean $link
     * @param boolean $current
     *
     * @return  array|null
     */
    protected function getNode($model, $show, $link, $current = true): ?array
    {
        $parent = $model->parent();

        if ($parent !== null) {

            $parent = $model->parent;

            if ($parent instanceof BreadcrumbsInterface) {

                $parentNode = $this->getNode($parent, true, true, false);
            }
        }

        $currentNode = $show ? [
            'title' => $model->breadcrumbTitle(),
            'link' => $link ? $model->link() : null,
            'current' => $current,
        ] : [];

        return array_merge($parentNode ?? [], [$currentNode]);
    }

    /**
     * Render breadcrumbs.
     *
     * @param array $nodes
     * @param string $classPrefix
     * @param boolean $currentAsH1
     *
     * @return  null|string
     */
    protected function render($nodes, $classPrefix, $currentAsH1): ?string
    {
        $html = "<ul class=\"{$classPrefix}\">";
        $previous = null;

        foreach ($nodes as $node) {
            if ($node === [] || $previous === $node['link']) {
                continue;
            }

            $previous = $node['link'];

            if ($currentAsH1 && $node['current']) {
                $html .= $node['link']
                    ? "<li class=\"{$classPrefix}__node {$classPrefix}__node-active\"><a class=\"{$classPrefix}__node-title\" href='{$node['link']}'><h1>{$node['title']}</h1></a></li>"
                    : "<li class=\"{$classPrefix}__node {$classPrefix}__node-active\"><h1 class=\"{$classPrefix}__node-title\">{$node['title']}</h1></li>";
            } elseif (!$currentAsH1 && $node['current']) {
                $html .= $node['link']
                    ? "<li class=\"{$classPrefix}__node {$classPrefix}__node-active\"><a class=\"{$classPrefix}__node-title\" href='{$node['link']}'>{$node['title']}</a></li>"
                    : "<li class=\"{$classPrefix}__node {$classPrefix}__node-active\"><span class=\"{$classPrefix}__node-title\">{$node['title']}</span></li>";
            } else {
                $html .= $node['link']
                    ? "<li class=\"{$classPrefix}__node {$classPrefix}__node-parent\"><a class=\"{$classPrefix}__node-title\" href='{$node['link']}'>{$node['title']}</a></li>"
                    : "<li class=\"{$classPrefix}__node {$classPrefix}__node-parent\"><span class=\"{$classPrefix}__node-title\">{$node['title']}</span></li>";
            }
        }
        $html .= '</ul>';

        return $html;
    }
}
