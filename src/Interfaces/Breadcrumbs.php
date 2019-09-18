<?php

namespace Modules\Opx\Breadcrumbs\Interfaces;


use Illuminate\Database\Eloquent\Relations\Relation;

interface Breadcrumbs
{
    /**
     * Get parent model.
     *
     * @return  Relation|null
     */
    public function parent(): ?Relation;

    /**
     * Get link to model.
     *
     * @return null|string
     */
    public function link(): ?string;

    /**
     * Get title for breadcrumbs.
     *
     * @return  null|string
     */
    public function breadcrumbTitle(): ?string;
}