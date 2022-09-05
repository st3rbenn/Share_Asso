<?php

namespace App\Components;

use App\Repository\MaterialRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('search')]
class SearchComponent
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public string $query = '';

    public function __construct(private MaterialRepository $materialRepository)
    {
    }

    public function getMaterials(): array
    {
        return $this->materialRepository->search($this->query);
    }
}