<?php

namespace App\Controller\Admin;

use App\Entity\Department;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use App\Repository\DepartmentRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


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


    public function ham(DepartmentRepository $dprp)
    {
        $departments = $dprp->findBy($this->getUser());

        return $this;
    }

    // public function findOneBySomeField(User $user): ?Department
    // {
    //     $userDepartments = $user->getDepartments();

    //     $qb = $this->createQueryBuilder('p');

    //     $qb
    //         ->innerJoin('App\Entity\User', 'u', 'WITH', 'u = p.user')
    //         ->where('u.userId = :val')
    //         ->setParameter('val', $user->getId())
    //         ->getQuery()
    //         ->getOneOrNullResult();

    //     // dump($qb->getQuery()->getResult());

    //     return $qb->getQuery()->getResult();
    // }

    // protected function createListQueryBuilder($entityClass, $sortDirection, $sortField, $dqlFilter): QueryBuilder
    // {
    //     $isAdminUser = $this->isGranted('ROLE_ADMIN');

    //     $qb = $this->createListQueryBuilder($entityClass, $sortDirection, $sortField, $dqlFilter);

    //     $user = $this->getUser();
    //     $userDepartments = $user->getDepartments();

    //     if (!$isAdminUser) {
    //         foreach ($userDepartments as $result) {
    //             $qb
    //                 ->where('entity.id = :departmentId')
    //                 ->setParameter('departmentId', $result);
    //         }
    //     }
    //     return $qb;
    // }

    // public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    // {
    //     $isAdminUser = $this->isGranted('ROLE_ADMIN');
    //     $defaultQueryBuilder = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

    //     $user = $this->getUser();
    //     $userDepartments = $user->getDepartments();

    //     if (!$isAdminUser) {
    //         // foreach ($userDepartments as $result) {
    //         $defaultQueryBuilder
    //             ->where('entity.id = :departmentId')
    //             ->setParameter('departmentId', $userDepartments[0]);
    //         // }
    //     }
    //     return $defaultQueryBuilder;
    // }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        // $user = $this->getUser()->getId();
        $qb = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);
        if (!$this->isGranted('ROLE_ADMIN')) {
            $qb->where('entity.id = :id');
            $qb->setParameter('id', $this->getUser()->getId());
        }
        return $qb;
    }
}
