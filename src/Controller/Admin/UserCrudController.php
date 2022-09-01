<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('User')
            ->showEntityActionsInlined();
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->setPermission(Action::NEW, 'ROLE_ADMIN');
    }

    public function configureFields(string $pageName): iterable
    {
        $roles = ['ROLE_SUPER_ADMIN', 'ROLE_ADMIN', 'ROLE_MODERATOR', 'ROLE_USER'];
        return [
            IdField::new('id')
                ->onlyOnDetail(),
            EmailField::new('email'),
            AssociationField::new('Departments')
                ->formatValue(function ($value, $entity) {
                    $str = $entity->getDepartments()[0];
                    for ($i = 1; $i < $entity->getDepartments()->count(); $i++) {
                        $str = $str . ", " . $entity->getDepartments()[$i];
                    }
                    return $str;
                }),
            ChoiceField::new('roles')
                ->setChoices(array_combine($roles, $roles))
                ->allowMultipleChoices()
                ->setSortable(false),
            TextField::new('password')
            // ->onlyWhenCreating(),
        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)

            ->add('email');
    }

    protected function createListQueryBuilder($entityClass, $sortDirection, $sortField = null, $dqlFilter = null)
    {
        /** @var QueryBuilder $result  */
        $result = $this->createListQueryBuilder($entityClass, $sortDirection, $sortField, $dqlFilter);

        # Getting data User wise
        $result->leftJoin('entity.projectRequirementsHasUserUser', 'user')
            ->andWhere('user.id = :user')
            ->setParameter('user', $this->getUser());

        return $result;
    }
}
