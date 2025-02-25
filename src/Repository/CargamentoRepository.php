<?php

namespace App\Repository;

use App\Entity\Cargamento;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cargamento>
 */
class CargamentoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cargamento::class);
    }

    public function idsCargamento(?int $cargamentoId): array
    {
        return $this->createQueryBuilder('cargamento')
            ->select('pedidos.id')
            ->join('cargamento.pedidos', 'pedidos')
            ->where('cargamento.id = :id')
            ->setParameter('id', $cargamentoId)
            ->getQuery()
            ->getSingleColumnResult();
    }
}
