<?php

namespace Modules\Opx\Breadcrumbs\Interfaces;

interface Breadcrumbs
{
    /**
     * Get parent breadcrumb node.
     *
     * @return  Breadcrumbs|null
     */
    public function breadcrumbParent(): ?Breadcrumbs;

    /**
     * Get link to breadcrumb.
     *
     * @return string|null
     */
    public function breadcrumbLink(): ?string;

    /**
     * Get title for breadcrumb.
     *
     * @return  string|null
     */
    public function breadcrumbTitle(): ?string;
}