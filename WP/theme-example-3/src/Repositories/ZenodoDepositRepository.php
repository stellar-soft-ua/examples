<?php

namespace THEME\Theme\Repositories;

use THEME\Framework\Database\Repositories\PostRepository;

class ZenodoDepositRepository extends PostRepository
{
    protected $model = 'zenodo_deposit';

    public function initBuilder()
    {
        $this->setArgument('post_status', ['publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash']);
    }

    public function orderByModified(string $direction = 'DESC')
    {
        $this->setArgument('meta_key', 'zenodo_modified');
        $this->setArgument('orderby', 'meta_value');
        $this->setArgument('order', $direction);

        return $this;
    }

    public function whereZenodoId(int $id)
    {
        $this->setArgument('meta_query.zenodo_id_clause', [
            'key'     => 'zenodo_id',
            'value'   => $id,
            'compare' => '='
        ]);

        return $this;
    }

    public function whereZenodoDoi($doi)
    {
        $this->setArgument('meta_query.zenodo_doi_clause', [
            'key'     => 'zenodo_doi',
            'value'   => $doi,
            'compare' => is_array($doi) ? 'IN' : '='
        ]);

        return $this;
    }

    public function whereIdenticalIdentifiersNotSet()
    {
        $this->setArgument('meta_query.relation', 'OR');
        $this->addMetaQuery([
            'key'     => 'identical_identifiers',
            'compare' => 'NOT EXISTS'
        ]);

        $this->addMetaQuery([
            'key'     => 'identical_identifiers',
            'value'   => '',
            'compare' => '='
        ]);

        return $this;
    }

    public function whereIdenticalIdentifier($identifier)
    {
        $this->addMetaQuery([
            'key'     => 'identical_identifiers',
            'value'   => $identifier,
            'compare' => 'LIKE'
        ]);

        return $this;
    }
}
