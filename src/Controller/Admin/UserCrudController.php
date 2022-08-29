<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
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
            AssociationField::new('department'),
            ChoiceField::new('roles')
                ->setChoices(array_combine($roles, $roles))

                ->allowMultipleChoices()
                ->setSortable(false),
            Field::new('password')
                ->setFormType(PasswordType::class)
                ->onlyWhenCreating(),
            // ->allowMultipleChoices(),
            TextField::new('password')
            // ->onlyWhenCreating(),
        ];
    }
}
