<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Filter\UserFilter as FilterUserFilter;
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

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->setPermission(Action::NEW, 'ROLE_ADMIN');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->onlyOnDetail(),
            TextField::new('name'),
            TextareaField::new('description'),
            UrlField::new('URL'),
            UrlField::new('onePassword', '1password'),
            // AssociationField::new('Departments')
            //     ->autocomplete()
            //     ->formatValue(function ($value, $entity) {
            //         $str = $entity->getDepartments()[0];
            //         for ($i = 1; $i < $entity->getDepartments()->count(); $i++) {
            //             $str = $str . ", " . $entity->getDepartments()[$i];
            //         }
            //         return $str;
            //     }),
            TextareaField::new('additionalInfo'),
            DateField::new('created')
                ->hideOnForm(),
            DateField::new('updated')
                ->hideOnForm(),
            // DateField::new('contentChanged')
            //     ->hideOnForm()
        ];
    }

    // public function configureFilters(Filters $filters): Filters
    // {
    //     return $filters->add(FilterUserFilter::new('user'));
    //     // return $filter->
    // }
}
