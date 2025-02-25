<?php

namespace App\Repository;

use App\Entity\Pedido;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Pedido>
 */
class PedidoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pedido::class);
    }

    public function disponiblesParaCargamento(array $pedidoIds): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder('pedido')
            ->select('pedido')
            ->andWhere('pedido.asignado is null or pedido.asignado = false')
            ->orderBy('pedido.fechaRegistro', 'ASC')
        ;

        // Solo es para las ediciones de cargamento
        if (!empty($pedidoIds)) {
            $expr = $queryBuilder->expr();
            $queryBuilder
                ->orWhere($expr->in('pedido.id', $pedidoIds));
        }
        //

        return $queryBuilder;
    }
}
