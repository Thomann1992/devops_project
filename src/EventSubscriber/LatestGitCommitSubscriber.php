<?php

namespace App\EventSubscriber;

use App\Controller\Admin\DescriptionCrudController;
use App\Entity\Description;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeCrudActionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LatestGitCommitSubscriber implements EventSubscriberInterface
{
    public function onBeforeCrudActionEvent(BeforeCrudActionEvent $event): void
    {
        $descriptionController = new DescriptionCrudController();

        $descriptionController->updateAll();
        // DescriptionCrudController->updateAll();
        // updateAll();

        // $adminContext = $event->getAdminContext();
        // if (!$adminContext instanceof DescriptionCrudController){
        //     return;
        // }

        // $someEntity = $this->adminContextProvider->getContext()->getEntity();
        // $em = $doctrine->getManager();

        // $qb = $em->createQueryBuilder();
        // $repository = $doctrine->getRepository(Description::class);

        // $descriptions = $repository->findAll();

        // $descriptions = $this->createQueryBuilder('v')
        // ->andWhere('v.exampleField = :val')
        // ->setParameter('val', $value)
        // ->orderBy('v.id', 'ASC')
        // ->setMaxResults(10);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            // BeforeEntityUpdatedEvent::class => 'onBeforeCrudActionEvent',
            'BeforeCrudActionEvent' => 'onBeforeCrudActionEvent',
        ];
    }
}
