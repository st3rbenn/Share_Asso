<?php

namespace App\Component;

use App\Repository\MaterialRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('search')]
class SearchComponent
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public ?string $query = null;

    public function __construct(private MaterialRepository $materialRepository)
    {
    }

    public function getPackages(): array
    {
        return $this->materialRepository->findAll($this->query);
    }
}