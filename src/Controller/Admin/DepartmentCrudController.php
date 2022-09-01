<?php

namespace App\Controller\Admin;

use App\Entity\Department;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Doctrine\ORM\QueryBuilder;


class DepartmentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Department::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Department')
            ->showEntityActionsInlined();
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->onlyOnDetail(),
            TextField::new('departmentName'),
            AssociationField::new('users')
                ->setLabel('Total users')
                ->setFormTypeOption('by_reference', false),
            AssociationField::new('descriptions')
                ->setLabel('Total descriptions')
                ->setFormTypeOption('by_reference', false)
        ];
    }

    protected function createListQueryBuilder($entityClass, $sortDirection, $sortField = null, $dqlFilter = null)
    {
        /**
         * @var QueryBuilder $qb
         */
        $qb = $this->createListQueryBuilder($entityClass, $sortDirection, $sortField, $dqlFilter);

        if (method_exists($entityClass, 'getUser')) {
            $qb->andWhere('entity.user = :user');
            $qb->setParameter('user', $this->getUser());
        }
        return $qb;
        echo ('ham');
    }


    // protected function createListQueryBuilder($entityClass, $sortDirection, $sortField = null, $dqlFilter = null)
    // {
    //     /** @var QueryBuilder $result  */
    //     $result = $this->createListQueryBuilder($entityClass, $sortDirection, $sortField, $dqlFilter);

    //     # Getting data User wise
    //     $result->leftJoin('entity.projectRequirementsHasUserUser', 'user')
    //         ->andWhere('user.id = :user')
    //         ->setParameter('user', $this->getUser());

    //     return $result;
    // }
}
