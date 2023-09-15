<?php

namespace App\Controller\Admin;

use App\Entity\Machine;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MachineCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Machine::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('type'),
            AssociationField::new('dorm'),
            DateTimeField::new('last_maintenance'),
            BooleanField::new('is_active'),
        ];
    }
}
