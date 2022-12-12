<?php

namespace App\Controller\Admin;

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
use Exception;

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
                ->setSortable(true)
                ->setHelp('This should be the same as the Github repository'),
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
            // Field::new('Github_URL'),
            Field::new('DefaultBranch')
                ->hideOnIndex(),
            Field::new('Latest_Commit_date')
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
            ->add('updated')
        ;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $qb = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

        $descriptions = $this->getCurrentUsersDescriptions();

        if (!$this->isGranted('ROLE_ADMIN')) {
            $qb
                ->andWhere('entity.id in (:descriptionIds)')
                ->setParameter('descriptionIds', $descriptions)
            ;
        }
        return $qb;
    }

    // public function updateAll()
    // {
    //     $client = new \Github\Client();

    //     $ini = parse_ini_file('../app.ini');

    //     $client->authenticate($ini['Github_token'], '', \Github\AuthMethod::ACCESS_TOKEN);
    //     $descriptions = $this->getCurrentUsersDescriptions();

    //     foreach ($descriptions as $description) {
    //         try {
    //             $commit = $client->api('repo')->commits()->all('itk-dev', $description->getName(), ['sha' => $description->getDefaultBranch()]);

    //             $commit = $commit[0]['commit']['author']['date'];
    //             $description->setLatestCommitDate($commit);
    //         } catch (Exception $e) {
               
    //         }
    //     }
    // }

    public function getCurrentUsersDescriptions(): array
    {
        $userDepartments = $this->getUser()->getDepartments();

        $descriptions = [];

        foreach ($userDepartments as $result) {
            foreach ($result->getDescriptions() as $description) {
                array_push($descriptions, $description);
            }
        }

        return $descriptions;
    }
}
