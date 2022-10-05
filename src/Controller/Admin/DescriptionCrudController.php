<?php

namespace App\Controller\Admin;

use App\Entity\Department;
use App\Entity\Description;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class DescriptionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Description::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Description')
            ->setEntityLabelInPlural('Descriptions')
            ->showEntityActionsInlined()
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->onlyOnDetail(),
            TextField::new('Name')
                ->setSortable(true),
            TextareaField::new('description'),
            UrlField::new('URL'),
            UrlField::new('OnePassword', '1password')
                ->setSortable(true),
            AssociationField::new('Departments')
                ->formatValue(function ($value, $entity) {
                    return implode(', ', $entity->getDepartments()->getValues());
                })
                ->setTextAlign('left')
                ->hideOnIndex(),
            TextareaField::new('additionalInfo')
                ->setSortable(false),
            DateField::new('created')
                ->hideOnForm(),
            DateField::new('updated')
                ->hideOnForm(),
            Field::new('createdBy')
                ->onlyOnDetail(),
            Field::new('updatedBy')
                ->onlyOnDetail(),
        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add('id')
            ->add('Name')
            ->add('URL')
            ->add('OnePassword')
            ->add('Departments')
            ->add('created')
            ->add('updated')
        ;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $qb = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

        $userDepartments = $this->getUser()->getDepartments();

        $descriptions = [];

        foreach ($userDepartments as $result) {
            foreach ($result->getDescriptions() as $description) {
                array_push($descriptions, $description);
            }
        }

        if (!$this->isGranted('ROLE_ADMIN')) {
            $qb
                ->andWhere('entity.id in (:descriptionIds)')
                ->setParameter('descriptionIds', $descriptions)
            ;
        }

        return $qb;
    }
}
