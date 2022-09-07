<?php

namespace App\Controller\Admin;

use App\Entity\Description;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;

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
            ->showEntityActionsInlined();
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
                ->autocomplete()
                ->formatValue(function ($value, $entity) {
                    $str = $entity->getDepartments()[0];
                    for ($i = 1; $i < $entity->getDepartments()->count(); $i++) {
                        $str = $str . ", " . $entity->getDepartments()[$i];
                    }
                    return $str;
                }),
            TextareaField::new('additionalInfo')
                ->setSortable(false),
            DateField::new('created')
                ->hideOnForm(),
            DateField::new('updated')
                ->hideOnForm(),
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
            ->add('updated');
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $qb = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

        $userDepartments = $this->getUser()->getDepartments();

        $descriptions = array();

        foreach ($userDepartments as $result) {
            foreach ($result->getDescriptions() as $description) {
                array_push($descriptions, $description);
            }
        }

        if (!$this->isGranted('ROLE_ADMIN')) {
            $qb
                ->andWhere('entity.id in (:descriptionIds)')
                ->setParameter('descriptionIds', $descriptions);
        }
        return $qb;
    }
}
